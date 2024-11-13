<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'post_id', 'comment_id', 'type'
    ];

    // علاقة مع المستخدم (الذي قام بالإعجاب)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة مع المنشور (إذا كان الإعجاب مرتبط بمنشور)
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // علاقة مع التعليق (إذا كان الإعجاب مرتبط بتعليق)
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
