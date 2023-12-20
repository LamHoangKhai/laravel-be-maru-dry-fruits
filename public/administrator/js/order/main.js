import { Mydebounce, loading, formatDate, statusText } from "../function.js";
import { loadProduct } from "./load-data.js";
//  call api Search

$(document).ready(() => {
    let storage = {
        search: "",
        page: 1,
        take: 25,
        totalData: 0,
        totalPage: 1,
        select: 0,
        url: $("#url").data("url"),
        tableCols: 9,
    };
    //handle search
    $("#search").keypress(
        Mydebounce((e) => {
            if (e.keyCode === 13) {
                return 0;
            }
            storage.search = e.target.value;
            storage.page = 1;
            loading(storage.tableCols);
            $("#pagination").simplePaginator("changePage", 1);
        }, 500)
    );

    $("#search").bind("paste", (e) => {
        // access the clipboard using the api
        storage.search = e.originalEvent.clipboardData.getData("text");
        storage.page = 1;
        loading(storage.tableCols);
        $("#pagination").simplePaginator("changePage", 1);
    });

    $("#search").keyup(
        Mydebounce((e) => {
            if (e.keyCode === 8) {
                storage.search = e.target.value;
                storage.page = 1;
                loading(storage.tableCols);
                $("#pagination").simplePaginator("changePage", 1);
            }
            return 0;
        }, 500)
    );
    // end handle search

    //handle select
    $("#select").change((e) => {
        storage.select = e.target.value;
        loading(storage.tableCols);
        $("#pagination").simplePaginator("changePage", 1);
    });

    //end handle select

    // load pagination
    $("#pagination").simplePaginator({
        totalPages: 1,
        maxButtonsVisible: 10,
        currentPage: 1,
        nextLabel: "next",
        prevLabel: "prev",
        firstLabel: "first",
        lastLabel: "last",
        clickCurrentPage: true,
        pageChange: function (page) {
            storage.page = parseInt(page);
            this.currentPage = storage.page;
            loadProduct(storage);
        },
    });
    // end pagination

    $("#table").on("click", ".detail", (e) => {
        let urlDetail = $("#url-detail").data("url");
        let orderId = $(e.target).parent().data("id");
        $.ajax({
            type: "POST",
            url: urlDetail,
            data: { id: orderId },
            dataType: "json",
            success: (res) => {
                let data = res.data || [];
                $("#modalOrderDetail").modal("show");
                modalHtml(data);
            },
            error: function (error) {
                console.log(error.message);
            },
        });
    });

    $("#modalOrderDetail").on("click", "#closeModal", (e) => {
        $("#modalOrderDetail").modal("toggle");
    });

    $("#modalOrderDetail").on("click", "#confirm", (e) => {
        const urlUpdateStatus = $("#url-update-status").data("url");
        let orderId = e.target.value;
        $.ajax({
            type: "POST",
            url: urlUpdateStatus,
            data: { id: orderId },
            dataType: "json",
            success: (res) => {
                $("#modalOrderDetail").modal("toggle");
                loading(storage.tableCols);
                $("#pagination").simplePaginator("changePage", 1);
            },
            error: function (error) {
                console.log(error.message);
            },
        });
    });

    $("#modalOrderDetail").on("click", "#cancel", (e) => {
        const urlCancel = $("#url-cancel").data("url");
        let orderId = e.target.value;
        $.ajax({
            type: "POST",
            url: urlCancel,
            data: { id: orderId },
            dataType: "json",
            success: (res) => {
                $("#modalOrderDetail").modal("toggle");
                loading(storage.tableCols);
                $("#pagination").simplePaginator("changePage", 1);
            },
            error: function (error) {
                console.log(error.message);
            },
        });
    });
});

const modalHtml = (data) => {
    $(".numberOrder").text("Order #" + data.id);
    $(".orderDate").text(formatDate(new Date(data.created_at)));
    // append item oder
    $("#items").html("");
    $("#items").append(
        `<div class="col mb-4">
             <h6 class="mb-0">Product</h6>
         </div>
        <div class="col text-end">
             <h6 class="mb-0">Price</h6>
        </div>
        <div class="col text-end">
            <h6 class="mb-0">Quantity</h6>
        </div>
        <div class="col text-end">
            <h6 class="mb-0">Subtotal</h6>
        </div>
`
    );
    let xhmtlItem = ``;
    data.order_items.forEach((element) => {
        let formatText =
            element.weight > 1000
                ? element.weight / 1000 + "kg"
                : element.weight + "gram";

        xhmtlItem += ` <div class="row g-3 mt-0 mb-4">
        <div class="col mt-0">
            <span>${element.product.name} (${formatText}) </span>
        </div>
        
        <div class="col text-end mt-0">
            <span>$${element.product.price}/100gr </span>
        </div>
        <div class="col text-end mt-0">
            <span>${element.quantity} </span>
        </div>
        <div class="col text-end mt-0">
            <span>$${element.price}</span>
        </div>
    </div>`;
    });

    $("#items").append(xhmtlItem);

    //append order details
    $("#orderDetail").html("");
    let text = statusText(data.status);
    let xhmtDetails = ` 
    <div class="col mb-2">
        <ul type="none">
            <li class="left">Status Order:</li>
            <li class="left">Subtotal:</li>
            <li class="left">Discount:</li>
            <li class="left">Total Price:</li>
        </ul>
    </div>
    <div class="col mb-2 ">
        <ul class="right" type="none">
            <li class="right"><strong>${text[0]}</strong></li>
            <li class="right"><strong>$${data.subtotal}</strong></li>
            <li class="right"><strong>${data.discount}%</strong></li>
            <li class="right"><strong>$${data.total}</strong></li>
        </ul>
    </div>`;
    $("#orderDetail").append(xhmtDetails);

    $(".modal-footer").html("");
    let xhtmlButton = `
        <button class="btn btn-primary " style="margin-right: 4px"
            id="confirm" value=${data.id}>Confirm</button>
        <button class="btn btn-danger " style="margin-right: 4px"
            id="cancel" value=${data.id}>Cancel</button>
        <button type="button" class="btn btn-secondary" id="closeModal">Close</button>
    `;

    $(".modal-footer").append(xhtmlButton);
};
