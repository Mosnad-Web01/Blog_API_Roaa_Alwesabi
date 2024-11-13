<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'content', 'author_id', 'tags', 'language', 'category_id'
    ];

    // علاقة مع المستخدم (الكاتب)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // علاقة مع التعليقات
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // علاقة مع الفئات
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // علاقة مع الوسائط
    public function media()
    {
        return $this->hasMany(Media::class);
    }

    // علاقة مع الإعجابات
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // علاقة مع حالة المنشور
    public function status()
    {
        return $this->hasOne(PostStatus::class);
    }
}
