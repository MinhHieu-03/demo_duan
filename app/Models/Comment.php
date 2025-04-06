<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'user_id', 'name', 'comment', 'admin_reply', 'slug'];

   
    public function category()
{
    return $this->belongsTo(Category::class, 'category_id');
}


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
