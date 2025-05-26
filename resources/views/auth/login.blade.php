<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="auth-title">Log In to <span class="accent">Nakshah</span></h2>
    
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">{{ __('Email Address') }}</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" 
                required autofocus autocomplete="username" placeholder="name@nakshah.com" />
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input id="password" class="form-input" type="password" name="password" 
                required autocomplete="current-password" placeholder="Enter your password" />
            @error('password')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="form-group">
            <div class="checkbox-container">
                <input id="remember_me" type="checkbox" name="remember">
                <label for="remember_me" class="text-sm">{{ __('Remember me') }}</label>
            </div>
        </div>

        <div class="auth-footer">
            <a class="auth-link text-sm" href="{{ route('register') }}">
                {{ __("Don't have an account?") }}
            </a>

            <button type="submit" class="primary-button">
                {{ __('Log In') }}
            </button>
        </div>
    </form>
</x-guest-layout>
