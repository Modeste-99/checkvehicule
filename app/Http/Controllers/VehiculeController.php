<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use Illuminate\Http\Request;

class VehiculeController extends Controller
{
    public function index()
    {
        $vehicules = Vehicule::where('user_id', auth()->id())->get();
        return view('vehicules.index', compact('vehicules'));
    }

    public function create()
    {
        return view('vehicules.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'marque' => 'required',
            'modele' => 'required',
            'immatriculation' => 'required|unique:vehicules,immatriculation,NULL,id,user_id,' . auth()->id(),
            'annee' => 'required|integer',
            'kilometrage' => 'required|integer',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['marque', 'modele', 'immatriculation', 'annee', 'kilometrage']);
        $data['user_id'] = auth()->id();

        // Traiter l'upload de photo
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('vehicules', 'public');
            $data['photo'] = $photoPath;
        }

        Vehicule::create($data);

        return redirect()->route('vehicules.index')->with('success', 'Véhicule ajouté !');
    }

    public function edit(Vehicule $vehicule)
    {
        // Vérifier que le véhicule appartient à l'utilisateur
        if ($vehicule->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }
        return view('vehicules.edit', compact('vehicule'));
    }

    public function update(Request $request, Vehicule $vehicule)
    {
        // Vérifier que le véhicule appartient à l'utilisateur
        if ($vehicule->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }

        $request->validate([
            'marque' => 'required',
            'modele' => 'required',
            'annee' => 'required|integer',
            'kilometrage' => 'required|integer',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['marque', 'modele', 'annee', 'kilometrage']);

        // Traiter l'upload de photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($vehicule->photo && \Storage::disk('public')->exists($vehicule->photo)) {
                \Storage::disk('public')->delete($vehicule->photo);
            }
            $photoPath = $request->file('photo')->store('vehicules', 'public');
            $data['photo'] = $photoPath;
        }

        $vehicule->update($data);

        return redirect()->route('vehicules.index')->with('success', 'Véhicule modifié !');
    }

    public function destroy(Vehicule $vehicule)
    {
        // Vérifier que le véhicule appartient à l'utilisateur
        if ($vehicule->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }
        $vehicule->delete();
        return redirect()->route('vehicules.index')->with('success', 'Véhicule supprimé !');
    }
}
