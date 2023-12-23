import { statusText, formatDate } from "../function.js";

const modalHtml = (data) => {
    $("#numberOrder").text("Order #" + data.id);
    $("#orderDate").text(formatDate(new Date(data.created_at)));
    $("#userName").text(data.full_name);
    $("#userPhone").text(data.phone);
    $("#userEmail").text(data.email);
    $("#userAddress").text(data.address);
    $("#userNote").text(data.note);
    // append item oder
    $("#items").html(
        `       <div class="col mb-4">
                    <h6 class="mb-0">Product</h6>
                </div>
                <div class="col text-end">
                    <h6 class="mb-0">Price</h6>
                </div>
                <div class="col text-end">
                    <h6 class="mb-0">Quantity</h6>
                </div>
                <div class="col text-end">
                    <h6 class="mb-0">Subtotal</h6>
                 </div>
            `
    );
    let xhmtlItem = ``;
    data.order_items.forEach((element) => {
        let formatText =
            element.weight > 1000
                ? element.weight / 1000 + "kg"
                : element.weight + "gram";

        xhmtlItem += ` <div class="row g-3 mt-0 mb-4">
        <div class="col mt-0">
            <span>${element.product.name} (${formatText}) </span>
        </div>
        
        <div class="col text-end mt-0">
            <span>$${element.product.price}/100gr </span>
        </div>
        <div class="col text-end mt-0">
            <span>${element.quantity} </span>
        </div>
        <div class="col text-end mt-0">
            <span>$${element.price}</span>
        </div>
    </div>`;
    });
    $("#items").append(xhmtlItem);

    //append order details
    let text = statusText(data.status);
    let xhmtDetails = ` 
    <div class="col mb-2">
        <ul type="none">
            <li class="left">Status Order: <strong>${text[0]}</strong></li>
            <li class="left">Subtotal: <strong>$${data.subtotal}</strong></li>
            <li class="left">Discount: <strong>${data.discount}%</strong></li>
            <li class="left">Total Price: <strong>$${data.total}</strong></li>
        </ul>
    </div>`;
    
    $("#orderDetail").html(xhmtDetails);

    let xhtmlButton = ``;
    if (data.status <= 3) {
        xhtmlButton += `
        <button class="btn btn-primary " style="margin-right: 4px"
            id="confirm" value=${data.id}>Confirm</button>
        <button class="btn btn-danger " style="margin-right: 4px"
            id="cancel" value=${data.id}>Cancel</button>
    `;
    }
    xhtmlButton += `
        <button type="button" class="btn btn-secondary" id="closeModal">
             Close
        </button>`;
    $(".modal-footer").html(xhtmlButton);
};

export { modalHtml };
