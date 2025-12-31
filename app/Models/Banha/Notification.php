<?php

namespace App\Models\Banha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['form_user_id', 'form_user_table', 'to_user_id', 'to_user_table', 'title', 'message', 'is_read', 'action', 'operation_id'];
}
