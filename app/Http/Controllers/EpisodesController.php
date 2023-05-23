<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Episode;

class EpisodesController extends Controller
{
    public function show(Episode $episode){
        return response()->json($episode);
    }
}
