<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdXAnalytic;
use Illuminate\Http\Request;

class AdXAnalyticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 3);
        $accounts = AdXAnalytic::orderBy('id', 'desc')->paginate($perPage); // Nombre d'éléments par page

        return response()->json($accounts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AdXAnalytic $adXAnalytic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AdXAnalytic $adXAnalytic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdXAnalytic $adXAnalytic)
    {
        //
    }
}
