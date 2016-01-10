<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderproductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
//        Schema::create('orderproducts', function(Blueprint $table) {
//            $table -> engine = 'InnoDB';
//            $table -> increments('id');
//            $table -> integer('user_id');
//            $table -> integer('order_id');
//            $table -> integer('product_id');
//            $table -> decimal('current_price', 10, 2);
//            $table -> float('discount', 3, 2);
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
