<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function searchAjax(Request $request)
    {
        return response()->json([
            'temp' => 28,
            'description' => 'Nắng đẹp',
            'city' => $request->city ?? 'Hà Nội'
        ]);
    }
}
