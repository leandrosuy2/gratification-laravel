<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

/**
 * @OA\Tag(name="Authentication")
 */
class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @OA\Get(
     *     path="/email/verify/{id}/{hash}",
     *     tags={"Authentication"},
     *     summary="Verify the user's email address",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="hash",
     *         in="path",
     *         required=true,
     *         description="Verification hash",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Email verified successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error during email verification"
     *     )
     * )
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // Verifica se o usuário já confirmou o e-mail
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false) . '?verified=1');
        }

        // Marca o e-mail como verificado
        if ($request->user()->markEmailAsVerified()) {
            // Dispara o evento de verificação do e-mail
            event(new Verified($request->user()));
        }

        // Redireciona para o dashboard com o parâmetro de verificação
        return redirect()->intended(route('dashboard', absolute: false) . '?verified=1');
    }
}
