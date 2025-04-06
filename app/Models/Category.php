<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    public $timestamps = true;

    // Thêm price vào fillable
    protected $fillable = ['name', 'slug', 'price', 'image', 'description', 'sale_price'];

    
    // Hàm tạo slug tự động từ name
    public static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->name, '-');
        });

        static::updating(function ($category) {
            $category->slug = Str::slug($category->name, '-');
        });

        static::saving(function ($category) {
            $category->slug = Str::slug($category->name, '-');
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    public function comments()
{
    return $this->hasMany(Comment::class);
}



// Quan hệ với ảnh
public function images()
{
    return $this->hasMany(CategoryImage::class);
}


}

