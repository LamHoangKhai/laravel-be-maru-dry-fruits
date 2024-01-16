import { Mydebounce, getUrl } from "../function.js";
import { loadProduct } from "./load-data-table.js";
import { modalHtml } from "./modal-order-detail.js";
import { printInvoice } from "./print-invoice.js";
//  call api Search

$(document).ready(() => {
    let storage = {
        search: "",
        page: 1,
        take: 25,
        totalData: 0,
        totalPage: 1,
        select: 0,
        url: getUrl("/order"),
        date: $("#date").val(),
    };
    //handle search
    $("#search").keypress(
        Mydebounce((e) => {
            if (e.keyCode === 13) {
                return 0;
            }
            storage.search = e.target.value;
            storage.page = 1;

            $("#pagination").simplePaginator("changePage", 1);
        }, 500)
    );

    $("#search").bind("paste", (e) => {
        // access the clipboard using the api
        storage.search = e.originalEvent.clipboardData.getData("text");
        storage.page = 1;

        $("#pagination").simplePaginator("changePage", 1);
    });

    $("#search").keyup(
        Mydebounce((e) => {
            if (e.keyCode === 8) {
                storage.search = e.target.value;
                storage.page = 1;

                $("#pagination").simplePaginator("changePage", 1);
            }
            return 0;
        }, 500)
    );
    // end handle search

    $("#date").change((e) => {
        storage.date = e.target.value;
        $("#pagination").simplePaginator("changePage", 1);
    });

    //handle select
    $("#select").change((e) => {
        storage.select = e.target.value;

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
        let orderId = $(e.target).parent().data("id");
        $.ajax({
            type: "POST",
            url: storage.url + "/get-order-detail",
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
        let orderId = e.target.value;
        $.ajax({
            type: "POST",
            url: storage.url + "/update-status",
            data: { id: orderId },
            dataType: "json",
            success: (res) => {
                $("#modalOrderDetail").modal("toggle");

                $("#pagination").simplePaginator("changePage", 1);
            },
            error: function (error) {
                console.log(error.message);
            },
        });
    });

    $("#modalOrderDetail").on("click", "#cancel", (e) => {
        let orderId = e.target.value;
        Swal.fire({
            title: "<strong>Warning!!!</strong>",
            html: `<strong>Are you sure cancel this order ?</strong>`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, cancel it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: storage.url + "/cancel-order",
                    data: { id: orderId },
                    dataType: "json",
                    success: (res) => {
                        $("#modalOrderDetail").modal("toggle");

                        $("#pagination").simplePaginator("changePage", 1);
                    },
                    error: function (error) {
                        console.log(error.message);
                    },
                });
            }
        });
    });

    $("#modalOrderDetail").on("click", "#btnPrintInvoice", (e) => {
        let orderId = e.target.value;
        $.ajax({
            type: "POST",
            url: storage.url + "/get-order-detail",
            data: { id: orderId },
            dataType: "json",
            success: (res) => {
                let data = res.data || [];
                printInvoice(data);
            },
            error: function (error) {
                console.log(error.message);
            },
        });
    });

    $("#modalOrderDetail").on(
        "keypress",
        "#discount",
        Mydebounce((e) => {
            let orderId = $("#discount").data("id");
            let discount = e.target.value;
            $.ajax({
                type: "POST",
                url: storage.url + "/get-order-detail",
                data: { id: orderId, discount },
                dataType: "json",
                success: (res) => {
                    $("#total").text("$" + res.total);
                },
                error: function (error) {
                    console.log(error.message);
                },
            });
        })
    );
});
