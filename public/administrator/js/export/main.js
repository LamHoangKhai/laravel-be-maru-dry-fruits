import { Mydebounce } from "../function.js";
import { loadUser } from "./ajax.js";
//  call api Search

$(document).ready(() => {
    let storage = {
        search: "",
        page: 1,
        take: 25,
        totalData: 0,
        totalPage: 1,
        url: $("#url").data("url"),
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

    // handle filter
    $(".filter").change((e) => {
        const selecter = e.target;
        const isChecked = selecter.checked;
        const name = selecter.name;
        const value = selecter.value;
        storage.page = 1;

        $(selecter).attr("disabled", true);
        setTimeout(() => {
            $(selecter).removeAttr("disabled");
        }, 500);
        $("#pagination").simplePaginator("changePage", 1);
    });
    // end handle filter

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

    // move fast page
    $("#movePage").keypress(
        Mydebounce((e) => {
            let page = parseInt(e.target.value);
            // if user input value > total page
            if (page > storage.totalPage) {
                storage.page = storage.totalPage;
            } else {
                storage.page = page;
            }
            $("#pagination").simplePaginator("changePage", storage.page);
        }, 500)
    );
    // end fast page

    $("#renderData").on("click", "#delete", async (e) => {
        e.preventDefault();
        const url = e.target.href;
        const name = e.target.getAttribute("value");
        // show modal
        await Swal.fire({
            title: "Are you sure?",
            html: `Bạn có muốn xóa <strong>${name}</strong> hay không`,
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
    });
});
