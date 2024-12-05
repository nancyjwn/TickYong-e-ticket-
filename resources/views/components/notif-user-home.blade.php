<!-- Success and Error Messages with Modern Styling -->
@if (session('success'))
<div
    class="p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-lg shadow-md flex items-center space-x-4">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <strong>Success:</strong> {{ session('success') }}
</div>
@endif
@if (session('error'))
<div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-lg shadow-md flex items-center space-x-4">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
    </svg>
    <strong>Error:</strong> {{ session('error') }}
</div>
@endif