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
        Schema::table('articles', function (Blueprint $table) {
            $table->unsignedInteger('view_count')->default(0); // Adds view_count column with default value of 0
        });
    }
    
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('view_count');
        });
    }
    
};
