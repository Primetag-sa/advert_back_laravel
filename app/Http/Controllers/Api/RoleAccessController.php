<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RoleAccess;
use Illuminate\Http\Request;

class RoleAccessController extends Controller
{
    // Récupérer tous les roles/accés
    public function index()
    {
        $rolesAccess = RoleAccess::all();

        return response()->json($rolesAccess);
    }

    // Créer un nouveau role/accés
    public function store(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|string|max:255',
            'access' => 'nullable|string',
        ]);

        $roleAccess = RoleAccess::create($validated);

        return response()->json($roleAccess, 201); // 201 = Created
    }

    // Récupérer un role/accés spécifique par son ID
    public function show($id)
    {
        $roleAccess = RoleAccess::find($id);

        if (! $roleAccess) {
            return response()->json(['message' => 'RoleAccess non trouvé'], 404);
        }

        return response()->json($roleAccess);
    }

    // Mettre à jour un role/accés existant
    public function update(Request $request, $id)
    {
        $roleAccess = RoleAccess::find($id);

        if (! $roleAccess) {
            return response()->json(['message' => 'la combinaison role et accés non trouvée'], 404);
        }

        $validated = $request->validate([
            'role' => 'required|string|max:255',
            'access' => 'nullable|string',
        ]);

        $roleAccess->update($validated);

        return response()->json($roleAccess);
    }

    // Supprimer un role/accés
    public function destroy($id)
    {
        $roleAccess = RoleAccess::find($id);

        if (! $roleAccess) {
            return response()->json(['message' => 'la combinaison role et accés non trouvée'], 404);
        }

        $roleAccess->delete();

        return response()->json(['message' => 'la combinaison role et accés supprimée avec succès']);
    }
}
