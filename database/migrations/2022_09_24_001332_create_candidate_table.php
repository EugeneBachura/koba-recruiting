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
            $table->string('first_name'); //imie
            $table->string('last_name'); //nazwisko
            $table->Date('date_of_birth')->nullable(); //data urodzenia
            $table->string('photo')->nullable(); //zdjecie
            $table->text('about')->nullable(); //o mnie
            $table->string('interests')->nullable(); //zainteresowania
            $table->string('education')->nullable(); //wykształcenie
            $table->string('skills')->nullable(); //umiejętności
            $table->string('telephone')->nullable(); //telefon
            $table->string('user_email'); // email
            $table->foreign('user_email')->references('email')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');;
            $table->string('cv')->nullable(); //cv link
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
