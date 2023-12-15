import { formatDate, setTotalPages } from "../function.js";

const loadProduct = (storage) => {
    console.log("run");
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
                    let create_at = formatDate(new Date(element.created_at));
                    let update_at = formatDate(new Date(element.updated_at));
                    console.log(update_at);
                    // get url edit
                    let urlEdit = $("#url-edit-import")
                        .attr("data-url")
                        .replace(/id/g, element.id);

                    let level =
                        element.transaction_type == 1
                            ? ["Import", "primary"]
                            : ["Export", "dark"];

                    xhtml += `
                        <tr>
                        <td>${index + 1}</td>
                        <td class="max-250">${element.supplier.name}</td>
                        <td>${element.product.name}</td>
                        <td>${element.quantity}kg</td>
                        <td>${element.current_quantity}kg</td>
                        <td>${element.shipment}</td>
                        <td><span class="badge rounded-pill bg-${level[1]}">${
                        level[0]
                    }</span> </td>
                        <td>${element.transaction_date}</td>
                        <td>${element.expiration_date}</td>
                        <td  class="max-110">${create_at}</td>
                        <td  class="max-110">${update_at}</td>
                        <td class="g-2" >
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                     <i class="bx bx-dots-vertical-rounded"></i>
                                </button>

                                <div class="dropdown-menu" style="">
                                <a href="${urlEdit}" class="dropdown-item"><i class="bx bx-edit-alt me-1"></i> Edit</a>
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
            console.log(error.message);
        },
    });
};

export { loadProduct };
