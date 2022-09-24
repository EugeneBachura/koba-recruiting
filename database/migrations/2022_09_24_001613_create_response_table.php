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
        Schema::create('response', function (Blueprint $table) {
            $table->id(); //id
            $table->foreignId('candidate_id')->constrained('candidate')
                ->onUpdate('cascade')
                ->onDelete('cascade'); //kandydat
            $table->foreignId('recruiter_id')->constrained('recruiter')
                ->onUpdate('cascade')
                ->onDelete('cascade'); //rekruter
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