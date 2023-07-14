<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable=[
        'post_id','count','delivery','user_id','pack_id','size','color'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function carrier()
    {
        return $this->morphToMany(Carrier::class, 'carriables');
    }
}
