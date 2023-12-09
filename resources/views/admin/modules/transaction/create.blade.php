<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if(Session::has('message'))
    <div class="alert alert-danger">
        {{ Session::get('message') }}
    </div>
    @endif
    <form method="post" action="{{route('admin.transaction.store')}}" >
        @csrf
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Transaction create</h3>
    
            </div>
    
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Product ID</label>
                            <input type="text" class="form-control" placeholder="Enter product name" name="product_id" value="">
                        </div>
    
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" class="form-control" placeholder="Enter product price" name="quantity" value="">
                        </div>
    
                        <div class="form-group">
                            <label for=""> Transaction type</label>
                            <select name="transaction_type" id="">
                                <option value="1">Import</option>
                                <option value="2">Export</option>
                            </select>
                        </div>
                        

                        <div class="form-group">
                            <label>Shipment</label>
                            <input type="number" class="form-control" name="shipment" value="">
                        </div>

                    </div>

                    </div>
                </div>
            </div>
    
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </div>
        <!-- /.card -->
    </form>
</body>
</html>