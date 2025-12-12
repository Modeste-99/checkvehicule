<?php

namespace App\Http\Controllers;

use App\Models\Garage;
use Illuminate\Http\Request;

class GarageController extends Controller
{
    public function index()
    {
        $garages = Garage::where('user_id', auth()->id())->get();
        return view('garages.index', compact('garages'));
    }

    public function create()
    {
        return view('garages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'adresse' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $data = $request->only(['nom', 'adresse', 'latitude', 'longitude']);
        $data['user_id'] = auth()->id();
        Garage::create($data);

        return redirect()->route('garages.index')->with('success', 'Garage ajouté !');
    }

    public function edit(Garage $garage)
    {
        // Vérifier que le garage appartient à l'utilisateur
        if ($garage->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }
        return view('garages.edit', compact('garage'));
    }

    public function update(Request $request, Garage $garage)
    {
        // Vérifier que le garage appartient à l'utilisateur
        if ($garage->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }

        $request->validate([
            'nom' => 'required',
            'adresse' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $garage->update($request->only(['nom', 'adresse', 'latitude', 'longitude']));

        return redirect()->route('garages.index')->with('success', 'Garage mis à jour !');
    }

    public function destroy(Garage $garage)
    {
        // Vérifier que le garage appartient à l'utilisateur
        if ($garage->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }
        $garage->delete();

        return redirect()->route('garages.index')->with('success', 'Garage supprimé !');
    }

    public function carte()
    {
        $garages = Garage::where('user_id', auth()->id())
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();
        return view('garages.carte', compact('garages'));
    }
}
