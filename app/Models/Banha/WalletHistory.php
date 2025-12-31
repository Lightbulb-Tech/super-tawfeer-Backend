<?php

namespace App\Models\Banha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletHistory extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'operation', 'amount', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
