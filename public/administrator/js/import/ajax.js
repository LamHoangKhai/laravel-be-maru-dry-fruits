import { formatDate } from "../function.js";
const loadUser = (storage) => {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

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
                    let urlDelete = $("#url-destroy")
                        .attr("data-url")
                        .replace(/id/g, element.id);

                    xhtml += `
                    <tr>
                    <td>${element.id}</td>
                    <td>${element.supplier.name}</td>
                    <td>${element.product.name}</td>
                    <td>${element.quantity}</td>
                    <td>${element.current_quantity}</td>
                    <td>${element.shipment}</td>
                    <td  class="text-wrap" style="min-width:180px">${element.transaction_date}</td>
                    <td  class="text-wrap" style="min-width:180px">${element.expiration_date}</td>
                    <td  class="text-wrap" style="min-width:180px">${create_at}</td>
                    <td  class="text-wrap" style="min-width:180px">${update_at}</td>
                    <td class="g-2">
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

const setTotalPages = (storage) => {
    storage.totalPage = storage.totalData
        ? Math.ceil(storage.totalData / storage.take)
        : 1;
    $("#pagination").simplePaginator("setTotalPages", storage.totalPage);

    $(".totalData").text(
        `Show ${storage.page == 1 ? 1 : storage.take * storage.page} to  ${
            storage.totalData
        } entries`
    );
};

export { loadUser };
