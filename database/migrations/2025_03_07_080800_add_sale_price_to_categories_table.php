<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('categories', function (Blueprint $table) {
        $table->decimal('sale_price', 8, 2)->nullable(); // Thêm cột sale_price
    });
}

public function down()
{
    Schema::table('categories', function (Blueprint $table) {
        $table->dropColumn('sale_price'); // Nếu rollback, xóa cột sale_price
    });
}


};
