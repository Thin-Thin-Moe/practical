<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'author_id'
    ];

    public function likes()
    {
        return  $this->hasMany(Like::class);
    }

    public function tags()
    {
        return  $this->belongsToMany(Tag::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
