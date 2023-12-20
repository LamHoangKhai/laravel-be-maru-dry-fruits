<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product details</title>
</head>
<body>
    @foreach ($product as $product_detail) 
        <p>{{$product_detail->name}}</p>
        <p>{{$product_detail->id}}</p>
    @endforeach
</body>
</html>