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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(true);
            $table->string('description')->nullable(true);
            $table->string('email');
            $table->string('establishment');
            $table->string('region');
            $table->string('representative_name');
            $table->string('representative_contact')->nullable(true);
            $table->string('person_name');
            $table->string('person_info')->nullable(true);   
            $table->string('logo')->nullable(true);
            $table->string('country_id');
            $table->string('company_social')->nullable(true);
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
        Schema::dropIfExists('companies');
    }
};
