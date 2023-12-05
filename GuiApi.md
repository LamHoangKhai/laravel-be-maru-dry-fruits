Login {
    URL: http://localhost:8000/api/auth/login,
    Method: POST
    Content type: application/json

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


