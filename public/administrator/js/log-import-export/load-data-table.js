import { formatDate, setTotalPages, loading } from "../function.js";

const loadProduct = (storage) => {
    const numberOfTH = $("thead th").length;
    loading(numberOfTH);
    let text = storage.select == 1 ? "Import Quantity" : "Export Quantity";
    $("#quantity").html(text);
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
                    <td valign="top" colspan=${numberOfTH} class="text-center">No matching records found</td>
                    </tr>
                     `;
            } else {
                data.forEach((element, index) => {
                    let updated_at = formatDate(new Date(element.updated_at));
                    // get url edit
                    let urlEdit = $("#url-edit-import")
                        .attr("data-url")
                        .replace(/id/g, element.id);

                    let type =
                        element.transaction_type == 1
                            ? ["Import", "primary", "+"]
                            : ["Export", "dark", "-"];

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
                            <td class="max-250">${element.supplier.name}</td>
                            <td>${type[2] + element.quantity}kg</td>
                            <td class="text-center">$${element.input_price}</td>
                            <td>${element.shipment}</td>
                            <td>
                                <span class="badge rounded-pill 
                                bg-${type[1]}">${type[0]}</span> 
                            </td>
                            <td>${element.expiration_date}</td>
                            <td>${element.transaction_date}</td>
                            <td  class="max-110">${updated_at}</td>
                            <td class="g-2" >
                                <div class="dropdown ">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                         <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    ${
                                        storage.select == 1
                                            ? `<div class="dropdown-menu" style="">
                                                 <a href="${urlEdit}" class="dropdown-item"><i class="bx bx-edit-alt me-1"></i> Edit</a> 
                                                </div>`
                                            : ""
                                    }
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

export { loadProduct };
