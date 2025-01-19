<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'transport_id',
        'hotel_id',
        'prix_transport',
        'prix_hotel',
        'prix_total',
        'date_reservation',
    ];

    // Définir la relation avec le transport
    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }

    // Définir la relation avec l'hôtel
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    // Calculer le prix total (transport + hôtel)
    public static function calculateTotalPrice($transport_id, $hotel_id)
    {
        // Récupérer les prix du transport et de l'hôtel
        $transport = Transport::find($transport_id);
        $hotel = Hotel::find($hotel_id);

        if (!$transport || !$hotel) {
            return null; // Si l'un des éléments n'existe pas
        }

        // Calculer le prix total
        $prix_transport = $transport->prix_billet;
        $prix_hotel = $hotel->price_per_night;

        // Calculer le prix total
        $prix_total = $prix_transport + $prix_hotel;

        return [
            'prix_transport' => $prix_transport,
            'prix_hotel' => $prix_hotel,
            'prix_total' => $prix_total,
        ];
    }
}
