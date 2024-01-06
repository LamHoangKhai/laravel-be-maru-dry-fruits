import { formatDate, loading, setTotalPages, statusText } from "../function.js";

const loadProduct = (storage) => {
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
                    let user = ``;
                    if (element.user.level == 2) {
                        user = `
                        <td class="max-250">${element.full_name}</td>
                        <td class="max-250">${element.email}</td>
                        <td class="max-250">${element.address}</td>
                        <td>${element.phone}</td>
                        `;
                    } else {
                        user = ` 
                        <td class="max-110" colspan="2">${element.user.email}</td>
                        <td class="max-110 text-center" colspan="2">Sold Offline</td>
                        `;
                    }

                    let type = statusText(element.status);
                    xhtml += `
                        <tr class="detail" data-id="${element.id}">
                            <td class="max-110">${element.id}</td>
                            ${user}
                            <td class="text-center">${element.discount}%</td>
                            <td class="max-110">$${element.total}</td>
                            <td class="max-110"><span class="badge rounded-pill bg-${
                                type[1]
                            }">${type[0]}</span> </td>
                            <td class="max-110"><span class="badge rounded-pill bg-${
                                element.transaction_status == 1
                                    ? "dark"
                                    : "warning"
                            }">${
                        element.transaction_status == 1 ? "Paid" : "Unpaid"
                    }</span> </td>
                        </tr>
                         `;
                });
            }

            setTimeout(() => $("#renderData").html(xhtml), 300);
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

export { loadProduct };
