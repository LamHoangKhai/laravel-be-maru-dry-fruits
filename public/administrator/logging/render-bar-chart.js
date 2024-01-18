const renderBarCharMethod = (date) => {
    $.ajax({
        type: "POST",
        url: "http://localhost:8000/logging-method",
        data: { date },
        dataType: "json",
        success: (res) => {
            let dataRes = res.data ? res.data : [];
            let labels = Object.keys(dataRes);
            let numberGET = [];
            let numberPOST = [];
            let array = Object.values(dataRes);
            array.forEach((element, index) => {
                numberGET[index] = element.GET;
                numberPOST[index] = element.POST;
            });

            let $methodCanvas = $("#method");

            // Kiểm tra nếu tồn tại thẻ
            if ($methodCanvas.length) {
                // Tạo một thẻ mới với cùng id
                let $newMethodCanvas = $("<canvas>").attr("id", "method");

                // Thay thế thẻ cũ bằng thẻ mới
                $methodCanvas.replaceWith($newMethodCanvas);
            }

            let ctx = document.getElementById("method").getContext("2d");

            let data = {
                labels: labels,
                datasets: [
                    {
                        label: "GET",
                        backgroundColor: "rgba(75, 192, 192, 0.5)",
                        data: numberGET,
                    },
                    {
                        label: "POST",
                        backgroundColor: "rgba(255, 99, 132, 0.5)",
                        data: numberPOST,
                    },
                ],
            };

            let options = {
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true,
                    },
                },
            };

            let myChart = new Chart(ctx, {
                type: "bar",
                data: data,
                options: options,
            });
        },
        error: function (error) {
            Swal.fire({
                icon: "error",
                title: "Error!!!",
                html: "<strong>QR not exist</strong>",
                timer: 3000,
            });
            console.log(error.message);
        },
    });
};

const renderBarCharHttpCode = (date) => {
    $.ajax({
        type: "POST",
        url: "http://localhost:8000/logging-http-code",
        data: { date },
        dataType: "json",
        success: (res) => {
            let dataRes = res.data ? res.data : [];
            let labels = Object.keys(dataRes);
            let number200 = [];
            let number404 = [];
            let number429 = [];
            let number500 = [];
            let array = Object.values(dataRes);
            array.forEach((element, index) => {
                if (element["200"]) {
                    number200[index] = element["200"];
                }
                if (element["404"]) {
                    number404[index] = element["404"];
                }
                if (element["429"]) {
                    number429[index] = element["429"];
                }
                if (element["500"]) {
                    number500[index] = element["500"];
                }
            });

            let $httpCodeCanvas = $("#httpCode");

            // Kiểm tra nếu tồn tại thẻ
            if ($httpCodeCanvas.length) {
                // Tạo một thẻ mới với cùng id
                let $newHttpCodeCanvas = $("<canvas>").attr("id", "httpCode");

                // Thay thế thẻ cũ bằng thẻ mới
                $httpCodeCanvas.replaceWith($newHttpCodeCanvas);
            }

            let ctx = document.getElementById("httpCode").getContext("2d");

            let data = {
                labels: labels,
                datasets: [
                    {
                        label: "200",
                        backgroundColor: "rgba(75, 192, 192, 0.5)",
                        data: number200,
                    },
                    {
                        label: "404",
                        backgroundColor: "rgba(255, 99, 132, 0.5)",
                        data: number404,
                    },
                    {
                        label: "429",
                        backgroundColor: "rgba(200, 95,57, 0.5)",
                        data: number429,
                    },
                    {
                        label: "500",
                        backgroundColor: "rgba(78, 32,255, 0.5)",
                        data: number500,
                    },
                ],
            };

            let options = {
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true,
                    },
                },
            };

            let myChart = new Chart(ctx, {
                type: "bar",
                data: data,
                options: options,
            });
        },
        error: function (error) {
            Swal.fire({
                icon: "error",
                title: "Error!!!",
                html: "<strong>QR not exist</strong>",
                timer: 3000,
            });
            console.log(error.message);
        },
    });
};

const renderBarCharResponseTime = (date) => {
    $.ajax({
        type: "POST",
        url: "http://localhost:8000/logging-response-time",
        data: { date },
        dataType: "json",
        success: (res) => {
            let dataRes = res.data ? res.data : [];
            let labels = Object.keys(dataRes);
            let resTime = [];
            let array = Object.values(dataRes);
            array.forEach((element, index) => {
                resTime[index] = element.duration;
            });

            let $responseTimeCanvas = $("#responseTime");

            // Kiểm tra nếu tồn tại thẻ
            if ($responseTimeCanvas.length) {
                // Tạo một thẻ mới với cùng id
                let $newResponseTimeCanvas = $("<canvas>").attr(
                    "id",
                    "responseTime"
                );

                // Thay thế thẻ cũ bằng thẻ mới
                $responseTimeCanvas.replaceWith($newResponseTimeCanvas);
            }

            let ctx = document.getElementById("responseTime").getContext("2d");

            let data = {
                labels: labels,
                datasets: [
                    {
                        label: "Response Time (ms)",
                        backgroundColor: "rgba(255, 100, 255, 0.5)",
                        data: resTime,
                    },
                ],
            };

            let options = {
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true,
                    },
                },
            };

            let myChart = new Chart(ctx, {
                type: "bar",
                data: data,
                options: options,
            });
        },
        error: function (error) {
            Swal.fire({
                icon: "error",
                title: "Error!!!",
                html: "<strong>QR not exist</strong>",
                timer: 3000,
            });
            console.log(error.message);
        },
    });
};

export {
    renderBarCharMethod,
    renderBarCharHttpCode,
    renderBarCharResponseTime,
};
