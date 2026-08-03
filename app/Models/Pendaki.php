<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaki extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'no_telepon', 'alamat'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
