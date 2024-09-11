<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'role' => 'required|string|in:ResponsableFinancier,SeniorManager,ResponsableTechnique',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Génération du token
        $token = $user->createToken('apiToken')->plainTextToken;

        // Retourner une réponse JSON avec l'utilisateur et le token
        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);  // 201 pour indiquer que la ressource a été créée
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validation des données
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|confirmed|min:8',
            'role' => 'required|string|in:ResponsableFinancier,SeniorManager,ResponsableTechnique',
        ]);

        // Récupérer l'utilisateur
        $user = User::findOrFail($id);

        // Mise à jour des informations
        $user->name = $request->name;
        $user->email = $request->email;

        // Mettre à jour le mot de passe seulement s'il est fourni
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->role = $request->role;
        $user->save();  // Enregistrer les modifications

        return response()->json([
            'message' => 'Utilisateur mis à jour avec succès',
            'user' => $user,
        ], 200);  // 200 pour indiquer que la ressource a été modifiée
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
