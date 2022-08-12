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
  
        Schema::create('watchlists', function (Blueprint $table) {
            $table->unsignedBigInteger('cuser');
            $table->unsignedBigInteger('lid');
            $table->timestamps();

            $table->primary(['cuser', 'lid']);
            
            $table->foreign('cuser')->references('id')->on('users');
            $table->foreign('lid')->references('id')->on('listings');
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('cuser');
            $table->unsignedBigInteger('lid');
            $table->string('notification');
            $table->timestamps();

            $table->primary(['cuser', 'lid']);
            
            $table->foreign('cuser')->references('id')->on('users');
            $table->foreign('lid')->references('id')->on('listings');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bids');
        Schema::dropIfExists('watchlists');
        Schema::dropIfExists('notifications');
    }
};
