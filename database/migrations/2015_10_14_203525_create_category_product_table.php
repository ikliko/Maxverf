<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
//        Schema::create('categories_products', function(Blueprint $table)
//        {
//            $table -> engine = 'InnoDB';
//            $table -> increments('id');
//            $table -> integer('parent_id');
//            $table -> string('title', 255);
//            $table -> softDeletes();
//            $table -> timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
