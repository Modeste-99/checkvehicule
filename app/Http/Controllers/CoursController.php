<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CoursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cours = Cours::where('user_id', auth()->id())->latest()->get();
        return view('cours.index', compact('cours'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cours.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'categorie' => 'nullable|string|max:255',
            'fichier_pdf' => 'required|file|mimes:pdf|max:10240', // Max 10MB
        ]);

        $data = $request->only(['titre', 'description', 'categorie']);

        // Upload du fichier PDF
        if ($request->hasFile('fichier_pdf')) {
            $file = $request->file('fichier_pdf');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/cours', $filename);
            $data['fichier_pdf'] = $filename;
        }

        $data['user_id'] = auth()->id();
        Cours::create($data);

        return redirect()->route('cours.index')->with('success', 'Cours ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cours $cour)
    {
        // Vérifier que le cours appartient à l'utilisateur
        if ($cour->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }
        return view('cours.show', compact('cour'));
    }

    /**
     * Download the PDF file
     */
    public function download(Cours $cour)
    {
        // Vérifier que le cours appartient à l'utilisateur
        if ($cour->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }

        if (!$cour->fichier_pdf || !Storage::exists('public/cours/' . $cour->fichier_pdf)) {
            return redirect()->route('cours.index')->with('error', 'Fichier PDF introuvable.');
        }

        return Storage::download('public/cours/' . $cour->fichier_pdf, $cour->titre . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cours $cour)
    {
        // Vérifier que le cours appartient à l'utilisateur
        if ($cour->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }
        return view('cours.edit', compact('cour'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cours $cour)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'categorie' => 'nullable|string|max:255',
            'fichier_pdf' => 'nullable|file|mimes:pdf|max:10240', // Max 10MB
        ]);

        $data = $request->only(['titre', 'description', 'categorie']);

        // Upload du nouveau fichier PDF si fourni
        if ($request->hasFile('fichier_pdf')) {
            // Supprimer l'ancien fichier
            if ($cour->fichier_pdf && Storage::exists('public/cours/' . $cour->fichier_pdf)) {
                Storage::delete('public/cours/' . $cour->fichier_pdf);
            }

            $file = $request->file('fichier_pdf');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/cours', $filename);
            $data['fichier_pdf'] = $filename;
        }

        $cour->update($data);

        return redirect()->route('cours.index')->with('success', 'Cours mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cours $cour)
    {
        // Vérifier que le cours appartient à l'utilisateur
        if ($cour->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }

        // Supprimer le fichier PDF
        if ($cour->fichier_pdf && Storage::exists('public/cours/' . $cour->fichier_pdf)) {
            Storage::delete('public/cours/' . $cour->fichier_pdf);
        }

        $cour->delete();

        return redirect()->route('cours.index')->with('success', 'Cours supprimé avec succès !');
    }
}
