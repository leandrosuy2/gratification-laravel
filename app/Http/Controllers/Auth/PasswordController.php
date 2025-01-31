<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

/**
 * @OA\Tag(name="Authentication")
 */
class PasswordController extends Controller
{
    /**
     * Update the user's password.
     *
     * @OA\Put(
     *     path="/user/password",
     *     tags={"Authentication"},
     *     summary="Update the user's password",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"current_password", "password", "password_confirmation"},
     *             @OA\Property(property="current_password", type="string", format="password", example="oldpassword123"),
     *             @OA\Property(property="password", type="string", format="password", example="newpassword123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="newpassword123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password updated successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid current password or invalid data"
     *     )
     * )
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        // Atualiza a senha do usuário
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Retorna a resposta com o status de sucesso
        return back()->with('status', 'password-updated');
    }
}
