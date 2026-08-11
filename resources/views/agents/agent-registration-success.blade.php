<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center px-4">

<div class="max-w-md w-full bg-white rounded-2xl shadow-md p-10 text-center">

    <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-5
                {{ $action === 'created' ? 'bg-green-100' : 'bg-blue-100' }}">
        @if($action === 'created')
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        @else
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
        @endif
    </div>

    <h1 class="text-2xl font-bold text-gray-800 mb-2">
        {{ $action === 'created' ? 'Registration Successful!' : 'Record Updated!' }}
    </h1>

    <p class="text-gray-500 text-sm mb-6">
        {{ $action === 'created'
            ? 'Your CSC center has been added to the database.'
            : 'Your existing record has been updated with the new information.' }}
    </p>

    @if($center)
    <div class="bg-gray-50 rounded-lg p-4 text-left text-sm space-y-2 mb-6">
        <div class="flex justify-between">
            <span class="text-gray-500">Name</span>
            <span class="font-medium">{{ $center->vle_name }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-500">Mobile</span>
            <span class="font-medium">{{ $center->mobile }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-500">District</span>
            <span class="font-medium">{{ $center->district }}</span>
        </div>
    </div>
    @endif

    <a href="{{ route('agent.registration') }}"
       class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-6 py-3 rounded-lg transition">
        Register Another
    </a>
</div>

</body>
</html>
