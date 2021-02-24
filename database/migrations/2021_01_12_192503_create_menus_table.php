<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('foodName');
            $table->double('foodPrice', 15, 8);
            $table->boolean('foodAvailable')->default(true);
            $table->foreignId('restaurant_id')
                    ->constrained()
                    ->onDelete('cascade');
            $table->string('foodDescription')->nullable();
            $table->string('foodClass')->nullable();
            $table->string('foodPicUrl')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
