<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    //

    public function index(){
        
        $users = User::all();
        $nb = User::all()->count();
        return view('pages.gestionUsers', [
            'titre'=>'Gestion des utilisateurs',
            'users'=> $users,
            'nb'=> $nb,

            ]
        );
    }

    public function delete($id, Request $req){
        $user = User::find($id);
        if ($user->delete() == 1) {
            $req->session()->flash('status', 'Suppression d\'un utilisateur Reussie!');      
        }else{
            $req->session()->flash('error', 'Une erreur s\'est produite lors de la suppression');
        }
        return redirect()->route('gestionUsers');
    }

    public function update($id, Request $req){
        if ($req->password == $req->password_confirmation) {
            $user = User::find($id);
            if ($req->password == '') {

                $user->name = $req->name;
                $user->email = $req->email;
            } else {
                
                $user->name = $req->name;
                $user->email = $req->email;
                $user->password = Hash::make($req['password']);
            }
            $user->save();
            $req->session()->flash('status', 'Modification d\'un utilisateur Reussie!');
        } else {
            $req->session()->flash('error', "le mot de passe que vous avez entré n'est pas pareil");
        }
        
        return redirect()->route('gestionUsers');
    }

    public function add(Request $req){

        $req->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        User::create([
            'name' => $req['name'],
            'email' => $req['email'],
            'password' => Hash::make($req['password']),
        ]);

        $req->session()->flash('status', "L'utilisateur a été bien enregistré !");
        return redirect()->route('gestionUsers');
    }
}
