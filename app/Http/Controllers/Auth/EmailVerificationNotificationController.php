<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Authentication")
 */
class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @OA\Post(
     *     path="/email/verification-notification",
     *     tags={"Authentication"},
     *     summary="Send a new email verification notification",
     *     @OA\Response(
     *         response=200,
     *         description="Email verification link sent"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Email already verified or error sending verification link"
     *     )
     * )
     */
    public function store(Request $request): RedirectResponse
    {
        // Verifica se o usuário já verificou o email
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // Envia o e-mail de verificação
        $request->user()->sendEmailVerificationNotification();

        // Retorna a resposta com a notificação de que o link foi enviado
        return back()->with('status', 'verification-link-sent');
    }
}
