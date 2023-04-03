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
        height: 25px;
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
        width: 100%;
    }

    label {
        font-size: 13px !important;
        padding-right: 0px !important;
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

    .ckeditor {
        margin-bottom: 15px;
        width: 100%;
        clear: both;
    }

    .cke_toolgroup {
        background-image: none;
        border-color: #fff;
        background: #fff;
        box-shadow: none;
    }
</style>


<div id="vehicle">
    <div class="row">
        <div class="col-md-12">
            <h4 style="padding: 6px 13px;background:#eee;margin: 0px 0px 25px;">Add Daily Maintenance</h4>
            <div class="row" style="margin-top: 10px;margin-bottom:15px;">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">In Date:</label>
                        <div class="col-md-8">
                            <input type="date" class="form-control" v-model="inputData.date">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4">Out Date:</label>
                        <div class="col-md-8">
                            <input type="date" class="form-control" v-model="inputData.out_date">
                        </div>
                    </div>

                    <div class="form-group">

                        <label class="control-label col-md-4">Workshop Name:</label>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-xs-10 no-padding-right">
                                    <select class="form-control" v-model="inputData.workshop_name" style="padding: 0px;">
                                        <option value="" disabled>Select---</option>
                                        <option v-for="workshop in workshops" :value="workshop.workshop_id">
                                            {{ workshop.workshop_name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-xs-2">
                                    <a href="/add-workshop" target="_blank">
                                        <span style="background: #3e2e6b;color: #fff;padding: 3px 14px;position: absolute;font-weight: 600;">+</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Vehicle Reg. No:</label>
                        <div class="col-md-8">
                            <v-select v-bind:options="vehicles" v-model="selectedVehicle" @input="getJobCard" label="vehicle_reg_no" placeholder="Select Vehciles"></v-select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Vehicle In Time:</label>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="time" class="form-control" v-model="inputData.vehicle_in_time">
                                </div>
                                <div class="col-md-2 no-padding-right" style="text-align: right;">Out: </div>
                                <div class="col-md-5">
                                    <input type="time" class="form-control" v-model="inputData.vehicle_out_time">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Mechanic Name:</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" v-model="inputData.mechanic_name">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Automobile Eng:</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" v-model="inputData.autmobile_engineer">
                        </div>
                    </div>
                    <!-- <div class="form-group clearfix">
                        <label class="control-label col-md-4">Other Cost:</label>
                        <div class="col-md-8">
                            <input type="number" v-on:input="calTotalCost" class="form-control" v-model="inputData.cost">
                        </div>
                    </div> -->
                    <!-- <div class="form-group clearfix">
                        <label class="control-label col-md-4">Labour Cost:</label>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="number" v-on:input="calTotalCost" class="form-control" v-model="inputData.labour_cost">
                                </div>
                                <div class="col-md-4" style="text-align: right;">Other Cost: </div>
                                <div class="col-md-4">
                                    <input type="number" v-on:input="calTotalCost" class="form-control" v-model="inputData.other_cost">
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="form-group clearfix">
                        <label class="control-label col-md-4">Total Cost:</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" v-model="inputData.total_cost" disabled>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <label class="control-label col-md-4">Job Details/ Problems:</label>
                        <div class="col-md-8">
                            <!-- <textarea class="form-control" v-model="inputData.job_problems" cols="30"
                                rows="3"></textarea> -->
                            <template>
                                <div>
                                    <mc-wysiwyg v-model="inputData.job_problems" :height="150"></mc-wysiwyg>
                                </div>
                            </template>
                            <!-- <ckeditor v-model="inputData.job_problems"> </ckeditor> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Job Activity/ Progress:</label>
                        <div class="col-md-8">
                            <!-- <textarea class="form-control" v-model="inputData.job_progress" cols="30"
                                rows="3"></textarea> -->

                            <template>
                                <div>
                                    <mc-wysiwyg v-model="inputData.job_progress" :height="150"></mc-wysiwyg>
                                </div>
                            </template>

                        </div>
                    </div>

                </div>
                <div class="col-md-6">

                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Spare Parts Cost:</label>
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr style="background: rgb(0 47 70);color:#fff">
                                    <td>Sl.</td>
                                    <td>Spare Parts Name</td>
                                    <td style="width: 10%;">Qty</td>
                                    <td style="width: 10%;">Rate</td>
                                    <td style="width: 20%;">Cost TK</td>
                                    <td style="width: 48px;">#</td>
                                </tr>
                                <tr v-for=" (item,index) in parts_cart">
                                    <td style="padding:1px;">{{ index+1 }}</td>
                                    <td style="padding:0px;">
                                        <input class="form-control" v-model="item.parts_name" type="text" style="text-align:left;padding:1px;margin-bottom:0px;border:none;">
                                    </td>
                                    <td style="padding:0px;">
                                        <input class="form-control" v-model.number="item.qty" type="text" style="text-align:center;padding:1px;margin-bottom:0px;border:none;">
                                    </td>
                                    <td style="padding:0px;">
                                        <input class="form-control" v-model.number="item.rate" type="text" style="text-align:center;padding:1px;margin-bottom:0px;border:none;">
                                    </td>
                                    <td style="padding:0px;">
                                        <input class="form-control" v-model.number="item.total_tk" type="text" style="text-align:center;padding:1px;margin-bottom:0px;border:none;">
                                    </td>
                                    <td style="padding:1px;">
                                        <button class="addcartitem" v-on:click.prevent="partsAddCartItem"> + </button>
                                        <button v-if="index > 0" class="delcartitem" v-on:click.prevent="delPartsCartItem(index)"> - </button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Labour Cost:</label>
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr style="background: rgb(0 47 70);color:#fff">
                                    <td>Sl.</td>
                                    <td>Name</td>
                                    <td style="width: 20%;">Cost TK</td>
                                    <td style="width: 48px;">#</td>
                                </tr>
                                <tr v-for=" (item,index) in labour_cart">
                                    <td style="padding:0px;">{{ index+1 }}</td>
                                    <td style="padding:0px;">
                                        <input class="form-control" v-model="item.labour_name" type="text" style="text-align:left;padding:1px;margin-bottom:0px;border:none;">
                                    </td>
                                    <td style="padding:0px;">
                                        <input class="form-control" v-model.number="item.total_tk" type="text" style="text-align:center;padding:1px;margin-bottom:0px;border:none;">
                                    </td>
                                    <td style="padding:0px;">
                                        <button class="addcartitem" v-on:click.prevent="labourAddCartItem"> + </button>
                                        <button v-if="index > 0" class="delcartitem" v-on:click.prevent="delCartItem(index)"> - </button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Other Cost:</label>
                        <div class="col-md-8">
                            <input type="text" @input="calTotalCost()" class="form-control" v-model.number="inputData.other_cost">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Total Cost:</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" v-model="inputData.total_cost" disabled>
                        </div>
                    </div>
                    <div class="form-group clearfix" style="margin-top: 15px;">
                        <label class="control-label col-md-4">Image 1:</label>
                        <div class="col-md-8">
                            <input type="file" @change="getFile1" style="padding: 1px;" class="form-control">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Image 2:</label>
                        <div class="col-md-8">
                            <input type="file" @change="getFile2" style="padding: 1px;" class="form-control">
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="padding-left: 25px;">
                    <label style="padding-right: 10px !important;" for="">ENABLE PARTS REPLACE: </label>
                    <input style="position: absolute;width:15px;height:15px" type="checkbox" v-model="partsReplace">
                </div>
            </div>
            <div class="row" style="margin-top: 10px;border-top: 1px solid #aaa;padding-top: 20px;display:none" :style="{display: partsReplace ? '' : 'none'}">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">New Parts:</label>
                        <div class="col-md-8">
                            <v-select v-bind:options="newParts" v-model="selectedNewParts" label="display_text" placeholder="Select Parts"></v-select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">New Parts Serial:</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" v-model="cartItem.new_parts_serial">
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Install Date:</label>
                        <div class="col-md-8">
                            <input type="date" class="form-control" v-model="cartItem.install_date">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Expire Date:</label>
                        <div class="col-md-8">
                            <input type="date" class="form-control" v-model="cartItem.expire_date">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Old Parts:</label>
                        <div class="col-md-8">
                            <v-select v-bind:options="oldParts" v-model="selectedOldParts" label="display_text" placeholder="Select Parts"></v-select>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-4">Old Parts Serial:</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" v-model="cartItem.old_parts_serial">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-md-12" style="text-align: right;margin-top:15px;">
                            <button class="btn btn-default btn-sm" v-on:click="addToCart">Add to Cart</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 10px;border-top: 1px dotted #aaa;padding-top: 20px;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>New Parts</th>
                                <th>New Parts Serial</th>
                                <th>Install Date</th>
                                <th>Expire Date</th>
                                <th>Old Parts</th>
                                <th>Old Parts Serial</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item,sl) in cart">
                                <td>{{ sl+1 }}</td>
                                <td>{{ item.new_parts_name }}</td>
                                <td>{{ item.new_parts_serial }}</td>
                                <td>{{ item.install_date }}</td>
                                <td>{{ item.expire_date }}</td>
                                <td>{{ item.old_parts_name }}</td>
                                <td>{{ item.old_parts_serial }}</td>
                                <td><button v-on:click="deleteCartItem(sl)" style="background: none;border: none;"><i class="fa fa-trash" style="color: red;;"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="text-align: right;">
                    <button v-on:click="saveData" class="btn btn-sm btn-success" :disabled="isprocess">Save </button>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script src="https://unpkg.com/@mycure/vue-wysiwyg/dist/mc-wysiwyg.js"></script>


<script>
    Vue.component('v-select', VueSelect.VueSelect);
    Vue.use(McWysiwyg.default);

    new Vue({
        el: '#vehicle',
        data() {
            return {
                inputData: {
                    maintenance_id: '<?php echo $maintenance_id ?>',
                    date: moment().format('YYYY-MM-DD'),
                    out_date: '',
                    workshop_name: '',
                    vehicle_id: '',
                    vehicle_in_time: '',
                    vehicle_out_time: '',
                    mechanic_name: '',
                    autmobile_engineer: '',
                    spare_cost: '',
                    labour_cost: '',
                    other_cost: '',
                    total_cost: 0,
                    job_problems: '',
                    job_progress: '',
                    // spare_parts: '',
                    // remarks: ''
                },
                image1: '',
                image2: '',
                partsReplace: false,
                isprocess: false,
                cartItem: {
                    new_parts_serial: '',
                    install_date: moment().format('YYYY-MM-DD'),
                    expire_date: '',
                    old_parts_serial: '',
                },
                workshops: [],
                vehicles: [],
                selectedVehicle: null,
                newParts: [],
                selectedNewParts: null,
                oldParts: [],
                selectedOldParts: null,
                cart: [],
                labour_cart: [],
                parts_cart: [],

                columns: [{
                        label: 'Vehicle Reg. no',
                        field: 'vehicle_reg_no',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Engine no',
                        field: 'engine_no',
                        align: 'center'
                    },
                    {
                        label: 'Chassis no',
                        field: 'chassis_no',
                        align: 'center'
                    },
                    {
                        label: 'Model no',
                        field: 'model_no',
                        align: 'center'
                    },
                    {
                        label: 'Manufacturing date',
                        field: 'manufacturing_date',
                        align: 'center'
                    },
                    {
                        label: 'Body size',
                        field: 'body_size',
                        align: 'center'
                    },
                    {
                        label: 'Helper',
                        field: 'helper',
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
        async created() {
            await this.labourAddCartItem();
            await this.partsAddCartItem();
            await this.getWorkshops();
            await this.getVehicle();
            await this.getParts();
            // this.getEmployee();
            if (this.inputData.maintenance_id != '') {
                this.getMaintenance();
            }
        },
        computed: {
            labour_total() {
                return this.labour_cart.reduce((prev, curr) => {
                    return prev + +curr.total_tk
                }, 0)

            },
            parts_total() {
                return this.parts_cart.reduce((prev, curr) => {
                    return prev + +curr.total_tk
                }, 0)

            },
            // total_cost() {
            //     total = +this.labour_total + +this.parts_total + +this.inputData.other_cost;
            //     this.inputData.total_cost = total;
            // }
        },
        watch: {
            parts_cart: {
                deep: true,
                handler: function(newValue, oldValue) {
                    newValue.forEach(ele => {
                        if (ele.qty != '' && ele.rate != '') {
                            ele.total_tk = ele.qty * ele.rate;
                        } else {
                            ele.total_tk = '';
                        }
                    })
                }
            },
            labour_total: function(val) {
                this.calTotalCost()
            },
            parts_total: function(val) {
                this.calTotalCost()
            }
        },
        methods: {
            getFile1() {
                if (event.target.files.length > 0) {
                    this.image1 = event.target.files[0];
                }
            },
            getFile2() {
                if (event.target.files.length > 0) {
                    this.image2 = event.target.files[0];
                }
            },
            labourAddCartItem() {
                let item = {
                    labour_name: '',
                    total_tk: ''
                }
                this.labour_cart.push(item);
            },
            delCartItem(index) {
                // console.log(index);
                this.labour_cart.splice(index, 1)
            },
            partsAddCartItem() {
                let item = {
                    parts_name: '',
                    qty: '',
                    rate: '',
                    total_tk: ''
                }
                this.parts_cart.push(item);
            },
            delPartsCartItem(index) {
                // console.log(index);
                this.parts_cart.splice(index, 1)
            },
            getJobCard() {
                if (this.inputData.maintenance_id == '') {
                    axios.post("get-job-card", {
                        vehicleId: this.selectedVehicle.vehicle_id
                    }).then(res => {
                        this.inputData.job_problems = res.data[0].work_details;
                        this.inputData.job_progress = res.data[0].req_spare_parts;
                    })
                }
            },
            getWorkshops() {
                axios.get('/get-workshop').then(res => {
                    this.workshops = res.data;
                })
            },
            getVehicle() {
                axios.get('/get_vehicle').then(res => {
                    this.vehicles = res.data;
                })
            },
            getParts() {
                axios.get('/get_products').then(res => {
                    this.newParts = res.data;
                    this.oldParts = res.data;
                })
            },
            async getMaintenance() {
                axios.post('/get-all-maintenance', {
                    maintenance_id: this.inputData.maintenance_id
                }).then(res => {
                    this.inputData = res.data.maintenance[0];
                    delete this.inputData.AddBy;
                    delete this.inputData.AddTime;
                    delete this.inputData.FullName;
                    delete this.inputData.branch_id;
                    delete this.inputData.status;
                    delete this.inputData.updateBy;
                    delete this.inputData.updateTime;
                    delete this.inputData.vehicle_reg_no;

                    let details = res.data.maintenanceDetails;
                    details.forEach(ele => {
                        let item = {
                            new_parts: ele.new_parts,
                            new_parts_name: ele.Product_Name,
                            old_parts: ele.old_parts,
                            old_parts_name: ele.Product_Name,
                            new_parts_serial: ele.new_parts_serial,
                            install_date: ele.install_date,
                            expire_date: ele.expire_date,
                            old_parts_serial: ele.old_parts_serial,
                        }
                        this.cart.push(item);
                    })
                    details.length > 0 ? this.partsReplace = true : ''
                    this.parts_cart = res.data.spare_cart;
                    this.labour_cart = res.data.labour_cart;

                    setTimeout(() => {
                        this.selectedVehicle = this.vehicles.find(v => v.vehicle_id == res.data.maintenance[0].vehicle_id)
                    }, 500)
                })
            },
            // getEmployee() {
            //     axios.get('/get_employees').then(res => {
            //         res.data.forEach(element => {
            //             if (element.Designation_Name == 'Driver') {
            //                 this.drivers.push(element);
            //             }
            //             if (element.Designation_Name == 'Helper') {
            //                 this.helpers.push(element);
            //             }
            //         });
            //     })
            // },
            addToCart() {
                if (this.selectedNewParts == null || this.selectedNewParts.Product_SlNo == '') {
                    alert('Select a New Parts')
                    return;
                }
                if (this.cartItem.new_parts_serial == '') {
                    alert('New parts serial required')
                    return;
                }
                // if (this.cartItem.expire_date == '') {
                //     alert('Expire date required')
                //     return;
                // }
                if (this.selectedOldParts == null || this.selectedOldParts.Product_SlNo == '') {
                    alert('Select a New Parts')
                    return;
                }
                if (this.cartItem.old_parts_serial == '') {
                    alert('Old parts serial required')
                    return;
                }

                let items = this.cartItem
                items.new_parts = this.selectedNewParts.Product_SlNo
                items.new_parts_name = this.selectedNewParts.Product_Name
                items.old_parts = this.selectedOldParts.Product_SlNo
                items.old_parts_name = this.selectedOldParts.Product_Name

                this.cart.push(items);

                this.cartItem = {
                    new_parts_serial: '',
                    install_date: moment().format('YYYY-MM-DD'),
                    expire_date: '',
                    old_parts_serial: '',
                }
                this.selectedNewParts = null;
                this.selectedOldParts = null;
            },
            deleteCartItem(sl) {
                this.cart.splice(sl, 1);
            },
            calTotalCost() {
                this.inputData.total_cost = (parseFloat(this.labour_total == '' ? 0 : this.labour_total) +
                    parseFloat(this.parts_total == '' ? 0 : this.parts_total) + parseFloat(this.inputData
                        .other_cost == '' ? 0 : this.inputData.other_cost)).toFixed(2);
            },

            saveData() {
                if (this.inputData.workshop_name == '') {
                    alert('Select a workshop name please');
                    return;
                }
                if (this.selectedVehicle == null || this.selectedVehicle.vehicle_id == '') {
                    alert('Select a vehicle please');
                    return;
                }
                if (this.inputData.vehicle_in_time == '' || this.inputData.vehicle_out_time == '') {
                    alert('Vehicle In/Out Time require!');
                    return;
                }
                if (this.inputData.mechanic_name == '') {
                    alert('Mechanic name required!');
                    return;
                }
                if (this.inputData.autmobile_engineer == '') {
                    alert('Automobile engineer name is required!');
                    return;
                }
                if (this.inputData.job_problems == '') {
                    alert('Job details/ problem required!');
                    return;
                }
                if (this.inputData.job_progress == '') {
                    alert('Job activity/ progress required!');
                    return;
                }
                // if (this.inputData.spare_parts == '') {
                //     alert('Spare parts required!');
                //     return;
                // }

                // if (this.inputData.cost == '') {
                //     alert('Cost requied!');
                //     return;
                // }
                // if (this.inputData.labour_cost == '') {
                //     alert('Labour cost required!');
                //     return;
                // }

                if (this.inputData.total_cost == '') {
                    alert('Total cost is Empty!');
                    return;
                }

                this.inputData.spare_cost = this.parts_total;
                this.inputData.labour_cost = this.labour_total;

                this.inputData.vehicle_id = this.selectedVehicle.vehicle_id;

                // this.isprocess = true;

                // let filter = {
                //     data: this.inputData,
                //     cart: this.cart,
                //     labour_cart: this.labour_cart,
                //     parts_cart: this.parts_cart
                // }

                let url = '/save_maintenance';
                if (this.inputData.maintenance_id != '') {
                    url = "/update_maintenance";
                }

                let fd = new FormData();
                fd.append('image1', this.image1);
                fd.append('image2', this.image2);
                fd.append('data', JSON.stringify(this.inputData));
                fd.append('cart', JSON.stringify(this.cart));
                fd.append('labour_cart', JSON.stringify(this.labour_cart));
                fd.append('parts_cart', JSON.stringify(this.parts_cart));

                // console.log(fd, url);
                // return;

                axios.post(url, fd).then(res => {
                    let r = res.data;
                    // console.log(r);
                    // alert(r.message);
                    if (r.success) {
                        let conf = confirm('Save success, Do you want to view Record?');
                        if (conf) {
                            window.open('/maintanance_print/' + r.maintenance_id, '_blank');
                            this.isprocess = false;
                            // this.getVehicle();
                            this.clearForm();
                        }
                    }
                })
            },
            editVehicle(vehicle) {
                console.log(vehicle);
                this.vehicle = vehicle;
                // vehicle_id: '',
                //     this.vehicle.vehicle_reg_no = vehicle
                //     this.vehicle.engine_no = 
                //     this.vehicle.chassis_no = 
                //     this.vehicle.model_no = 
                //     this.vehicle.manufacturing_date = 
                //     this.vehicle.body_size = 
                //     this.vehicle.q_do_miter = 
                //     this.vehicle.vehicle_color = 
                //     this.vehicle.vehicle_type = 
                //     this.vehicle.brand_name = 
                //     this.vehicle.driver = 
                //     this.vehicle.helper = 
                //     this.vehicle.tyre_size = 
                //     this.vehicle.tyre_no = 
                //     this.vehicle.tyre_brand = 
                //     this.vehicle.own_or_hire = 
                //     this.vehicle.owner_name = 
                //     this.vehicle.owner_mobile = 
                //     this.vehicle.owner_address = 
                // this.vehicle.registration_id = vehicle.registration_id;
                // this.vehicle.registration_no = vehicle.registration_no;
                // this.vehicle.engine_no = vehicle.engine_no;
                // this.vehicle.chassis_no = vehicle.chassis_no;
                // this.vehicle.model_no = vehicle.model_no;
                // this.vehicle.manufacturing_date = vehicle.manufacturing_date;
                // this.vehicle.body_size = vehicle.body_size;
                // this.vehicle.q_do_miter = vehicle.q_do_miter;
                // this.vehicle.vehicle_color = vehicle.vehicle_color;
                // this.vehicle.vehicle_type = vehicle.vehicle_type;
                // this.vehicle.branded = vehicle.branded;
                // this.vehicle.ownership_details = vehicle.ownership_details;
                // this.vehicle.oparator = vehicle.oparator;
                // this.vehicle.helper = vehicle.helper;
                // this.vehicle.type = vehicle.type;
                // this.vehicle.type_details = vehicle.type_details;
                // this.vehicle.hire_type = vehicle.hire_typ;
            },
            deleteVehicle(id) {
                let deleteConfirm = confirm('Are Your Sure to delete the item?');
                if (deleteConfirm == false) {
                    return;
                }
                axios.post('/delete_vehicle', {
                    vehicle_id: id
                }).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.getVehicle();
                    }
                })
            },
            clearForm() {
                this.inputData = {
                    maintenance_id: '',
                    date: moment().format('YYYY-MM-DD'),
                    workshop_name: '',
                    vehicle_id: '',
                    vehicle_in_time: '',
                    vehicle_out_time: '',
                    mechanic_name: '',
                    autmobile_engineer: '',
                    spare_cost: '',
                    labour_cost: '',
                    other_cost: '',
                    total_cost: 0,
                    job_problems: '',
                    job_progress: '',
                    // spare_parts: '',
                    // remarks: ''
                }
                this.cart = [];
                this.labour_cart = [];
                this.parts_cart = [];
                this.selectedVehicle = null;
            }
        }
    })
</script>