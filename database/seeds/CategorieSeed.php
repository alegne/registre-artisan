<?php

use App\Categorie;
use Illuminate\Database\Seeder;

class CategorieSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $categories = ["Rien", "Produits utilitaires", "Produits d'art", "Prestation de service"];

    public function run()
    {
        foreach ($this->categories as $key => $categorie) {
            $fil = new Categorie();
            $fil->name = $categorie;
            $fil->save();
        }
    }
}
