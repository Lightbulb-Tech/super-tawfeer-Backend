<?php

namespace App\Models\Banha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneCode extends Model
{
    use HasFactory;

    protected $fillable = ['phone', 'phone_code', 'code'];

    public function setPhoneCodeAttribute($value)
    {
        $this->attributes['phone_code'] = ltrim($value, '+');
    }

}
