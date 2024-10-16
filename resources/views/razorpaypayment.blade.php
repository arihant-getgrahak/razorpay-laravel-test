<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen gap-4">
    <h1 class="text-2xl font-bold text-center mb-6 underline">Razorpay Payment</h1>

    <body class="bg-gray-100 flex items-center justify-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
            <form id="paymentForm" class="space-y-6">
                @csrf


                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" id="name" name="name" required
                        class="mt-1 p-2 border border-gray-300 w-full rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" required
                        class="mt-1 p-2 border border-gray-300 w-full rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                    <input type="number" id="amount" name="amount" required step="0.01" min="0"
                        class="mt-1 p-2 border border-gray-300 w-full rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <button type="submit" id="payBtn"
                        class="w-full bg-blue-500 text-white p-2 rounded-md shadow-lg hover:bg-blue-600 transition duration-300">
                        PayNow
                    </button>
                </div>
            </form>
        </div>
    </body>

    <script>
        document.getElementById('payBtn').onclick = function (e) {
            e.preventDefault();

            fetch("{{ url('api/user/payment/create-order') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                    amount: document.getElementById('amount').value
                })
            })
                .then(response => response.json())
                .then(data => {
                    window.location.href = `/arihant/razorpay/public/pay?order_id=${data.order_id}&amount=${data.amount}&name=${data.name}&email=${data.email}`;
                    // var options = {
                    //     "key": "{{ env('RAZORPAY_KEY') }}",
                    //     "amount": data.amount * 100,
                    //     "currency": "INR",
                    //     "name": data.name,
                    //     "description": "Test Transaction",
                    //     "order_id": data.order_id,
                    //     "handler": function (response) {
                    //         document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                    //         document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                    //         document.getElementById('razorpay_signature').value = response.razorpay_signature;
                    //         document.getElementById('paymentForm').submit();
                    //     },
                    //     "prefill": {
                    //         "name": data.name,
                    //         "email": data.email
                    //     },
                    //     "theme": {
                    //         "color": "#F37254"
                    //     }
                    // };


                    // var rzp1 = new Razorpay(options);
                    // rzp1.on('payment.failed', async function (response) {
                    //     const res = await fetch("{{ url('api/user/payment/fail') }}", {
                    //         method: 'POST',
                    //         headers: {
                    //             'Content-Type': 'application/json',
                    //             'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    //         },
                    //         body: JSON.stringify({
                    //             order_id: response.error.metadata.order_id,
                    //             message: response.error.description
                    //         })
                    //     })
                    //     const data = await res.json();
                    //     if (!data.success) {
                    //         alert(data.message);
                    //     }
                    // });
                    // rzp1.open();
                })
                .catch(error => console.error('Error:', error));
        };
    </script>
</body>

</html>