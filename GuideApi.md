Login {
    URL: http://localhost:8000/api/auth/login,
    Method: POST
    Content type: application/json
    Data: {
        email,
        password,
    }
    return: {
        access_tokens,
        token_type,
        expires_in
    }
}

Register {
    URL: http://localhost:8000/api/auth/register,
    Method: POST
    Content type: application/json
    Data: {
        email,
        password,
        password_confirmation
    }
    return: {
       'message': 'User successfuly registered'
    }
}

Logout {
    URL: http://localhost:8000/api/auth/logout,
    Method: POST
    Content type: application/json

    return: {
        'message' => 'Successfully logged out'
    }
}

Profile {
    URL: http://localhost:8000/api/auth/profile,
    Method: GET
    Content type: application/json

    Nếu user đã login -> return: Tất cả thông tin của user vừa đăng nhập
    Nếu user đã logout hoặc chưa login -> return:  'message' => 'You need to login to get profile'
}

Category {
    URL: http://localhost:8000/api/product/category/{parent_id},
    Method: GET
    Content type: application/json

    return: Tất cả thằng con của parent đó
}

Product {
    URL1: http://localhost:8000/api/product/allproduct,
    URL2: http//localhost:8000/api/product/product/{category_id}
    Method: GET
    Content type: application/json

    URL1: Trả về tất cả product
    URL2: Trả về tất cả các product có trong category
}

Order {
    URL: http://localhost:8000/api/order/order
    Method: POST
    Content type: application/json

    Data: {
        'email' => $request->email,
        'full_name' => $request->full_name,
        'address' => $request->address,
        'phone' => $request->phone,
        'transaction' => $request->transaction,
        'total' => $request->total,
    }

    return: {
        'message' : "Checkout successfully",
        'email'
        'full_name'
        'address'
        'phone'
        'transaction'
        'total'
        'status_order_id' => 1,
        'grand_total' => $request->total + 35000,
        'transaction_status' => 1,
        'created_at' => Carbon::now(),
    }
}

Order_Item {
    URL: http://localhost:8000/api/order/order_items
    Method: POST
    Content type: application/json

    Data: {
        $product_id = $request->product_id;
        $price = $request->price;
        $weight = $request->weight;
        $quantity = $request->quantity;
    }

    return: {
        'product_id' => $product_id,
        'order_id' => $latestOrder->id,
        'price' => $price,
        'weight' => $weight,
        'quantity' => $quantity
    }
}

Banner_Slide {
    URL: http://localhost:8000/api/banner_and_slide/banner_and_slide,
    Method: GET
    
    return: {
        id, title, image, description, position: banner or slide, status: show or hidden
    }
}

Get Comments {
    URL: http://localhost:8000/api/review/get_comment
    Method: POST
    Content type: application/json

    Data: {
        'content' => $request->content,
        'product_id' => $request->product_id,
    }

    return {
        'message': Comment successfully
    }
}

Get Rating {
    URL: http://localhost:8000/api/review/get_star
    Method: POST
    Content type: application/json

    Data: {
        'star' => $request->star,
        'product_id' => $request->product_id,
    }

    return {
         'message': Rating successfully
    }
}

Comment, Rating: Trả lên FE {
     URL: http://localhost:8000/api/review/return_review
    Method: GET
    Content type: application/json

    return {
        'full_name'
        'content'
        'star'
        'date'
        'product_id'
    }
}

Top 5 product co sao cao nhat  {
    URL: http://localhost:8000/api/product/highest_rating_products
    Method: get
    Content type: application/json

    return {
       "id"
            "category_id",
            "name":
            "image":
            "description":
            "nutrition_detail": 
            "stock_quantity": 
            "store_quantity": 
            "price":
            "star": 
            "status": 
            "feature": 
            "deleted_at": 
            "created_at": 
            "updated_at": 
    }
}

Top 5 san pham chat luong nhat  {
    URL: http://localhost:8000/api/product/featured_products
    Content type: application/json

    return {
       "id"
            "category_id",
            "name":
            "image":
            "description":
            "nutrition_detail": 
            "stock_quantity": 
            "store_quantity": 
            "price":
            "star": 
            "status": 
            "feature": 
            "deleted_at": 
            "created_at": 
            "updated_at": 
    }
}

