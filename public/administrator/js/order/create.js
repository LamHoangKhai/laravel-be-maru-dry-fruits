import { checkMathUrl } from "../function.js";

$(document).ready(() => {
    $("#select").change((e) => {
        let product_id = e.target.value;
        createItems(product_id);
    });
    $("#list-item").on("click", ".remove-item", (e) => {
        $(e.target).parent().parent().remove();
    });

    $("#list-item").on("change", ".quantity", (e) => {
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

    //handle scan
    let barcode = "";
    $(document).keypress(function (e) {
        var code = e.keyCode ? e.keyCode : e.which;

        if (code == 13) {
            console.log(barcode);
            if (checkMathUrl(barcode)) {
                createItems(barcode);
            }
            barcode = "";
        } else if (code == 9) {
            if (checkMathUrl(barcode)) {
                createItems(barcode);
            }
            barcode = "";
        } else {
            barcode = barcode + String.fromCharCode(code);
        }
    });
    //end handle scan
});

const createItems = (barcode) => {
    if (!checkMathUrl(barcode)) {
        Swal.fire({
            icon: "error",
            title: "Error!!!",
            html: "<strong>QR not exist</strong>",
            timer: 3000,
        });
        return;
    }

    let url = new URL(barcode);
    let product_id = url.search.split("=")[1];

    $.ajax({
        type: "POST",
        url: $("#url-detail").data("url"),
        data: { id: product_id },
        dataType: "json",
        success: (res) => {
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
