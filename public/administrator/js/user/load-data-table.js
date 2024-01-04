import { formatDate, loading, setTotalPages } from "../function.js";

const loadUser = (storage) => {
    const numberOfTH = $("thead th").length;
    loading(numberOfTH);
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
                    <td valign="top" colspan=${numberOfTH} class="text-center">No matching records found</td>
                    </tr>
                     `;
            } else {
                data.forEach((element, index) => {
                    let updated_at = formatDate(new Date(element.updated_at));

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
                        <td>${
                            storage.page === 1
                                ? index + 1
                                : storage.take * storage.page -
                                  storage.take +
                                  index
                        }</td>
                        <td>${
                            element.full_name
                                ? element.full_name
                                : "Wait For Update..."
                        }</td>
                        <td>${element.email}</td>
                        <td>${
                            element.phone ? element.phone : "Wait For Update..."
                        }</td>
                        <td  class="text-wrap" style="min-width:180px">
                            ${
                                element.address
                                    ? element.address
                                    : "Wait For Update..."
                            }
                        </td>
                        <td>
                            <span class="badge rounded-pill 
                            bg-${level[1]}">${level[0]}</span>
                        </td>
                        <td>${updated_at}</td>
                        <td class="g-2" >
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                            data-bs-toggle="dropdown" aria-expanded="false">
                                 <i class="bx bx-dots-vertical-rounded"></i>
                            </button>

                            <div class="dropdown-menu" style="">
                                <a href="${urlEdit}" class="dropdown-item"><i class="bx bx-edit-alt me-1"></i> Edit</a>

                                <a  href="${urlDelete}" id="delete" 
                                value="${
                                    element.full_name
                                }" class="text-danger delete dropdown-item"><i class="bx bx-trash me-1"></i> Delete</a>
                            </div>
                         </div>
                        </td>
                    </tr>
                     `;
                });
            }

            setTimeout(() => {
                $("#loadingTable").remove();
                $("#renderData").html(xhtml);
            }, 300);
            storage.totalData = res.data.total;
            setTotalPages(storage);
        },
        error: function (error) {
            Swal.fire({
                title: "Errors system!!",
                text: "The system needs maintenance.",
                icon: "warning",
            });
            console.log(error.message);
        },
    });
};

export { loadUser };
