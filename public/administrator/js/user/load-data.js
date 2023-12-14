const loadUser = (storage) => {
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
                    let urlEdit = $("#url-edit")
                        .attr("data-url")
                        .replace(/id/g, element.id);
                    let urlDelete = $("#url-destroy")
                        .attr("data-url")
                        .replace(/id/g, element.id);

                    let level =
                        element.id === "maruDr-yfRui-tspRo-jectfORFOU-Rmembe" &&
                        element.level === 1
                            ? ["Superadmin", "danger"]
                            : element.level === 1
                            ? ["Admin", "dark"]
                            : element.level === 2
                            ? ["Member", "info"]
                            : ["Member VIP", "warning"];

                    xhtml += `
                    <tr>
                    <td>${index + 1}</td>
                    <td>${element.full_name}</td>
                    <td>${element.email}</td>
                    <td>
                    <span class="badge rounded-pill bg-${level[1]}">${
                        level[0]
                    }</span>
                    </td>
                    <td>${element.phone}</td>
                    <td  class="text-wrap" style="min-width:180px">${
                        element.address
                    }</td>
                   


                    <td class="g-2" >
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                        data-bs-toggle="dropdown" aria-expanded="false">
                             <i class="bx bx-dots-vertical-rounded"></i>
                        </button>

                        <div class="dropdown-menu" style="">
                            <a href="${urlEdit}" class="dropdown-item"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                            
                            <a  href="${urlDelete}" id="delete" value="${
                        element.full_name
                    }" class="text-danger delete dropdown-item"><i class="bx bx-trash me-1"></i> Delete</a>
                        </div>
                     </div>
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