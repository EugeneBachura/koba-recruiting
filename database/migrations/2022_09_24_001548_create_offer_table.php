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
        Schema::create('offer', function (Blueprint $table) {
            $table->id(); //id
            $table->string('position'); //stanowisko
            $table->foreignId('recruiter_id')->constrained('recruiter')
                ->onUpdate('cascade')
                ->onDelete('cascade'); //rekruter
            $table->string('level'); //poziom
            $table->text('description'); //opis
            $table->json('skills'); //umiejętności
            $table->boolean('active')->default(true); //aktywna
            $table->date('duration'); //czas trwania
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
        Schema::dropIfExists('offer');
    }
};
