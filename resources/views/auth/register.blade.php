<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Profile Image Upload -->
        <div class="flex flex-col items-center mb-6">
            <div class="relative group cursor-pointer">
                <!-- Círculo para imagem de perfil -->
                <div
                    class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden border-4 border-gray-300 hover:border-indigo-500 transition-all duration-200">
                    <!-- Preview da imagem com limites para 32x32px -->
                    <img id="profile_image_preview" src="{{ asset('images/default-avatar.png') }}" alt="Profile Preview"
                        class="object-cover object-center"
                        style="width: 75px !important; height: 75px !important; display: none;">
                    <!-- Ícone padrão de imagem -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" id="default_icon"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <!-- Input oculto -->
                <input type="file" id="profile_image" name="profile_image" accept="image/*" class="hidden" />
                <div
                    class="absolute inset-0 rounded-full bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
            </div>
            <!-- Label para upload -->
            <label for="profile_image"
                class="mt-2 text-sm font-medium text-gray-600 cursor-pointer hover:text-indigo-500 transition-colors duration-200">
                {{ __('Upload Profile Picture') }}
            </label>
            <x-input-error :messages="$errors->get('profile_image')" class="mt-2" />
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Username -->
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')"
                required />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Telcel -->
        <div>
            <x-input-label for="telcel" :value="__('Telefone Celular')" />
            <x-text-input id="telcel" class="block mt-1 w-full" type="text" name="telcel" :value="old('telcel')" />
            <x-input-error :messages="$errors->get('telcel')" class="mt-2" />
        </div>

        <!-- Setor -->
        <div>
            <x-input-label for="setor" :value="__('Setor')" />
            <x-text-input id="setor" class="block mt-1 w-full" type="text" name="setor" :value="old('setor')" />
            <x-input-error :messages="$errors->get('setor')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Perfil de Acesso -->
        <div>
            <x-input-label for="id_perfil" :value="__('Tipo de Acesso')" />
            <select id="id_perfil" name="id_perfil"
                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="" disabled selected>Perfis de Acesso disponíveis</option>
                @foreach ($perfis as $perfil)
                    <option value="{{ $perfil->id }}">{{ $perfil->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('id_perfil')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        const profileImagePreview = document.getElementById('profile_image_preview');
        const defaultIcon = document.getElementById('default_icon');

        // Evento para alterar a imagem do perfil
        document.getElementById('profile_image').addEventListener('change', function(event) {
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Atualiza o src da imagem com a nova imagem
                    profileImagePreview.src = e.target.result;
                    // Exibe a imagem e oculta o ícone padrão
                    profileImagePreview.style.display = 'block';
                    defaultIcon.style.display = 'none';
                }

                reader.readAsDataURL(file);
            }
        });

        // Permitir o clique no círculo para abrir o input file
        document.querySelector('.group').addEventListener('click', function() {
            document.getElementById('profile_image').click();
        });
    </script>
</x-guest-layout>
