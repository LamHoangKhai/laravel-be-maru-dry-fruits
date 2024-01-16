import { formatDate, loading, setTotalPages, renderLink } from "../function.js";

const loadProduct = (storage) => {
    const links = [
        {
            url: storage.url + "/warehouse/create-import/",
            text: "Import",
            classBootstrap: "",
            classIcon: "bx bx-import",
        },
        {
            url: storage.url + "/warehouse/create-export/",
            text: "Export",
            classBootstrap: "",
            classIcon: "bx bx-export",
        },
        {
            url: storage.url + "/warehouse/log/",
            text: "Log I/E",
            classBootstrap: "",
            classIcon: "bx bx-history",
        },
        {
            url: storage.url + "/edit/",
            text: "Edit",
            classBootstrap: "",
            classIcon: "bx bx-edit-alt me-1",
        },
        {
            url: storage.url + "/destroy/",
            text: "Delete",
            classBootstrap: "text-danger delete",
            classIcon: "bx bx-trash me-1",
        },
    ];

    const numberOfTH = $("thead th").length;
    loading(numberOfTH);

    $.ajax({
        type: "POST",
        url: storage.url + "/get-products",
        data: storage,
        dataType: "json",
        success: (res) => {
            let xhtml = "";
            let data = res?.data?.data || [];
            if (data.length === 0) {
                xhtml += `
                    <tr>
                    <td valign="top" colspan=${numberOfTH} class="text-center">No matching records found</td>
                    </tr>
                     `;
            } else {
                data.forEach((element, index) => {
                    let updated_at = formatDate(new Date(element.updated_at));

                    let qr =
                        element.product || element.product_weight.length > 0
                            ? element.product_weight[0].qrcode
                            : "";

                    let type =
                        element.status === 1
                            ? ["Show", "primary"]
                            : ["Hidden", "dark"];


                    xhtml += `
                    <tr>
                    <td>${
                        storage.page === 1
                            ? index + 1
                            : storage.take * storage.page -
                              storage.take +
                              index +
                              1
                    }</td>
                    <td class="max-250">${element.name}</td>
                    <td>${
                        element.category && element.category.name
                            ? element.category.name
                            : "Has deleted."
                    }</td>
                    <td >
			      <img src="${
                      element.image
                  }" class="img" alt="Sheep" width="100" height="75" >
		             </td>
                    <td>$${element.price}/100gram</td>
                    <td>${element.stock_quantity}kg</td>
                    <td>${element.store_quantity}kg</td>
                    <td>
                    <span class="badge rounded-pill bg-${type[1]}">${
                        type[0]
                    }</span>
                    </td>
                    <td  class="max-110">${updated_at}</td>
                    
                    <td class="g-2" >
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                            data-bs-toggle="dropdown" aria-expanded="false">
                                 <i class="bx bx-dots-vertical-rounded"></i>
                            </button>

                            <div class="dropdown-menu" style="">
                            <button value="${qr}" class="dropdown-item qr" i><i class='bx bx-qr'></i> QR</button>
                            ${renderLink(links, element.id)}
                            </div>

                         </div>
                    </td>

                        </tr>
                     `;
                });
            }

            setTimeout(() => $("#renderData").html(xhtml), 300);
            storage.totalData = res.data.total;
            setTotalPages(storage);
        },
        error: function (error) {
            Swal.fire({
                title: "Errors system!!",
                text: "The system needs maintenance.",
                icon: "warning",
            });
            console.log(error.message);
        },
    });
};

//load detail product
const detailProduct = (url, product_id) => {
    $(".card-img").attr("src", "");
    $(".name").html("");
    $(".category").html("");
    $(".price").html("");
    $(".input_price").html("");
    $(".exp_date").html("");
    $(".description").html("");
    $("#exLargeModal").modal("hide");

    $.ajax({
        type: "POST",
        url: url + "/detail",
        data: { id: product_id },
        dataType: "json",
        success: (res) => {
            let product = res.data.product;
            let warehouse = res.data.warehouse;
            let qrCode = res.data.qr_weight_tag;
            $(".card-img").attr("src", product.image);
            $(".name").html(product.name);
            $(".category").html("Category: " + product.category.name);
            $(".price").html("Price: " + product.price);
            $(".input_price").html(
                "Input Price: $" +
                    (warehouse && warehouse.input_price
                        ? warehouse.input_price
                        : 0)
            );
            $(".exp_date").html(
                "Exp Date: " +
                    (warehouse && warehouse.expiration_date
                        ? warehouse.expiration_date
                        : "")
            );
            $(".stock_quantity").html(
                "Stock Quantity: " + product.stock_quantity
            );
            $(".store_quantity").html(
                "Store Quantity: " + product.store_quantity
            );
            $(".total_quantity").html(
                "Total Quantity: " +
                    (product.stock_quantity + product.store_quantity)
            );

            let btnHTMl = ``;
            qrCode.map((item) => {
                return (btnHTMl += `<button type="button" class="btn rounded-pill btn-info btn-xs qr" style="margin-right:4px;" value=${
                    item.qrcode
                }>${
                    item.weight_tag.mass >= 1000
                        ? item.weight_tag.mass / 1000 + "kg"
                        : item.weight_tag.mass + "gram"
                }</button>`);
            });

            $(".qr_weight_tag").html(btnHTMl);

            $("#exLargeModal").modal("show");
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
export { loadProduct, detailProduct };
