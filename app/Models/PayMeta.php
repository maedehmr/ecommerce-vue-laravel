<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayMeta extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'post_id',
        'pack_id',
        'pay_id',
        'status',
        'method',
        'count',
        'price',
        'color',
        'size',
    ];
    public function getCreatedAtAttribute($value)
    {
        return verta($value)->format(' %d / %B / %Y');
    }
    public function pay()
    {
        return $this->belongsTo(Pay::class);
    }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function pack()
    {
        return $this->belongsTo(Pack::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
