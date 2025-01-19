<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    public function index()
    {
        $transports = Transport::paginate(5);
        return response()->json($transports);
    }

    public function show($id)
    {
        $transport = Transport::findOrFail($id);
        return response()->json($transport);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'prix_billet' => 'required|numeric',
            'date_depart' => 'required|date',
            'date_arrivee' => 'required|date|after_or_equal:date_depart',
            'compagnie' => 'required|string',
            'places_disponibles' => 'required|integer|min:0',
            
        ]);

        $transport = Transport::create($request->all());
        return response()->json($transport, 201);
    }

    public function update(Request $request, $id)
    {
        $transport = Transport::findOrFail($id);

        $request->validate([
            'type' => 'sometimes|required|string',
            'prix_billet' => 'sometimes|required|numeric',
            'date_depart' => 'sometimes|required|date',
            'date_arrivee' => 'sometimes|required|date|after_or_equal:date_depart',
            'compagnie' => 'sometimes|required|string',
            'places_disponibles' => 'sometimes|required|integer|min:0',
           
        ]);

        $transport->update($request->all());
        return response()->json($transport);
    }

    public function destroy($id)
    {
        $transport = Transport::findOrFail($id);
        $transport->delete();
        return response()->json(['message' => 'Transport deleted successfully']);
    }
}
