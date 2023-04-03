<style>
    .v-select {
        margin-bottom: 5px;
    }

    .v-select .dropdown-toggle {
        padding: 0px;
    }

    .v-select input[type=search],
    .v-select input[type=search]:focus {
        margin: 0px;
    }

    .v-select .vs__selected-options {
        overflow: hidden;
        flex-wrap: nowrap;
    }

    .v-select .selected-tag {
        margin: 2px 0px;
        white-space: nowrap;
        position: absolute;
        left: 0px;
    }

    .v-select .vs__actions {
        margin-top: -5px;
    }

    .v-select .dropdown-menu {
        width: auto;
        overflow-y: auto;
    }

    #branchDropdown .vs__actions button {
        display: none;
    }

    #branchDropdown .vs__actions .open-indicator {
        height: 15px;
        margin-top: 7px;
    }
</style>

<div class="row" id="purchase">
    <div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
        <div class="row">
            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right"> Invoice no </label>
                <div class="col-sm-2">
                    <input type="text" id="purchaseOrder_invoiceNo" name="purchaseOrder_invoiceNo" v-model="purchase.purchaseOrder_invoiceNo" readonly style="height:26px;" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right"> Purchase For </label>
                <div class="col-sm-3">
                    <v-select id="branchDropdown" v-bind:options="branches" v-model="selectedBranch" label="Brunch_name" disabled></v-select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right"> Date </label>
                <div class="col-sm-3">
                    <input class="form-control" id="purchaseOrder_date" name="purchaseOrder_date" type="date" v-model="purchase.purchaseOrder_date" v-bind:disabled="userType == 'u' ? true : false" style="border-radius: 5px 0px 0px 5px !important;padding: 4px 6px 4px !important;width: 230px;" />
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-9 col-md-9 col-lg-9">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Supplier & Product Information</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>

                    <a href="#" data-action="close">
                        <i class="ace-icon fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right"> Supplier </label>
                                <div class="col-sm-7">
                                    <v-select v-bind:options="suppliers" v-model="selectedSupplier" v-on:input="onChangeSupplier" label="display_name"></v-select>
                                </div>
                                <div class="col-sm-1" style="padding: 0;">
                                    <a href="<?= base_url('supplier') ?>" title="Add New Supplier" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
                                </div>
                            </div>

                            <div class="form-group" style="display:none;" v-bind:style="{display: selectedSupplier.Supplier_Type == 'G' ? '' : 'none'}">
                                <label class="col-sm-4 control-label no-padding-right"> Name </label>
                                <div class="col-sm-8">
                                    <input type="text" placeholder="Supplier Name" class="form-control" v-model="selectedSupplier.Supplier_Name" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right"> Mobile No </label>
                                <div class="col-sm-8">
                                    <input type="text" placeholder="Mobile No" class="form-control" v-model="selectedSupplier.Supplier_Mobile" v-bind:disabled="selectedSupplier.Supplier_Type == 'G' ? false : true" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right"> Address </label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" v-model="selectedSupplier.Supplier_Address" v-bind:disabled="selectedSupplier.Supplier_Type == 'G' ? false : true"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <form v-on:submit.prevent="addToCart">
                                <!-- <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right"> Vehicle </label>
                                    <div class="col-sm-7">
                                        <v-select v-bind:options="vehicles" v-model="selectedVehicle" label="vehicle_reg_no" placeholder="Select Vehciles"></v-select>
                                    </div>
                                    <div class="col-sm-1" style="padding: 0;">
                                        <a href="<?= base_url('add_vehicle') ?>" class="btn btn-xs btn-danger" style="height: 25px; border: 0px; width: 27px; margin-left: -10px;" target="_blank" title="Add Vehicle"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right"> Parts Item </label>
                                    <div class="col-sm-7">
                                        <v-select v-bind:options="products" v-model="selectedProduct" label="display_text" v-on:input="onChangeProduct"></v-select>
                                    </div>
                                    <div class="col-sm-1" style="padding: 0;">
                                        <a href="<?= base_url('product') ?>" title="Add New Product" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
                                    </div>
                                </div>

                                <!-- <div class="form-group" style="display:none;">
                                    <label class="col-sm-4 control-label no-padding-right"> Group Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="group" name="group" class="form-control" placeholder="Group name" readonly />
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right"> Quantity </label>
                                    <div class="col-sm-8">
                                        <input type="text" step="0.01" id="quantity" name="quantity" class="form-control" placeholder="Quantity" ref="quantity" v-model="selectedProduct.quantity" v-on:input="productTotal" required />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right"> Pur. Rate </label>
                                    <div class="col-sm-8">
                                        <input type="text" id="purchaseRate" name="purchaseRate" class="form-control" placeholder="Pur. Rate" v-model="selectedProduct.Product_Purchase_Rate" v-on:input="productTotal" required />
                                    </div>
                                </div>

                                <!-- <div class="form-group" style="display:none;">
                                    <label class="col-sm-4 control-label no-padding-right"> Cost </label>
                                    <div class="col-sm-3">
                                        <input type="text" id="cost" name="cost" class="form-control" placeholder="Cost" readonly />
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right"> Total Amount </label>
                                    <div class="col-sm-8">
                                        <input type="text" id="productTotal" name="productTotal" class="form-control" readonly v-model="selectedProduct.total" />
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right"> Selling Price </label>
                                    <div class="col-sm-8">
                                        <input type="text" id="sellingPrice" name="sellingPrice" class="form-control" v-model="selectedProduct.Product_SellingPrice" />
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right"> </label>
                                    <div class="col-sm-8">
                                        <button type="submit" class="btn btn-default pull-right">Add Cart</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
            <div class="table-responsive">
                <table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
                    <thead>
                        <tr>
                            <th style="width:4%;color:#000;">SL</th>
                            <th style="width:20%;color:#000;">Parts Name</th>
                            <!-- <th style="width:13%;color:#000;">Category</th> -->
                            <th style="width:8%;color:#000;">Purchase Rate</th>
                            <th style="width:5%;color:#000;">Quantity</th>
                            <th style="width:13%;color:#000;">Total Amount</th>
                            <th style="width:5%;color:#000;">Action</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: cart.length > 0 ? '' : 'none'}">
                        <tr v-for="(product, sl) in cart">
                            <td>{{ sl + 1}}</td>
                            <td>{{ product.name }}</td>
                            <!-- <td>{{ product.categoryName }}</td> -->
                            <td>{{ product.unit_price }}</td>
                            <td>{{ product.quantity }}</td>
                            <td>{{ product.total_amount }}</td>
                            <td><a href="" v-on:click.prevent="removeFromCart(sl)"><i class="fa fa-trash"></i></a></td>
                        </tr>

                        <!-- <tr>
                            <td colspan="7"></td>
                        </tr>

                        <tr style="font-weight: bold;">
                            <td colspan="4">Note</td>
                            <td colspan="3">Sub Total</td>
                        </tr>

                        <tr>
                            <td colspan="4"><textarea style="width: 100%;font-size:13px;" placeholder="Note" v-model="purchase.note"></textarea></td>
                            <td colspan="3" style="padding-top: 15px;font-size:18px;">{{ purchase.subTotal }}</td>
                        </tr> -->
                    </tbody>
                    <tfoot>
                        <tr style="font-weight: 600;">
                            <td style="font-size: 16px" colspan="3">Total = </td>
                            <td style="font-size: 16px">{{totalQty}}</td>
                            <td style="font-size: 16px">{{ purchase.subTotal }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>


    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Amount Details</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>

                    <a href="#" data-action="close">
                        <i class="ace-icon fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table style="color:#000;margin-bottom: 0px;">
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right">Sub Total</label>
                                                <div class="col-sm-12">
                                                    <input type="number" id="subTotal" name="subTotal" class="form-control" v-model="purchase.subTotal" readonly />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right"> Vat </label>
                                                <div class="col-sm-12">
                                                    <input type="number" id="vatPercent" name="vatPercent" v-model="vatPercent" v-on:input="calculateTotal" style="width:50px;height:25px;" />
                                                    <span style="width:20px;"> % </span>
                                                    <input type="number" id="vat" name="vat" v-model="purchase.vat" readonly style="width:140px;height:25px;" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr> -->

                                    <!-- <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right">Discount</label>
                                                <div class="col-sm-12">
                                                    <input type="number" id="discount" name="discount" class="form-control" v-model="purchase.discount" v-on:input="calculateTotal" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr> -->

                                    <!-- <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right">Transport / Labour Cost</label>
                                                <div class="col-sm-12">
                                                    <input type="number" id="freight" name="freight" class="form-control" v-model="purchase.freight" v-on:input="calculateTotal" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr> -->

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right">Total</label>
                                                <div class="col-sm-12">
                                                    <input type="number" id="total" class="form-control" v-model="purchase.total_price" readonly />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right">Paid</label>
                                                <div class="col-sm-12">
                                                    <input type="number" id="paid" class="form-control" v-model="purchase.paid" v-on:input="calculateTotal" v-bind:disabled="selectedSupplier.Supplier_Type == 'G' ? true : false" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right">Previous Due</label>
                                                <div class="col-sm-12">
                                                    <input type="number" id="previousDue" name="previousDue" class="form-control" v-model="purchase.previousDue" readonly style="color:red;" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right">Due</label>
                                                <div class="col-sm-12">
                                                    <input type="number" id="due" name="due" class="form-control" v-model="purchase.due" readonly />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <input type="button" class="btn btn-success" value="Purchase" v-on:click="savePurchase" v-bind:disabled="purchaseOnProgress == true ? true : false" style="background:#000;color:#fff;padding:3px;margin-right: 15px;">
                                                    <input type="button" class="btn btn-info" onclick="window.location = '<?php echo base_url(); ?>purchase'" value="New Purchase" style="background:#000;color:#fff;padding:3px;">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
    Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#purchase',
        data() {
            return {
                purchase: {
                    purchaseOrder_id: parseInt('<?php echo $purchaseId; ?>'),
                    purchaseOrder_invoiceNo: '<?php echo $invoice; ?>',
                    purchaseFor: '',
                    purchaseOrder_date: moment().format('YYYY-MM-DD'),
                    supplier_id: '',
                    subTotal: 0.00,
                    // vat: 0.00,
                    // discount: 0.00,
                    // freight: 0.00,
                    total_price: 0.00,
                    paid: 0.00,
                    due: 0.00,
                    previousDue: 0.00,
                    // note: ''
                },
                vehicles: [],
                selectedVehicle: null,
                vatPercent: 0.00,
                branches: [],
                selectedBranch: {
                    brunch_id: "<?php echo $this->session->userdata('BRANCHid'); ?>",
                    Brunch_name: "<?php echo $this->session->userdata('Brunch_name'); ?>"
                },
                suppliers: [],
                selectedSupplier: {
                    Supplier_SlNo: null,
                    Supplier_Code: '',
                    Supplier_Name: '',
                    display_name: 'Select Supplier',
                    Supplier_Mobile: '',
                    Supplier_Address: '',
                    Supplier_Type: ''
                },
                oldSupplierId: null,
                oldPreviousDue: 0,
                products: [],
                selectedProduct: {
                    Product_SlNo: '',
                    Product_Code: '',
                    display_text: 'Select Parts',
                    Product_Name: '',
                    Unit_Name: '',
                    quantity: '',
                    Product_Purchase_Rate: '',
                    Product_SellingPrice: 0.00,
                    total: ''
                },
                cart: [],
                purchaseOnProgress: false,
                userType: '<?php echo $this->session->userdata("accountType") ?>'
            }
        },
        created() {
            // this.getVehicle();
            this.getBranches();
            this.getSuppliers();
            this.getProducts();

            if (this.purchase.purchaseOrder_id != 0) {
                this.getPurchase();
            }
        },
        computed: {
            totalQty() {
                let total = 0;
                this.cart.forEach(ele => {
                    total += parseFloat(ele.quantity);
                })
                return total;
            }
        },
        methods: {
            getVehicle() {
                axios.get('/get_vehicle').then(res => {
                    this.vehicles = res.data;
                })
            },
            getBranches() {
                axios.get('/get_branches').then(res => {
                    this.branches = res.data;
                })
            },
            getSuppliers() {
                axios.get('/get_suppliers').then(res => {
                    this.suppliers = res.data;
                    // this.suppliers.unshift({
                    //     Supplier_SlNo: 'S01',
                    //     Supplier_Code: '',
                    //     Supplier_Name: '',
                    //     display_name: 'General Supplier',
                    //     Supplier_Mobile: '',
                    //     Supplier_Address: '',
                    //     Supplier_Type: 'G'
                    // })
                })
            },
            getProducts() {
                axios.post('/get_products', {
                    isService: 'false'
                }).then(res => {
                    this.products = res.data;
                })
            },
            onChangeSupplier() {
                if (this.selectedSupplier.Supplier_SlNo == null) {
                    return;
                }

                if (event.type == 'readystatechange') {
                    return;
                }

                if (this.purchase.purchaseOrder_id != 0 && this.oldSupplierId != parseInt(this.selectedSupplier.Supplier_SlNo)) {
                    let changeConfirm = confirm('Changing supplier will set previous due to current due amount. Do you really want to change supplier?');
                    if (changeConfirm == false) {
                        return;
                    }
                } else if (this.purchase.purchaseOrder_id != 0 && this.oldSupplierId == parseInt(this.selectedSupplier.Supplier_SlNo)) {
                    this.purchase.previousDue = this.oldPreviousDue;
                    return;
                }

                axios.post('/get_supplier_due', {
                    supplier_id: this.selectedSupplier.Supplier_SlNo
                }).then(res => {
                    if (res.data.length > 0) {
                        this.purchase.previousDue = res.data[0].due;
                    } else {
                        this.purchase.previousDue = 0;
                    }
                })
            },
            onChangeProduct() {
                this.$refs.quantity.focus();
            },
            productTotal() {
                this.selectedProduct.total = this.selectedProduct.quantity * this.selectedProduct.Product_Purchase_Rate;
            },
            addToCart() {
                let cartInd = this.cart.findIndex(p => p.productId == this.selectedProduct.Product_SlNo);
                if (cartInd > -1) {
                    alert('Product exists in cart');
                    return;
                }

                let product = {
                    parts_id: this.selectedProduct.Product_SlNo,
                    name: this.selectedProduct.Product_Name,
                    unit_price: this.selectedProduct.Product_Purchase_Rate,
                    quantity: this.selectedProduct.quantity,
                    total_amount: this.selectedProduct.total
                }

                this.cart.push(product);
                this.clearSelectedProduct();
                this.calculateTotal();
            },
            removeFromCart(ind) {
                this.cart.splice(ind, 1);
                this.calculateTotal();
            },
            clearSelectedProduct() {
                this.selectedProduct = {
                    Product_SlNo: '',
                    Product_Code: '',
                    display_text: 'Select Parts',
                    Product_Name: '',
                    Unit_Name: '',
                    quantity: '',
                    Product_Purchase_Rate: '',
                    Product_SellingPrice: 0.00,
                    total: ''
                }
            },
            calculateTotal() {
                this.purchase.subTotal = this.cart.reduce((prev, curr) => {
                    return prev + parseFloat(curr.total_amount);
                }, 0);
                // this.purchase.vat = (this.purchase.subTotal * this.vatPercent) / 100;
                // this.purchase.total = (parseFloat(this.purchase.subTotal) + parseFloat(this.purchase.vat) + parseFloat(this.purchase.freight)) - this.purchase.discount;
                this.purchase.total_price = parseFloat(this.purchase.subTotal);
                if (this.selectedSupplier.Supplier_Type == 'G') {
                    this.purchase.paid = this.purchase.total_price;
                } else {
                    this.purchase.due = (parseFloat(this.purchase.total_price) - parseFloat(this.purchase.paid)).toFixed(2);
                }
            },
            savePurchase() {
                if (this.selectedSupplier.Supplier_SlNo == null) {
                    alert('Select supplier');
                    return;
                }

                if (this.purchase.purchaseOrder_date == '') {
                    alert('Enter purchase date');
                    return;
                }

                if (this.cart.length == 0) {
                    alert('Cart is empty');
                    return;
                }

                this.purchase.supplier_id = this.selectedSupplier.Supplier_SlNo;
                this.purchase.purchaseFor = this.selectedBranch.brunch_id;

                this.purchaseOnProgress = true;

                let data = {
                    data: this.purchase,
                    cart: this.cart
                }

                if (this.selectedSupplier.Supplier_Type == 'G') {
                    data.supplier = this.selectedSupplier;
                }

                let url = '/save-purchase-order';
                if (this.purchase.purchaseOrder_id != 0) {
                    url = '/update-purchase-order';
                }

                // console.log(data, url);
                // return;

                axios.post(url, data).then(async res => {
                    if (res.data.success) {
                        alert(res.data.message);
                        location.reload();
                    } else {
                        alert('Something wrong! please try later...')
                    }
                    // let r = res.data;
                    // alert(r.message);
                    // if (r.success) {
                    //     let conf = confirm('Do you want to view invoice?');
                    //     if (conf) {
                    //         window.open(`/purchase_invoice_print/${r.purchaseOrder_id}`, '_blank');
                    //         await new Promise(r => setTimeout(r, 1000));
                    //         window.location = '/purchase';
                    //     } else {
                    //         window.location = '/purchase';
                    //     }
                    // } else {
                    //     this.purchaseOnProgress = false;
                    // }
                })
            },
            getPurchase() {
                axios.post('/get-all-purchase-Order', {
                    purchaseOrder_id: this.purchase.purchaseOrder_id
                }).then(res => {
                    // console.log(res.data);
                    // let r = res.data;
                    // let purchase = r.purchases[0];

                    this.selectedSupplier.Supplier_SlNo = res.data.purchaseOrder[0].supplier_id;
                    this.selectedSupplier.Supplier_Code = res.data.purchaseOrder[0].Supplier_Code;
                    this.selectedSupplier.Supplier_Name = res.data.purchaseOrder[0].Supplier_Name;
                    this.selectedSupplier.Supplier_Mobile = res.data.purchaseOrder[0].Supplier_Mobile;
                    this.selectedSupplier.Supplier_Address = res.data.purchaseOrder[0].Supplier_Address;
                    this.selectedSupplier.Supplier_Type = res.data.purchaseOrder[0].Supplier_Type;
                    this.selectedSupplier.display_name = purchase.Supplier_Type == 'G' ? 'General Supplier' : `${res.data.purchaseOrder[0].Supplier_Code} - ${res.data.purchaseOrder[0].Supplier_Name}`;

                    // this.purchase.purchaseOrder_invoiceNo = purchase.PurchaseMaster_InvoiceNo;
                    this.purchase.purchaseFor = res.data.purchaseOrder[0].purchaseFor;
                    // this.purchase.purchaseOrder_date = purchase.PurchaseMaster_OrderDate;
                    this.purchase.supplier_id = res.data.purchaseOrder[0].supplier_id;
                    this.purchase.subTotal = res.data.purchaseOrder[0].subTotal;
                    // this.purchase.vat = purchase.PurchaseMaster_Tax;
                    // this.purchase.discount = purchase.PurchaseMaster_DiscountAmount;
                    // this.purchase.freight = purchase.PurchaseMaster_Freight;
                    this.purchase.total_price = res.data.purchaseOrder[0].total_price;
                    this.purchase.paid = res.data.purchaseOrder[0].paid;
                    this.purchase.due = res.data.purchaseOrder[0].due;
                    this.purchase.previousDue = res.data.purchaseOrder[0].previousDue;
                    // this.purchase.note = purchase.PurchaseMaster_Description;

                    // this.oldSupplierId = purchase.Supplier_SlNo;
                    // this.oldPreviousDue = purchase.previous_due;

                    // this.vatPercent = (this.purchase.vat * 100) / this.purchase.subTotal;

                    res.data.purchaseOrderDetails.forEach(product => {
                        let item = {
                            parts_id: product.parts_id,
                            name: product.Product_Name,
                            unit_price: product.unit_price,
                            quantity: product.quantity,
                            total_amount: product.total_amount,
                        }

                        this.cart.push(item);
                    })
                })
            }
        }
    })
</script>