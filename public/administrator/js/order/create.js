$(document).ready(() => {
    ajax();
    //handle click add item
    $("#add-item").click(() => {
        ajax();
    });
    // remove item
    $("#list-item").on("click", ".remove-item", (e) => {
        $(e.target).parent().parent().remove();
    });

    $("#discount").keyup((e) => {
        if (!e.target.value || e.target.value < 0) {
            e.target.value = 0;
        }
        if (e.target.value > 100) {
            e.target.value = 100;
        }
    });
});

const ajax = () => {
    $.ajax({
        type: "POST",
        url: $("#url").data("url"),
        dataType: "json",
        success: (res) => {
            let data = res?.data || [];
            let optionItem = "";
            let optionWeights = "";
            let innerHTML = "";
            let listItem = [];
            for (const item of data.products) {
                optionItem += `<option  value="${item.id}">${item.name} </option>`;
                listItem = [...listItem, item.id];
            }
            for (const item of data.weights) {
                optionWeights += `<option value="${item.mass}">${
                    item.mass >= 1000
                        ? item.mass / 1000 + "kg"
                        : item.mass + "gram"
                }</option>`;
            }

            innerHTML = `<div class="row item">
                        <div class="row">
                         <i class='bx bx-x remove-item w-px-20'></i>
                         </div>
                         <div class="col mb-2">
                            <select class="form-select js-example-basic-single item_id" name="product[]" >
                            ${optionItem}
                            <option value="" disabled selected></option>
                            </select>
                        </div>

                        <div class="col mb-2">
                            <select name="weight[]" class="form-select">
                                ${optionWeights}
                            </select>
                         </div>

                        <div class="col mb-2">
                            <input type="number"  class="form-control "
                            placeholder="Enter quantity" name="quantity[]" value="1"   min="1"/>
                        </div>
            </div>`;
            //append 1 product
            $("#list-item").append(innerHTML);
            $(".js-example-basic-single").select2({
                theme: "bootstrap4",
            });
        },
        error: function (error) {
            console.log(error.message);
        },
    });
};
