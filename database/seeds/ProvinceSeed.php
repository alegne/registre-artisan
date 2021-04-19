<?php

use App\Province;
use Illuminate\Database\Seeder;

class ProvinceSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $provinces = ["Antananarivo", "Antsiranana", "Fianarantsoa", "Mahajanga", "Toamasina", "Toliara"];

    public function run()
    {
        foreach ($this->provinces as $key => $province) {
            $prov = new Province;
            $prov->name = $province;
            $prov->save();
        }
    }
}
