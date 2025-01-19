<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Transport;
use App\Models\Hotel;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        // Récupérer toutes les réservations avec leurs relations transport et hôtel
        $reservations = Reservation::with(['transport', 'hotel'])->get();

        // Retourner les données enrichies en format JSON
        return response()->json($reservations);
    }

    public function store(Request $request)
    {
        // Validation des données de la requête
        $validated = $request->validate([
            'transport_id' => 'required|exists:transports,id',
            'hotel_id' => 'required|exists:hotels,id',
            'date_reservation' => 'required|date',
        ]);

        // Récupérer les informations de transport et d'hôtel
        $transport = Transport::find($request->transport_id);
        $hotel = Hotel::find($request->hotel_id);

        // Vérifier que le transport et l'hôtel existent
        if (!$transport || !$hotel) {
            return response()->json(['message' => 'Transport ou Hôtel introuvable'], 404);
        }

        // Calculer les prix (en supposant que les prix sont stockés dans les champs 'prix_billet' et 'price_per_night')
        $prixTransport = $transport->prix_billet;
        $prixHotel = $hotel->price_per_night; // Vérifiez bien que vous avez ce champ dans votre modèle

        // Calculer le prix total
        $prixTotal = $prixTransport + $prixHotel;

        // Créer la réservation dans la base de données
        $reservation = Reservation::create([
            'transport_id' => $request->transport_id,
            'hotel_id' => $request->hotel_id,
            'prix_transport' => $prixTransport,
            'prix_hotel' => $prixHotel,
            'prix_total' => $prixTotal,
            'date_reservation' => $request->date_reservation,
        ]);

        // Retourner une réponse JSON avec la réservation créée
        return response()->json([
            'message' => 'Réservation créée avec succès',
            'reservation' => $reservation
        ], 201);
    }

    public function show($id)
    {
        // Recherche de la réservation par ID avec les relations (transport et hôtel)
        $reservation = Reservation::with(['transport', 'hotel'])->find($id);

        if (!$reservation) {
            return response()->json(['message' => 'Réservation non trouvée'], 404);
        }

        // Retourner la réservation trouvée avec ses détails
        return response()->json($reservation);
    }

    public function update(Request $request, $id)
    {
        // Validation des données
        $validated = $request->validate([
            'transport_id' => 'required|exists:transports,id',
            'hotel_id' => 'required|exists:hotels,id',
            'date_reservation' => 'required|date',
        ]);

        // Recherche de la réservation à mettre à jour
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json(['message' => 'Réservation non trouvée'], 404);
        }

        // Récupérer les informations de transport et d'hôtel
        $transport = Transport::find($request->transport_id);
        $hotel = Hotel::find($request->hotel_id);

        // Vérifier que le transport et l'hôtel existent
        if (!$transport || !$hotel) {
            return response()->json(['message' => 'Transport ou Hôtel introuvable'], 404);
        }

        // Calculer les prix
        $prixTransport = $transport->prix_billet;
        $prixHotel = $hotel->price_per_night; // Vérifiez bien que vous avez ce champ dans votre modèle
        $prixTotal = $prixTransport + $prixHotel;

        // Mettre à jour la réservation
        $reservation->update([
            'transport_id' => $request->transport_id,
            'hotel_id' => $request->hotel_id,
            'prix_transport' => $prixTransport,
            'prix_hotel' => $prixHotel,
            'prix_total' => $prixTotal,
            'date_reservation' => $request->date_reservation,
        ]);

        // Retourner la réservation mise à jour
        return response()->json($reservation);
    }

    public function destroy($id)
    {
        // Recherche de la réservation à supprimer
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json(['message' => 'Réservation non trouvée'], 404);
        }

        // Supprimer la réservation
        $reservation->delete();

        // Retourner une réponse de succès
        return response()->json(['message' => 'Réservation supprimée avec succès']);
    }

    

    
}

