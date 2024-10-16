<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <section class="py-24 relative">
        <div class="w-full max-w-7xl px-4 md:px-5 lg:px-5 mx-auto">
            <div class="w-full flex-col justify-start items-start gap-8 inline-flex">
                <div class="w-full flex-col justify-start items-start lg:gap-14 gap-8 flex">
                    <div class="w-full text-center text-black text-3xl font-bold font-manrope leading-normal">
                        {{session('status')}}</div>
                    <div class="flex-col justify-start items-start gap-3 flex">
                        <h4 class="text-black text-xl font-medium leading-8">Hello, {{session('name')}}</h4>
                        <h5 class="text-gray-500 text-lg font-normal leading-8">Thank you for shopping</h5>
                        <h5 class="text-gray-500 text-lg font-normal leading-8">Your order has been confirmed and will
                            be shipped within two days.</h5>
                    </div>
                </div>

                <div
                    class="w-full p-5 rounded-xl border border-gray-200 flex-col justify-start items-center gap-4 flex">
                    <div class="w-full justify-between items-center gap-6 inline-flex">
                        <h5 class="text-gray-600 text-lg font-normal leading-8">Subtotal:</h5>
                        <h5 class="text-right text-gray-900 text-lg font-semibold leading-8">₹{{session('amount')}}</h5>
                    </div>
                    <div class="w-full justify-between items-center gap-6 inline-flex">
                        <h5 class="text-gray-600 text-lg font-normal leading-8">Delivery:</h5>
                        <h5 class="text-right text-gray-900 text-lg font-semibold leading-8">Free</h5>
                    </div>
                    <div class="w-full justify-between items-center gap-6 inline-flex">
                        <h5 class="text-gray-600 text-lg font-normal leading-8">Total:</h5>
                        <h5 class="text-right text-gray-900 text-lg font-semibold leading-8">{{session('amount')}}</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        if ("{{session('success')}}") {
            alert("Payment Successful");
        }
        else if ("{{session('error')}}") {
            alert("Payment Failed");
        }
    </script>
</body>

</html>