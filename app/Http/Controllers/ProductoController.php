<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all();
        return response()->json($productos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $producto = Producto::create($request->all());
        return response()->json($producto, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        
        
        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'sometimes|required|string',
            'precio' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $producto->update($request->all());
        return response()->json($producto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        
        $producto->delete();
        return response()->json(['message' => 'Producto eliminado']);
    }


    public function addStock(Request $request, $id)
    {

        $producto = Producto::find($id);
        request()->validate(Producto::$ruleStock);  
        $producto->stock += $request->stock;
        
        $producto->update([
            'stock' => $producto->stock,
        ]);

        return response()->json($producto);
    }

    public function removeStock(Request $request, $id)
    {
        $producto = Producto::find($id);
        request()->validate(Producto::$ruleStock);  

        if ($producto->stock < $request->stock) {
            return response()->json(['message' => 'Stock insufiente'], 400);
        }
        
        $producto->stock -= $request->stock;
        
        $producto->update([
            'stock' => $producto->stock,
        ]);

        return response()->json($producto);
    }
}
