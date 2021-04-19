<?php

namespace App\Http\Controllers;

use App\Artisant;
use App\Categorie;
use App\Filiere;
use App\Metier;
use App\Province;
use App\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;


class ArtisantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function detailsArtisant($id){
        $artisant = Artisant::with('metiers', 'region')->find($id);
        return view('pages.detailsArtisant', [
            'artisant'=>$artisant,
        ]);
    }

    public function delete($id, Request $request){
        $artisant = Artisant::find($id);
        if ($artisant->urlPhoto != null) {
            Storage::delete($artisant->urlPhoto);
        }
        if ($artisant->delete() == 1) {
            $request->session()->flash('status', 'Suppression d\'un artisant Reussie!');      
        }else{
            $request->session()->flash('error', 'Une erreur s\'est produite lors de la suppression');
        }
        return redirect(URL::previous());
    }

    public function loadCreateArtisant(){
        $metiers = Metier::all();
        $regions = Region::all();
        $filieres = Filiere::all();
        $categories = Categorie::all();
        return view('pages.createArtisant', ['metiers'=> $metiers, 'regions'=>$regions, 'filieres'=>$filieres, 'categories'=>$categories]);
    }

    public function loadModifArtisant($id){
        $artisant = Artisant::with('metiers', 'region')->find($id);
        $region = Region::all();
        $metier = Metier::all();
        $filieres = Filiere::all();
        $categories = Categorie::all();
        $url = URL::previous();

        return view('pages.modificationArtisant', [
            'artisant'=>$artisant,
            'regions'=>$region,
            'metiers'=>$metier,
            'filieres'=>$filieres,
            'categories'=>$categories,
            'url'=>$url,
        ]);
    }

    public function insertArtisant(Request $req){
        //dd($req->file('photo'));
        $req->validate([
            'dateNaiss'=>'date|before:now',
            'dateDelivre'=>'date|before:now',
            'datePrincipale'=>'date|before:now',
            'dateSecondaire'=>'nullable|date|before:now',
            'photo'=>'nullable|image|mimes:png,jpeg,jpg,svg|max:2048',
        ]);

        $test = false;

        $artisants = Artisant::all();
        foreach ($artisants as $artisant) {
            if ($artisant->num == $req->input('numArtisant') || $artisant->numCarte == $req->input('numCarte') || $artisant->cin == $req->input('cin')) {
                $test = true;
            }
        }

        if ($test) {
            $req->session()->flash('error', "Le numero de l'artisant ou le numero de la carte ou le CIN que vous avez entrez appartient déjà à un autre Artisant!");
            return redirect()->route('createArtisant');
        } else {  
            $artisant = new Artisant;
            $artisant->num = $req->input('numArtisant');
            $artisant->name = $req->input('nomArtisant');
            $artisant->prenom = $req->input('prenomArtisant');
            $artisant->dateNaissance = $req->input('dateNaiss');
            $artisant->lieuNaissance = $req->input('lieuNaiss');
            $artisant->cin = $req->input('cin');
            $artisant->adresse = $req->input('adresse');
            if ($req->file('photo') != null) {
                $artisant->urlPhoto = $req->file('photo')->store('avatars');
            }
            $artisant->numStat = $req->input('numStat');
            $artisant->nif = $req->input('nif');
            $artisant->numCarte = $req->input('numCarte');
            $artisant->dateDelivrance = $req->input('dateDelivre');
            $artisant->lieuDelivrance = $req->input('lieuDelivre');
            $artisant->cartier = $req->input('cartier');
            $artisant->commune = $req->input('commune');
            $artisant->district = $req->input('district');
            $region = Region::where('name', $req->input('region'))->first();
            $artisant->region_id = $region->id;
            $artisant->save();//enregistrement de l'artisant   
            $metier1 = Metier::where('name', $req->input('activPrincipal'))->first();
            $artisant->metiers()->attach($metier1->id, ['primaire_ou_secondaire'=>'Primaire', 'dateDebut'=>$req->input('datePrincipale')]);
            if ($req->input('activSecondaire') != 'Rien') {
                $metier2 = Metier::where('name', $req->input('activSecondaire'))->first();
                $artisant->metiers()->attach($metier2->id, ['primaire_ou_secondaire'=>'Secondaire', 'dateDebut'=>$req->input('dateSecondaire')]);
            }
            $req->session()->flash('status', "Enregistrement reussi!");
            return redirect()->route('createArtisant');
        }
    }

    public function updateArtisant(Request $req){

        $req->validate([  
            'dateNaiss'=>'date|before:now',
            'dateDelivre'=>'date|before:now',
            'datePrincipale'=>'date|before:now',
            'dateSecondaire'=>'nullable|date|before:now',
            'photo'=>'nullable|image|mimes:png,jpeg,jpg,svg|max:2048',
        ]);

 
            $artisant = Artisant::find($req->input('id'));
            $artisant->num = $req->input('numArtisant');
            $artisant->name = $req->input('nomArtisant');
            $artisant->prenom = $req->input('prenomArtisant');
            $artisant->dateNaissance = $req->input('dateNaiss');
            $artisant->lieuNaissance = $req->input('lieuNaiss');
            $artisant->cin = $req->input('cin');
            $artisant->adresse = $req->input('adresse');
            if ($req->file('photo') != null) {
                Storage::delete($artisant->urlPhoto);
                $artisant->urlPhoto = $req->file('photo')->store('avatars');
            }else{
                Storage::delete($artisant->urlPhoto);
                $artisant->urlPhoto = null;
            }
            $artisant->numStat = $req->input('numStat');
            $artisant->nif = $req->input('nif');
            $artisant->numCarte = $req->input('numCarte');
            $artisant->dateDelivrance = $req->input('dateDelivre');
            $artisant->lieuDelivrance = $req->input('lieuDelivre');
            $artisant->cartier = $req->input('cartier');
            $artisant->commune = $req->input('commune');
            $artisant->district = $req->input('district');
            $region = Region::where('name', $req->input('region'))->first();
            $artisant->region_id = $region->id;
            $artisant->save();//enregistrement de l'artisant  
            foreach ($artisant->metiers as $metier) {
                $artisant->metiers()->detach($metier->id);
            }
            $metier1 = Metier::where('name', $req->input('activPrincipal'))->first();
            $artisant->metiers()->attach($metier1->id, ['primaire_ou_secondaire'=>'Primaire', 'dateDebut'=>$req->input('datePrincipale')]);
            if ($req->input('activSecondaire') != 'Rien') {
                $metier2 = Metier::where('name', $req->input('activSecondaire'))->first();
                $artisant->metiers()->attach($metier2->id, ['primaire_ou_secondaire'=>'Secondaire', 'dateDebut'=>$req->input('dateSecondaire')]);
            }
            $req->session()->flash('status', "Enregistrement reussi!");
            return redirect($req->input('url'));
    }


    //load view function
    public function accueil(){
        $provinces = Province::with('artisants', 'regions')->get();
        $label = array();
        $data = array();
        foreach ($provinces as $province) {
            if ($province->artisants->count()>0) {
                $label[] = $province->name;
                $data[] = $province->artisants->count();
            }
        }
        $chartjs = $this->chartDoughnut($label, $data, "chart"); 
        $artisants = Artisant::with('metiers', 'region')->get();
        $regions = Region::all();
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);
            
        $nb = $artisants->count();
        
        return view('pages.homeArtisant', [
            'nb'=>$nb,
            'dataArtisant'=>$dataArtisant,
            'titre' => 'Vue Globale sur Madagascar',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'provinces'=>$provinces,
            'dataFiliere'=>$dataFiliere,
            'chartjs'=>$chartjs,
        ]);
    }

    //Antananarivo///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function globalTana(){
        $provinces = Province::with('regions', 'artisants')->where('name', 'Antananarivo')->get();
        $regions = Region::all();

        $artisants = "";
        $label = array();
        $data = array();
        foreach($provinces as $province){
            $artisants = $province->artisants;
            foreach ($province->regions as $region) {
                if ($region->artisants->count()>0) {
                    $label[] = $region->name;
                    $data[] = $region->artisants->count();
                }
            }
        } 
        $chartjs = $this->chartDoughnut($label, $data, 'chart');
         
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);
    
        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'nb'=>$nb,
            'titre' => 'Province Antananarivo',
            'artisants' =>$artisants,
            'dataArtisant'=>$dataArtisant,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'dataFiliere'=>$dataFiliere,
            'chartjs'=>$chartjs,
        ]);     
    }

    public function analamanga(){
        $artisants = "";
        $regions = Region::all();

        foreach(Region::with('artisants')->where('name', 'Analamanga')->get() as $region){
            $artisants = $region->artisants;
        }

        $nb = $artisants->count();
        $data = array();
        $label = array();
        $d = array();

        foreach ($artisants as $artisant) {
            $data[$artisant->district] = 0;
        }

        foreach ($artisants as $artisant) {
                if (!in_array($artisant->district, $label)) {
                    $label[] = $artisant->district;
                }
                $data[$artisant->district] = $data[$artisant->district]+1;
        }

        foreach ($data as $data1) {
           $d[] = $data1;
        }

        $chartjs = $this->chartDoughnut($label, $d, 'chart');
        
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);
        
        return view('pages.homeArtisant', [
            'nb'=>$nb,
            'titre' => 'Région Analamanga',
            'artisants' =>$artisants,
            'dataArtisant'=>$dataArtisant,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'dataFiliere'=>$dataFiliere,
            'chartjs'=>$chartjs,
        ]);    
    }

    public function vakinankaratra(){
        $artisants = "";
        $regions = Region::all();

        foreach(Region::with('artisants')->where('name', 'Vakinankaratra')->get() as $region){
            $artisants = $region->artisants;
        }

        $nb = $artisants->count();
        $data = array();
        $label = array();
        $d = array();

        foreach ($artisants as $artisant) {
            $data[$artisant->district] = 0;
        }

        foreach ($artisants as $artisant) {
                if (!in_array($artisant->district, $label)) {
                    $label[] = $artisant->district;
                }
                $data[$artisant->district] = $data[$artisant->district]+1;
        }

        foreach ($data as $data1) {
           $d[] = $data1;
        }

        $chartjs = $this->chartDoughnut($label, $d, 'chart');
        
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        return view('pages.homeArtisant', [
            'nb'=>$nb,
            'titre' => 'Région Vakinankaratra',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'dataArtisant'=>$dataArtisant,
            'dataFiliere'=>$dataFiliere,
            'chartjs'=>$chartjs,
        ]);
    }

    public function itasy(){
        $artisants = "";
        $regions = Region::all();

        foreach(Region::with('artisants')->where('name', 'Itasy')->get() as $region){
            $artisants = $region->artisants;
        }

        $nb = $artisants->count();
        $data = array();
        $label = array();
        $d = array();

        foreach ($artisants as $artisant) {
            $data[$artisant->district] = 0;
        }

        foreach ($artisants as $artisant) {
                if (!in_array($artisant->district, $label)) {
                    $label[] = $artisant->district;
                }
                $data[$artisant->district] = $data[$artisant->district]+1;
        }

        foreach ($data as $data1) {
           $d[] = $data1;
        }

        $chartjs = $this->chartDoughnut($label, $d, 'chart');
        
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);
        
        return view('pages.homeArtisant', [
            'nb'=>$nb,
            'titre' => 'Région Itasy',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'dataArtisant'=>$dataArtisant,
            'dataFiliere'=>$dataFiliere,
            'chartjs'=>$chartjs,
        ]);
    }

    public function bongolava(){
        $artisants = "";
        $regions = Region::all();

        foreach(Region::with('artisants')->where('name', 'Bongolava')->get() as $region){
            $artisants = $region->artisants;
        }

        $nb = $artisants->count();
        $data = array();
        $label = array();
        $d = array();

        foreach ($artisants as $artisant) {
            $data[$artisant->district] = 0;
        }

        foreach ($artisants as $artisant) {
                if (!in_array($artisant->district, $label)) {
                    $label[] = $artisant->district;
                }
                $data[$artisant->district] = $data[$artisant->district]+1;
        }

        foreach ($data as $data1) {
           $d[] = $data1;
        }

        $chartjs = $this->chartDoughnut($label, $d, 'chart');
        
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        return view('pages.homeArtisant', [
            'nb'=>$nb,
            'titre' => 'Région Bongolava',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'metiers'=>$metiers,
            'chartjs'=>$chartjs,
        ]);
    }

    //Fianarantsoa////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function globalFianar(){
        $provinces = Province::with('regions', 'artisants')->where('name', 'Fianarantsoa')->get();
        $regions = Region::all();
        $metiers = Metier::all();

        $artisants = "";

        $label = array();
        $data = array();
        foreach($provinces as $province){
            $artisants = $province->artisants;
            foreach ($province->regions as $region) {
                if ($region->artisants->count()>0) {
                    $label[] = $region->name;
                    $data[] = $region->artisants->count();
                }
            }
        }  
        $chartjs = $this->chartDoughnut($label, $data, 'chart');
        
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Province Fianarantsoa',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'chartjs'=>$chartjs,
        ]); 
    }

    public function hautematsiatsa(){
        $artisants = "";
        $regions = Region::all();

        foreach(Region::with('artisants')->where('name', 'Matsiatsa Ambony')->get() as $region){
            $artisants = $region->artisants;
        }

        $nb = $artisants->count();
        $data = array();
        $label = array();
        $d = array();

        foreach ($artisants as $artisant) {
            $data[$artisant->district] = 0;
        }

        foreach ($artisants as $artisant) {
                if (!in_array($artisant->district, $label)) {
                    $label[] = $artisant->district;
                }
                $data[$artisant->district] = $data[$artisant->district]+1;
        }

        foreach ($data as $data1) {
           $d[] = $data1;
        }

        $chartjs = $this->chartDoughnut($label, $d, 'chart');
        
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Région Matsiatsa Ambony',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'chartjs'=>$chartjs,
        ]);
    }

    public function amoronimania(){
        $artisants = "";
        $regions = Region::all();

        foreach(Region::with('artisants')->where('name', 'Amoron\'i Mania')->get() as $region){
            $artisants = $region->artisants;
        }

        $nb = $artisants->count();
        $data = array();
        $label = array();
        $d = array();

        foreach ($artisants as $artisant) {
            $data[$artisant->district] = 0;
        }

        foreach ($artisants as $artisant) {
                if (!in_array($artisant->district, $label)) {
                    $label[] = $artisant->district;
                }
                $data[$artisant->district] = $data[$artisant->district]+1;
        }

        foreach ($data as $data1) {
           $d[] = $data1;
        }

        $chartjs = $this->chartDoughnut($label, $d, 'chart');
        
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Région Amoron\'i Mania',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'chartjs'=>$chartjs,
        ]);
    }

    public function ihorombe(){
        $artisants = "";
        $regions = Region::all();
        $metiers = Metier::all();

        foreach(Region::with('artisants')->where('name', 'Ihorombe')->get() as $region){
            $artisants = $region->artisants;
        }

        $nb = $artisants->count();
        $data = array();
        $label = array();
        $d = array();

        foreach ($artisants as $artisant) {
            $data[$artisant->district] = 0;
        }

        foreach ($artisants as $artisant) {
                if (!in_array($artisant->district, $label)) {
                    $label[] = $artisant->district;
                }
                $data[$artisant->district] = $data[$artisant->district]+1;
        }

        foreach ($data as $data1) {
           $d[] = $data1;
        }

        $chartjs = $this->chartDoughnut($label, $d, 'chart');
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Région Ihorombe',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'chartjs'=>$chartjs,
        ]);
    }

    public function vatovavyfitovinany(){
        $artisants = "";
        $regions = Region::all();
        $metiers = Metier::all();

        foreach(Region::with('artisants')->where('name', 'Vato Vavy Fito Vinany')->get() as $region){
            $artisants = $region->artisants;
        }

        $nb = $artisants->count();
        $data = array();
        $label = array();
        $d = array();

        foreach ($artisants as $artisant) {
            $data[$artisant->district] = 0;
        }

        foreach ($artisants as $artisant) {
                if (!in_array($artisant->district, $label)) {
                    $label[] = $artisant->district;
                }
                $data[$artisant->district] = $data[$artisant->district]+1;
        }

        foreach ($data as $data1) {
           $d[] = $data1;
        }

        $chartjs = $this->chartDoughnut($label, $d, 'chart');
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Région Vato Vavy Fito Vinany',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'chartjs'=>$chartjs,
        ]);
    }

    public function atsimoatsinanana(){
        $artisants = "";
        $regions = Region::all();
        $metiers = Metier::all();

        foreach(Region::with('artisants')->where('name', 'Atsimo Atsinanana')->get() as $region){
            $artisants = $region->artisants;
        }

        $nb = $artisants->count();
        $data = array();
        $label = array();
        $d = array();

        foreach ($artisants as $artisant) {
            $data[$artisant->district] = 0;
        }

        foreach ($artisants as $artisant) {
                if (!in_array($artisant->district, $label)) {
                    $label[] = $artisant->district;
                }
                $data[$artisant->district] = $data[$artisant->district]+1;
        }

        foreach ($data as $data1) {
           $d[] = $data1;
        }

        $chartjs = $this->chartDoughnut($label, $d, 'chart');
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Région Atsimo Atsinanana',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'chartjs'=>$chartjs,
        ]);
    }

    //Mahajanga
    public function globalMahaj(){
        $provinces = Province::with('regions', 'artisants')->where('name', 'Mahajanga')->get();
        $regions = Region::all();

        $artisants = "";

        $label = array();
        $data = array();
        foreach($provinces as $province){
            $artisants = $province->artisants;
            foreach ($province->regions as $region) {
                if ($region->artisants->count()>0) {
                    $label[] = $region->name;
                    $data[] = $region->artisants->count();
                }
            }
        }  
        $chartjs = $this->chartDoughnut($label, $data, 'chart');
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Province Mahajanga',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'chartjs'=>$chartjs,
        ]); 
    }

    public function betsiboka(){
        $artisants = "";
        $regions = Region::all();

        foreach(Region::with('artisants')->where('name', 'Betsiboka')->get() as $region){
            $artisants = $region->artisants;
        }

        $nb = $artisants->count();
        $data = array();
        $label = array();
        $d = array();

        foreach ($artisants as $artisant) {
            $data[$artisant->district] = 0;
        }

        foreach ($artisants as $artisant) {
                if (!in_array($artisant->district, $label)) {
                    $label[] = $artisant->district;
                }
                $data[$artisant->district] = $data[$artisant->district]+1;
        }

        foreach ($data as $data1) {
           $d[] = $data1;
        }

        $chartjs = $this->chartDoughnut($label, $d, 'chart');
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Région Betsiboka',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'chartjs'=>$chartjs,
        ]);
    }

    public function boeny(){
        $artisants = "";
        $regions = Region::all();
        $metiers = Metier::all();

        foreach(Region::with('artisants')->where('name', 'Boeny')->get() as $region){
            $artisants = $region->artisants;
        }

        $nb = $artisants->count();
        $data = array();
        $label = array();
        $d = array();

        foreach ($artisants as $artisant) {
            $data[$artisant->district] = 0;
        }

        foreach ($artisants as $artisant) {
                if (!in_array($artisant->district, $label)) {
                    $label[] = $artisant->district;
                }
                $data[$artisant->district] = $data[$artisant->district]+1;
        }

        foreach ($data as $data1) {
           $d[] = $data1;
        }

        $chartjs = $this->chartDoughnut($label, $d, 'chart');
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Région Boeny',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'chartjs'=>$chartjs,
        ]);
    }

    public function melaky(){
        $artisants = "";
        $regions = Region::all();
        $metiers = Metier::all();

        foreach(Region::with('artisants')->where('name', 'Melaky')->get() as $region){
            $artisants = $region->artisants;
        }

        $nb = $artisants->count();
        $data = array();
        $label = array();
        $d = array();

        foreach ($artisants as $artisant) {
            $data[$artisant->district] = 0;
        }

        foreach ($artisants as $artisant) {
                if (!in_array($artisant->district, $label)) {
                    $label[] = $artisant->district;
                }
                $data[$artisant->district] = $data[$artisant->district]+1;
        }

        foreach ($data as $data1) {
           $d[] = $data1;
        }

        $chartjs = $this->chartDoughnut($label, $d, 'chart');
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Région Melaky',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'chartjs'=>$chartjs,
        ]);
    }

    public function sofia(){
        $artisants = "";
        $regions = Region::all();
        $metiers = Metier::all();

        foreach(Region::with('artisants')->where('name', 'Sofia')->get() as $region){
            $artisants = $region->artisants;
        }

        $nb = $artisants->count();
        $data = array();
        $label = array();
        $d = array();

        foreach ($artisants as $artisant) {
            $data[$artisant->district] = 0;
        }

        foreach ($artisants as $artisant) {
                if (!in_array($artisant->district, $label)) {
                    $label[] = $artisant->district;
                }
                $data[$artisant->district] = $data[$artisant->district]+1;
        }

        foreach ($data as $data1) {
           $d[] = $data1;
        }

        $chartjs = $this->chartDoughnut($label, $d, 'chart');
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Région Sofia',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'chartjs'=>$chartjs,
        ]);
    }

    //Antsiranana
    public function globalAntsir(){
        $provinces = Province::with('regions', 'artisants')->where('name', 'Antsiranana')->get();
        $regions = Region::all();

        $artisants = "";

        $label = array();
        $data = array();
        foreach($provinces as $province){
            $artisants = $province->artisants;
            foreach ($province->regions as $region) {
                if ($region->artisants->count()>0) {
                    $label[] = $region->name;
                    $data[] = $region->artisants->count();
                }
            }
        }  
        $chartjs = $this->chartDoughnut($label, $data, 'chart');

        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Province Antsiranana',
            'artisants' =>$artisants,
            'dataArtisant'=>$dataArtisant,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'dataFiliere'=>$dataFiliere,
            'chartjs'=>$chartjs,
        ]); 
    }

    public function diana(){
        $artisants = "";
        $regions = Region::all();

        foreach(Region::with('artisants')->where('name', 'Diana')->get() as $region){
            $artisants = $region->artisants;
        }

        $nb = $artisants->count();
        $data = array();
        $label = array();
        $d = array();

        foreach ($artisants as $artisant) {
            $data[$artisant->district] = 0;
        }

        foreach ($artisants as $artisant) {
                if (!in_array($artisant->district, $label)) {
                    $label[] = $artisant->district;
                }
                $data[$artisant->district] = $data[$artisant->district]+1;
        }

        foreach ($data as $data1) {
           $d[] = $data1;
        }

        $chartjs = $this->chartDoughnut($label, $d, 'chart');
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Région Diana',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'chartjs'=>$chartjs,
        ]);
    }

    public function sava(){
        $artisants = "";
        $regions = Region::all();

        foreach(Region::with('artisants')->where('name', 'Sava')->get() as $region){
            $artisants = $region->artisants;
        }

        $nb = $artisants->count();
        $data = array();
        $label = array();
        $d = array();

        foreach ($artisants as $artisant) {
            $data[$artisant->district] = 0;
        }

        foreach ($artisants as $artisant) {
                if (!in_array($artisant->district, $label)) {
                    $label[] = $artisant->district;
                }
                $data[$artisant->district] = $data[$artisant->district]+1;
        }

        foreach ($data as $data1) {
           $d[] = $data1;
        }

        $chartjs = $this->chartDoughnut($label, $d, 'chart');
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Région Sava',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'chartjs'=>$chartjs,
        ]);
    }

    //Toliara
    public function globalTol(){
        $provinces = Province::with('regions', 'artisants')->where('name', 'Toliara')->get();
        $regions = Region::all();

        $artisants = "";
        $label = array();
        $data = array();
        foreach($provinces as $province){
            $artisants = $province->artisants;
            foreach ($province->regions as $region) {
                if ($region->artisants->count()>0) {
                    $label[] = $region->name;
                    $data[] = $region->artisants->count();
                }
            }
        }  
        $chartjs = $this->chartDoughnut($label, $data, 'chart');
        //fahatany
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Province Toliara',
            'artisants'=>$artisants,
            'dataArtisant'=>$dataArtisant,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'dataFiliere'=>$dataFiliere,
            'chartjs'=>$chartjs,
        ]); 
    }

    public function atsimoandrefana(){
        $artisants = "";
        $regions = Region::all();

        foreach(Region::with('artisants')->where('name', 'Atsimo Andrefana')->get() as $region){
            $artisants = $region->artisants;
        }

        $nb = $artisants->count();
        $data = array();
        $label = array();
        $d = array();

        foreach ($artisants as $artisant) {
            $data[$artisant->district] = 0;
        }

        foreach ($artisants as $artisant) {
                if (!in_array($artisant->district, $label)) {
                    $label[] = $artisant->district;
                }
                $data[$artisant->district] = $data[$artisant->district]+1;
        }

        foreach ($data as $data1) {
           $d[] = $data1;
        }

        $chartjs = $this->chartDoughnut($label, $d, 'chart');
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Région Atsimo Andrefana',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'chartjs'=>$chartjs,
        ]);
    }

    public function menabe(){
        $artisants = "";
        $regions = Region::all();

        foreach(Region::with('artisants')->where('name', 'Menabe')->get() as $region){
            $artisants = $region->artisants;
        }

        $nb = $artisants->count();
        $data = array();
        $label = array();
        $d = array();

        foreach ($artisants as $artisant) {
            $data[$artisant->district] = 0;
        }

        foreach ($artisants as $artisant) {
                if (!in_array($artisant->district, $label)) {
                    $label[] = $artisant->district;
                }
                $data[$artisant->district] = $data[$artisant->district]+1;
        }

        foreach ($data as $data1) {
           $d[] = $data1;
        }

        $chartjs = $this->chartDoughnut($label, $d, 'chart');
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Région Menabe',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'chartjs'=>$chartjs,
        ]);
    }

    public function anosy(){
        $artisants = "";
        $regions = Region::all();

        foreach(Region::with('artisants')->where('name', 'Anosy')->get() as $region){
            $artisants = $region->artisants;
        }

        $nb = $artisants->count();
        $data = array();
        $label = array();
        $d = array();

        foreach ($artisants as $artisant) {
            $data[$artisant->district] = 0;
        }

        foreach ($artisants as $artisant) {
                if (!in_array($artisant->district, $label)) {
                    $label[] = $artisant->district;
                }
                $data[$artisant->district] = $data[$artisant->district]+1;
        }

        foreach ($data as $data1) {
           $d[] = $data1;
        }

        $chartjs = $this->chartDoughnut($label, $d, 'chart');
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Région Anosy',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'chartjs'=>$chartjs,
        ]);
    }

    public function androy(){
        $artisants = "";
        $regions = Region::all();

        foreach(Region::with('artisants')->where('name', 'Androy')->get() as $region){
            $artisants = $region->artisants;
        }

        $nb = $artisants->count();
        $data = array();
        $label = array();
        $d = array();

        foreach ($artisants as $artisant) {
            $data[$artisant->district] = 0;
        }

        foreach ($artisants as $artisant) {
                if (!in_array($artisant->district, $label)) {
                    $label[] = $artisant->district;
                }
                $data[$artisant->district] = $data[$artisant->district]+1;
        }

        foreach ($data as $data1) {
           $d[] = $data1;
        }

        $chartjs = $this->chartDoughnut($label, $d, 'chart');
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Région Androy',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'chartjs'=>$chartjs,
        ]);
    }

    //Toamasina
    public function globalToam(){
        $provinces = Province::with('regions', 'artisants')->where('name', 'Toamasina')->get();
        $regions = Region::all();

        $artisants = "";

        $label = array();
        $data = array();
        foreach($provinces as $province){
            $artisants = $province->artisants;
            foreach ($province->regions as $region) {
                if ($region->artisants->count()>0) {
                    $label[] = $region->name;
                    $data[] = $region->artisants->count();
                }
            }
        }  
        $chartjs = $this->chartDoughnut($label, $data, 'chart');

        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Province Toamasina',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'chartjs'=>$chartjs,
        ]); 
    }

    public function atsinanana(){
        $artisants = "";
        $regions = Region::all();

        foreach(Region::with('artisants')->where('name', 'Atsinanana')->get() as $region){
            $artisants = $region->artisants;
        }

        $nb = $artisants->count();
        $data = array();
        $label = array();
        $d = array();

        foreach ($artisants as $artisant) {
            $data[$artisant->district] = 0;
        }

        foreach ($artisants as $artisant) {
                if (!in_array($artisant->district, $label)) {
                    $label[] = $artisant->district;
                }
                $data[$artisant->district] = $data[$artisant->district]+1;
        }

        foreach ($data as $data1) {
           $d[] = $data1;
        }

        $chartjs = $this->chartDoughnut($label, $d, 'chart');
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Région Atsinanana',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'chartjs'=>$chartjs,
        ]);
    }

    public function analanjirofo(){
        $artisants = "";
        $regions = Region::all();

        foreach(Region::with('artisants')->where('name', 'Analanjirofo')->get() as $region){
            $artisants = $region->artisants;
        }

        $nb = $artisants->count();
        $data = array();
        $label = array();
        $d = array();

        foreach ($artisants as $artisant) {
            $data[$artisant->district] = 0;
        }

        foreach ($artisants as $artisant) {
                if (!in_array($artisant->district, $label)) {
                    $label[] = $artisant->district;
                }
                $data[$artisant->district] = $data[$artisant->district]+1;
        }

        foreach ($data as $data1) {
           $d[] = $data1;
        }

        $chartjs = $this->chartDoughnut($label, $d, 'chart');
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Région Analanjirofo',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'chartjs'=>$chartjs,
        ]);
    }

    public function alaotramangoro(){
        $artisants = "";
        $regions = Region::all();

        foreach(Region::with('artisants')->where('name', 'Alaotra Mangoro')->get() as $region){
            $artisants = $region->artisants;
        }

        $nb = $artisants->count();
        $data = array();
        $label = array();
        $d = array();

        foreach ($artisants as $artisant) {
            $data[$artisant->district] = 0;
        }

        foreach ($artisants as $artisant) {
                if (!in_array($artisant->district, $label)) {
                    $label[] = $artisant->district;
                }
                $data[$artisant->district] = $data[$artisant->district]+1;
        }

        foreach ($data as $data1) {
           $d[] = $data1;
        }

        $chartjs = $this->chartDoughnut($label, $d, 'chart');
        $metiers = Metier::with('filiere', 'artisants')->get();
        //fahatany
        $dataFiliere = $this->dataFiliere($metiers, $artisants);
        $dataArtisant = $this->dataArtisant($artisants);

        $nb = $artisants->count();
        return view('pages.homeArtisant', [
            'dataFiliere'=>$dataFiliere,
            'dataArtisant'=>$dataArtisant,
            'nb'=>$nb,
            'titre' => 'Région Alaotra Mangoro',
            'artisants' =>$artisants,
            'regions'=>$regions,
            'metiers'=>$metiers,
            'chartjs'=>$chartjs,
        ]);
    }
 
    //creation du chart
    private function chartDoughnut($label, $data, $chartName){
        $chartjs = app()->chartjs
        ->name($chartName)
        ->type('doughnut')
        ->size(['width' => 700, 'height' => 500])
        ->labels($label)
        ->datasets([
            [
                'backgroundColor' => ['Plum','Olive', 'Cyan', 'Fuchsia', 'Brown','Azure','Ivory', 'Teal', 'Silver', 'Purple', 'Gray', 'Orange', 'Maroon'],
                
                'hoverBackgroundColor' => ['Plum','Olive', 'Cyan', 'Fuchsia', 'Brown','Azure','Ivory', 'Teal', 'Silver', 'Purple', 'Gray', 'Orange', 'Maroon'],
                'data' => $data
            ]
        ]);
        return $chartjs;
    }

    private function chartPie($label, $data, $chartName){
        $chart1js = app()->chartjs
        ->name($chartName)
        ->type('pie')
        ->size(['width' => 1500, 'height' => 1000])
        ->labels($label)
        ->datasets([
            [
                'backgroundColor' => ['Plum','Olive', 'Cyan', 'Fuchsia', 'Brown','Azure','Ivory', 'Teal', 'Silver', 'Purple', 'Gray', 'Orange', 'Maroon'],
                
                'hoverBackgroundColor' => ['Plum','Olive', 'Cyan', 'Fuchsia', 'Brown','Azure','Ivory', 'Teal', 'Silver', 'Purple', 'Gray', 'Orange', 'Maroon'],
                'data' => $data
            ]
        ]);
        return $chart1js;
    }


    //traitant les tableau dans la repartition
    private function dataFiliere($metiers, $artisants){
        $dataFiliere = [];
        foreach ($metiers as $metier) {
            $dataFiliere[$metier->filiere->name] = 0; 
        }
        
        foreach ($metiers as $metier) {
            foreach ($artisants as $artisant) {
                foreach ($metier->artisants as $value) {
                    if ($artisant->id == $value->id) {
                        $dataFiliere[$metier->filiere->name] += 1; break;
                    }
                }
            }
        }
        return $dataFiliere;
    }

    private function dataArtisant($artisants){
        $dataArtisant = [];
        foreach ($artisants as $art) {
            $dataArtisant[date("Y", strtotime($art->dateDelivrance))] = 0; 
        }
        foreach ($artisants as $art) {
            $dataArtisant[date("Y", strtotime($art->dateDelivrance))] += 1; 
        }
        return $dataArtisant;
    }
}
