<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $nama_pengguna = '';
    public string $email = '';
    public string $tanggal_lahir = '';
    public string $alamat = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->nama_pengguna = Auth::user()->nama_pengguna;
        $this->email = Auth::user()->email;
        $this->tanggal_lahir = Auth::user()->tanggal_lahir;
        $this->alamat = Auth::user()->alamat;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        // Validasi properti selain email
        $validated = $this->validate([
            'nama_pengguna' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required', 'string'],
        ]);

        // Validasi email hanya jika diubah
        if ($this->email !== $user->email) {
            $this->validate([
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            ]);
            $user->email = $this->email;
        }

        // Update properti lainnya
        $user->nama_pengguna = $validated['nama_pengguna'];
        $user->tanggal_lahir = $validated['tanggal_lahir'];
        $user->alamat = $validated['alamat'];

        // Reset email verification jika email berubah
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Dispatch event untuk notifikasi
        $this->dispatch('profile-updated');

        // Redirect ke dashboard
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
    
    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <x-input-label for="nama_pengguna" :value="__('Nama')" />
            <x-text-input wire:model="nama_pengguna" id="nama_pengguna" name="nama_pengguna" type="text"
                class="mt-1 block w-full" required autofocus autocomplete="nama_pengguna" />
            <x-input-error class="mt-2" :messages="$errors->get('nama_pengguna')" />
        </div>

        <div>
            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
            <x-text-input wire:model="tanggal_lahir" id="tanggal_lahir" name="tanggal_lahir" type="date"
                class="mt-1 block w-full" required autofocus autocomplete="tanggal_lahir" />
            <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir')" />
        </div>

        <div>
            <x-input-label for="alamat" :value="__('Alamat')" />
            <x-text-input wire:model="alamat" id="alamat" name="alamat" type="text" class="mt-1 block w-full"
                required autofocus autocomplete="alamat" />
            <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
