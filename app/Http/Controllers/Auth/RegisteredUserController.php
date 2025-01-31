<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PerfilAcesso; // Adicionando o modelo PerfilAcesso
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Recupera todos os perfis de acesso para passar à view
        $perfis = PerfilAcesso::all();

        return view('auth.register', compact('perfis'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Log the incoming registration request
        Log::info('Registration request received:', $request->all());

        // Validate the incoming request
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'username' => ['required', 'string', 'max:255', 'unique:' . User::class],  // Assuming username is required
            'telcel' => ['nullable', 'string', 'max:255'], // Assuming telcel is optional
            'id_perfil' => ['nullable', 'integer', 'exists:perfil_acessos,id'], // Assuming id_perfil is optional, but must exist in perfil_acessos
            'setor' => ['nullable', 'string', 'max:255'], // Assuming setor is optional
            'status' => ['nullable', 'integer'], // Assuming status is optional
            'menu_permissions' => ['nullable', 'array'], // Assuming menu_permissions is optional
            'profile_image' => ['nullable', 'image', 'max:1024'], // Validate the image field
        ]);

        // Log the validated data (access data directly from $request->all())
        Log::info('Validated data:', $request->all()); // Log all request data, validated data can be accessed this way

        // Lidar com o upload da imagem de perfil
        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
            Log::info('Profile image uploaded to: ' . $profileImagePath);
        }

        // Create a new user and log the creation
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'username' => $request->username,
            'telcel' => $request->telcel,
            'id_perfil' => $request->id_perfil,
            'setor' => $request->setor,
            'status' => true, // Status is always true as per the previous logic
            'menu_permissions' => $request->menu_permissions,
            'profile_image' => $profileImagePath, // Store the path of the uploaded image
        ]);

        // Log the user creation
        Log::info('User created successfully:', $user->toArray());

        // Trigger the Registered event
        event(new Registered($user));

        // Log the login event
        Log::info('Logging in the user:', $user->toArray());

        // Log the user in
        Auth::login($user);

        // Redirect to dashboard
        return redirect(route('dashboard', absolute: false));
    }
}
