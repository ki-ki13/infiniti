<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     *  @OA\Post(
     *      operationId="saveStockData",
     *      tags={"Stock"},
     *      summary="Save inbound stock data",
     *      description="This endpoint saves the inbound stock data and requires Basic Authentication.",
     *      path="/stock/create",
     *      security={{"basicAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          description="The inbound stock data to be saved",
     *          @OA\JsonContent(
     *              example={
     *                  "barcode": "123456789",
     *                  "item_name": "Sample Item",
     *                  "sku": "SKU001",
     *                  "qty": 100,
     *                  "storage_location": "Warehouse A",
     *                  "status": "inbound"
     *              }
     *          ),
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Ok",
     *          @OA\JsonContent(
     *              example={
     *                  "success": true,
     *                  "message": "Data berhasil disimpan"
     *              }
     *          ),
     *      ),
     *       )
     */

    #function to save the inbound data
    public function saveData(Request $request)
    {
        $username = request()->getUser();
        $password = request()->getPassword();
        $success = false;
        $message = "Autorisasi Gagal";
        $data = null;
        if ($this->checkAuth($username, $password)) {
            $message = "Data berhasil disimpan";
            $data = Stock::create($request->all());
            $success = True;
        }
        return response()->json([
            'success' => $success,
            'message' => $message
        ], 200);
    }

    /**
     *  @OA\Get(
     *      operationId="getStockData",
     *      tags={"Stock"},
     *      summary="Get all stock data",
     *      description="This endpoint retrieves all stock data and requires Basic Authentication.",
     *      path="/stock",
     *      security={{"basicAuth":{}}},
     *      @OA\Response(
     *          response="200",
     *          description="Ok",
     *          @OA\JsonContent(
     *              example={
     *                  "success": true,
     *                  "message": "Data berhasil diambil",
     *                  "data": {
     *                      {
     *                          "id": 1,
     *                          "barcode": "123456789",
     *                          "item_name": "Sample Item",
     *                          "sku": "SKU001",
     *                          "qty": 100,
     *                          "storage_location": "Warehouse A",
     *                          "status": "inbound",
     *                          "created_at": "2024-08-09T12:34:56.000000Z",
     *                          "updated_at": "2024-08-09T12:34:56.000000Z"
     *                      },
     *                      {
     *                          "id": 2,
     *                          "barcode": "987654321",
     *                          "item_name": "Another Item",
     *                          "sku": "SKU002",
     *                          "qty": 50,
     *                          "storage_location": "Warehouse B",
     *                          "status": "outbound",
     *                          "created_at": "2024-08-09T12:34:56.000000Z",
     *                          "updated_at": "2024-08-09T12:34:56.000000Z"
     *                      }
     *                  }
     *              }
     *          ),
     *      ),
     *  )
     */
    #function to get all data
    public function getData()
    {
        $username = request()->getUser();
        $password = request()->getPassword();
        $success = false;
        $message = "Autorisasi Gagal";
        $data = null;
        if ($this->checkAuth($username, $password)) {
            $message = "Data berhasil diambil";
            $data = Stock::where('status','inbound')->get();
            $success = True;
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data
        ], 200);
    }

    /**
     *  @OA\Put(
     *      operationId="updateStockData",
     *      tags={"Stock"},
     *      summary="Update stock data after outbound",
     *      description="This endpoint updates stock data after outbound and requires Basic Authentication.",
     *      path="/stock/update",
     *      security={{"basicAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          description="The updated stock data",
     *          @OA\JsonContent(
     *              example={
     *                  "id": 1,
     *                  "barcode": "123456789",
     *                  "item_name": "Updated Item",
     *                  "sku": "SKU001",
     *                  "qty": 80,
     *                  "storage_location": "Warehouse A",
     *                  "status": "outbound"
     *              }
     *          ),
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Ok",
     *          @OA\JsonContent(
     *              example={
     *                  "success": true,
     *                  "message": "Data berhasil diupdate"
     *              }
     *          ),
     *      ),
     *  )
     */
    #function to update the data after outbound
    public function updateData(Request $request)
    {
        $username = request()->getUser();
        $password = request()->getPassword();
        $success = false;
        $message = "Autorisasi Gagal";
        $data = null;
        if ($this->checkAuth($username, $password)) {
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
        }

        $success = True;
        return response()->json([
            'success' => $success,
            'message' => $message
        ], 200);
    }
}
