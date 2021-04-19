<?php

use App\Filiere;
use Illuminate\Database\Seeder;

class filiereSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $filieres = [
        "Bois et dérivés",
        "Métaux et travail de métaux",
        "Pierre et bijouterie",
        "Textile et habillement",
        "Aménagement de l'habitat",
        "Fibres végétales",
        "Divers animals",
        "Agro-alimentaire et alimentaire",
        "Corps gras et hygiènes",
        "Photographie, peinture et art graphique",
        "Cultures et loisirs",
        "Micro-mécanique, électronique, informatique, froid et électrotechnique",
        "Soie"
    ];

    public function run()
    {
        foreach ($this->filieres as $key => $filiere) {
            $fil = new Filiere();
            $fil->name = $filiere;
            $fil->save();
        }
    }
}
