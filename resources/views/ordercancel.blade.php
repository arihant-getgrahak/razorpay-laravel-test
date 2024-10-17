<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Canceled</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-red-500" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>
            <h2 class="text-2xl font-semibold mt-4">Order Canceled</h2>
            <p class="mt-2 text-gray-600">Your order has been successfully canceled.</p>
            <button class="mt-6 bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600">
                <a href="{{ url('/') }}">
                    Return to Homepage
                </a>
            </button>
        </div>
    </div>

</body>

</html>