<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    use HasFactory;
    protected $fillable=[
        'auth',
        'refId',
        'user_id',
        'price',
        'deliver',
        'property',
        'method',
        'deposit',
        'seen',
        'status',
        'time',
    ];

    /**
     * @inheritDoc
     */
    public function getCreatedAtAttribute($value)
    {
        return verta($value)->format(' H:i | %d / %B / %Y');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function post()
    {
        return $this->hasMany(Post::class);
    }
    public function carrier()
    {
        return $this->morphToMany(Carrier::class, 'carriables');
    }
    public function payMeta()
    {
        return $this->hasMany(PayMeta::class , 'pay_id' , 'id');
    }
}
