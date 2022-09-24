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
        Schema::create('candidate', function (Blueprint $table) {
            $table->id(); //id
            $table->foreignId('user_id')->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade'); // user
            $table->string('first_name'); //imie
            $table->string('last_name'); //nazwisko
            $table->Date('date_of_birth'); //data urodzenia
            $table->json('interests'); //zainteresowania
            $table->json('education'); //wykształcenie
            $table->json('skills'); //umiejętności
            $table->json('telephone'); //telefon
            $table->string('user_email'); // email
            $table->foreign('user_email')->references('email')->on('users');
            $table->string('cv_link'); //cv link
            $table->json('cv_history'); //cv historia
            $table->timestamps(); // czas utworzenia i modyfikacji
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidate');
    }
};
