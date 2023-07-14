<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'post_id',
        'rate_post',
    ];
    public function ratable()
    {
        return $this->morphTo();
    }
    public function post()
    {
        return $this->hasMany(Post::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
