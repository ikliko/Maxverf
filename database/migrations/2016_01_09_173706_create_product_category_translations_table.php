<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('product_category_translations', function(Blueprint $table) {
            $table -> engine = 'InnoDB';

            $table -> increments('id');
            $table -> integer('category_id')
                -> unsigned();

            $table -> string('locale')
                -> index();

            $table -> string('title', 255);
            $table->unique(['category_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }
}
