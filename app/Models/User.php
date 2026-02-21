<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $fillable = [
        'name',
        'email',
        'avatar',
        'banner',
        'bible_version',
        'role',
        'status',
        'device_id',
        'fcm_token',
        'phone',
        'date_of_birth',
        'position',
        'about',
        'address',
        'country',
        'city',
        'state',
        'google_id',
        'apple_id',
        'facebook_id',
        'guest_id',
        'is_guest',
        'zip_code',
        'email_verified_at',
        'password',
        'remember_token',
        'password_reset_otp_expiry',
        'password_reset_otp',
        'password_reset_otp_is_verified',
    ];

    /**
     * Old accessor method for retrieving the avatar attribute in API requests (for Laravel 9 and below).
     * This method is used to return the avatar attribute with a URL when the request is an API request.
     * This method is deprecated and will be removed in future versions of the application.
     */

    /*  public function getAvatarAttribute($value): string | null
    {
        if (request()->is('api/*') && !empty($value)) {
            return url($value);
        }
        return $value;
    } */


    /**
     * Attribute method for retrieving the avatar attribute in API requests.
     * This method is used in Laravel 10 and above.
     */
    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn($value) =>
            request()->is('api/*') && !empty($value)
                ? url($value)
                : $value
        );
    }


    /** Get the identifier that will be stored in the subject claim of the JWT.
     * @return mixed */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /** Return a key value array, containing any custom claims to be added to the JWT.
     * @return array */
    public function getJWTCustomClaims()
    {
        return [];
    }

   /*  public static function roles()
    {
        return [
            'ADMIN' => env('DEFAULT_ADMIN_ROLE', 'admin'),
            'USER' => env('DEFAULT_USER_ROLE', 'user')
        ];
    } */

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationship with reviews
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Relationship with carts
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Relationship with orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relationship with customer information
     */
    public function customerInformation()
    {
        return $this->hasMany(CustomerInformation::class);
    }
}
