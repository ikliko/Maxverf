<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
//        Schema::create('product_sizes', function(Blueprint $table)
//        {
//            $table -> engine = 'InnoDB';
//            $table -> increments('id');
//            $table -> integer('product_id');
//            $table -> string('size', 255);
//            $table -> string('color', 255);
//            $table -> decimal('price', 15, 2);
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
