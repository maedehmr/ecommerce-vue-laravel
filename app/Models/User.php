<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\MailResetPasswordToken;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'admin',
        'number',
        'password',
        'activity',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function sendPasswordResetNotification($token)
    {
        return $this->notify(new MailResetPasswordToken($token));
    }

    public function getCreatedAtAttribute($value)
    {
        return verta($value)->format(' %d / %B / %Y');
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class);
    }

    public function payMeta()
    {
        return $this->hasMany(PayMeta::class);
    }
    public function pay()
    {
        return $this->hasMany(Pay::class);
    }
    public function category()
    {
        return $this->morphToMany(Category::class, 'catables');
    }
    public function pack()
    {
        return $this->morphToMany(Pack::class, 'packables');
    }
    public function brand()
    {
        return $this->morphToMany(Brand::class, 'brandables');
    }
    public function color()
    {
        return $this->morphToMany(Color::class, 'colorables');
    }
    public function carrier()
    {
        return $this->morphToMany(Carrier::class, 'carriables');
    }
    public function size()
    {
        return $this->morphToMany(Size::class, 'sizables');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function bookmark()
    {
        return $this->hasMany(Bookmark::class);
    }
    public function like()
    {
        return $this->hasMany(Like::class);
    }
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
    public function post()
    {
        return $this->hasMany(Post::class);
    }
    public function news()
    {
        return $this->hasMany(News::class);
    }
    public function userMeta()
    {
        return $this->morphToMany(UserMeta::class , 'user_metasables');
    }
    public function view()
    {
        return $this->morphToMany(View::class, 'viewables');
    }
}
