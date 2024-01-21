const ajaxReq = (url, method, data) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            type: method,
            data: data,
            dataType: "json",
            success: (res) => {
                resolve(res);
            },
            error: function (error) {
                reject(error);
            },
        });
    });
};

const Mydebounce = (callback, timeout = 500) => {
    let timer;
    return (...agrs) => {
        clearTimeout(timer);
        timer = setTimeout(() => {
            callback.apply(this, agrs);
        }, timeout);
    };
};

function formatDate(date) {
    let year = date.getFullYear();
    let month = String(date.getMonth() + 1).padStart(2, "0");
    let day = String(date.getDate()).padStart(2, "0");
    let hours = String(date.getHours()).padStart(2, "0");
    let minutes = String(date.getMinutes()).padStart(2, "0");
    let seconds = String(date.getSeconds()).padStart(2, "0");
    return (
        year +
        "/" +
        month +
        "/" +
        day +
        " " +
        hours +
        ":" +
        minutes +
        ":" +
        seconds
    );
}

const setTotalPages = (storage) => {
    storage.totalPage = storage.totalData
        ? Math.ceil(storage.totalData / storage.take)
        : 1;
    $("#pagination").simplePaginator("setTotalPages", storage.totalPage);
};

const loading = (colspan) => {
    let loading = `<tr>
    <td valign="top" colspan="${colspan}" class="text-center">
        <div class="spinner-border text-primary" role="status" id="loadingTable">
         <span class="visually-hidden">Loading...</span>
         </div>
    </td>
</tr>`;
    $("#renderData").html(loading);
};

const statusText = (text) => {
    switch (text) {
        case 1:
            return ["Pending", "primary"];
        case 2:
            return ["Prepare", "info"];
        case 3:
            return ["Delivery", "secondary"];
        case 4:
            return ["Complete", "success"];
        case 5:
            return ["Cancel", "danger"];
    }
};

const getUrl = (path) => {
    return $("#url").data("url") + "/admin" + path;
};

const renderLink = (links, id) => {
    let xhtml = ``;
    links.map((item) => {
        xhtml += `<a 
        value="${id}" 
        href="${item.url + id}" 
        class="dropdown-item ${item.classBootstrap}">
        <i class='${item.classIcon}'></i> 
        ${item.text}</a>`;
    });
    return xhtml;
};

export {
    Mydebounce,
    formatDate,
    setTotalPages,
    loading,
    statusText,
    getUrl,
    renderLink,
    ajaxReq,
};
