<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col justify-center items-center gap-4">
    <div class="container mx-auto p-6">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Amount</th>
                    <th class="py-3 px-6 text-left">Payment Status</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <tr class="border-b">
                    <td class="py-3 px-6">John Doe</td>
                    <td class="py-3 px-6">$120.00</td>
                    <td class="py-3 px-6">Paid</td>
                </tr>

            </tbody>
        </table>
    </div>

    <form method="POST" action="{{ url('pay/verify') }}" id="paymentForm">
        @csrf
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
        <button type="submit" id="payBtn"
            class="text-black p-2 rounded-md shadow-lg border border-gray-500 hover:bg-blue-500 hover:text-white">
            Pay Again</button>
    </form>

    <div class="hidden fixed inset-0 flex items-center justify-center z-50 backdrop-blur confirm-dialog "
        id="confirm-dialog">
        <div class="relative px-4 min-h-screen md:flex md:items-center md:justify-center">
            <div class=" opacity-25 w-full h-full absolute z-10 inset-0"></div>
            <div
                class="bg-white rounded-lg md:max-w-md md:mx-auto p-4 fixed inset-x-0 bottom-0 z-50 mb-4 mx-4 md:relative shadow-lg">
                <div class="md:flex items-center">
                    <div
                        class="rounded-full border border-gray-300 flex items-center justify-center w-16 h-16 flex-shrink-0 mx-auto">
                        <i class="bx bx-error text-3xl">
                            &#9888;
                        </i>
                    </div>
                    <div class="mt-4 md:mt-0 md:ml-6 text-center md:text-left">
                        <p class="font-bold">Warning!</p>
                        <p class="text-sm text-gray-700 mt-1">Do you really want to cancel this order?
                        </p>
                    </div>
                </div>
                <div class="text-center md:text-right mt-4 md:flex md:justify-end">
                    <button id="confirm-delete-btn"
                        class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-red-200 text-red-700 rounded-lg font-semibold text-sm md:ml-2 md:order-2">
                        Yes
                    </button>
                    <button id="confirm-cancel-btn"
                        class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-gray-200 rounded-lg font-semibold text-sm mt-4 md:mt-0 md:order-1">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <button id="show-modal-btn"
        class="p-2 rounded-md shadow-lg border border-gray-500 hover:bg-blue-500 hover:text-white">Cancel
        Order</button>

    <script>
        window.onload = function () {
            console.log("window loaded")
            const urlParams = new URLSearchParams(window.location.search);
            const name = urlParams.get('name');
            const email = urlParams.get('email');
            const amount = urlParams.get('amount');
            const order_id = urlParams.get('order_id');
            const razorpay_order_id = urlParams.get('razorpay_order_id');
            const razorpay_payment_id = urlParams.get('razorpay_payment_id');
            const razorpay_signature = urlParams.get('razorpay_signature');
            const key = urlParams.get("key")
            try {
                var options = {
                    "key": key,
                    "amount": amount * 100,
                    "currency": "INR",
                    "name": name,
                    "description": "Test Transaction",
                    "order_id": order_id,
                    "handler": function (response) {
                        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                        document.getElementById('razorpay_order_id').value = order_id;
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
                            order_id: response.error.metadata.order_id,
                            message: response.error.description
                        })
                    })
                    data = await res.json();
                    if (!data.success) {
                        alert(data.message);
                    }
                });
                rzp1.open();
            }
            catch (error) {
                alert(error);
            }
        }

        document.getElementById("payBtn").onclick = function (e) {
            const urlParams = new URLSearchParams(window.location.search);
            const name = urlParams.get('name');
            const email = urlParams.get('email');
            const amount = urlParams.get('amount');
            const order_id = urlParams.get('order_id');
            const razorpay_order_id = urlParams.get('razorpay_order_id');
            const razorpay_payment_id = urlParams.get('razorpay_payment_id');
            const razorpay_signature = urlParams.get('razorpay_signature');
            const key = urlParams.get("key")
            try {
                var options = {
                    "key": key,
                    "amount": amount * 100,
                    "currency": "INR",
                    "name": name,
                    "description": "Test Transaction",
                    "order_id": order_id,
                    "handler": function (response) {
                        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                        document.getElementById('razorpay_order_id').value = order_id;
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
                            order_id: response.error.metadata.order_id,
                            message: response.error.description
                        })
                    })
                    data = await res.json();
                    if (!data.success) {
                        alert(data.message);
                    }
                });
                rzp1.open();
            }
            catch (error) {
                alert(error);
            }
        }

        document.getElementById("cancelBtn").onclick = async function (e) {
            e.preventDefault();
            const message = "Are you sure you want to cancel the order?";
            if (confirm(message) === true) {
                const urlParams = new URLSearchParams(window.location.search);
                const order_id = urlParams.get('order_id');

                const res = await fetch("{{ url('api/order/cancel') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        order_id: order_id
                    })
                })
                data = await res.json();
                if (!data.success) {
                    alert(data.message);
                }
                window.location.href = 'order-cancel';
                return;
            }
            else {
                alert("Order Not Cancelled.")
            }

        }
    </script>
    <script>
        const modal = document.getElementById('confirm-dialog');
        const showModalBtn = document.getElementById('show-modal-btn');
        const cancelBtn = document.getElementById('confirm-cancel-btn');
        const deleteBtn = document.getElementById('confirm-delete-btn');

        showModalBtn.addEventListener('click', () => {
            console.log('show modal');
            modal.classList.remove('hidden');
        });

        cancelBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        deleteBtn.addEventListener('click', async () => {
            // e.preventDefault();
            console.log('delete');
            const urlParams = new URLSearchParams(window.location.search);
            const order_id = urlParams.get('order_id');

            const res = await fetch("{{ url('api/order/cancel') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    order_id: order_id
                })
            })
            data = await res.json();
            if (!data.success) {
                alert(data.message);
            }
            window.location.href = 'order-cancel';
            return;
        });
    </script>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const name = urlParams.get('name');
        const email = urlParams.get('email');
        const amount = urlParams.get('amount');
        const tableBody = document.getElementById('table-body');
        tableBody.innerHTML = '';
        const row = document.createElement('tr');
        row.classList.add('border-b');
        row.innerHTML = `
                        <td class="py-3 px-6">${name}</td>
                        <td class="py-3 px-6">₹${parseInt(amount).toFixed(2)}</td>
                        <td class="py-3 px-6 text-red-500">Pending</td>
                    `;
        tableBody.appendChild(row);
    </script>
</body>

</html>