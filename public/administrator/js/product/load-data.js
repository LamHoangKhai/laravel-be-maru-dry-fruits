import { formatDate, setTotalPages, checkMathUrl } from "../function.js";

const loadProduct = (storage) => {
    $.ajax({
        type: "POST",
        url: storage.url,
        data: storage,
        dataType: "json",
        success: (res) => {
            let xhtml = "";
            let data = res?.data?.data || [];
            if (data.length === 0) {
                xhtml += `
                    <tr>
                    <td valign="top" colspan="12" class="text-center">No matching records found</td>
                    </tr>
                     `;
            } else {
                data.forEach((element, index) => {
                    let created_at = formatDate(new Date(element.created_at));
                    let updated_at = formatDate(new Date(element.updated_at));
                    // get url edit
                    let urlEdit = $("#url-edit")
                        .attr("data-url")
                        .replace(/id/g, element.id);
                    // get url delete
                    let urlDelete = $("#url-destroy")
                        .attr("data-url")
                        .replace(/id/g, element.id);
                    //get url import product
                    let urlImport = $("#url-import")
                        .attr("data-url")
                        .replace(/id/g, element.id);
                    //get url export product
                    let urlExport = $("#url-export")
                        .attr("data-url")
                        .replace(/id/g, element.id);
                    //get url export product
                    let urlLog = $("#url-log")
                        .attr("data-url")
                        .replace(/id/g, element.id);

                    let type =
                        element.status === 1
                            ? ["Show", "primary"]
                            : ["Hidden", "dark"];

                    xhtml += `
                    <tr>
                    <td>${index + 1}</td>
                    <td class="max-250">${element.name}</td>
                    <td>${element.category.name}</td>
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
                    <td  class="max-110">${created_at}</td>
                    <td  class="max-110">${updated_at}</td>
                    
                    <td class="g-2" >
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                            data-bs-toggle="dropdown" aria-expanded="false">
                                 <i class="bx bx-dots-vertical-rounded"></i>
                            </button>

                            <div class="dropdown-menu" style="">
                            <button value="${
                                element.qrcode
                            }" class="dropdown-item qr" i><i class='bx bx-qr'></i> QR</button>
                            <a href="${urlImport}" class="dropdown-item"><i class='bx bx-import'></i> Import</a>
                            <a href="${urlExport}" class="dropdown-item"><i class='bx bx-export'></i> Export</a>
                            <a href="${urlLog}" class="dropdown-item"><i class='bx bx-history'></i> Log I/E</a>
                            <a href="${urlEdit}" class="dropdown-item"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                            <a  href="${urlDelete}" id="delete" value="${
                        element.id
                    }" class="text-danger delete dropdown-item"><i class="bx bx-trash me-1"></i> Delete</a>
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

const detailProduct = (barcode) => {
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
    $(".card-img").attr("src", "");
    $(".name").html("");
    $(".category").html("");
    $(".price").html("");
    $(".input_price").html("");
    $(".exp_date").html("");
    $(".description").html("");
    $("#exLargeModal").modal("toggle");
    $.ajax({
        type: "POST",
        url: $("#url-detail").data("url"),
        data: { id: product_id },
        dataType: "json",
        success: (res) => {
            console.log(res);
            let data = res.data.product;
            let exparationDate = res.data.exparationDate;
            $(".card-img").attr("src", data.image);
            $(".name").html(data.name);
            $(".category").html("Category: " + data.category.name);
            $(".price").html("Price: " + data.price);
            $(".input_price").html("Input Price: " + data.input_price);
            $(".exp_date").html("Exp Date: " + exparationDate);
            $(".description").html(data.description);
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
