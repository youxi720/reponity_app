<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\User;
use App\Models\Likepost;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'target',
        'overview',
        'form_url',
    ];
    
    public function getPaginateByLimit(int $limit_count = 5)
    {
    // updated_atで降順に並べたあと、limitで件数制限をかける
    return $this->orderBy('updated_at', 'DESC')->paginate($limit_count);

    }
    
    public function user()   
    {
    return $this->belongsTo(User::class);  
    }
    
    public function likeposts()
    {
        return $this->hasMany(Likepost::class);
    }
    
    // 投稿にLIKEがついているのか判定
    public function is_liked_by_auth_user()
    {
        $id = Auth::id();

        // likeposts リレーションを通じて user_id を配列で取得
        $likers = $this->likeposts->pluck('user_id')->toArray();

        // in_array で判定
        return in_array($id, $likers);
    }
}

?>