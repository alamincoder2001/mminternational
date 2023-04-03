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
                    Supplier Feedback Form
                </div>
                <form class="form-horizontal" @submit.prevent="saveFeedback">
                    <div class="col-xs-5 col-xs-offset-3">
                        <div class="form-group">
                            <label class="control-label col-xs-4">Date :</label>
                            <div class="col-xs-8">
                                <input type="date" v-model="feedback.feedback_date" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-4">Supplier Name :</label>
                            <div class="col-xs-8">
                                <v-select v-bind:options="suppliers" v-model="selectedSupplier" label="display_name" placeholder="Select Supplier" v-on:input="supplierOnChange"></v-select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-4">Supplier Address :</label>
                            <div class="col-xs-8">
                                <textarea v-model="selectedSupplier.Supplier_Address" cols="30" rows="2" class="form-control"></textarea>
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
                                <td style="width:7%;">Customer Service (20)</td>
                                <td style=" width:7%;">Payments Mode (65)</td>
                                <td style="width:7%;">Behavior & Others (15)</td>
                                <td style=" width:7%;">Total (100)</td>
                                <td style="width:20%;">Comments</td>
                            </tr>
                            <tr v-for=" (item,index) in cart">
                                <td style="padding:1px;">{{ index+1 }}</td>
                                <td style="padding:1px;">
                                    <input class="form-control" v-model="item.service_name" type="text" style="text-align:center;padding:15px;margin-bottom:1px;">
                                </td>
                                <td style="padding:1px;">
                                    <input class="form-control" v-model="item.customer_service" v-on:input="calTotal(index)" type="number" style="text-align:center;padding:15px;margin-bottom:1px;">
                                </td>
                                <td style="padding:1px;">
                                    <input class=" form-control" v-model="item.payment_mode" v-on:input="calTotal(index)" type="number" style="text-align:center;padding:15px;margin-bottom:1px;">
                                </td>
                                <td style="padding:1px;">
                                    <input class=" form-control" v-model="item.behaviors_and_others" v-on:input="calTotal(index)" type="number" style="text-align:center;padding:15px;margin-bottom:1px;">
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
                                <p><b>Note: </b> Total 100-95 = Excellent, 94-90 = Good, 89-85 = Average</p>
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
                            <td>{{ row.feedback_date }}</td>
                            <td>{{ row.Supplier_Name }}</td>


                            <td>
                                <a href="" title="Edit Supplier Feedback" @click.prevent="editSupFeedback(row)"><i class="fa fa-pencil"></i></a>&nbsp;
                                <a href="" class="button" @click.prevent="deleteSupFeedback(row.sup_feedback_id)"><i class="fa fa-trash"></i></a>
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
                    sup_feedback_id: '',
                    feedback_date: moment().format('YYYY-MM-DD'),
                    supplier_Id: '',
                },
                cart: [],
                suppliers: [],
                selectedSupplier: {
                    Supplier_SlNo: '',
                    Supplier_Code: '',
                    Supplier_Name: '',
                    display_name: 'Select Supplier',
                    Supplier_Mobile: '',
                    Supplier_Address: '',
                    Supplier_Type: ''
                },
                // selectedVehicle: null,
                feedbacks: [],

                columns: [{
                        label: 'Feedback Date',
                        field: 'feedback_date',
                        align: 'center'
                    },
                    {
                        label: 'Supplier Name',
                        field: 'Supplier_Name',
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
            this.getSuppliers();
            this.getSupFeedback();
            // this.getLicense();
        },
        methods: {
            getSupFeedback() {
                axios.get('/get-supplier-feedback').then(res => {
                    this.feedbacks = res.data;
                })
            },
            addCartItem() {
                let item = {
                    service_name: '',
                    customer_service: '',
                    payment_mode: '',
                    behaviors_and_others: '',
                    total: '',
                    comments: '',
                }
                this.cart.push(item);
            },
            delCartItem(index) {
                // console.log(index);
                this.cart.splice(index, 1)
            },
            getSuppliers() {
                axios.get('/get_suppliers').then(res => {
                    this.suppliers = res.data;
                })
            },
            supplierOnChange() {
                // this.evaluation.Supplier_Address
                this.feedback.supplier_Id = this.selectedSupplier.Supplier_SlNo;

            },
            calTotal(index) {
                if (this.cart[index].customer_service > 20) {
                    alert('Max customer service is 20 valid for the field!')
                    this.cart[index].customer_service = 20;
                }
                if (this.cart[index].payment_mode > 65) {
                    alert('Max payment mode is 65 valid for the field!')
                    this.cart[index].payment_mode = 65;
                }
                if (this.cart[index].behaviors_and_others > 15) {
                    alert('Max behaviors and others is 15 valid for the field!')
                    this.cart[index].behaviors_and_others = 15;
                }
                this.cart[index].total = parseFloat(this.cart[index].customer_service == '' ? 0 : this.cart[index].customer_service) +
                    parseFloat(this.cart[index].payment_mode == '' ? 0 : this.cart[index].payment_mode) +
                    parseFloat(this.cart[index].behaviors_and_others == '' ? 0 : this.cart[index].behaviors_and_others)
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
                if (this.selectedSupplier.Supplier_SlNo == '') {
                    alert('Select a Supplier');
                    return;
                }
                if (this.feedback.date == '') {
                    alert('Date required!');
                    return;
                }

                this.cart.forEach(ele => {
                    if (ele.service_name == '') {
                        alert('Service Name is required!')
                        return;
                    }
                    if (ele.customer_service == '') {
                        alert('Customer Service required!')
                        return;
                    }
                    if (ele.payment_mode == '') {
                        alert('Payment Mode required!')
                        return;
                    }
                    if (ele.behaviors_and_others == '') {
                        alert('Behaviours and Others required!')
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

                let url = '/save-supplier-feedback';
                if (this.feedback.sup_feedback_id != '') {
                    url = "/update-supplier-feedback";
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
                        this.getSupFeedback();
                        this.clearForm();
                    }
                })
            },
            editSupFeedback(data) {
                // console.log(data);
                this.feedback.sup_feedback_id = data.sup_feedback_id;
                this.feedback.supplier_Id = data.supplier_Id;
                this.feedback.feedback_date = data.feedback_date;

                this.cart = data.details;

                this.suppliers.forEach(ele => {
                    if (ele.Supplier_SlNo == data.supplier_Id) {
                        this.selectedSupplier = ele;
                    }
                })

            },
            deleteSupFeedback(id) {
                let deleteConfirm = confirm('Are Your Sure to delete the item?');
                if (deleteConfirm == false) {
                    return;
                }
                axios.post('/delete-supplier-feedback', {
                    sup_feedback_id: id
                }).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.getSupFeedback();
                    }
                })
            },
            clearForm() {
                this.feedback = {
                    sup_feedback_id: '',
                    feedback_date: moment().format('YYYY-MM-DD'),
                    supplier_Id: '',
                }

                this.selectedSupplier = {
                    Supplier_SlNo: '',
                    Supplier_Code: '',
                    Supplier_Name: '',
                    display_name: 'Select Supplier',
                    Supplier_Mobile: '',
                    Supplier_Address: '',
                    Supplier_Type: ''
                };
                this.cart = [];
                this.addCartItem();
            }
        }
    })
</script>