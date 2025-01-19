<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    { 
        try { 
            $destinations = Destination::paginate(4); 
            return response()->json($destinations); 
        } catch (\Exception $e) { 
            return response()->json(["error" => "Problème de récupération des destinations"], 500); 
        } 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) 
    { 
        try { 
            $destination = new Destination([ 
                "nom" => $request->input("nom"), 
                "description" => $request->input("description"), 
                "pays" => $request->input("pays"), 
                "image" => $request->input("image"), 
                "rank" => $request->input("rank") 
            ]); 
            $destination->save(); 
            return response()->json($destination); 
        } catch (\Exception $e) { 
            return response()->json("Insertion impossible", 500); 
        } 
    }

    /**
     * Display the specified resource.
     */
    public function show($id) 
    { 
        try { 
            $destination = Destination::findOrFail($id); 
            return response()->json($destination); 
        } catch (\Exception $e) { 
            return response()->json(["error" => "Problème de récupération des données"], 500); 
        } 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) 
    { 
        try { 
            $destination = Destination::findOrFail($id); 
            $destination->update($request->all()); 
            return response()->json($destination); 
        } catch (\Exception $e) { 
            return response()->json("Problème de modification", 500); 
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) 
    { 
        try { 
            $destination = Destination::findOrFail($id); 
            $destination->delete(); 
            return response()->json("Destination supprimée avec succès"); 
        } catch (\Exception $e) { 
            return response()->json("Problème de suppression de destination", 500); 
        } 
    } 

    public function clientIndex()
    {
        try {
            // On récupère les 9 premières destinations triées par 'rank'
            $destinations = Destination::orderBy('rank', 'desc')->limit(3)->get();

            // Si aucune destination n'est trouvée
            if ($destinations->isEmpty()) {
                return response()->json(['message' => 'Aucune destination trouvée'], 404);
            }

            // Retourner les destinations sous forme de réponse JSON
            return response()->json($destinations, 200);
        } catch (\Exception $e) {
            // En cas d'erreur, on renvoie un message d'erreur
            return response()->json(['error' => 'Problème de récupération des données', 'message' => $e->getMessage()], 500);
        }
    }
}
