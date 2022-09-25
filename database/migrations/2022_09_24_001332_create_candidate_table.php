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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id(); //id
            $table->foreignId('user_id')->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade'); // user
            $table->string('first_name')->nullable(); //imie
            $table->string('last_name')->nullable(); //nazwisko
            $table->Date('date_of_birth')->nullable(); //data urodzenia
            $table->json('interests')->nullable(); //zainteresowania
            $table->json('education')->nullable(); //wykształcenie
            $table->json('skills')->nullable(); //umiejętności
            $table->json('telephone')->nullable(); //telefon
            $table->string('user_email'); // email
            $table->foreign('user_email')->references('email')->on('users');
            $table->string('cv_link')->nullable(); //cv link
            $table->json('cv_history')->nullable(); //cv historia
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
