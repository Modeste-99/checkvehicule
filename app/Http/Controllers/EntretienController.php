<?php

namespace App\Http\Controllers;

use App\Models\Entretien;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EntretienController extends Controller
{
    public function index()
    {
        $entretiens = Entretien::where('user_id', auth()->id())
            ->with('vehicule')
            ->latest()
            ->get();
        return view('entretiens.index', compact('entretiens'));
    }

    public function create()
    {
        $vehicules = Vehicule::where('user_id', auth()->id())->get();
        return view('entretiens.create', compact('vehicules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicule_id' => [
                'required',
                'exists:vehicules,id',
                function ($attribute, $value, $fail) {
                    $vehicule = Vehicule::find($value);
                    if ($vehicule && $vehicule->user_id !== auth()->id()) {
                        $fail('Ce véhicule ne vous appartient pas.');
                    }
                },
            ],
            'type' => 'required|string',
            'date_entretien' => 'required|date',
            'kilometrage' => 'nullable|integer',
            'prix_pieces' => 'nullable|numeric|min:0',
            'prix_main_oeuvre' => 'nullable|numeric|min:0',
            'note' => 'nullable|string',
        ]);

        // Vérifier que le véhicule appartient à l'utilisateur
        $vehicule = Vehicule::findOrFail($request->vehicule_id);

        $data = $request->only([
            'vehicule_id', 
            'type', 
            'date_entretien', 
            'kilometrage', 
            'prix_pieces', 
            'prix_main_oeuvre',
            'note'
        ]);
        
        // Le prix total sera calculé automatiquement par le modèle
        $data['user_id'] = auth()->id();
        Entretien::create($data);

        return redirect()->route('entretiens.index')->with('success', 'Entretien ajouté avec succès !');
    }

    public function edit(Entretien $entretien)
    {
        // Vérifier que l'entretien appartient à l'utilisateur
        if ($entretien->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }
        $vehicules = Vehicule::where('user_id', auth()->id())->get();
        return view('entretiens.edit', compact('entretien', 'vehicules'));
    }

    public function update(Request $request, Entretien $entretien)
    {
        // Vérifier que l'entretien appartient à l'utilisateur
        if ($entretien->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }

        $request->validate([
            'vehicule_id' => [
                'required',
                'exists:vehicules,id',
                function ($attribute, $value, $fail) {
                    $vehicule = Vehicule::find($value);
                    if ($vehicule && $vehicule->user_id !== auth()->id()) {
                        $fail('Ce véhicule ne vous appartient pas.');
                    }
                },
            ],
            'type' => 'required|string',
            'date_entretien' => 'required|date',
            'kilometrage' => 'nullable|integer',
            'prix_pieces' => 'nullable|numeric|min:0',
            'prix_main_oeuvre' => 'nullable|numeric|min:0',
            'note' => 'nullable|string',
        ]);

        // Vérifier que le véhicule appartient à l'utilisateur
        $vehicule = Vehicule::findOrFail($request->vehicule_id);

        $entretien->update($request->only([
            'vehicule_id', 
            'type', 
            'date_entretien', 
            'kilometrage', 
            'prix_pieces', 
            'prix_main_oeuvre',
            'note'
        ]));

        return redirect()->route('entretiens.index')->with('success', 'Entretien mis à jour !');
    }

    public function destroy(Entretien $entretien)
    {
        // Vérifier que l'entretien appartient à l'utilisateur
        if ($entretien->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }
        $entretien->delete();

        return redirect()->route('entretiens.index')->with('success', 'Entretien supprimé !');
    }
}
