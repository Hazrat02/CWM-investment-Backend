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
        Schema::create('works', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->string('industry')->nullable();
            $table->string('employ')->nullable();
            $table->string('source_of_income')->nullable();
            $table->string('est_annual_income')->nullable();
            $table->string('est_net_worth')->nullable();
            $table->string('ever_traded')->nullable();
            $table->string('previous_work_exp')->nullable();
            $table->string('are_you_us_citizen')->nullable();
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
        Schema::dropIfExists('works');
    }
};
