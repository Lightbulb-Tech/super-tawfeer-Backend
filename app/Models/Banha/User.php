<?php

namespace App\Models\Banha;

// use Illuminate\Contracts\MyAuth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'phone_code',
        'email',
        'image',
        'lat',
        'lon',
        'points',
        'is_deleted',
        'is_blocked',
        'checked_address',
        'register_from',
        'register_type',
        'social_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function fireBaseTokens()
    {
        return $this->hasMany(FirebaseToken::class);

    }
    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id');
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'user_id')->where('selected', '=', 1);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'user_id');
    }

    public function favouriteProducts()
    {
        return $this->belongsToMany(Product::class, 'favourites', 'user_id', 'product_id');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
