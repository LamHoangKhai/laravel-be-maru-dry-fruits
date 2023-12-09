const loadData = (storage) => {
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
                    let update_at = formatDate(new Date(element.updated_at));

                    // get url edit
                    let urlEdit = $("#url-edit")
                        .attr("data-url")
                        .replace(/id/g, element.id);
                    // get url delete
                    let urlDelete = $("#url-destroy")
                        .attr("data-url")
                        .replace(/id/g, element.id);

                    let level =
                        element.status === 1
                            ? ["Show", "primary"]
                            : ["Hidden", "dark"];

                    xhtml += `
                    <tr>
                    <td>${element.id}</td>
                    <td>${element.name}</td>
                    <td>${element.category.name}</td>
                    <td>${element.price}</td>
                    <td>${element.stock_quantity}</td>
                    <td>
                    <span class="badge rounded-pill bg-${level[1]}">${level[0]}</span>
                    </td>
                    <td  class="text-wrap" style="min-width:180px">${create_at}</td>
                    <td  class="text-wrap" style="min-width:180px">${update_at}</td>
                    
                    <td class="g-2">
                    <a href="${urlEdit}" >Edit</a>
                    <a style="margin-right:-8px;margin-left:8px;" href="${urlDelete}" id="delete">Delete</a>
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

function formatDate(date) {
    var year = date.getFullYear();
    var month = String(date.getMonth() + 1).padStart(2, "0");
    var day = String(date.getDate()).padStart(2, "0");
    var hours = String(date.getHours()).padStart(2, "0");
    var minutes = String(date.getMinutes()).padStart(2, "0");
    var seconds = String(date.getSeconds()).padStart(2, "0");

    return (
        year +
        "-" +
        month +
        "-" +
        day +
        " " +
        hours +
        ":" +
        minutes +
        ":" +
        seconds
    );
}

export { loadData, setTotalPages };
