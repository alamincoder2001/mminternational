<style>
    .v-select .selected-tag {
        margin: 0px;
    }

    .v-select {
        margin-bottom: 5px;
    }

    .v-select .dropdown-toggle {
        padding: 0px;
    }

    .v-select input[type=search],
    .v-select input[type=search]:focus {
        margin: 0px;
        height: 24px;
    }

    .card {
        border: 1px solid #aaa;
        padding-bottom: 20px;
    }

    .card-header {
        font-size: 20px;
        font-weight: 500;
        background: #eee;
        padding: 3px 7px;
        margin-bottom: 10px;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .addcartitem {
        margin-top: 3px;
        border: none;
        background: #04db00;
        color: #fff;
    }

    .delcartitem {
        margin-top: 3px;
        margin-top: 3px;
        padding: 1px 8px;
        background: red;
        color: #fff;
        font-weight: bold;
        border: none;
    }

    /* .form-control {
        height: 30px !important;
    } */
</style>
<div id="vehicle">
    <div class="row" style="margin-top: 5px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom: 15px;">
        <div class="col-xs-12" style="padding: 0px;">
            <div class="card clearfix">
                <div class="card-header">
                    Customer Feedback Form
                </div>
                <form class="form-horizontal" @submit.prevent="saveFeedback">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class="form-group">
                            <label class="control-label col-xs-4">Received Date :</label>
                            <div class="col-xs-8">
                                <input type="date" v-model="feedback.received_date" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-4">Customer Name :</label>
                            <div class="col-xs-8">
                                <v-select v-bind:options="customers" v-model="selectedCustomer" label="display_name" placeholder="Select Customer" v-on:input="customerOnChange"></v-select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-4">Customer Phone :</label>
                            <div class="col-xs-8">
                                <input type="text" v-model="selectedCustomer.Customer_Mobile" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-4">Customer Address :</label>
                            <div class="col-xs-8">
                                <textarea v-model="selectedCustomer.Customer_Address" cols="30" rows="2" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-4">Factory Address :</label>
                            <div class="col-xs-8">
                                <textarea v-model="feedback.factory_address" cols="30" rows="2" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12" style="margin-top: 20px;">
                        <table class="table table-bordered">
                            <tr style="background: rgb(0 47 70);color:#fff">
                                <td rowspan="2">Sl.</td>
                                <td rowspan="2">Service Name</td>
                                <td colspan="5">Rating</td>
                                <td rowspan="2" style="width: 7%;">Action</td>
                            </tr>
                            <tr style="background: rgb(0 47 70);color:#fff">
                                <td style="width:7%;">Quality of Service (40)</td>
                                <td style=" width:7%;">Product Delivery Time (35)</td>
                                <td style="width:7%;">Price (25)</td>
                                <td style=" width:7%;">Total (100)</td>
                                <td style="width:20%;">Comments</td>
                            </tr>
                            <tr v-for=" (item,index) in cart">
                                <td style="padding:1px;">{{ index+1 }}</td>
                                <td style="padding:1px;">
                                    <input class="form-control" v-model="item.service_name" type="text" style="text-align:center;padding:15px;margin-bottom:1px;">
                                </td>
                                <td style="padding:1px;">
                                    <input class="form-control" v-model="item.quality_of_service" v-on:input="calTotal(index)" type="number" style="text-align:center;padding:15px;margin-bottom:1px;">
                                </td>
                                <td style="padding:1px;">
                                    <input class=" form-control" v-model="item.product_delivery_time" v-on:input="calTotal(index)" type="number" style="text-align:center;padding:15px;margin-bottom:1px;">
                                </td>
                                <td style="padding:1px;">
                                    <input class=" form-control" v-model="item.price" v-on:input="calTotal(index)" type="number" style="text-align:center;padding:15px;margin-bottom:1px;">
                                </td>
                                <td style="padding:1px;">
                                    <input class=" form-control" v-model="item.total" type="number" style="text-align:center;padding:15px;margin-bottom:1px;" disabled>
                                </td>
                                <td style="padding:1px;">
                                    <input class=" form-control" v-model="item.comments" type="text" style="text-align:center;padding:15px;margin-bottom:1px;">
                                </td>
                                <td style="padding:1px;">
                                    <button class="addcartitem" v-on:click.prevent="addCartItem"> + </button>
                                    <button v-if="index > 0" class="delcartitem" v-on:click.prevent="delCartItem(index)"> - </button>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class=" col-xs-12">
                        <div class="form-group clearfix" style="margin-top: 10px;">
                            <div class="col-xs-10">
                                <p><b>Note: </b> Total 100-96 = Excellent, 95-91 = Good, 90-85 = Average</p>
                            </div>
                            <div class="col-xs-2">
                                <input type="submit" class="btn btn-success btn-sm" value="Save Feedback">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 form-inline">
            <div class="form-group">
                <label for="filter" class="sr-only">Filter</label>
                <input type="text" class="form-control" v-model="filter" placeholder="Filter">
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <datatable :columns="columns" :data="feedbacks" :filter-by="filter">
                    <template scope="{ row }">
                        <tr>
                            <td>{{ row.received_date }}</td>
                            <td>{{ row.Customer_Name }}</td>
                            <td>{{ row.Customer_Address }}</td>
                            <td>{{ row.factory_address }}</td>


                            <td>
                                <a href="" title="Edit Customer Feedback" @click.prevent="editCusFeedback(row)"><i class="fa fa-pencil"></i></a>&nbsp;
                                <a href="" class="button" @click.prevent="deleteCusFeedback(row.cus_feedback_id)"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    </template>
                </datatable>
                <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script>
    Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#vehicle',

        data() {
            return {
                feedback: {
                    cus_feedback_id: '',
                    received_date: moment().format('YYYY-MM-DD'),
                    customer_Id: '',
                    factory_address: '',
                },
                cart: [],
                customers: [],
                selectedCustomer: {
                    Customer_SlNo: '',
                    Customer_Code: '',
                    Customer_Name: '',
                    display_name: 'Select Customer',
                    Customer_Mobile: '',
                    Customer_Address: '',
                    Customer_Type: ''
                },
                // selectedVehicle: null,
                feedbacks: [],

                columns: [{
                        label: 'Received Date',
                        field: 'received_date',
                        align: 'center'
                    },
                    {
                        label: 'Customer Name',
                        field: 'Customer_Name',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Customer Address',
                        field: 'Customer_Address',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Factory Address',
                        field: 'factory_address',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Action',
                        align: 'center',
                        filterable: false
                    }
                ],
                page: 1,
                per_page: 10,
                filter: ''
            }
        },
        created() {
            this.addCartItem();
            this.getCustomers();
            this.getCusFeedback();
            // this.getLicense();
        },
        methods: {
            getCusFeedback() {
                axios.get('/get-customer-feedback').then(res => {
                    this.feedbacks = res.data;
                })
            },
            addCartItem() {
                let item = {
                    service_name: '',
                    quality_of_service: '',
                    product_delivery_time: '',
                    price: '',
                    total: '',
                    comments: '',
                }
                this.cart.push(item);
            },
            delCartItem(index) {
                // console.log(index);
                this.cart.splice(index, 1)
            },
            getCustomers() {
                axios.get('/get_customers').then(res => {
                    this.customers = res.data;
                })
            },
            customerOnChange() {
                // this.evaluation.Supplier_Address
                this.feedback.customer_Id = this.selectedCustomer.Customer_SlNo;

            },
            calTotal(index) {
                if (this.cart[index].quality_of_service > 40) {
                    alert('Max Quality of service is 40 valid for the field!')
                    this.cart[index].quality_of_service = 20;
                }
                if (this.cart[index].product_delivery_time > 35) {
                    alert('Max Product delivery time is 35 valid for the field!')
                    this.cart[index].product_delivery_time = 35;
                }
                if (this.cart[index].price > 25) {
                    alert('Max price is 25 valid for the field!')
                    this.cart[index].price = 25;
                }
                this.cart[index].total = parseFloat(this.cart[index].quality_of_service == '' ? 0 : this.cart[index].quality_of_service) +
                    parseFloat(this.cart[index].product_delivery_time == '' ? 0 : this.cart[index].product_delivery_time) +
                    parseFloat(this.cart[index].price == '' ? 0 : this.cart[index].price)
            },
            // getVehicle() {
            //     axios.get('/get_vehicle').then(res => {
            //         this.vehicles = res.data;
            //     })
            // },
            // getLicense() {
            //     axios.get('/get-vehicle-license').then(res => {
            //         console.log(res);
            //         this.vehicleLicense = res.data;
            //     })
            // },
            saveFeedback() {
                if (this.selectedCustomer.Customer_SlNo == '') {
                    alert('Select a Customer');
                    return;
                }
                if (this.feedback.received_date == '') {
                    alert('Received date required!');
                    return;
                }
                if (this.feedback.factory_address == '') {
                    alert('Factory address required!');
                    return;
                }

                this.cart.forEach(ele => {
                    if (ele.service_name == '') {
                        alert('Service Name is required!')
                        return;
                    }
                    if (ele.quality_of_service == '') {
                        alert('Quality of service required!')
                        return;
                    }
                    if (ele.product_delivery_time == '') {
                        alert('Product delivery time required!')
                        return;
                    }
                    if (ele.price == '') {
                        alert('Price required!')
                        return;
                    }
                    if (ele.total == '') {
                        alert('Total required!')
                        return;
                    }
                    if (ele.comments == '') {
                        alert('Comments required!')
                        return;
                    }
                })

                // console.log(this.cart);
                // return;

                // this.license.vehicle_id = this.selectedVehicle.vehicle_id;

                let url = '/save-customer-feedback';
                if (this.feedback.cus_feedback_id != '') {
                    url = "/update-customer-feedback";
                }
                let filter = {
                    cart: this.cart,
                    details: this.feedback
                }

                // console.log(this.license);
                // return;

                axios.post(url, filter).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.getCusFeedback();
                        this.clearForm();
                    }
                })
            },
            editCusFeedback(data) {
                // console.log(data);
                this.feedback.cus_feedback_id = data.cus_feedback_id;
                this.feedback.customer_Id = data.customer_Id;
                this.feedback.received_date = data.received_date;
                this.feedback.factory_address = data.factory_address;

                this.cart = data.details;

                this.customers.forEach(ele => {
                    if (ele.Customer_SlNo == data.customer_Id) {
                        this.selectedCustomer = ele;
                    }
                })

            },
            deleteCusFeedback(id) {
                let deleteConfirm = confirm('Are Your Sure to delete the item?');
                if (deleteConfirm == false) {
                    return;
                }
                axios.post('/delete-customer-feedback', {
                    cus_feedback_id: id
                }).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.getCusFeedback();
                    }
                })
            },
            clearForm() {
                this.feedback = {
                    cus_feedback_id: '',
                    received_date: moment().format('YYYY-MM-DD'),
                    customer_Id: '',
                    factory_address: '',
                }

                this.selectedCustomer = {
                    Customer_SlNo: '',
                    Customer_Code: '',
                    Customer_Name: '',
                    display_name: 'Select Customer',
                    Customer_Mobile: '',
                    Customer_Address: '',
                    Customer_Type: ''
                };
                this.cart = [];
                this.addCartItem();
            }
        }
    })
</script>