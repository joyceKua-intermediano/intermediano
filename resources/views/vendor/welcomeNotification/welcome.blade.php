<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('Set your password') }} </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class=" h-screen bg-gray-50 flex items-center justify-center p-4">

    <form method="POST" class=" w-full max-w-[450px] mx-auto bg-white p-4 rounded-lg shadow-md">
        @csrf
    
        <input type="hidden" name="email" value="{{ $user->email }}"/>
    
        <div>
            <label for="password">{{ __('Password') }}</label>
    
            <div class="mb-4">
                <input id="password" type="password" class="@error('password') is-invalid @enderror border p-2 rounded-xl w-full"  name="password" autocomplete="new-password">
    
                @error('password')
                <span class="text-red-500 txt-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>
    
        <div>
            <label for="password-confirm">{{ __('Confirm Password') }}</label>
    
            <div>
                <input id="password-confirm" type="password" name="password_confirmation" class=" border p-2 rounded-xl w-full"
                       autocomplete="new-password">
            </div>
        </div>
    
        <div class="mt-5">
            <button type="submit" class=" bg-red-800 text-white hover:bg-red-700 duration-150 p-2 rounded-xl px-5">
                {{ __('Save password and login') }}
            </button>
        </div>
    </form>
    
    
</body>
</html>