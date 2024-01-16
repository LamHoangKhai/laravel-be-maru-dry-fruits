import { Mydebounce, getUrl } from "../function.js";
import { loadUser } from "./load-data-table.js";
//  call api Search

$(document).ready(() => {
    let storage = {
        search: "",
        page: 1,
        take: 25,
        totalData: 0,
        totalPage: 1,
        select: 0,
        url: getUrl("/user"),
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

    //choose show entries
    $("#showEntries").change((e) => {
        storage.take = e.target.value;
        storage.page = 1;
        $("#pagination").simplePaginator("changePage", 1);
    });
    //end choose show entries

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

            loadUser(storage);
        },
    });
    // end pagination

    $("#renderData").on("click", ".delete", async (e) => {
        e.preventDefault();
        const url = e.target.href;
        const parent = $(e.target).parent().parent().parent().parent();
        const email = $(parent).children("#email").text();
        // show modal
        await Swal.fire({
            title: "<strong>Please read the warning carefully!!!</strong>",
            html: `
            Do you want to delete user <strong>${email}, If you delete this user, things related to reviews and orders cannot be found?</strong>`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                if (result.isConfirmed) {
                    return (window.location.href = url);
                }
            }
        });
    });
});
