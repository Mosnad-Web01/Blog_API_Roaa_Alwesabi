<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username', 'password', 'name', 'email', 'phone_number', 'bio', 'profile_image', 'role'
    ];

    // إخفاء الحقول الحساسة عند الإرجاع
    protected $hidden = [
        'password', 'remember_token',
    ];

    // علاقة مع المنشورات
    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    // علاقة مع التعليقات
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // علاقة مع الإعجابات
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
