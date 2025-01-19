<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::paginate(5);
        return response()->json($hotels);
    }

    public function show($id)
    {
        $hotel = Hotel::findOrFail($id);
        return response()->json($hotel);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'rank' => 'required|integer|min:1|max:5',
            'country' => 'required|string',
            'city' => 'required|string',
            'price_per_night' => 'required|numeric',
            'available_rooms' => 'required|integer',
            'description' => 'required|string',
            'image_url' => 'required|url',
        ]);

        $hotel = Hotel::create($request->all());
        return response()->json($hotel, 201);
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string',
            'rank' => 'sometimes|required|integer|min:1|max:5',
            'country' => 'sometimes|required|string',
            'city' => 'sometimes|required|string',
            'price_per_night' => 'sometimes|required|numeric',
            'available_rooms' => 'sometimes|required|integer',
            'description' => 'sometimes|required|string',
            'image_url' => 'sometimes|required|url',
        ]);

        $hotel->update($request->all());
        return response()->json($hotel);
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();
        return response()->json(['message' => 'Hotel deleted successfully']);
    }
}
