<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return Client::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_email' => 'required|string|email|max:255|unique:clients',
            'contact_phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $client = Client::create($request->all());
        return response()->json($client, 201);
    }

    public function show($id)
    {
        return Client::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        $client->update($request->all());
        return response()->json($client, 200);
    }

    public function destroy($id)
    {
        Client::destroy($id);
        return response()->json(null, 204);
    }

}
