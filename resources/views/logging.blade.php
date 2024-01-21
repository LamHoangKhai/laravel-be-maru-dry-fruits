<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Stacked Column Chart</title>
    <style>
        .content {
            width: 100%;
            height: auto;
            display: flex;
            justify-content: space-evenly
        }

        .width-600px {
            width: 600px;
            display: flex;
            flex-direction: column;
        }

        .width-600px h2 {
            text-align: center;
        }
    </style>
</head>

<body>
    <label for="selectDays">Chọn Ngày:</label>
    <select id="selectDays">
        <!-- Options sẽ được thêm vào đây bằng JavaScript -->
    </select>
    <div class="content">
        <div class="width-600px">
            <h2>Http Method</h2>
            <canvas id="method" width="600" height="400"></canvas>

        </div>

        <div class="width-600px">
            <h2>Http Response Time</h2>
            <canvas id="responseTime" width="600" height="400"></canvas>
        </div>


    </div>

    <div class="content">

        <div class="width-600px">
            <h2>Http Code</h2>
            <canvas id="httpCode" width="600" height="400"></canvas>
        </div>

    </div>


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script src="{{ asset('administrator/logging/main.js') }}" type="module"></script>
</body>

</html>
