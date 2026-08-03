<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\ETicket;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');

        // Bypass SSL verification on local environment to prevent Windows cURL SSL certificate error
        if (app()->environment('local')) {
            Config::$curlOptions = [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTPHEADER     => [],
            ];
        }
    }

    public function getSnapToken(Booking $booking, Pembayaran $pembayaran): string
    {
        $params = [
            'transaction_details' => [
                'order_id'     => $pembayaran->order_id,
                'gross_amount' => $booking->total_harga,
            ],
            'customer_details' => [
                'first_name' => $booking->nama_ketua,
                'phone'      => $booking->no_telepon,
                'email'      => $booking->user->email,
            ],
            'item_details' => [
                [
                    'id'       => 'TIKET-CIKURAY',
                    'price'    => $booking->harga_per_orang,
                    'quantity' => $booking->jumlah_pendaki,
                    'name'     => 'Tiket Pendakian Gunung Cikuray via Cintanagara',
                ],
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        $pembayaran->update(['snap_token' => $snapToken]);

        return $snapToken;
    }

    public function handleCallback(array $data): array
    {
        $notification = new Notification();

        $transactionStatus = $notification->transaction_status;
        $paymentType       = $notification->payment_type;
        $orderId           = $notification->order_id;
        $fraudStatus       = $notification->fraud_status ?? null;

        $status = 'menunggu';

        if ($transactionStatus === 'capture') {
            $status = ($fraudStatus === 'challenge') ? 'menunggu' : 'berhasil';
        } elseif ($transactionStatus === 'settlement') {
            $status = 'berhasil';
        } elseif (in_array($transactionStatus, ['cancel', 'deny'])) {
            $status = 'gagal';
        } elseif ($transactionStatus === 'expire') {
            $status = 'kedaluwarsa';
        } elseif ($transactionStatus === 'pending') {
            $status = 'menunggu';
        }

        return [
            'order_id'          => $orderId,
            'status'            => $status,
            'metode_pembayaran' => $paymentType,
            'raw'               => $data,
        ];
    }

    public function checkStatus(Pembayaran $pembayaran): ?string
    {
        try {
            $statusResponse = \Midtrans\Transaction::status($pembayaran->order_id);
            if (!$statusResponse) {
                return null;
            }

            $transactionStatus = $statusResponse->transaction_status;
            $paymentType       = $statusResponse->payment_type ?? '';
            $fraudStatus       = $statusResponse->fraud_status ?? null;

            $status = 'menunggu';

            if ($transactionStatus === 'capture') {
                $status = ($fraudStatus === 'challenge') ? 'menunggu' : 'berhasil';
            } elseif ($transactionStatus === 'settlement') {
                $status = 'berhasil';
            } elseif (in_array($transactionStatus, ['cancel', 'deny'])) {
                $status = 'gagal';
            } elseif ($transactionStatus === 'expire') {
                $status = 'kedaluwarsa';
            } elseif ($transactionStatus === 'pending') {
                $status = 'menunggu';
            }

            if ($status !== $pembayaran->status) {
                $pembayaran->update([
                    'status'            => $status,
                    'metode_pembayaran' => $paymentType,
                    'midtrans_response' => (array) $statusResponse,
                    'paid_at'           => $status === 'berhasil' ? now() : null,
                ]);

                if ($status === 'berhasil') {
                    $pembayaran->booking->update(['status_booking' => 'dikonfirmasi']);

                    ETicket::firstOrCreate(
                        ['booking_id' => $pembayaran->booking_id],
                        [
                            'kode_tiket'      => ETicket::generateKode(),
                            'status_validasi' => 'valid',
                            'diterbitkan_at'  => now(),
                        ]
                    );
                }
            }

            return $status;
        } catch (\Exception $e) {
            Log::error('Midtrans status check error: ' . $e->getMessage());
            return null;
        }
    }
}
