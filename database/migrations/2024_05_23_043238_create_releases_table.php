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
        Schema::create('releases', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('category_id');
             $table->enum('type', ['Distillery', 'Merchant', 'Brand', 'Release']);
            $table->boolean('is_selected')->default(false);
            $table->string('other_type')->nullable(true);
            $table->string('brand_DM')->nullable(true);
            $table->string('ean');
            $table->string('country');
            $table->string('region');
            $table->date('publication_date');
            $table->string('price_band');
            $table->string('abv');
            $table->string('story');
            $table->string('logo')->nullable(true);
            $table->string('gallery')->nullable(true);
            $table->string('cover')->nullable(true);      
            $table->string('socialmedia_link')->nullable(true); 
            $table->foreign('category_id')
            ->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('categories');
    }
};
