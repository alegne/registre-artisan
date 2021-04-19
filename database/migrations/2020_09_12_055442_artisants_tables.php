<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArtisantsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artisants', function (Blueprint $table) {
            $table->id();
            $table->string('num', 50)->unique();
            $table->string('name');
            $table->string('prenom');
            $table->date('dateNaissance');
            $table->string('lieuNaissance');
            $table->string('cin');
            $table->string('adresse');
            $table->string('urlPhoto');
            $table->string('numStat');
            $table->string('nif');
            $table->string('numCarte');
            $table->string('lieuDelivrance');
            $table->date('dateDelivrance');
            $table->timestamps();
            $table->string('cartier');
            $table->string('commune');
            $table->string('district');
            $table->foreignId('region_id')->contrained('regions')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('artisant_metier', function (Blueprint $table) {
            $table->id();
            $table->string('primaire_ou_secondaire');
            $table->date('dateDebut');
            $table->foreignId('artisant_id')->contrained('artisants')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('metier_id')->contrained('metiers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artisants');
    }
}
