<!-- ///////////////////////////////////// AUTH /////////////////////////////////////////-->
STATUS_CODE: 
910: COn 3 don hang chua thanh toan, hay thanh toan roi mua tiep
904: User chua mua hang
903: Cần phải đăng nhập
902: Đã comment rồi
901: Account bị khóa rồi 
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
URL: http://localhost:8000/api/auth/profile,
Method: GET
Content type: application/json

    Nếu user đã login -> return: Tất cả thông tin của user vừa đăng nhập
    Nếu user đã logout hoặc chưa login -> return:  'message' => 'You need to login to get profile' -->



<!-- Edit profile { -->
    URL: http://localhost:8000/api/auth/edit_profile
    Method: POST
    Content type: application/json

        data {
            'full_name'
            'phone'
            'address'
            password và password_confirmation nếu user có đổi password
        }
        return {
            'message' => 'Edit successfully'    
        }

<!-- ///////////////////////////////////// CATEGORY /////////////////////////////////////////-->

Category {
URL: http://localhost:8000/api/product/category,
Method: GET
Content type: application/json

    return: Tất cả category

}

<!-- ///////////////////////////////////// PRODUCT /////////////////////////////////////////-->

<!-- Product { -->
URL1: http://localhost:8000/api/product/allproduct  
METHOD: POST
    Data gửi xuống: 
        "category" => $request->category vd san pham = 0, hat = 1, trai cay kho = 3,
     return: {
        if(category == 0) {
            Tat ca san pham 
        }
        else {
            Tat ca san pham co trong category do
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


<!-- Top 5 product co sao cao nhat { -->
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



<!-- Top 5 product noi bat  { -->
URL: http://localhost:8000/api/product/featured_products
METHOD: GET
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
    data_order: {
        'email' => $request->email,
        'full_name' => $request->full_name,
        'address' => $request->address,
        'phone' => $request->phone,
        'transaction' => $request->transaction,
        'subtotal' => $request->subtotal,
    }
    }

    return: {
        'message' => 'Checkout successfully'
    }
    status_code => 910 -> Please pay for your order to continue shopping 


    Data của order items gửi xuống
    "data_orderDetail": [
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

    return cua order items:
    data_orderDetail {
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
        "data": [
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
        "data": [
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
Method: POST
    Data gửi xuống: position = $request->position: 1 hoặc 2
    return: {
        id, title, image, description, position: banner or slide, status: show or hidden
    }

}

<!-- ///////////////////////////////////// Review /////////////////////////////////////////-->
<!-- Get Comments { -->
URL: http://localhost:8000/api/review/review
Method: POST
Content type: application/json

    Data: {
        'content' => $request->content,
        'product_id' => $request->product_id,
        'star' => $request->star
    }

    return {
        'message': Review successfully
        'status_code: 
        
    }
    Status_code:
        904: User chua mua hang
        903: Cần phải đăng nhập
        902: Đã comment rồi
        901: Account bị khóa rồi 

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
<!-- Payment -->
URL: http://localhost:8000/api/vnpay/vnpay_payment
METHOD: POST
Data gửi xuống: {
    $request->subtotal
    $request->bank_code -> Ngân hàng gì: Vietcombank, NCB, TPBank (Phải đúng code)

    return: {
        {
        "code": "00",
        "message": "success",
        "url": "" -> Đường dẫn tới cổng thanh toán
        }
    }
    Khi thanh toán thành công sẽ trả 1 về trang bên client
}

