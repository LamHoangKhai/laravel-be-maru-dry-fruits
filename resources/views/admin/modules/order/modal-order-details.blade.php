<!-- The Modal -->
<div class="modal fade " id="modalOrderDetail">

    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title " id="numberOrder"></h4>
                <h6 class="modal-title " id="orderDate"></h6>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding-top: 0">
                <div class="user">
                    <p>Username: <strong id="userName"></strong></p>
                    <p>Phone: <strong id="userPhone"></strong></p>
                    <p>Email: <strong id="userEmail"></strong></p>
                    <p>Address: <strong id="userAddress"></strong></p>
                </div>
                <p>Note: <strong id="userNote"></strong></p>
                <div class="container" style="padding-top:4px ">
                    <h5>Item Details</h5>
                    <div class="row  g-3" id="items">
                    </div>
                    <h6>Order Details</h6>
                    <div class="row g-2" id="orderDetail">

                    </div>


                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer d-flex">

            </div>

        </div>
    </div>
</div>
