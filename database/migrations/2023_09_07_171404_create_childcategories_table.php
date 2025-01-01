<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('childcategories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->length(255);
            $table->string('slug')->length(255)->index();
            $table->integer('subcategory_id')->index();
            $table->string('meta_title')->nullable();
            $table->text('meta_decription')->nullable();
            $table->foreignId('subcategory_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('status');
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
        Schema::dropIfExists('childcategories');
    }
};
