<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'name')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('name')->nullable(); // hoặc không sử dụng nullable nếu bạn muốn cột này bắt buộc
            });
        }
    }
    

        public function down()
        {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['name', 'role']);
            });
        }

};
