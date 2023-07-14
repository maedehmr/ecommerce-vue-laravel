<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Vidget extends Model
{
    use HasFactory;
    use Sluggable;
    protected $fillable=[
        'name',
        'background',
        'category',
        'title',
        'more',
        'slug',
        'show',
        'type',
        'count',
        'brand',
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
