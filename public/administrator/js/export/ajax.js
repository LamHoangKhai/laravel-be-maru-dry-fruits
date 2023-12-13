import { formatDate, setTotalPages } from "../function.js";

const loadExport = (storage) => {
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
            if (data.length === 0) {
                xhtml += `
                    <tr>
                    <td class="text-red">No result!</td>
                    </tr>
                     `;
            } else {
                data.forEach((element, index) => {
                    let create_at = formatDate(new Date(element.created_at));
                    xhtml += `
                    <tr>
                    <td>${index + 1}</td>
                    <td>${element.supplier.name}</td>
                    <td>${element.product.name}</td>
                    <td>${element.quantity}kg</td>
                    <td>${element.shipment}</td>
                    <td>${element.transaction_date}</td>
                    <td>${element.expiration_date}</td>
                    <td>${create_at}</td>
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

const loadShipmentOptions = (url, product_id) => {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#shipment").html("");

    $.ajax({
        type: "POST",
        url: url,
        data: { product_id },
        dataType: "json",
        success: (res) => {
            let xhtml = '<option value="">Choose Shipment</option>';
            let data = res?.data || [];

            if (data) {
                data.forEach((element) => {
                    xhtml += `<option value="${element.shipment}">
                                ${element.supplier.name}
                                -current_quantity:${element.current_quantity}
                                -expiration_date:${element.expiration_date}
                                -shipment:${element.shipment}
                                </option>`;
                });
            }
            $("#shipment").append(xhtml);
        },
        error: function (error) {
            console.log(error.message);
        },
    });
};

export { loadExport, loadShipmentOptions };
