<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cadastrar Nova Empresa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('empresas.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-3 gap-4">
                            <!-- Primeira coluna -->
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="nome" :value="__('Nome')" />
                                    <x-text-input id="nome" class="block mt-1 w-full" type="text" name="nome" :value="old('nome')" required />
                                </div>
                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" />
                                </div>
                                <div>
                                    <x-input-label for="telcom" :value="__('Telefone Comercial')" />
                                    <x-text-input id="telcom" class="block mt-1 w-full" type="text" name="telcom" :value="old('telcom')" />
                                </div>
                                <div>
                                    <x-input-label for="cep" :value="__('CEP')" />
                                    <x-text-input id="cep" class="block mt-1 w-full" type="text" name="cep" :value="old('cep')" />
                                </div>
                            </div>

                            <!-- Coluna central (Logo) -->
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="w-48 h-48 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center overflow-hidden border-4 border-gray-300 dark:border-gray-600">
                                    <img id="logo-preview" class="w-full h-full object-cover hidden" alt="Logo Preview">
                                    <span id="upload-icon" class="text-gray-400">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </span>
                                </div>
                                <input type="file" id="logo" name="logo" class="hidden" accept="image/*">
                                <x-primary-button type="button" class="w-full" onclick="document.getElementById('logo').click()">
                                    {{ __('Escolher Logo') }}
                                </x-primary-button>
                                <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                            </div>

                            <!-- Terceira coluna -->
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="razao_social" :value="__('Razão Social')" />
                                    <x-text-input id="razao_social" class="block mt-1 w-full" type="text" name="razao_social" :value="old('razao_social')" required />
                                </div>
                                <div>
                                    <x-input-label for="cnpj" :value="__('CNPJ')" />
                                    <x-text-input id="cnpj" class="block mt-1 w-full" type="text" name="cnpj" :value="old('cnpj')" />
                                </div>
                                <div>
                                    <x-input-label for="telcel" :value="__('Telefone Celular')" />
                                    <x-text-input id="telcel" class="block mt-1 w-full" type="text" name="telcel" :value="old('telcel')" />
                                </div>
                                <div>
                                    <x-input-label for="estado" :value="__('Estado')" />
                                    <x-text-input id="estado" class="block mt-1 w-full" type="text" name="estado" :value="old('estado')" />
                                </div>
                            </div>
                        </div>

                        <!-- Linha adicional para campos de endereço -->
                        <div class="grid grid-cols-3 gap-4 mt-4">
                            <div>
                                <x-input-label for="cidade" :value="__('Cidade')" />
                                <x-text-input id="cidade" class="block mt-1 w-full" type="text" name="cidade" :value="old('cidade')" />
                            </div>
                            <div>
                                <x-input-label for="bairro" :value="__('Bairro')" />
                                <x-text-input id="bairro" class="block mt-1 w-full" type="text" name="bairro" :value="old('bairro')" />
                            </div>
                            <div>
                                <x-input-label for="rua" :value="__('Rua')" />
                                <x-text-input id="rua" class="block mt-1 w-full" type="text" name="rua" :value="old('rua')" />
                            </div>
                        </div>

                        <!-- Última linha para número e botão salvar -->
                        <div class="flex items-center justify-between mt-4">
                            <div class="w-1/3">
                                <x-input-label for="numero" :value="__('Número')" />
                                <x-text-input id="numero" class="block mt-1 w-full" type="text" name="numero" :value="old('numero')" />
                            </div>
                            <x-primary-button>
                                {{ __('Salvar') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('logo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('logo-preview');
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    document.getElementById('upload-icon').classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>