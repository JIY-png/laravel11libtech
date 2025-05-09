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
        Schema::table('books', function (Blueprint $table) {
            $table->decimal('overdue_price', 8, 2)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('overdue_price');
        });
    }
    
};
