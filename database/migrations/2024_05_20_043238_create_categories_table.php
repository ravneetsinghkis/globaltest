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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('company_id');
            $table->enum('type', ['Distillery', 'Merchant', 'Brand']);
            $table->boolean('is_selected')->default(false);
            $table->string('other_type')->nullable(true);
            $table->string('brand_DM')->nullable(true);
            $table->string('establishment');
            $table->string('country');
            $table->string('region');
            $table->string('story');
            $table->string('logo')->nullable(true);
            $table->string('cover')->nullable(true);      
            $table->string('socialmedia_link')->nullable(true); 
            $table->foreign('company_id')
            ->references('id')->on('companies')->onDelete('cascade');
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
