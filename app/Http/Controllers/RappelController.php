<?php

namespace App\Http\Controllers;

use App\Models\Rappel;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RappelController extends Controller
{
    /**
     * Affiche la liste des rappels de l'utilisateur
     */
    public function index()
    {
        $rappels = auth()->user()->rappels()
            ->with('vehicule')
            ->orderBy('date_rappel', 'desc')
            ->paginate(10);
            
        return view('rappels.index', compact('rappels'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau rappel
     */
    public function create()
    {
        $vehicules = auth()->user()->vehicules;
        return view('rappels.create', compact('vehicules'));
    }

    /**
     * Enregistre un nouveau rappel
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'type' => 'required|in:entretien,revision',
            'date_rappel' => 'required|date|after:now',
            'notes' => 'nullable|string|max:500'
        ]);

        // Vérifier que le véhicule appartient bien à l'utilisateur
        $vehicule = auth()->user()->vehicules()->findOrFail($validated['vehicule_id']);

        $rappel = auth()->user()->rappels()->create($validated);

        return redirect()->route('rappels.index')
            ->with('success', 'Rappel programmé avec succès!');
    }

    /**
     * Affiche le formulaire de modification d'un rappel
     */
    public function edit(Rappel $rappel)
    {
        $this->authorize('update', $rappel);
        
        $vehicules = auth()->user()->vehicules;
        return view('rappels.edit', compact('rappel', 'vehicules'));
    }

    /**
     * Met à jour un rappel
     */
    public function update(Request $request, Rappel $rappel)
    {
        $this->authorize('update', $rappel);
        
        $validated = $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'type' => 'required|in:entretien,revision',
            'date_rappel' => 'required|date|after:now',
            'notes' => 'nullable|string|max:500'
        ]);

        // Vérifier que le véhicule appartient bien à l'utilisateur
        $vehicule = auth()->user()->vehicules()->findOrFail($validated['vehicule_id']);

        $rappel->update($validated);

        return redirect()->route('rappels.index')
            ->with('success', 'Rappel modifié avec succès!');
    }

    /**
     * Supprime un rappel
     */
    public function destroy(Rappel $rappel)
    {
        $this->authorize('delete', $rappel);
        
        $rappel->delete();
        
        return redirect()->route('rappels.index')
            ->with('success', 'Rappel supprimé avec succès');
    }
}
