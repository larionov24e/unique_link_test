<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\LinkService;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(
        Request $request,
        LinkService $linkService,
        UserService $userService
    ): Response
    {
        $newUser = $userService->createUser(
            $request->input('username'),
            $request->input('phonenumber')
        );

        $newLink = $linkService->createLinkByUser($newUser);

        return Inertia::render('Auth/Register', [
            'generatedLink' => $newLink
        ]);
    }
}
