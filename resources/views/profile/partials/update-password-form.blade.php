<section>
    <div class="card-body">
        <div class="card-title">
            <h2 class="h5 fw-semibold mb-2">{{ __('Update Password') }}</h2>
            <p class="text-muted small">
                {{ __('Ensure your account is using a long, random password to stay secure.') }}
            </p>
        </div>

        <form method="post" action="{{ route('password.update') }}" class="mt-4">
            @csrf
            @method('put')

            <div class="mb-3">
                <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
                <input 
                    type="password" 
                    id="update_password_current_password" 
                    name="current_password" 
                    class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                    autocomplete="current-password"
                >
                @error('current_password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
                <input 
                    type="password" 
                    id="update_password_password" 
                    name="password" 
                    class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                    autocomplete="new-password"
                >
                @error('password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                <input 
                    type="password" 
                    id="update_password_password_confirmation" 
                    name="password_confirmation" 
                    class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                    autocomplete="new-password"
                >
                @error('password_confirmation', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex align-items-center gap-3">
                <button type="submit" class="btn btn-primary">
                    {{ __('Save') }}
                </button>

                @if (session('status') === 'password-updated')
                    <div 
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-success"
                    >
                        {{ __('Saved.') }}
                    </div>
                @endif
            </div>
        </form>
    </div>
</section>