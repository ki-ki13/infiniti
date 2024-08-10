<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProxyController extends Controller
{
    public function getDetail(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $barcode = $request->input('barcode');

        if (!$username || !$password) {
            return response()->json(['success' => false, 'message' => 'Username and password are required'], 400);
        }

        try {
            $response = Http::withBasicAuth($username, $password)
                ->post('https://test.sid.airlab.id/api/v1/parts/getDetail', [
                    'barcode' => $barcode
                ]);

            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function sendInboundTask(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $barcode = $request->input('barcode');

        if (!$username || !$password || !$barcode) {
            return response()->json(['success' => false, 'message' => 'Username, password, and barcode are required'], 400);
        }

        try {
            $response = Http::withBasicAuth($username, $password)
                ->post('https://test.sid.airlab.id/api/v1/robots/sendInboundTask', [
                    'barcode' => $barcode
                ]);

            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function sendOutboundTask(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $storage_location = $request->input('storage_location');

        if (!$username || !$password || !$storage_location) {
            return response()->json(['status' => 'Error', 'message' => 'Username, password, and storage_location are required'], 400);
        }

        try {
            $response = Http::withBasicAuth($username, $password)
                ->post('https://test.sid.airlab.id/api/v1/robots/sendOutboundTask', [
                    'storageLocation' => $storage_location
                ]);

            $data = $response->json();

            if ($data['status'] == 'OK') {
                return response()->json([
                    'status' => 'OK',
                    'itemDetail' => $data['itemDetail'] ?? null
                ]);
            } else {
                return response()->json([
                    'status' => 'Error',
                    'message' => $data['message'] ?? 'Unknown error occurred'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }
}
