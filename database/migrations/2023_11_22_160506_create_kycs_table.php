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
        Schema::create('kycs', function (Blueprint $table) {
            $table->id();
     
            $table->unsignedBigInteger('user_id');
            
            $table->string('type')->nullable();

            $table->string('id_front')->nullable();
            $table->string('id_back')->nullable();
            $table->string('id_file')->nullable();
            $table->string('id_status')->default('pending');

            $table->string('ad_front')->nullable();
            $table->string('ad_back')->nullable();
            $table->string('ad_file')->nullable();
            $table->string('ad_status')->default('pending');
            
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('postel')->nullable();

            $table->string('ot_front')->nullable();
            $table->string('ot_back')->nullable();
            $table->string('ot_file')->nullable();
            $table->string('ot_status')->default('pending');

            $table->string('se_front')->nullable();
            $table->string('se_back')->nullable();
            $table->string('se_file')->nullable();
            $table->string('se_status')->default('pending');


            $table->foreign('user_id')->references('id')->on('Users')->onDelete('cascade');

        
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
        Schema::dropIfExists('kycs');
    }
};
