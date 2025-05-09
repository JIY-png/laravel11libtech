<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('student_id');
            $table->string('first_name', 512);
            $table->string('last_name', 512);
            $table->tinyInteger('approved')->default(0);
            $table->tinyInteger('rejected')->default(0);
            $table->integer('category')->unsigned();
            $table->string('roll_num', 15);
            $table->tinyInteger('branch')->default(0);
            $table->integer('year')->unsigned()->comment('Year must be between 2000 and current year');
            $table->tinyInteger('books_issued')->default(0);
            $table->string('email', 512);
            $table->enum('status', ['new', 'approved', 'blocked', 'rejected'])->default('new');
            $table->timestamps();
        });
        
        // Add check constraint to ensure year is between 2000 and current year
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE students ADD CONSTRAINT check_year_range CHECK (year >= 2000 AND year <= YEAR(CURRENT_DATE()))'); 
        } elseif (DB::connection()->getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE students ADD CONSTRAINT check_year_range CHECK (year >= 2000 AND year <= EXTRACT(YEAR FROM CURRENT_DATE))'); 
        } elseif (DB::connection()->getDriverName() === 'sqlite') {
            // SQLite doesn't support check constraints in the same way
            // We'll handle validation at the application level
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
