import { Mydebounce } from "../function.js";
import { loadProduct } from "./load-data-table.js";
//  call api Search

$(document).ready(() => {
    let storage = {
        search: "",
        page: 1,
        take: 25,
        totalData: 0,
        totalPage: 1,
        select: 1,
        url: $("#url").data("url"),
        product_id: $("#product_id").val(),
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
});
