import { statusText, formatDate } from "../function.js";

const modalHtml = (data) => {
    $("#numberOrder").html("Order #" + data.id);
    $("#orderDate").html(formatDate(new Date(data.created_at)));
    if (data.user.level == 1) {
        $(".user").html("<p><strong>Sold offline</strong></p>");
    } else {
        $(".user").html(` <p>Username: <strong >${data.full_name}</strong></p>
        <p>Phone: <strong >${data.phone}</strong></p>
        <p>Email: <strong >${data.email}</strong></p>
        <p>Address: <strong >${data.address}</strong></p>`);
    }
    $("#userNote").html(data.note);
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
            element.weight >= 1000
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
           
            <li class="left mb-2">Subtotal: <strong>$${data.subtotal.toFixed(
                2
            )}</strong></li>
            <li class="left mb-2">Discount:  <strong>${
                data.discount
            }%</strong></li>
            <li class="left mb-2">Total Price: <strong id="total">$${data.total.toFixed(
                2
            )}</strong></li>
        </ul>
    </div> <div class="col mb-2">
    <ul type="none">
        <li class="left mb-2 ">Status Order: <strong>${text[0]}</strong></li>
        <li class="left mb-2">Transaction: <strong>${
            data.transaction == 1 ? "Cash/Ship COD" : "VNPAY"
        }</strong></li>
        <li class="left mb-2">Transaction Status: <strong>${
            data.transaction_status == 1 ? "Complete" : "Pending payment"
        }</strong></li>
    </ul>
</div>`;

    $("#orderDetail").html(xhmtDetails);

    let xhtmlButton = `
    <button type='button' id='btnPrintInvoice' value=${data.id} class="bnt" style="margin-right:auto">
     <i class='bx bx-printer '></i>&nbsp;
    Print</button>`;

    if (data.status <= 3) {
        xhtmlButton += `
        <button class="btn btn-primary " style="margin-right: 4px"
            id="confirm" value=${data.id}>Confirm Order</button>
        <button class="btn btn-danger " style="margin-right: 4px"
            id="cancel" value=${data.id}>Cancel Order</button>
    `;
    }

    xhtmlButton += `
        <button type="button" class="btn btn-secondary" id="closeModal">
             Close
        </button>`;
    $(".modal-footer").html(xhtmlButton);
};

export { modalHtml };
