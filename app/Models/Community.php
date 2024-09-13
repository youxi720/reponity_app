<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Community extends Model
{
    use HasFactory;
    
        protected $fillable = [
        'title',
        'description',
        'creator_id'
    ];
    
    public function creator()
    {
        return $this->belongsTo(User::class);
    }
    
    public function members()
    {
        return $this->belongsToMany(User::class);
    }
}
