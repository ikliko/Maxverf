<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('products', function(Blueprint $table)
//        {
//            $table -> engine = 'InnoDB';
//            $table -> increments('id');
//            $table -> integer('category_id');
//            $table -> string('name', 255);
//            $table -> text('description');
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
