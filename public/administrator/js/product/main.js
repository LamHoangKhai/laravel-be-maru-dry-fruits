import { Mydebounce, loading } from "../function.js";
import { loadProduct } from "./load-data.js";
//  call api Search

$(document).ready(() => {
    let storage = {
        search: "",
        page: 1,
        take: 25,
        totalData: 0,
        totalPage: 1,
        url: $("#url").data("url"),
        tableCols: 12,
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
                loading(storage.tableCols);
                $("#pagination").simplePaginator("changePage", 1);
            }
            return 0;
        }, 500)
    );
    // end handle search

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
});
