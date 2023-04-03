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
                    Supplier Evaluation Record
                </div>
                <form class="form-horizontal" @submit.prevent="saveEvaluation">
                    <div class="col-xs-5 col-xs-offset-1">
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
                    <div class="col-xs-5">
                        <div class="form-group">
                            <label class="control-label col-xs-4">Date of Evaluation :</label>
                            <div class="col-xs-8">
                                <input type="date" v-model="evaluation.date_of_evaluation" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-4">Period of Evaluation :</label>
                            <div class="col-xs-8">
                                <div class="row">
                                    <div class="col-xs-5" style="padding-right:0px">
                                        <select v-model="evaluation.period_of_evaluation_from" id="" class="form-control" style="padding: 0px 5px;">
                                            <?php
                                            $y = date('Y');
                                            for ($i = $y - 5; $i < $y + 5; $i++) { ?>
                                                <option value="<?= $i ?>"><?= $i ?></option>

                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-2" style="text-align: center;">to</div>
                                    <div class="col-xs-5" style="padding-left:0px">
                                        <select v-model="evaluation.period_of_evaluation_to" id="" class="form-control" style="padding: 0px 5px;">
                                            <?php
                                            $y = date('Y');
                                            for ($i = $y - 5; $i < $y + 5; $i++) { ?>
                                                <option value="<?= $i ?>"><?= $i ?></option>

                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- <input type="date" v-model="evaluation.period_of_evaluation" class="form-control"> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-4">Evaluation By :</label>
                            <div class="col-xs-8">
                                <input type="text" v-model="evaluation.evaluation_by" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-12" style="margin-top: 20px;">
                        <table class="table table-bordered">
                            <tr style="background: rgb(0 47 70);color:#fff">
                                <td rowspan="2">Sl.</td>
                                <td rowspan="2">Material Name</td>
                                <td colspan="5">Rating</td>
                                <td rowspan="2" style="width: 7%;">Action</td>
                            </tr>
                            <tr style="background: rgb(0 47 70);color:#fff">
                                <td style="width:7%;">Quality (50)</td>
                                <td style=" width:7%;">Service (30)</td>
                                <td style="width:7%;">Price (20)</td>
                                <td style=" width:7%;">Total (100)</td>
                                <td style="width:20%;">Remarks</td>
                            </tr>
                            <tr v-for=" (item,index) in cart">
                                <td style="padding:1px;">{{ index+1 }}</td>
                                <td style="padding:1px;">
                                    <input class="form-control" v-model="item.material_name" type="text" style="text-align:center;padding:15px;margin-bottom:0px;">
                                </td>
                                <td style="padding:1px;">
                                    <input class="form-control" v-model="item.quality" v-on:input="calTotal(index)" type="number" style="text-align:center;padding:15px;margin-bottom:0px;">
                                </td>
                                <td style="padding:1px;">
                                    <input class=" form-control" v-model="item.service" v-on:input="calTotal(index)" type="number" style="text-align:center;padding:15px;margin-bottom:0px;">
                                </td>
                                <td style="padding:1px;">
                                    <input class=" form-control" v-model="item.price" v-on:input="calTotal(index)" type="number" style="text-align:center;padding:15px;margin-bottom:0px;">
                                </td>
                                <td style="padding:1px;">
                                    <input class=" form-control" v-model="item.total" type="number" style="text-align:center;padding:15px;margin-bottom:0px;" disabled>
                                </td>
                                <td style="padding:1px;">
                                    <input class=" form-control" v-model="item.remarks" type="text" style="text-align:center;padding:15px;margin-bottom:0px;">
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
                                <p><b>Note: </b> Total 90-100 will be continued with satisfaction, 80-89 continue without satisfaction, 70-79 will be avoided</p>
                            </div>
                            <div class="col-xs-2">
                                <input type="submit" class="btn btn-success btn-sm" value="Save License">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- <div class="row">
        <div class="col-sm-12 form-inline">
            <div class="form-group">
                <label for="filter" class="sr-only">Filter</label>
                <input type="text" class="form-control" v-model="filter" placeholder="Filter">
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <datatable :columns="columns" :data="evaluations" :filter-by="filter">
                    <template scope="{ row }">
                        <tr>
                            <td>{{ row.date }}</td>
                            <td>{{ row.Supplier_Name }}</td>
                            <td>{{ row.date_of_evaluation }}</td>
                            <td>{{ row.period_of_evaluation }}</td>
                            <td>{{ row.evaluation_by }}</td>

                            <td>
                                <a href="" title="Edit Supplier Evaluation" @click.prevent="editSupEvaluation(row)"><i class="fa fa-pencil"></i></a>&nbsp;
                                <a href="" class="button" @click.prevent="deleteSupEvaluation(row.supplier_evaluation_id)"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    </template>
                </datatable>
                <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
            </div>
        </div>
    </div> -->
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
                evaluation: {
                    supplier_evaluation_id: '<?= $id ?>',
                    supplier_Id: '',
                    date_of_evaluation: '',
                    period_of_evaluation_from: '<?= date('Y') - 1 ?>',
                    period_of_evaluation_to: '<?= date('Y') ?>',
                    evaluation_by: '',
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
                evaluations: [],

                columns: [{
                        label: 'Date',
                        field: 'date',
                        align: 'center'
                    },
                    {
                        label: 'Supplier Name',
                        field: 'Supplier_Name',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Date of Evaluation',
                        field: 'date_of_evaluation',
                        align: 'center'
                    },
                    {
                        label: 'Period of Evaluation',
                        field: 'period_of_evaluation',
                        align: 'center'
                    },
                    // {
                    //     label: 'Remarks',
                    //     field: 'remarks',
                    //     align: 'center'
                    // },
                    {
                        label: 'Evaluation By',
                        field: 'evaluation_by',
                        align: 'center'
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
            // this.getSupEvaluation();
            if (this.evaluation.supplier_evaluation_id != '') {
                axios.post('/get-supplier-evaluation', {
                    supplier_evaluation_id: this.evaluation.supplier_evaluation_id
                }).then(res => {
                    // this.evaluations = res.data;

                    this.editSupEvaluation(res.data[0]);

                })
            }

        },
        methods: {
            // getSupEvaluation() {
            //     axios.get('/get-supplier-evaluation').then(res => {
            //         this.evaluations = res.data;
            //     })
            // },
            addCartItem() {
                let item = {
                    material_name: '',
                    quality: '',
                    service: '',
                    price: '',
                    total: '',
                    remarks: '',
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
                this.evaluation.supplier_Id = this.selectedSupplier.Supplier_SlNo;

            },
            calTotal(index) {
                if (this.cart[index].quality > 50) {
                    alert('Max qualtiy is 50 valid for the field!')
                    this.cart[index].quality = 50;
                }
                if (this.cart[index].service > 30) {
                    alert('Max service is 30 valid for the field!')
                    this.cart[index].service = 30;
                }
                if (this.cart[index].price > 20) {
                    alert('Max price is 20 valid for the field!')
                    this.cart[index].price = 20;
                }
                this.cart[index].total = parseFloat(this.cart[index].quality == '' ? 0 : this.cart[index].quality) +
                    parseFloat(this.cart[index].service == '' ? 0 : this.cart[index].service) +
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
            saveEvaluation() {
                if (this.selectedSupplier.Supplier_SlNo == '') {
                    alert('Select a Supplier');
                    return;
                }
                if (this.evaluation.date_of_evaluation == '') {
                    alert('Date of evaluation required!');
                    return;
                }
                if (this.evaluation.period_of_evaluation_from == '') {
                    alert('Period of evaluation from required!');
                    return;
                }
                if (this.evaluation.period_of_evaluation_to == '') {
                    alert('Period of evaluation to required!');
                    return;
                }
                if (this.evaluation.evaluation_by == '') {
                    alert('Evaluation By required!');
                    return;
                }

                this.cart.forEach(ele => {
                    if (ele.material_name == '') {
                        alert('Material Name is required!')
                        return;
                    }
                    if (ele.quality == '') {
                        alert('Quality required!')
                        return;
                    }
                    if (ele.service == '') {
                        alert('Service required!')
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
                    if (ele.remarks == '') {
                        alert('Remarks required!')
                        return;
                    }
                })

                // console.log(this.cart);
                // return;

                // this.license.vehicle_id = this.selectedVehicle.vehicle_id;

                let url = '/save-supplier-evaluation';
                if (this.evaluation.supplier_evaluation_id != '') {
                    url = "/update-supplier-evaluation";
                }
                let filter = {
                    cart: this.cart,
                    details: this.evaluation
                }

                // console.log(this.license);
                // return;

                axios.post(url, filter).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.getSupEvaluation();
                        this.clearForm();
                    }
                })
            },
            editSupEvaluation(data) {


                // console.log(data);
                this.evaluation.supplier_evaluation_id = data.supplier_evaluation_id;
                this.evaluation.supplier_Id = data.supplier_Id;
                this.evaluation.date_of_evaluation = data.date_of_evaluation;
                this.evaluation.period_of_evaluation_from = data.period_of_evaluation_from;
                this.evaluation.period_of_evaluation_to = data.period_of_evaluation_to;
                this.evaluation.evaluation_by = data.evaluation_by;

                this.cart = data.details;

                this.suppliers.forEach(ele => {
                    if (ele.Supplier_SlNo == data.supplier_Id) {
                        this.selectedSupplier = ele;
                    }
                })

            },
            deleteSupEvaluation(id) {
                let deleteConfirm = confirm('Are Your Sure to delete the item?');
                if (deleteConfirm == false) {
                    return;
                }
                axios.post('/delete-supplier-evaluation', {
                    supplier_evaluation_id: id
                }).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.getSupEvaluation();
                    }
                })
            },
            clearForm() {
                this.evaluation = {
                    supplier_evaluation_id: '',
                    supplier_Id: '',
                    date_of_evaluation: '',
                    period_of_evaluation_from: '<?= date('Y') - 1 ?>',
                    period_of_evaluation_to: '<?= date('Y') ?>',
                    evaluation_by: '',
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