<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    #function to save the inbound data
    public function saveData(Request $request)
    {
        $message = "Data berhasil disimpan";
        $data = Stock::create($request->all());
        $success = True;
        return response()->json([
            'success' => $success,
            'message' => $message
        ], 200);
    }

    #function to get all data
    public function getData()
    {
        $username = request()->getUser();
        $password = request()->getPassword();
        $success = false;
        $message = "Authorization Failed";
        $data = null;
        if ($this->checkAuth($username, $password)) {
            $message = "Data berhasil diambil";
            $data = Stock::get();
            $success = True;
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data
        ], 200);
    }

    #function to update the data after outbound
    public function updateData(Request $request)
    {
        $message = "Data berhasil diupdate";
        $data = array(
            "barcode" => $request->input("barcode"),
            "item_name" => $request->input("item_name"),
            "sku" => $request->input("sku"),
            "qty" => $request->input("qty"),
            "storage_location" => $request->input("storage_location"),
            "status" => $request->input("status")
        );
        $id = $request->input('id');
        $result = Stock::where('id', $id)->update($data);

        $success = True;
        return response()->json([
            'success' => $success,
            'message' => $message
        ], 200);
    }
}
