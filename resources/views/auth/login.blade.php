<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LAI.HUB</title>
    <link rel="stylesheet" href="{{ asset('login/css/style.css') }}">
    <link rel="icon" href="{{ asset('atlantis/img/icon/lai.ico') }}" type="image/x-icon"/>
    
</head>
<body>
    <div class="login-container">
        <img src="{{ asset('get-started/images/LAI.png') }}" alt="Logo Lautan Air Indonesia">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Email Address -->
                <div class="form-group">
                    <x-input-label for="username" :value="__('Username')" />
                    <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>


                <!-- Password -->
                <div class="form-group password-toggle">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">                 
                    <x-primary-button class="ms-3 bg-blue-500 hover:bg-blue-600 text-white">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
                
                <div class="options">
                    <label><input id="remember_me" type="checkbox" name="remember"> Remember me</label>
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>
                
            </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleText = document.querySelector('.password-toggle span');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleText.textContent = 'Show';
            } else {
                passwordInput.type = 'password';
                toggleText.textContent = 'Hide';
            }
        }
    </script>

    <script>
        document.getElementById('password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const loginButton = document.getElementById('login-button');
            
            if (password.trim() !== '') {
                loginButton.classList.remove('btn-disabled');
                loginButton.classList.add('btn-blue');
                loginButton.disabled = false;
            } else {
                loginButton.classList.remove('btn-blue');
                loginButton.classList.add('btn-disabled');
                loginButton.disabled = true;
            }
        });
    </script>
</body>
</html>
