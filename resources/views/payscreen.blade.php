<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex justify-center items-center">
    <form method="POST" action="{{ url('arihant/razorpay/public/pay/verify') }}" id="paymentForm">
        @csrf
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
        <button type="submit" id="payBtn"
            class="text-black p-2 rounded-md shadow-lg border border-gray-500 hover:bg-blue-500 w-[50%]">Pay with
            Razorpay</button>
    </form>

    <script>
        document.getElementById('payBtn').onclick = function (e) {
            e.preventDefault();
            const urlParams = new URLSearchParams(window.location.search);
            const name = urlParams.get('name');
            const email = urlParams.get('email');
            const amount = urlParams.get('amount');
            const order_id = urlParams.get('order_id');
            const razorpay_order_id = urlParams.get('razorpay_order_id');
            const razorpay_payment_id = urlParams.get('razorpay_payment_id');
            const razorpay_signature = urlParams.get('razorpay_signature');
            try {
                var options = {
                    "key": "{{ env('RAZORPAY_KEY') }}",
                    "amount": amount * 100,
                    "currency": "INR",
                    "name": name,
                    "description": "Test Transaction",
                    "order_id": order_id,
                    "handler": function (response) {
                        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                        document.getElementById('razorpay_order_id').value = response.order_id;
                        document.getElementById('razorpay_signature').value = response.razorpay_signature;
                        document.getElementById('paymentForm').submit();
                    },
                    "prefill": {
                        "name": name,
                        "email": email
                    },
                    "theme": {
                        "color": "#F37254"
                    }
                };
                var rzp1 = new Razorpay(options);
                rzp1.on('payment.failed', async function (response) {
                    const res = await fetch("{{ url('api/user/payment/fail') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            order_id: response.error.morder_id,
                            message: response.error.description
                        })
                    })
                    data = await res.json();
                    if (!datasuccess) {
                        alert(data.message);
                    }
                });
                rzp1.open();
            }
            catch (error) {
                console.log(error);
            }
        }

    </script>
</body>

</html>