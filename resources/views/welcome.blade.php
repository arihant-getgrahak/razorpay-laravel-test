<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Welcome</h1>
    <a href="/razorpay">Pay with Razorpay</a>

    <script>
        if ("{{session('success')}}") {
            alert("Payment Successful");
        }
        else if("{{session('error')}}") {
            console.log("Payment Failed");
            alert("Payment Failed");
        }
        else {
            alert("Payment Failed");
        }
    </script>
</body>

</html>