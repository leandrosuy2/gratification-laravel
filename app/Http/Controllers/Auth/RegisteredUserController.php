<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PerfilAcesso;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

/**
 * @OA\Info(
 *      title="Gratification API",
 *      version="1.0.0",
 *      description="Documentação da API do Gratification",
 *      @OA\Contact(
 *          email="suporte@gratification.com"
 *      ),
 * )
 */
class RegisteredUserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/register",
     *     summary="Exibe o formulário de registro",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=200,
     *         description="Retorna a página de registro"
     *     )
     * )
     */
    public function create(): View
    {
        $perfis = PerfilAcesso::all();
        return view('auth.register', compact('perfis'));
    }

    /**
     * @OA\Post(
     *     path="/register",
     *     summary="Cria um novo usuário",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "username"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="username", type="string", example="johndoe"),
     *             @OA\Property(property="telcel", type="string", example="+5511999999999"),
     *             @OA\Property(property="id_perfil", type="integer", example=1),
     *             @OA\Property(property="setor", type="string", example="TI"),
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="menu_permissions", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="profile_image", type="string", format="binary")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuário criado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function store(Request $request): RedirectResponse
    {
        Log::info('Registration request received:', $request->all());

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'telcel' => ['nullable', 'string', 'max:255'],
            'id_perfil' => ['nullable', 'integer', 'exists:perfil_acessos,id'],
            'setor' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'integer'],
            'menu_permissions' => ['nullable', 'array'],
            'profile_image' => ['nullable', 'image', 'max:1024'],
        ]);

        Log::info('Validated data:', $request->all());

        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
            Log::info('Profile image uploaded to: ' . $profileImagePath);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'username' => $request->username,
            'telcel' => $request->telcel,
            'id_perfil' => $request->id_perfil,
            'setor' => $request->setor,
            'status' => true,
            'menu_permissions' => $request->menu_permissions,
            'profile_image' => $profileImagePath,
        ]);

        Log::info('User created successfully:', $user->toArray());

        event(new Registered($user));

        Log::info('Logging in the user:', $user->toArray());

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
