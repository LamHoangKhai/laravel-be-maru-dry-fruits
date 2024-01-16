import { getUrl } from "../function.js";

$(document).ready(() => {
    $("#select").change((e) => {
        let id = e.target.value;
        createItems(id);
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
        if (code == 13 || code == 9) {
            let id = barcode.match(/\d+$/);
            createItems(id);
            barcode = "";
        } else {
            barcode = barcode + String.fromCharCode(code);
        }
    });
    //end handle scan
});

let listItem = [];
const createItems = (id) => {
    $.ajax({
        type: "POST",
        url: getUrl("/order/product"),
        data: { id: parseInt(id) },
        dataType: "json",
        success: (res) => {
            let data = res?.data || [];
            let isExist = listItem.find((item) =>
                item.product_id === data.product_id &&
                item.weight_id === data.weight_tag_id
                    ? true
                    : false
            );
            if (isExist) {
                listItem = listItem.map((item) => {
                    if (
                        item.product_id === data.product_id &&
                        item.weight_id === data.weight_tag_id
                    ) {
                        return {
                            ...item,
                            quantity: item.quantity + 1,
                        };
                    }
                    return item;
                });
            } else {
                listItem = [
                    ...listItem,
                    {
                        product_id: data.product_id,
                        weight_id: data.weight_tag_id,
                        name: data.product.name,
                        price: data.product.price,
                        mass: data.weight_tag.mass,
                        quantity: 1,
                    },
                ];
            }

            let innerHTML = "";
            listItem.map((item) => {
                return (innerHTML += `
                <div class="row item">
                    <div class="row">
                     <i class='bx bx-x remove-item w-px-20'></i>
                     </div>
                     <div class="col mb-2 d-flex align-items-center justify-content-center">
                       <span >${item.name} </span>
                       <input type="hidden" name="products[]" value="${
                           item.product_id
                       }">
                    </div>
                    <div class="col mb-2  d-flex align-items-center justify-content-center">
                        <span >$${item.price}/100gram </span>
                    </div>
                    <div class="col mb-2 d-flex align-items-center justify-content-center">
                       <span >${
                           item.mass >= 1000
                               ? item.mass / 1000 + "kg"
                               : item.mass + "gram"
                       } </span>
                       <input type="hidden" name="weight[]" value="${
                           item.mass
                       }">
                    </div>
                    <div class="col mb-2  ">
                        <input type="number"  class="form-control text-end quantity"
                        placeholder="Enter quantity" name="quantity[]" value=${
                            item.quantity
                        }   min="1" max="100"/>
                    </div>
                </div>`);
            });

            $("#list-item").html(innerHTML);
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
