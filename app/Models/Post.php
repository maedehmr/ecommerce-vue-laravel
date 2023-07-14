<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    use Sluggable;
    protected $fillable=[
        'title',
        'status',
        'image',
        'user_id',
        'summery',
        'used',
        'original',
        'showcase',
        'code',
        'suggest',
        'count',
        'off',
        'offPrice',
        'price',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function postMeta()
    {
        return $this->morphToMany(PostMeta::class , 'post_metables');
    }

    public function category()
    {
        return $this->morphToMany(Category::class, 'catables');
    }

    public function like()
    {
        return $this->hasMany(Like::class);
    }

    public function bookmark()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function rate()
    {
        return $this->hasMany(Rate::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function brand()
    {
        return $this->morphToMany(Brand::class, 'brandables');
    }

    public function size()
    {
        return $this->morphToMany(Size::class, 'sizables');
    }

    public function time()
    {
        return $this->morphToMany(Time::class, 'timables');
    }

    public function view()
    {
        return $this->morphToMany(View::class, 'viewables');
    }
    public function color()
    {
        return $this->morphToMany(Color::class, 'colorables');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function payMeta()
    {
        return $this->hasMany(PayMeta::class);
    }
}
