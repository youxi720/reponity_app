<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class Target extends Model
{
    use HasFactory;
    
    protected $fillable = ['target'];
    
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_target', 'target_id', 'post_id');
    }
}
