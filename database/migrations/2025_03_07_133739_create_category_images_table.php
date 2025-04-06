<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('category_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Khóa ngoại
            $table->string('image_path'); // Lưu đường dẫn ảnh
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_images');
    }
};
