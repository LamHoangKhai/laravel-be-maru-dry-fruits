import { formatDate, setTotalPages, statusText } from "../function.js";

const loadProduct = (storage) => {
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
                    <td valign="top" colspan="12" class="text-center">No matching records found</td>
                    </tr>
                     `;
            } else {
                data.forEach((element, index) => {
                    let created_at = formatDate(new Date(element.created_at));
                    let updated_at = formatDate(new Date(element.updated_at));

                    let type = statusText(element.status);
                    console.log(element);
                    xhtml += `
                        <tr class="detail" data-id="${element.id}">
                            <td>${element.id}</td>
                            <td >${element.user.full_name}</td>
                            <td>${element.user.email}</td>
                            <td>${element.user.address}</td>
                            <td>${element.user.phone}</td>
                            <td><span class="badge rounded-pill bg-${type[1]}">${type[0]}</span> </td>
                            <td  class="max-110">${created_at}</td>
                            <td  class="max-110">${updated_at}</td>
                        </tr>
                         `;
                });
            }

            setTimeout(() => $("#renderData").html(xhtml), 300);
            storage.totalData = res.data.total;
            setTotalPages(storage);
        },
        error: function (error) {
            console.log(error.message);
        },
    });
};

export { loadProduct };
