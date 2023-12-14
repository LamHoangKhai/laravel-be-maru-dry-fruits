import { formatDate, setTotalPages } from "../function.js";
const loadImport = (storage) => {


    $("#renderData").html("");

    $.ajax({
        type: "POST",
        url: storage.url,
        data: storage,
        dataType: "json",
        success: (res) => {
            let xhtml = "";
            let data = res?.data?.data || [];
            console.log(res);
            if (data.length === 0) {
                xhtml += `
                    <tr>
                    <td class="text-red">No result!</td>
                    </tr>
                     `;
            } else {
                data.forEach((element, index) => {
                    let create_at = formatDate(new Date(element.created_at));
                    let update_at = formatDate(new Date(element.updated_at));

                    let urlEdit = $("#url-edit")
                        .attr("data-url")
                        .replace(/id/g, element.id);

                    xhtml += `
                    <tr>
                    <td>${index + 1}</td>
                    <td class="max-250">${element.supplier.name}</td>
                    <td class="max-250">${element.product.name}</td>
                    <td>${element.quantity}kg</td>
                    <td>${element.current_quantity}kg</td>
                    <td  class="max-110">${element.shipment}</td>
                    <td  class="max-110">${element.transaction_date}</td>
                    <td  class="max-110">${element.expiration_date}</td>
                    <td  class="max-110">${create_at}</td>
                    <td  class="max-110">${update_at}</td>
                    <td class="g-2" style="width:80px">
                    <a href="${urlEdit}" >Edit</a>
                    </td>
                    </tr>
                     `;
                });
            }

            $("#renderData").append(xhtml);
            storage.totalData = res.data.total;
            setTotalPages(storage);
        },
        error: function (error) {
            console.log(error.message);
        },
    });
};

export { loadImport };
