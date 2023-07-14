<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Pack extends Model
{
    use HasFactory;
    use Sluggable;
    protected $fillable=[
        'title',
        'price',
        'count',
        'image',
        'slug',
    ];

    public function getCreatedAtAttribute($value)
    {
        return verta($value)->format(' %d / %B / %Y');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function payMeta()
    {
        return $this->hasMany(PayMeta::class);
    }
    public function user()
    {
        return $this->morphedByMany(User::class, 'packables');
    }
    public function post()
    {
        return $this->morphedByMany(Post::class, 'packables');
    }
}
