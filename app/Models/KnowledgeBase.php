<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeBase extends Model
{
    protected $fillable = [
        'kategori', 'pertanyaan', 'kata_kunci', 'jawaban', 'is_active',
    ];

    protected $casts = [
        'kata_kunci' => 'array',
        'is_active'  => 'boolean',
    ];
}
