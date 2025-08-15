<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Mostrar lista de clientes con paginación
    public function index()
    {
        //paginación
        $cantidad = request('cantidad', 5); // Cantidad a mostrar
        if ($cantidad === 'all') {
            $clients = Client::get();
            $paginado = false;
        } else {
            $clients = Client::paginate($cantidad);
            $paginado = true;
        }

        return view('clients.index', compact('clients', 'paginado'));

    }



    // Mostrar formulario para crear un nuevo cliente
    public function create()
    {
        return view('clients.create');
    }

    // Almacenar un nuevo cliente
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'nullable|string|max:255',
            'email_verified' => 'required|boolean',
            'identification_number' => 'nullable|string|max:255',
        ]);

        Client::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'email_verified' => $request->email_verified,
            'identification_number' => $request->identification_number,
        ]);

        return redirect()->route('clients.index')->with('success', 'Cliente creado exitosamente.');
    }

    // Mostrar los detalles de un cliente
    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    // Mostrar formulario para editar un cliente
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    // Actualizar los datos de un cliente
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:255',
            'email_verified' => 'required|boolean',
            'identification_number' => 'nullable|string|max:255',
        ]);

        //Actualización del cliente
        $client->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'email_verified' => $request->email_verified,
            'identification_number' => $request->identification_number,
        ]);

        return redirect()->route('clients.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    // Eliminar un cliente
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Cliente eliminado exitosamente.');
    }
}
