<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
//        Schema::create('orders', function(Blueprint $table) {
//            $table -> engine = 'InnoDB';
//            $table -> increments('id');
//            $table -> string('first_name', 50);
//            $table -> string('last_name', 50);
//            $table -> string('email', 150);
//            $table -> string('phone', 255);
//            $table -> string('address', 255);
//            $table -> text('comment');
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
//        Schema::drop('orders');
    }
}
