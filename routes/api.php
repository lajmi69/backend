<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\ReservationController;



Route::group([
    'middleware' => 'api',
    'prefix' => 'users'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refreshToken', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::get('/verify-email', [AuthController::class, 'verifyEmail'])->name('verify.email');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'destinations'
], function ($router) {
    Route::get('/', [DestinationController::class, 'index']); // Original route to fetch all destinations
    Route::post('/', [DestinationController::class, 'store']);
    Route::get('/{id}', [DestinationController::class, 'show']);
    Route::put('/{id}', [DestinationController::class, 'update']);
    Route::delete('/{id}', [DestinationController::class, 'destroy']);

});



Route::group([
    'prefix' => 'hotels'], function () {
    Route::get('/', [HotelController::class, 'index']);
    Route::post('/', [HotelController::class, 'store']);
    Route::get('/{id}', [HotelController::class, 'show']);
    Route::put('/{id}', [HotelController::class, 'update']);
    Route::delete('/{id}', [HotelController::class, 'destroy']);
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'transports'
], function () {
    Route::get('/', [TransportController::class, 'index']); // Affiche la liste des transports
    Route::post('/', [TransportController::class, 'store']); // Crée un nouveau transport
    Route::get('/{id}', [TransportController::class, 'show']); // Affiche un transport spécifique
    Route::put('/{id}', [TransportController::class, 'update']); // Met à jour un transport
    Route::delete('/{id}', [TransportController::class, 'destroy']); // Supprime un transport
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'reservations'
], function () {
    Route::get('/data', function () {
        $transports = \App\Models\Transport::all(); // Récupérer tous les transports
        $hotels = \App\Models\Hotel::all(); // Récupérer tous les hôtels

        return response()->json([
            'transports' => $transports,
            'hotels' => $hotels,
        ]);
    });
    Route::get('/', [ReservationController::class, 'index']);
    Route::post('/', [ReservationController::class, 'store']);
    Route::get('/{id}', [ReservationController::class, 'show']);
    Route::put('/{id}', [ReservationController::class, 'update']);
    Route::delete('/{id}', [ReservationController::class, 'destroy']);
});

Route::get('/client', [DestinationController::class, 'clientIndex']); // Route pour récupérer les destinations client

