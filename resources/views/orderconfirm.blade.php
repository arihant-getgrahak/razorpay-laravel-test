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
    <h1>a</h1>
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