<?php

namespace App\Http\Controllers;

use App\Services\LinkService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class LinkController extends Controller
{
    public function open(string $hash): Response
    {
        return Inertia::render('Link', [
            'link' => $hash,
        ]);
    }

    /**
     * @throws Exception
     */
    public function update(
        string $hash,
        LinkService $linkService
    ): RedirectResponse
    {
        $link = $linkService->updateExistingLink($hash);

        return Redirect::route('open', ['hash' => $link]);
    }


    /**
     * @throws Exception
     */
    public function deactivate(
        string $hash,
        LinkService $linkService
    ): RedirectResponse
    {
        $linkService->deactivateLinkByHash($hash);

        return Redirect::route('open', [
            'hash' => $hash
        ]);
    }
}
