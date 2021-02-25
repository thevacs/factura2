<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $clientes = Cliente::when(request()->buscar, function ($query, $buscar) {
            return $query->Where('rif', 'like', '%' . $buscar . '%')
                ->orWhere('nombre', 'like', '%' . $buscar . '%');
        })
            ->paginate();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rif = $request->char1 . '-' . substr($request->number, 0, \strlen($request->number) - 1) . '-' . substr($request->number, -1);
        $request->request->add(['rif' => $rif]);

        $request->validate([
            'rif' => 'required|unique:clientes',
            'char1' => 'required|string|max:1',
            'number' => 'required|numeric',
            'nombre' => 'required',
            'contacto' => 'nullable',
            'telefono1' => 'nullable',
            'telefono2' => 'nullable',
            'direccion' => 'required',
        ]);

        Cliente::create($request->except(['char1', 'number']));
        toast('Cliente Registrado!', 'success', 'top-right');
        return redirect('clientes')->with('status', 'Cliente Registrado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        $char1 = substr($cliente->rif, 0, 1);
        $number = str_replace('-', '', substr($cliente->rif, 2, \strlen($cliente->rif) - 1));
        return view('clientes.edit', compact('cliente', 'char1', 'number'));
    }

    public function autocomplete()
    {
        $clientes = Cliente::select('nombre')->get()->toArray();
        $results = array_column($clientes, 'nombre');
        return response()->json($results);
    }

    public function getCliente(request $request)
    {        
        $resultado = Cliente::with('notas')->where('nombre', 'like', '%' . request()->cliente . '%')->get()->first();
        return $resultado;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        $rif = $request->char1 . '-' . substr($request->number, 0, \strlen($request->number) - 1) . '-' . substr($request->number, -1);
        $request->request->add(['rif' => $rif]);

        $request->validate([
            'rif' => 'required|unique:clientes,rif,' . $cliente->id,
            'char1' => 'required|string|max:1',
            'number' => 'required|numeric',
            'nombre' => 'required',
            'contacto' => 'nullable',
            'telefono1' => 'nullable',
            'telefono2' => 'nullable',
            'direccion' => 'required',
        ]);

        $cliente->update($request->all());

        toast('Cliente Actualizado!', 'success', 'top-right');
        return redirect('clientes')->with('status', 'Cliente Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->back()->with('status', 'El cliente se ha borrado con exito.');
    }
}
