<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id', 'status'
    ];

    // علاقة مع المنشور
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
