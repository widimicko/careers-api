<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recruitment_id');
            // $table->unsignedBigInteger('category_id');
            $table->string('name');
            $table->string('gender');
            $table->string('place_birth');
            $table->date('date_birth');
            $table->string('email');
            $table->integer('age');
            $table->string('address');
            $table->string('city');
            $table->string('education');
            $table->string('major');
            $table->string('univercity');
            $table->string('media_social')->nullable();
            $table->string('information')->nullable();
            $table->timestamps();

            $table->foreign('recruitment_id')->references('id')->on('recruitments');
            // $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participants');
    }
}
