<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{
    use HasFactory;
    protected $fillable=[
        'ability',
        'titleEn',
        'property',
        'body',
        'guarantee',
        'rate',
    ];
    public function post()
    {
        return $this->morphToMany(Post::class , 'post_metables');
    }
}
