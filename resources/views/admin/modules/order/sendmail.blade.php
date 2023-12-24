<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
    
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }
    
        p {
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <p>{{$body['dear']}}</p>
    <p>{{$body['greeting']}}</p>
    <p>Here are the details of your order</p>

    <table>
        <tr>
            <td>Order id:</td>
            <td>Date:</td>
            <td>Total:</td>
            <td>Transaction</td>
            <td>Name:</td> 
            <td>Address:</td>
            <td>Phone:</td>  
        </tr>

        <tr>
            <td>{{$body['order_id']}}</td>
            <td>{{$body['date']}}</td>
            <td>{{$body['total']}}</td>
            <td>{{$body['transaction'] == 1 ? 'Ship COD' : 'VNPAY'}}</td>
            <td>{{$body['full_name']}}</td>
            <td>{{$body['address']}}</td>
            <td>{{$body['phone']}}</td>
        </tr>
        
    </table>
    <p>{{$body['end']}}</p>
</body>
</html>