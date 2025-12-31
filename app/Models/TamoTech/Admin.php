<?php

namespace App\Models\TamoTech;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable implements LaratrustUser
{
    use HasFactory;
    use HasApiTokens, HasFactory, Notifiable;
    use HasRolesAndPermissions;

    protected $fillable = ['name', 'email', 'admin_type', 'phone', 'password', 'image'];


}
