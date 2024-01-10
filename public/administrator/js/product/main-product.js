import { Mydebounce } from "../function.js";
import { loadProduct, detailProduct } from "./load-data-table.js";
//  call api Search

$(document).ready(() => {
    //handle scan
    let barcode = "";
    $(document).keypress(function (e) {
        var code = e.keyCode ? e.keyCode : e.which;
        if (code == 13 || code == 9) {
            if (barcode.length < 1) {
                return;
            }
            console.log(barcode);

            detailProduct(barcode);
            barcode = "";
        } else {
            barcode = barcode + String.fromCharCode(code);
        }
    });

    // end handle scan

    let storage = {
        search: "",
        page: 1,
        take: 25,
        totalData: 0,
        totalPage: 1,
        url: $("#url").data("url"),
        select: 0,
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

                $("#pagination").simplePaginator("changePage", 1);
            }
            return 0;
        }, 500)
    );
    // end handle search

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

    $("#renderData").on("click", ".delete", async (e) => {
        e.preventDefault();
        const url = e.target.href;
        const urlCheck = $("#url-check").attr("data-url");
        const product_id = e.target.getAttribute("value");

        $.ajax({
            type: "POST",
            url: urlCheck,
            data: {
                product_id,
            },
            dataType: "json",
            success: (res) => {
                if (res && !res.permission) {
                    console.log(res.permission);
                    Swal.fire({
                        title: "<strong>Please read the warning carefully!!!</strong>",
                        html: `<strong>${res.msg}</strong>`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                    });
                    return;
                }

                Swal.fire({
                    title: "<strong>Please read the warning carefully!!!</strong>",
                    html: `When deleting this product, related items such as <strong> orders, imports, and exports</strong> cannot be found, and this product still has a total weight of <strong>${res.totalQuantity}kg</strong>.`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        return (window.location.href = url);
                    }
                });
            },
            error: function (error) {
                console.log(error.message);
            },
        });
    });

    $("#renderData").on("click", ".qr", async (e) => {
        Swal.fire({
            imageUrl: e.target.value,
            imageHeight: 100,
            imageAlt: "A tall image",
        });
    });

    $("#exLargeModal").on("click", ".qr", async (e) => {
        Swal.fire({
            imageUrl: e.target.value,
            imageHeight: 100,
            imageAlt: "A tall image",
        });
    });
});
