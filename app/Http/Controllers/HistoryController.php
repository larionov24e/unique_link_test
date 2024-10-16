<?php

namespace App\Http\Controllers;

use App\Http\Repositories\LinkRepository;
use App\Services\HistoryService;
use Illuminate\Http\JsonResponse;

class HistoryController extends Controller
{
    public function history(
        HistoryService $historyService,
        LinkRepository $linkRepository
    ): JsonResponse
    {
        $link = $linkRepository->getLinkByHash(
            request()->input('hash')
        );

        return response()->json(
            [
                'history' => $historyService->getLatestById($link->id)
            ]
        );
    }


}
