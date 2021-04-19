<?php

use App\Province;
use App\Region;
use Illuminate\Database\Seeder;

class RegionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $regions = [
        "Analamanga" => "Antananarivo",
        "Bongolava" => "Antananarivo",
        "Itasy" => "Antananarivo",
        "Vakinankaratra" => "Antananarivo",
        "Diana" => "Antsiranana",
        "Sava" => "Antsiranana",
        "Amoron'i Mania" => "Fianarantsoa",
        "Atsimo Atsinanana" => "Fianarantsoa",
        "Haute-Matsiatra" => "Fianarantsoa",
        "Ihorombe" => "Fianarantsoa",
        "Vatovavy-Fitovinany" => "Fianarantsoa",
        "Betsiboka" => "Mahajanga",
        "Boeny" => "Mahajanga",
        "Melaky" => "Mahajanga",
        "Sofia" => "Mahajanga",
        "Alaotra Mangoro" => "Toamasina",
        "Analanjirofo" => "Toamasina",
        "Atsinanana" => "Toamasina",
        "Anosy" => "Toliara",
        "Atsimo Andrefana" => "Toliara",
        "Menabe" => "Toliara",
        "Androy" => "Toliara",
    ];

    public function run()
    {
        foreach ($this->regions as $region => $province) {
            $reg = new Region();
            $prov = Province::where('name', $province)->first();
            $reg->name = $region;
            $reg->province_id = $prov->id;
            $reg->save();
        }
    }
}
