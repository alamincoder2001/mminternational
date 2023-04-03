<style>
.v-select {
    margin-bottom: 5px;
    width: 250px;
}

.v-select .dropdown-toggle {
    padding: 0px;
}

.v-select input[type=search],
.v-select input[type=search]:focus {
    margin: 0px;
}

.v-select .selected-tag {
    margin: 0px;
}

label {
    text-align: right;
}
</style>

<div id="salesInvoiceReport">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:15px;">
            <div class="form-group" style="margin-top:10px;">
                <label class="col-sm-2 col-sm-offset-2 control-label no-padding-right" style="text-align: right;">
                    Purchase Order </label>
                <label class="col-sm-1 control-label no-padding-right" style="width: 10px;"> : </label>
                <div class="col-sm-3">
                    <v-select v-bind:options="purchaseOrders" label="purchaseOrder_invoiceNo"
                        v-model="selectedpurchaseOrder" v-on:input="loadChalanPage" placeholder="Select Purchase Order">
                    </v-select>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
            <div class="form-group" style="margin-top:10px;">
                <label class="col-sm-2 col-sm-offset-2 control-label no-padding-right" style="text-align: right;"> Purchase Order Invoice </label>
                <label class="col-sm-1 control-label no-padding-right" style="width: 10px;"> : </label>
                <div class="col-sm-3">
                    <v-select v-bind:options="purchaseOrders" label="purchaseOrder_invoiceNo" v-model="selectedpurchaseOrder" v-on:input="loadChalanPage" placeholder="Select Purchase Order"></v-select>
                </div>
            </div>
        </div>
    </div> -->

    <div class="row" style="display:none" :style="{display: carts.length > 0 ? '' : 'none'}">
        <div class="col-xs-6">
            <strong>GRN No: </strong><br>
            <strong>Supplier: </strong>{{ purchaseOrder.Supplier_Name }}
        </div>
        <div class="col-xs-6" style="text-align: right;">
            <strong>Date: </strong>{{ purchaseOrder.purchaseOrder_date }}<br>
        </div>
        <div class="col-xs-12" style="margin-top: 15px;">
            <table class="table table-bordered">
                <thead>
                    <th>SL No</th>
                    <th>Code No</th>
                    <th>Name of the Items</th>
                    <th>Order Qty</th>
                    <th>Unit Price</th>
                    <th>Invoice Qty</th>
                    <th style="width: 100px;">Already Received Qty</th>
                    <th style="width: 100px;">Received Qty</th>
                    <th style="width: 300px;">Remarks</th>
                </thead>
                <tbody>
                    <tr v-for="(item,sl) in carts">
                        <td>{{sl+1}}</td>
                        <td>{{''}}</td>
                        <td>{{item.Product_Name}}</td>
                        <td>{{item.quantity}}</td>
                        <td>{{item.unit_price}}</td>
                        <td>{{item.quantity}}</td>
                        <td>{{item.already_received_qty}}</td>
                        <td>
                            <input type="text" class="form-control" v-model="item.received_qty"
                                style="width: 100%; text-align:center" v-on:input="checkValidQty(sl)">
                        </td>
                        <td>
                            <input type="text" class="form-control" v-model="item.remarks" style="width: 100%;">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-xs-12" style="margin-top: 15px;text-align:right">
            <button class="btn btn-success" v-on:click="saveChallan">Save Purchase Challan</button>
        </div>
    </div>
</div>



<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/js/vue/components/salesInvoice.js"></script> -->
<!-- <script src="<?php echo base_url(); ?>assets/js/vue/components/requisition.js"></script> -->

<script>
Vue.component('v-select', VueSelect.VueSelect);
new Vue({
    el: '#salesInvoiceReport',
    data() {
        return {
            purchaseOrders: [],
            purchaseOrder: {},
            carts: [],
            selectedpurchaseOrder: null,
            showRequisition: false
        }
    },
    created() {
        this.getPurchaseOrders();
    },
    methods: {
        getPurchaseOrders() {
            axios.get("/get-all-purchase-Order").then(res => {
                // console.log(res);
                let data = res.data.purchaseOrder;

                data.forEach(ele => {
                    if (parseFloat(ele.order_qty) != parseFloat(ele.received_qty)) {
                        this.purchaseOrders.push(ele);
                    }
                })
            })
        },
        loadChalanPage() {
            this.carts = [];
            let data = {
                purchaseOrder_id: this.selectedpurchaseOrder.purchaseOrder_id
            }
            axios.post("/get-all-purchase-Order", data).then(res => {
                // console.log(res);
                this.purchaseOrder = res.data.purchaseOrder[0];
                res.data.purchaseOrderDetails.forEach(ele => {
                    ele.received_qty = '';
                    ele.remarks = '';
                    this.carts.push(ele);
                });
            })
        },
        checkValidQty(index) {
            let restQty = parseFloat(this.carts[index].quantity) - parseFloat(this.carts[index]
                .already_received_qty)
            if (parseFloat(restQty) < parseFloat(this.carts[index].received_qty)) {
                alert('max valid quantity is' + restQty)
                this.carts[index].received_qty = restQty;
                return
            }
        },
        saveChallan() {

            let total = 0;
            this.carts.forEach(ele => {
                total += parseFloat(ele.received_qty == '' ? 0 : ele.received_qty);
            })

            if (total == 0) {
                alert('Return quantity is empty!')
                return;
            }

            let filter = {
                masterData: this.purchaseOrder,
                cartProducts: this.carts
            }
            filter.masterData.purchaseTotalAmount = this.carts.reduce((prev, curr) => prev + parseFloat(curr
                .unit_price * curr.received_qty), 0)

            console.log(filter);
            // return;

            axios.post('/add_purchase', filter).then(res => {
                // console.log(res);
                if (res.data.success) {
                    //alert(res.data.message);
                    let conf = confirm('Purchase Success, Do you want to view invoice?');
                    if (conf) {
                        window.open('/purchase_chalan_print/' + res.data.purchaseId, '_blank');
                        //await new Promise(r => setTimeout(res.data, 1000));
                        // window.location = this.sales.isService == 'false' ? '/sales/product' :
                        //     '/sales/service';
                    }
                    // else {
                    //     window.location = this.sales.isService == 'false' ? '/sales/product' :
                    //         '/sales/service';
                    // }
                    // this.getPurchaseOrders();
                    location.reload();
                }
            })
        }
    }
})
</script>