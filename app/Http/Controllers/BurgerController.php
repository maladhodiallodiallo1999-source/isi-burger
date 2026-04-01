<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use Illuminate\Http\Request;

class BurgerController extends Controller
{
    // Liste tous les burgers
    public function index()
    {
        $burgers = Burger::all();
        return view('burgers.index', compact('burgers'));
    }

    // Formulaire d'ajout
    public function create()
    {
        return view('burgers.create');
    }

    // Enregistrer un nouveau burger
    public function store(Request $request)
    {
        $request->validate([
            'nom'   => 'required',
            'prix'  => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('burgers', 'public');
        }

        Burger::create([
            'nom'         => $request->nom,
            'prix'        => $request->prix,
            'image'       => $imagePath,
            'description' => $request->description,
            'stock'       => $request->stock,
            'archive'     => false,
        ]);

        return redirect('/burgers');
    }

    // Formulaire de modification
    public function edit($id)
    {
        $burger = Burger::findOrFail($id);
        return view('burgers.edit', compact('burger'));
    }

    // Mettre à jour un burger
    public function update(Request $request, $id)
    {
        $burger = Burger::findOrFail($id);

        $imagePath = $burger->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('burgers', 'public');
        }

        $burger->update([
            'nom'         => $request->nom,
            'prix'        => $request->prix,
            'image'       => $imagePath,
            'description' => $request->description,
            'stock'       => $request->stock,
        ]);

        return redirect('/burgers');
    }

    // Archiver un burger
    public function archiver($id)
    {
        $burger = Burger::findOrFail($id);
        $burger->update(['archive' => true]);
        return redirect('/burgers');
    }

    // Désarchiver un burger
    public function desarchiver($id)
    {
        $burger = Burger::findOrFail($id);
        $burger->update(['archive' => false]);
        return redirect('/burgers');
    }
    // Supprimer un burger
    public function destroy($id)
    {
        $burger = Burger::findOrFail($id);
        $burger->delete();
        return redirect('/burgers');
    }


}
