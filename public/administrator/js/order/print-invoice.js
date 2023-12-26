import { formatDate } from "../function.js";

const printInvoice = (data) => {
    let html = htmlString(data);

    let newWin = window.open("", "Print-Window");
    newWin.document.open();
    newWin.document.write(
        '<html><body onload="window.print()">' + html + "</body></html>"
    );
    newWin.document.close();
    setTimeout(function () {
        newWin.close();
    }, 10);
};

const htmlString = (data) => {
    //head invoice
    let head = ` 
        <div id='DivIdToPrint'>
<!-- start invoice print -->
<style type="text/css">
    body {
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }

    .table_border tr td {
        border: 1px solid #555 !important;
    }

    .itemrows td,
    .heading td,
    .padding td {
        padding: 8px;
    }

    .total td {
        padding: 4px;
    }
</style>

<table cellpadding="0" cellspacing="0">
    <table style="border:0;width:100%;">
    <tr>
            <td colspan="4" align="center"><h3>Invoice</h3></td>
        </tr>
        <tr>
            <td colspan="4" align="center"><b>Maru Dry Fruits</b></td>
        </tr>
        <tr>
            <td colspan="4" align="center">35/6 Đường D5, Phường 25, Bình Thạnh, Thành phố Hồ Chí
                Minh
                72308</td>
        </tr>
        <tr>
            <td colspan="4" align="center"><b>Contact:</b> 001800 1779</td>
        </tr>`;

    //infomation user
    let userInformation = `
    <tr class="padding">
        <td><b>Username:</b> ${data.user.full_name}</td>
    </tr>
    <tr class="padding">
        <td><b>Phone:</b> ${data.user.phone}</td>
    </tr>
    <tr class="padding">
        <td><b>Email:</b> ${data.user.email}</td>
    </tr>
    <tr class="padding">
        <td><b>Address:</b> ${data.user.address}</td>
    </tr>
    <tr class="padding">
        <td><b>Date:</b> ${formatDate(new Date(data.created_at))}</td>
    </tr>
    <tr class="padding">
        <td><b>Note:</b> ${data.note ? data.note : ""}</td>
</tr>`;

    //list items
    let listItems = `

<tr class="heading" style="background:#eee;border-bottom:1px solid #ddd;font-weight:bold;">
<td>
    Item
</td>
<td>
    Price
</td>
<td>
    Quantity
</td>
<td>
    Subtotal
</td>
</tr>
`;

    data.order_items.forEach((element) => {
        let formatText =
            element.weight > 1000
                ? element.weight / 1000 + "kg"
                : element.weight + "gram";

        listItems += ` 
        <tr class="itemrows" style="border-bottom:1px solid #d9dee3;">
            <td>${element.product.name} (${formatText})</td>
            <td>$${element.product.price}/100gr</td>

            <td>${element.quantity}</td>
            <td>$${element.price}</td>
        </tr>`;
    });

    // order details
    let orderDetail = `
    <tr class="total" stlye="margin-top:12px">
<td align="right" colspan="3">
    <b>Order #&nbsp;:&nbsp; ${data.id}</b>
</td>
</tr>
<tr class="total" stlye="margin-top:12px">
<td align="right" colspan="3">
    <b>Subtotal&nbsp;:&nbsp;$${data.subtotal}</b>
</td>
</tr>
<tr class="total" stlye="margin-top:12px">
<td align="right" colspan="3">
    <b>Subtotal&nbsp;:&nbsp;${data.discount}%</b>
</td>
</tr>
<tr class="total" stlye="margin-top:12px">
<td align="right" colspan="3">
    <b>Total&nbsp;:&nbsp;$${data.total.toFixed(2)}</b>
</td>
</tr>
<tr>
<td colspan="4" align="center">Thank You ! Visit Again</td>
</tr>
</table>
</table>
<!-- end invoice print -->
</div>
`;

    return head + userInformation + listItems + orderDetail;
};
export { printInvoice };
