<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Pendaki;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

// Root: Landing Page
Route::get('/', fn() => view('landing'))->name('landing');

// Auth routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Midtrans webhook (no auth required)
Route::post('/midtrans/callback', [Pendaki\PembayaranController::class, 'callback'])
    ->name('midtrans.callback')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Public Chatbot route
Route::post('/chatbot', [Pendaki\ChatbotController::class, 'ask'])->name('chatbot.ask');

// ──────────────────────────────────────────────
// PENDAKI ROUTES
// ──────────────────────────────────────────────
Route::middleware(['auth', 'role:pendaki'])
    ->prefix('pendaki')
    ->name('pendaki.')
    ->group(function () {
        Route::get('/dashboard', [Pendaki\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/informasi', [Pendaki\InformasiController::class, 'index'])->name('informasi');
        Route::get('/jadwal', [Pendaki\JadwalController::class, 'index'])->name('jadwal');

        // Booking
        Route::get('/booking/syarat', [Pendaki\BookingController::class, 'syarat'])->name('booking.syarat');
        Route::post('/booking/syarat', [Pendaki\BookingController::class, 'setujuSyarat'])->name('booking.syarat.setuju');
        Route::get('/booking/create', [Pendaki\BookingController::class, 'create'])->name('booking.create');
        Route::post('/booking', [Pendaki\BookingController::class, 'store'])->name('booking.store');
        Route::get('/booking/{booking}', [Pendaki\BookingController::class, 'show'])->name('booking.show');

        // Pembayaran
        Route::get('/pembayaran/{pembayaran}', [Pendaki\PembayaranController::class, 'show'])->name('pembayaran.show');
        Route::post('/pembayaran/{pembayaran}/upload-bukti', [Pendaki\PembayaranController::class, 'uploadBukti'])->name('pembayaran.upload-bukti');

        // Status & E-Ticket
        Route::get('/status-booking', [Pendaki\StatusBookingController::class, 'index'])->name('status-booking');
        Route::get('/eticket/{eticket}', [Pendaki\ETicketController::class, 'show'])->name('eticket.show');

    });

// ──────────────────────────────────────────────
// ADMIN ROUTES
// ──────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // Pendaki
        Route::get('/pendaki', [Admin\PendakiController::class, 'index'])->name('pendaki.index');
        Route::get('/pendaki/{user}', [Admin\PendakiController::class, 'show'])->name('pendaki.show');

        // Jadwal
        Route::resource('/jadwal', Admin\JadwalController::class);
        Route::post('/jadwal/{jadwal}/toggle-status', [Admin\JadwalController::class, 'toggleStatus'])->name('jadwal.toggle-status');

        // Booking
        Route::get('/booking', [Admin\BookingController::class, 'index'])->name('booking.index');
        Route::get('/booking/{booking}', [Admin\BookingController::class, 'show'])->name('booking.show');
        Route::patch('/booking/{booking}/status', [Admin\BookingController::class, 'updateStatus'])->name('booking.update-status');

        // Pembayaran
        Route::get('/pembayaran', [Admin\PembayaranController::class, 'index'])->name('pembayaran.index');
        Route::get('/pembayaran/{pembayaran}', [Admin\PembayaranController::class, 'show'])->name('pembayaran.show');
        Route::patch('/pembayaran/{pembayaran}/verifikasi', [Admin\PembayaranController::class, 'verifikasi'])->name('pembayaran.verifikasi');
        Route::patch('/pembayaran/{pembayaran}/tolak', [Admin\PembayaranController::class, 'tolak'])->name('pembayaran.tolak');

        // E-Ticket
        Route::get('/eticket', [Admin\ETicketController::class, 'index'])->name('eticket.index');
        Route::get('/eticket/{eticket}', [Admin\ETicketController::class, 'show'])->name('eticket.show');
        Route::patch('/eticket/{eticket}/validasi', [Admin\ETicketController::class, 'validasi'])->name('eticket.validasi');
        Route::patch('/eticket/{eticket}/tolak', [Admin\ETicketController::class, 'tolak'])->name('eticket.tolak');
        Route::patch('/eticket/{eticket}/check-in', [Admin\ETicketController::class, 'checkIn'])->name('eticket.check-in');
        Route::patch('/eticket/{eticket}/check-out', [Admin\ETicketController::class, 'checkOut'])->name('eticket.check-out');

        // Knowledge Base
        Route::resource('/knowledge-base', Admin\KnowledgeBaseController::class);

        // Laporan
        Route::get('/laporan', [Admin\LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/pdf', [Admin\LaporanController::class, 'pdf'])->name('laporan.pdf');
        Route::get('/laporan/csv', [Admin\LaporanController::class, 'csv'])->name('laporan.csv');
    });
