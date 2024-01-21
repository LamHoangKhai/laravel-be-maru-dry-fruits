import {
    formatDate,
    loading,
    renderLink,
    setTotalPages,
    ajaxReq,
} from "../function.js";

const numberOfTH = $("thead th").length;

const loadUser = async (storage) => {
    try {
        const links = [
            {
                url: storage.url + "/edit/",
                text: "Edit",
                classBootstrap: "",
                classIcon: "bx bx-edit-alt me-1",
            },
            {
                url: storage.url + "/destroy/",
                text: "Delete",
                classBootstrap: "text-danger delete",
                classIcon: "bx bx-trash me-1",
            },
        ];
        loading(numberOfTH);
        const url = storage.url + "/get-users";
        const method = "POST";
        const body = storage;

        const res = await ajaxReq(url, method, body);
        let page = res.data.current_page;
        let take = res.data.per_page;
        let data = res?.data?.data || [];
        let xhtml = "";
        if (data.length === 0) {
            xhtml += `
                        <tr>
                        <td valign="top" colspan=${numberOfTH} class="text-center">No matching records found</td>
                        </tr>
                         `;
        } else {
            xhtml = handleData(data, links, page, take);
        }

        $("#loadingTable").remove();
        $("#renderData").html(xhtml);

        storage.totalData = res.data.total;
        setTotalPages(storage);
    } catch (error) {
        Swal.fire({
            title: "Errors system!!",
            text: "The system needs maintenance.",
            icon: "warning",
        });
        console.log(error.message);
    }
};

const handleData = (data, links, page, take) => {
    let xhtml = "";

    data.forEach((element, index) => {
        let updated_at = formatDate(new Date(element.updated_at));

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
                        page === 1 ? index + 1 : take * page - take + index + 1
                    }</td>
                    <td>${
                        element.full_name
                            ? element.full_name
                            : "Wait For Update..."
                    }</td>
                    <td id="email">${element.email}</td>
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
                          ${renderLink(links, element.id)}
                        </div>
                     </div>
                    </td>
                </tr>
                 `;
    });
    return xhtml;
};

export { loadUser };
