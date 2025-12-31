<?php

namespace App\Models\Banha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointTransferRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'status', 'points'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }
}
