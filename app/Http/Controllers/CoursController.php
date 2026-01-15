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
            'fichier' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,txt|max:10240', // Max 10MB
        ]);

        $data = $request->only(['titre', 'description']);

        // Upload du fichier
        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/cours', $filename);
            $data['fichier'] = $filename;
            $data['type_fichier'] = $file->getClientOriginalExtension();
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

        $filePath = 'public/cours/' . $cour->fichier;
        
        if (!$cour->fichier || !Storage::exists($filePath)) {
            return redirect()->route('cours.index')
                ->with('error', 'Fichier introuvable : ' . $filePath);
        }

        // Récupérer le contenu du fichier
        $fileContents = Storage::get($filePath);
        $fileName = str_replace(' ', '_', $cour->titre) . '.' . pathinfo($cour->fichier, PATHINFO_EXTENSION);
        
        // Télécharger le fichier avec les en-têtes appropriés
        $headers = [
            'Content-Type' => Storage::mimeType($filePath),
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Content-Length' => Storage::size($filePath),
        ];
        
        return response($fileContents, 200, $headers);
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
        // Vérifier que le cours appartient à l'utilisateur
        if ($cour->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'fichier' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,txt|max:10240', // Max 10MB
        ]);

        $data = $request->only(['titre', 'description']);

        // Mise à jour du fichier si fourni
        if ($request->hasFile('fichier')) {
            // Supprimer l'ancien fichier
            if ($cour->fichier && Storage::exists('public/cours/' . $cour->fichier)) {
                Storage::delete('public/cours/' . $cour->fichier);
            }

            $file = $request->file('fichier');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/cours', $filename);
            $data['fichier'] = $filename;
            $data['type_fichier'] = $file->getClientOriginalExtension();
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

        // Supprimer le fichier
        if ($cour->fichier && Storage::exists('public/cours/' . $cour->fichier)) {
            Storage::delete('public/cours/' . $cour->fichier);
        }

        $cour->delete();

        return redirect()->route('cours.index')->with('success', 'Cours supprimé avec succès !');
    }
}
