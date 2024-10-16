<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;
use App\Models\Target;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'overview',
        'form_url',
        'sheet',
    ];
    
    public function user()   
    {
    return $this->belongsTo(User::class);  
    }
    
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likeposts');
    }
    
    public function targets()
    {
        return $this->belongsToMany(Target::class, 'post_target', 'post_id', 'target_id');
    }
    
    // 投稿にLIKEがついているのか判定
    public function is_liked_by_auth_user()
    {
        return $this->likes()->where('user_id', Auth::id())->exists();
    }
}