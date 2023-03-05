<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PengeluaranModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PengeluaranController extends Controller
{
    //

    public function index()
    {
        $user_id = Auth::id();
        $data =  PengeluaranModel::where('user_id', $user_id)->get();

        return response()->json([
            'message' => 'succes get data',
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'deskripsi' => 'required',
            'jumlah' => 'required|numeric'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Check your validation',
                'errors' => $validator->errors(),
            ], Response::HTTP_NOT_ACCEPTABLE);
        }

        $validated = $validator->validated();
        $user_id = auth()->user()->id;

        try {
            $data = new PengeluaranModel();
            $data ->user_id = $user_id;
            $data ->deskripsi = $validated['deskripsi'];
            $data ->jumlah = $validated['jumlah'];
            $data->save();
          
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'error',
                'errors' => $th->getMessage()
            ]);
        }


        return response()->json([
            'message' => 'successfully created your data',
            'data' => [
                'id' => $data->id,
                'data' => $data
            ]
        ], Response::HTTP_OK);
    }
}
