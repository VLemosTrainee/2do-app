<!-- resources/views/profile/partials/two-factor-authentication-form.blade.php -->
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Autenticação de Dois Fatores
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Adicione segurança adicional à sua conta usando a autenticação de dois fatores.
        </p>
    </header>

    @if (session('status') == 'two-factor-authentication-enabled')
        {{-- O 2FA está ativo, mas o utilizador está a reconfigurá-lo ou a ver os códigos --}}
        <div class="mt-4 max-w-xl text-sm text-gray-600 dark:text-gray-400">
            <p class="font-semibold">
                A autenticação de dois fatores está agora ativada.
            </p>
        </div>

        <div class="mt-4">
            <div class="font-semibold">
                Digitalize o seguinte código QR usando a aplicação de autenticação do seu telemóvel.
            </div>
            <div class="mt-2">
                {!! auth()->user()->twoFactorQrCodeSvg() !!}
            </div>
        </div>

        <div class="mt-4 max-w-xl text-sm text-gray-600 dark:text-gray-400">
            <p class="font-semibold">
                Guarde estes códigos de recuperação num local seguro. Eles podem ser usados para recuperar o acesso à sua conta se perder o seu dispositivo de autenticação de dois fatores.
            </p>
        </div>

        <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 dark:bg-gray-900 rounded-lg">
            @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                <div>{{ $code }}</div>
            @endforeach
        </div>

        <form method="POST" action="{{ route('two-factor.disable') }}" class="mt-5">
            @csrf
            @method('delete')
            <x-danger-button>{{ __('Desativar 2FA') }}</x-danger-button>
        </form>
    @else
        {{-- O 2FA não está ativo, mostrar o botão para ativar --}}
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mt-6">
            Você ainda não ativou a autenticação de dois fatores.
        </h3>

        <div class="mt-3 max-w-xl text-sm text-gray-600 dark:text-gray-400">
            <p>
                Quando a autenticação de dois fatores está ativada, ser-lhe-á solicitado um token seguro e aleatório durante a autenticação. Pode obter este token a partir da aplicação Google Authenticator do seu telemóvel.
            </p>
        </div>

        <form method="POST" action="{{ route('two-factor.enable') }}">
            @csrf
            <x-primary-button type="submit" class="mt-5">
                {{ __('Ativar 2FA') }}
            </x-primary-button>
        </form>
    @endif
</section>