<?php

namespace App\Services;

use App\Models\KnowledgeBase;

class ChatbotService
{
    public function processMessage(string $input): array
    {
        // Bersihkan dan normalisasi input
        $clean  = strtolower(trim($input));
        $clean  = preg_replace('/[^a-z0-9\s]/', ' ', $clean);
        $tokens = array_filter(explode(' ', $clean), fn($t) => strlen($t) > 1);

        $records = KnowledgeBase::where('is_active', true)->get();

        $bestMatch = null;
        $bestScore = 0;

        foreach ($records as $record) {
            $keywords = array_map('strtolower', $record->kata_kunci);
            $score    = 0;

            foreach ($keywords as $keyword) {
                $kTokens = explode(' ', $keyword);
                foreach ($kTokens as $kt) {
                    if (in_array($kt, $tokens)) {
                        $score++;
                    }
                }
                // Cek juga exact substring match
                if (str_contains($clean, $keyword)) {
                    $score += 2;
                }
            }

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestMatch = $record;
            }
        }

        if ($bestMatch && $bestScore > 0) {
            return [
                'jawaban'  => $bestMatch->jawaban,
                'kategori' => $bestMatch->kategori,
                'matched'  => true,
            ];
        }

        return [
            'jawaban'  => 'Maaf, saya belum bisa menjawab pertanyaan tersebut. Silakan hubungi petugas basecamp Cintanagara via WhatsApp/Telepon di **0897-6869-943** untuk informasi lebih lanjut, atau gunakan menu Informasi di atas.',
            'kategori' => 'umum',
            'matched'  => false,
        ];
    }
}
