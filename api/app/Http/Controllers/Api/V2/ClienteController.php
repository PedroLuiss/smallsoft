<?php

namespace App\Http\Controllers\Api\V2;
use App\Http\Controllers\Controller;
use App\Http\Requests\cliente\StoreClienteReques;
use App\Models\Cliente;
use App\Models\Cotizacion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{


    public function list_client()
    {
        return response(Cliente::all());
    }

    public function edit($id)
    {
        $data = Cliente::where('id',$id)->first();
        return response($data);
    }


    public function store(StoreClienteReques $request)
    {
        if ($request->id)
        {
            $model = Cliente::findOrFail($request->id);
            $accion = "Editado";

        }
        else
        {
            $model = new Cliente;
            $accion = " Creado";
        }

        $model->fill($request->all());
        $model->save();

        return response()->json(['message' => "Cliente {$accion} correctamente"],201);
    }

    public function delete_client(Request $request)
    {
        // $verifi= Cotizacion::where('cliente_id',$request['id'])->get();
        //     if (count($verifi)) {
        //         return response()->json(['error' => 'No puedes borrar un cliente que tenga asociada una cotización.','status' => 404,], 201);
        //         die;
        //     }

        Cliente::where('id',$request['id'])->delete();
        return response()->json(['success' => 'Cliente Eliminado Correctamente.','status' => 200,], 201);
        // }

    }
}
