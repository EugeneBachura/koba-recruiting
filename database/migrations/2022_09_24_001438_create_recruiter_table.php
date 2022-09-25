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
        Schema::create('recruiters', function (Blueprint $table) {
            $table->id(); //id
            $table->foreignId('user_id')->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade'); // user
            $table->string('first_name')->nullable(); //imie
            $table->string('last_name')->nullable(); //nazwisko
            $table->string('firm_name')->nullable(); //nazwa firmy
            $table->string('position')->nullable(); //stanowisko
            $table->json('telephone')->nullable(); //telefon
            $table->string('user_email'); // email
            $table->foreign('user_email')->references('email')->on('users');
            $table->timestamps(); //czas utworzenia i modyfikacji
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recruiter');
    }
};
