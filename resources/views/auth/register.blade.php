<x-guest-layout>
    <h2 class="auth-title">Create Your Account</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name" class="form-label">{{ __("Full Name") }}</label>
            <input
                id="name"
                class="form-input"
                type="text"
                name="name"
                value="{{ old('name') }}"
                autofocus
                autocomplete="name"
                placeholder="Your full name"
            />
            @error('name')
            <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">{{
                __("Email Address")
            }}</label>
            <input
                id="email"
                class="form-input"
                type="text"
                name="email"
                value="{{ old('email') }}"
                autocomplete="username"
                placeholder="name@nakshah.com"
            />
            @error('email')
            <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Phone -->
        <div class="form-group">
            <label for="phone" class="form-label">{{
                __("Phone Number")
            }}</label>
            <input
                id="phone"
                class="form-input"
                type="number"
                name="phone"
                value="{{ old('phone') }}"
                placeholder="Your phone number"
            />
            @error('phone')
            <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">{{
                __("Password")
            }}</label>
            <input
                id="password"
                class="form-input"
                type="password"
                name="password"
                autocomplete="new-password"
                placeholder="Choose a secure password"
            />
            @error('password')
            <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">{{
                __("Confirm Password")
            }}</label>
            <input
                id="password_confirmation"
                class="form-input"
                type="password"
                name="password_confirmation"
                autocomplete="new-password"
                placeholder="Confirm your password"
            />
            @error('password_confirmation')
            <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-footer">
            <a class="auth-link text-sm" href="{{ route('login') }}">
                {{ __("Already have an account?") }}
            </a>

            <button type="submit" class="primary-button">
                {{ __("Register") }}
            </button>
        </div>
    </form>
</x-guest-layout>
