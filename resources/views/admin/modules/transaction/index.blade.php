<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if(Session::has('success'))
    <div class="alert alert-danger">
        {{ Session::get('success') }}
    </div>
    @endif

    @if(Session::has('message'))
    <div class="alert alert-danger">
        {{ Session::get('message') }}
    </div>
    @endif
    <table>
        @foreach ($transactions as $transaction)   
        <tr>
            <td>Product ID:</td>
            <td>{{$transaction->product_id}}</td>
        </tr>

        <tr>
            <td>Quantity:</td>
            <td>{{$transaction->quantity}}</td>
        </tr>

        <tr>
            <td>Current quantity:</td>
            <td>{{$transaction->current_quantity}}</td>
        </tr>

        <tr>
            <td>Transaction type:</td>
            <td>{{$transaction->transaction_type}}</td>
        </tr>

        <tr>
            <td>Shipment:</td>
            <td>{{$transaction->shipment}}</td>
        </tr>
        @endforeach
    </table>
    <button id="export">Export</button>
    <form action="{{route('admin.transaction.export')}}" method="POST" id="export1">
        @csrf
    </form>
    <script>
        var button = document.getElementById('export');
        button.onclick = function (e) {
            var inputProduct = document.createElement("input");
            inputProduct.type = 'number';
            inputProduct.name = 'export_product';
            inputProduct.placeholder = 'Enter product_id';
            
            var inputQuantity = document.createElement("input");
            inputQuantity.type = 'number';
            inputQuantity.name = 'export_quantity';
            inputQuantity.placeholder = 'Enter quantity';
            document.getElementById('export1').appendChild(inputProduct);
            document.getElementById('export1').appendChild(inputQuantity);

            var inputShipment = document.createElement("input");
            inputShipment.type = 'number';
            inputShipment.name = 'export_shipment';
            inputShipment.placeholder = 'Enter shipment';
            document.getElementById('export1').appendChild(inputShipment);

            var button = document.createElement("button");
            button.type = 'submit';
            button.innerText = 'Export';
            document.getElementById('export1').appendChild(button);
        }
    </script>
    <a href="{{route('admin.transaction.create')}}">Create</a>
</body>
</html>