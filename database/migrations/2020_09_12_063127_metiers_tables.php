<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MetiersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metiers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->foreignId('filiere_id')->constrained('filieres')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('categorie_metier', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('categorie_id')->constrained('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('metier_id')->constrained('metiers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metiers');
    }
}
