$(document).ready(() => {
    $("#select").change((e) => {
        let product_id = e.target.value;
        createItems(product_id);
    });
    $("#list-item").on("click", ".remove-item", (e) => {
        $(e.target).parent().parent().remove();
    });

    $("#list-item").on("change", ".quantity", (e) => {
        console.log("run");
        if (!e.target.value || e.target.value < 1) {
            e.target.value = 1;
        }
        if (e.target.value > 100) {
            e.target.value = 100;
        }
    });

    $(".js-example-basic-single").select2({
        theme: "bootstrap4",
    });

    $("#discount").keyup((e) => {
        if (!e.target.value || e.target.value < 0) {
            e.target.value = 0;
        }
        if (e.target.value > 100) {
            e.target.value = 100;
        }
    });

    $("#scan").click(() => {
        // disable button scan
        setTimeout(() => {
            $("#scan").prop("disabled", true);
        }, 100);
        // show camera
        $("#preview").css("display", "block");
        // if timouet 20s close camera
        let timerId = setTimeout(() => {
            $(".closeModal").trigger("click");
            $("#scan").prop("disabled", false);
            scanner.stop();
        }, 20000);

        let scanner = new Instascan.Scanner({
            video: $("#preview")[0],
        });

        scanner.addListener("scan", function (qrURl) {
            // clear all timeout

            clearTimeout(timerId);
            // check math url
            if (!checkMathUrl(qrURl)) {
                Swal.fire({
                    icon: "error",
                    title: "Error!!!",
                    html: "<strong>QR not exist</strong>",
                    timer: 3000,
                });
                $(".closeModal").trigger("click");
                $("#scan").prop("disabled", false);
                scanner.stop();
                return;
            }
            let url = new URL(qrURl);
            let product_id = url.search.split("=")[1];
            // create item
            createItems(product_id);
            //close camera
            $(".closeModal").trigger("click");
            $("#scan").prop("disabled", false);
            scanner.stop();
        });
        //on camera
        Instascan.Camera.getCameras()
            .then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    console.error("No cameras found.");
                }
            })
            .catch(function (e) {
                console.error(e);
            });
        //close camera if click over layer modal
        $(".modal ").click(() => {
            // clear all timeout
            clearTimeout(timerId);
            $("#scan").prop("disabled", false);
            scanner.stop();
        });
    });
});

const checkMathUrl = (url) => {
    return url.indexOf("/admin/product/detail/") != -1 ? true : false;
};

const createItems = (product_id) => {
    $.ajax({
        type: "POST",
        url: $("#url").data("url"),
        data: { id: product_id },
        dataType: "json",
        success: (res) => {
            console.log("run");
            let data = res?.data || [];
            let optionWeights = "";
            let innerHTML = "";
            for (const item of data.weights) {
                optionWeights += `<option class="text-center" value="${
                    item.mass
                }">${
                    item.mass >= 1000
                        ? item.mass / 1000 + "kg"
                        : item.mass + "gram"
                }</option>`;
            }

            innerHTML = `<div class="row item">
                        <div class="row">
                         <i class='bx bx-x remove-item w-px-20'></i>
                         </div>
                         <div class="col mb-2 d-flex align-items-center justify-content-center">
                           <span >${data.product.name} </span>
                           <input type="hidden" name="products[]" value="${data.product.id}">
                        </div>
                        <div class="col mb-2  d-flex align-items-center justify-content-center">
                        <span >$${data.product.price}/100gram </span>
                        </div>
                        <div class="col mb-2 text-center">
                            <select name="weight[]" class="form-select ">
                                ${optionWeights}
                            </select>
                         </div>

                        <div class="col mb-2  ">
                            <input type="number"  class="form-control text-end quantity"
                            placeholder="Enter quantity" name="quantity[]" value="1"   min="1" max="100"/>
                        </div>
            </div>`;
            //append 1 product
            $("#list-item").append(innerHTML);
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
