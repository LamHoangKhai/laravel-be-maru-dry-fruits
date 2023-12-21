<!-- ///////////////////////////////////// AUTH /////////////////////////////////////////-->
<!-- Login { -->
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


<!-- Register { -->
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


<!-- Logout { -->
URL: http://localhost:8000/api/auth/logout,
Method: POST
Content type: application/json

    return: {
        'message' => 'Successfully logged out'
    }


<!-- Profile { -->
<!-- URL: http://localhost:8000/api/auth/profile,
Method: GET
Content type: application/json

    Nếu user đã login -> return: Tất cả thông tin của user vừa đăng nhập
    Nếu user đã logout hoặc chưa login -> return:  'message' => 'You need to login to get profile' -->



<!-- Edit profile { -->
    URL: http://localhost:8000/api/edit_profile/edit_profile
    Method: POST
    Content type: application/json

        data {
            'full_name'
            'email'
            'phone'
            'address'
            password và password_confirmation nếu user có đổi password
        }
        return {
            'message' => 'Edit successfully'    
        }

<!-- ///////////////////////////////////// CATEGORY /////////////////////////////////////////-->

Category {
URL: http://localhost:8000/api/product/category/{parent_id},
Method: GET
Content type: application/json

    return: Tất cả thằng con của parent đó

}

<!-- ///////////////////////////////////// PRODUCT /////////////////////////////////////////-->

<!-- Product { -->
URL1: http://localhost:8000/api/product/allproduct  theo category
METHOD: POST
    Data gửi xuống: 
        "category" => $request->category vd san pham = 0, hat = 1, trai cay kho = 3
    return: {
        if(category != 0) {
            Tat ca san pham co trong category do
        }
        else {
            Tat ca san pham
        }

    }


<!-- Product Details -->
URL3: http//localhost:8000/api/product/product_details
METHOD: POST
    Data gửi xuống: product_id
    return: {
        Tất cả thông tin của sản phẩm
    }

Search Prouduct
URL4: http://localhost:8000/api/product/search_product
METHOD: POST
    Data gửi xuống: nội dung search
    return: {
        tất cả các sản phẩm có nội dung search
    }


<!-- Top 5 product co sao cao nhat theo category { -->
URL: http://localhost:8000/api/product/highest_rating_products/{category_id}
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



<!-- Top 5 product noi bat theo category { -->
URL: http://localhost:8000/api/product/featured_products/{category_id}
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




<!-- ///////////////////////////////////// ORDER /////////////////////////////////////////-->

<!-- Order { -->
URL: http://localhost:8000/api/order/order
Method: POST
Content type: application/json

    Data cua ORder: {
        'email' => $request->email,
        'full_name' => $request->full_name,
        'address' => $request->address,
        'phone' => $request->phone,
        'transaction' => $request->transaction,
        'subtotal' => $request->subtotal,
    }

    return cua order: {
        'message' : "Checkout successfully",
        'email'
        'full_name'
        'address'
        'phone'
        'transaction'
        'subtotal'
        'total' => $request->subtotal + 35000,
        'status' => 1,
        'transaction_status' => 1,
        'created_at' => Carbon::now(),
    }


    Data của order items gửi xuống
    "order_items": [
        {
            $product_id = 1;
            $price = 123;
            $weight = 2;
            $quantity = 3;
        },

        {
            $product_id = 1;
            $price = 123;
            $weight = 2;
            $quantity = 3;
        }
        ...
        ]

    return cua order items: {
     'product_id' => $product_id,
        'order_id' => $latestOrder->id,
        'price' => $price,
        'weight' => $weight,
        'quantity' => $quantity
    }


<!-- History Order { -->
    URL: http://localhost:8000/api/order/history_order
    Method: GET
    Content type: application/json
    return: {
        "history_order": [
            {
                "order_id": 2,
                "status": 1,
                "subtotal": 15000,
                "created_at": "2023-12-20T03:46:00.000000Z",
                "quantity": so luong item 
            },
        ]
    }


<!-- History order details { -->
    URL: http://localhost:8000/api/order/history_order_details
    Method: POST
    Content type: application/json
    data {
        order_id
    }
    return {
        "history_order_details": [
        {
            "name": "Chuối sấy",
            "price": 500,
            "weight": 500,
            "quantity": 12,
            "total": 30000
        },
        ]
    }


<!-- ///////////////////////////////////// Banner_Slide /////////////////////////////////////////-->
Banner_Slide {
URL: http://localhost:8000/api/banner_and_slide/banner_and_slide,
Method: GET

    return: {
        id, title, image, description, position: banner or slide, status: show or hidden
    }

}

<!-- ///////////////////////////////////// Review /////////////////////////////////////////-->
<!-- Get Comments { -->
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



<!-- Get Rating { -->
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



<!-- Comment, Rating: Trả lên FE { -->
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



<!-- ///////////////////////////////////// Feedback /////////////////////////////////////////-->
<!-- Feedback { -->
    URL: http://localhost:8000/api/feedback/feedback
    Method: POST
    Content type: application/json

        data {
            'full_name'
            'email'
            'phone'
            'content'
        }
        return {
            'message' => 'Feedback is sent successfully'    
        }


