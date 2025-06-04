<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-accent flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md p-8 bg-white rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Login</h2>

        @if(session('status'))
            <div class="mb-4 text-green-600 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('auth') }}">
            @csrf

            <div class="mb-4">
                <label for="username" class="block text-sm font-semibold mb-1">Username</label>
                <input id="username" type="text" name="username" required autofocus
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('username')
                        ring-red-500
                    @enderror">
                @error('username')
                    <p class="text-red-500 text-xs mt-2">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-semibold mb-1">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex items-center justify-between mb-4">
                <label class="flex items-center text-sm">
                    <input type="checkbox" name="remember" class="mr-2">
                    Remember me
                </label>
                <a href="" class="text-sm text-blue-600 hover:underline">
                    Forgot Password?
                </a>
            </div>

            <button type="submit"
                class="w-full bg-accent text-white py-2 rounded hover:bg-accent-content transition duration-200 cursor-pointer">
                Login
            </button>
        </form>

        <p class="mt-6 text-center text-sm">
            Don't have an account?
            <a href="" class="text-blue-600 hover:underline">Register</a>
        </p>
    </div>

</body>
</html>
