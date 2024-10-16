<?php

namespace App\Http\Controllers;

use App\Services\GameService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function play(Request $request, GameService $gameService): JsonResponse
    {
        $response = $gameService->playForHash(
            $request->input('hash')
        );

        return response()->json(
            $response
        );
    }
}
