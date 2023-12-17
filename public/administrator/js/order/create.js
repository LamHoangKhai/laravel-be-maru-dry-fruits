$(document).ready(() => {
    let listItem = [];
    let optionItem = "";
    let optionWeights = "";
    let innerHTML = "";

    // call get product and weight tags
    $.ajax({
        type: "POST",
        url: $("#url").data("url"),
        dataType: "json",
        success: (res) => {
            let data = res?.data || [];
            for (const item of data.products) {
                optionItem += `<option value="${item.id}">${
                    item.name
                } --- price: ${item.price} ---  quantity: ${
                    item.stock_quantity + item.store_quantity
                }</option>`;
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
                            <input class="form-control item_id" list="datalistOptions" id="exampleDataList"f
                            placeholder="Type to search..." name="product[]">
                            <datalist id="datalistOptions">
                                ${optionItem}
                            </datalist>
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
        },
        error: function (error) {
            console.log(error.message);
        },
    });

    //handle click add item
    $("#add-item").click(() => {
        $("#list-item").append(innerHTML);
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

    //submit form
    $("#form").submit(function (e) {
        let isTrue = true;
        $(".item").each(function () {
            let selecterProduct = $(this).children().children(".item_id");
            let itemId = selecterProduct.val()
                ? parseInt(selecterProduct.val())
                : 0;
            let checkExistItem = listItem.find((e) => itemId === e);
            let removeTextDanger = selecterProduct.parent();
            if (!checkExistItem) {
                removeTextDanger.find(".text-danger").remove();
                selecterProduct
                    .parent()
                    .append(
                        `<span class="text-danger">* Not found product</span>`
                    );
                isTrue = false;
            } else {
                removeTextDanger.find(".text-danger").remove();
            }
        });
        if (!isTrue) {
            return e.preventDefault();
        }
        $(this).submit();
    });
});
