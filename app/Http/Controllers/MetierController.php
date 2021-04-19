<?php

namespace App\Http\Controllers;

use App\Categorie;
use App\Filiere;
use App\Metier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class MetierController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        
        $fil = Filiere::all();
        $categ = Categorie::all();
        $metcat = Metier::with('categories')->get();
        return view('pages.createMetier', [
            'filieres'=>$fil,
            'categories'=>$categ,
            'metcategories'=>$metcat,
        ]);
    }

    public function insert(Request $req){

        if (($req->input('categorie1')== "Rien" && $req->input('categorie2')== "Rien" && $req->input('categorie3')== "Rien") || (($req->input('categorie1') == $req->input('categorie2')) && ($req->input('categorie1') == $req->input('categorie3')))) {
            $req->session()->flash('error', 'Veuillez entrer au moins une categorie ou ne pas remplir tous les champs par une categorie');
            return redirect(URL::previous());

        } else {
            
            $cat1 = Categorie::where('name', $req->input('categorie1'))->first();
            $cat2 = Categorie::where('name', $req->input('categorie2'))->first();
            $cat3 = Categorie::where('name', $req->input('categorie3'))->first();
            $metiers = Metier::where('name', ucfirst($req->input('metier')))->first();
            if ( $metiers==null) {
                $metier = new Metier;
                $metier->name = $req->input('metier');
                if ($req->input('filiereAutre') == '') {
                    $fil = Filiere::where('name', $req->input('filiere'))->first();
                    $metier->filiere_id = $fil->id;
                } else {
                    $filiere = new Filiere;
                    $filiere->name = $req->input('filiereAutre')."(Autres)";
                    $filiere->save();
                    $fil = Filiere::where('name', $req->input('filiereAutre')."(Autres)")->first();
                    $metier->filiere_id = $fil->id;
                }
                
                $metier->save();
                $metier->categories()->sync([$cat1->id, $cat2->id, $cat3->id]);
                    $req->session()->flash('status', 'Metier bien enregistré !');
                    return redirect(URL::previous());
            }else{
                    $req->session()->flash('error', 'Le metier existe déjà !');
                    return redirect(URL::previous());
            }
        }
    }

    public function delete($id, Request $req){
        $metier = Metier::with('artisants')->find($id);

        if ($metier->artisants->count() == 0) {
            if ($metier->delete() == 1) {
                $req->session()->flash('status', 'Le Métier a été bien Supprimé!');
                return redirect()->route('createMetier');
            }
        } else {
            $req->session()->flash('error', 'Le Métier est associé à un artisant, vous ne pouvez pas le supprimé!');
            return redirect()->route('createMetier');
        }
    }

    public function deletefil($id, Request $req){
        $fil = Filiere::with('metiers')->find($id);
        $test = false;      
        if (strstr($fil->name, '(Autres)')) {

            foreach ($fil->metiers as $metier) {
                if ($metier->artisants->count() != 0) {
                    $test = true;
                }
            }
            if ($test) {
                $req->session()->flash('error', 'Vous ne pouvez pas supprimer cette Filière car un des metiers associés à cette derniere est associé à un aritsant!');
                return redirect()->route('createMetier');
            }else {
                $fil->delete();
                $req->session()->flash('status', 'Suppression reussie!');
                return redirect()->route('createMetier');
            }
           
        } else {
                $req->session()->flash('error', 'Vous ne pouvez pas supprimer cette Filière');
                return redirect()->route('createMetier');
        }
        
    }

    public function update(Request $req){
        $metier = Metier::find($req->id);


        if (($req->input('categorie1')== "Rien" && $req->input('categorie2')== "Rien" && $req->input('categorie3')== "Rien") || (($req->input('categorie1') == $req->input('categorie2')) && ($req->input('categorie1') == $req->input('categorie3')))) {
            $req->session()->flash('error', 'Veuillez entrer au moins une categorie ou de ne pas remplir tous les champs par une meme categorie');
            return redirect()->route('createMetier');

        } else {
            $cat1 = Categorie::where('name', $req->input('categorie1'))->first();
            $cat2 = Categorie::where('name', $req->input('categorie2'))->first();
            $cat3 = Categorie::where('name', $req->input('categorie3'))->first();
            $metier->name = $req->input('metier');
            if ($req->input('filiereAutre1') == '') {
                $fil = Filiere::where('name', $req->input('filiere'))->first();
                $metier->filiere_id = $fil->id;
            } else {
                //on recupere la filiere et on edite son nom
                $filiere = new Filiere;
                $filiere->name = $req->input('filiereAutre1')."(Autres)";
                $filiere->save();
                $fil = Filiere::where('name', $req->input('filiereAutre1')."(Autres)")->first();
                $metier->filiere_id = $fil->id;
            }
            
            $metier->save();
            $metier->categories()->sync([$cat1->id, $cat2->id, $cat3->id]);
            $req->session()->flash('status', 'Modification reussi');
            return redirect()->route('createMetier');
            }

    }

}
