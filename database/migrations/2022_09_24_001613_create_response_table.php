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
        Schema::create('responses', function (Blueprint $table) {
            $table->id(); //id
            $table->foreignId('candidate_id')->constrained('candidates')
                ->onUpdate('cascade')
                ->onDelete('cascade'); //kandydat
            $table->foreignId('recruiter_id')->constrained('recruiters')
                ->onUpdate('cascade')
                ->onDelete('cascade'); //rekruter
            $table->foreignId('offer_id')->constrained('offers')
                ->onUpdate('cascade')
                ->onDelete('cascade'); //oferta
            $table->string('status'); //status
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
        Schema::dropIfExists('recruiter');
    }
};
