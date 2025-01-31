<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * @OA\Tag(name="Authentication")
 */
class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @OA\Get(
     *     path="/email/verify",
     *     tags={"Authentication"},
     *     summary="Display the email verification prompt",
     *     @OA\Response(
     *         response=200,
     *         description="Email verification prompt displayed"
     *     ),
     *     @OA\Response(
     *         response=302,
     *         description="Redirect to dashboard if email is already verified"
     *     )
     * )
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        // Verifica se o e-mail já foi verificado
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(route('dashboard', absolute: false))
            : view('auth.verify-email');
    }
}
