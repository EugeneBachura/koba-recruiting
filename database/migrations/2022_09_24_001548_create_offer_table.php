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
        Schema::create('offers', function (Blueprint $table) {
            $table->id(); //id
            $table->string('position'); //stanowisko
            $table->foreignId('recruiter_id')->constrained('recruiters')
                ->onUpdate('cascade')
                ->onDelete('cascade'); //rekruter
            $table->string('level')->nullable(); //poziom
            $table->text('description')->nullable(); //opis
            $table->string('skills')->nullable(); //umiejętności
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
