<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    /**
     * Get promo by code
     */
    public function show(string $code): JsonResponse
    {
        $promo = Promo::where('code', $code)
            ->select(['id', 'code', 'percentage'])
            ->first();

        if (!$promo) {
            return response()->json([
                'message' => 'Promo code not found'
            ], 404);
        }

        // Hide ID from response
        $promo->makeHidden(['id']);

        return response()->json($promo);
    }

    /**
     * Validate promo code
     */
    public function validateCode(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $promo = Promo::where('code', $request->code)
            ->select(['id', 'code', 'percentage'])
            ->first();

        if (!$promo) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid promo code'
            ], 404);
        }

        // Hide ID from response
        $promo->makeHidden(['id']);

        return response()->json([
            'valid' => true,
            'promo' => $promo
        ]);
    }
}
