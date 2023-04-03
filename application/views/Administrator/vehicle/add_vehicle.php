<style>
</style>
<div id="vehicle">
    <div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom: 15px;">
        <form class="form-horizontal" @submit.prevent="saveVehicle">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Vehicle Reg. No :</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="vehicle.vehicle_reg_no"
                            placeholder="Vehicle Reg. No">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Engine No :</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="vehicle.engine_no" placeholder="Engine no...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Chassis No :</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="vehicle.chassis_no"
                            placeholder="Chassis no...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Model No :</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="vehicle.model_no" placeholder="Model no...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Manufacture Year :</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="vehicle.manufacture_year"
                            placeholder="Year...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Body Size :</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="vehicle.body_size" placeholder="Size...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Q do. Meter :</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="vehicle.q_do_miter"
                            placeholder="Q do. meter...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Vehicle Color :</label>
                    <div class="col-md-7">
                        <input type="text" id="purchase_rate" v-model="vehicle.vehicle_color" class="form-control"
                            placeholder="Color...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Loaded Weight (Kg) :</label>
                    <div class="col-md-7">
                        <input type="text" id="purchase_rate" v-model="vehicle.loaded_weight" class="form-control"
                            placeholder="Kg...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Unloaded Weight (Kg) :</label>
                    <div class="col-md-7">
                        <input type="text" id="purchase_rate" v-model="vehicle.unloaded_weight" class="form-control"
                            placeholder="Kg...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Vehicle Type :</label>
                    <div class="col-md-7">
                        <select class="form-control" v-model="vehicle.vehicle_type" style="padding: 0px;">
                            <option value="" disabled>Select---</option>
                            <option value="open">Open</option>
                            <option value="cavbard">Cavard</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Brand/Non-Brand :</label>
                    <div class="col-md-7">
                        <select class="form-control" v-model="vehicle.brand" style="padding: 0px;">
                            <option value="" disabled>Select---</option>
                            <option value="brand">Brand</option>
                            <option value="non-brand">Non-Brand</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="display: none;"
                    :style="{display: vehicle.brand == 'brand' ? '' : 'none'}">
                    <label class="control-label col-md-4">Brand Name :</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="vehicle.brand_name"
                            placeholder="Brand name...">

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Driver Name :</label>
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-xs-10 no-padding-right">
                                <select class="form-control" v-model="vehicle.driver" style="padding: 0px;">
                                    <option value="" disabled>Select---</option>
                                    <option v-for="driver in drivers" :value="driver.Employee_SlNo">
                                        {{ driver.Employee_Name }}</option>
                                </select>
                            </div>
                            <div class="col-xs-2">
                                <a href="/employee" target="_blank"><span
                                        style="background: #3e2e6b;color: #fff;padding: 2px 11px;position: absolute;font-weight: 600;">+</span></a>
                            </div>
                        </div>
                        <!-- <input type="text" class="form-control" v-model="vehicle.driver"> -->
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Helper :</label>
                    <div class="col-md-7">
                        <div class="row" style="display: flex;">
                            <div class="col-xs-10 no-padding-right">
                                <select class="form-control" v-model="vehicle.helper" style="padding: 0px;">
                                    <option value="" disabled>Select---</option>
                                    <option v-for="helper in helpers" :value="helper.Employee_SlNo">
                                        {{ helper.Employee_Name }}</option>
                                </select>
                            </div>
                            <div class="col-xs-2">
                                <a href="/employee" target="_blank"><span
                                        style="background: #3e2e6b;color: #fff;padding: 2px 11px;position: absolute;font-weight: 600;">+</span></a>
                            </div>
                        </div>

                        <!-- <input type="text" class="form-control" v-model="vehicle.helper"> -->
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Seat Capacity :</label>
                    <div class="col-md-7">
                        <input type="number" class="form-control" v-model="vehicle.seat_capacity"
                            placeholder="Seat capacity...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Tyre Size :</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="vehicle.tyre_size" placeholder="Tyre size...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Tyre No :</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="vehicle.tyre_no" placeholder="Tyre no...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Tyre Brand :</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="vehicle.tyre_brand"
                            placeholder="Tyre brand...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Own/Hire :</label>
                    <div class="col-md-7">
                        <select class="form-control" v-model="vehicle.own_or_hire" style="padding: 0px;">
                            <option value="" disabled>Select---</option>
                            <option value="own">Own</option>
                            <option value="hire">Hire</option>
                        </select>
                        <!-- <input type="text" class="form-control" v-model="vehicle.type_details"> -->
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Owner Name/Company :</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="vehicle.owner_name"
                            placeholder="Owner name...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Owner Mobile :</label>
                    <div class="col-md-7">
                        <input type="number" class="form-control" v-model="vehicle.owner_mobile"
                            placeholder="Mobile no...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Owner Address :</label>
                    <div class="col-md-7">
                        <textarea class="form-control" v-model="vehicle.owner_address" cols="30" rows="2"
                            placeholder="Address..."></textarea>
                    </div>
                </div>
                <!-- <div class="form-group clearfix">
                    <label class="control-label col-md-4">Washing Date:</label>
                    <div class="col-md-7">
                        <input type="date" class="form-control" v-model="vehicle.manufacturing_date">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Service Date:</label>
                    <div class="col-md-7">
                        <input type="date" class="form-control" v-model="vehicle.manufacturing_date">
                    </div>
                </div> -->

                <div class="form-group clearfix">
                    <div class="col-md-7 col-md-offset-4">
                        <input type="submit" class="btn btn-success btn-sm" value="Save">
                    </div>
                </div>
            </div>
        </form>
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
                <datatable :columns="columns" :data="vehicles" :filter-by="filter">
                    <template scope="{ row }">
                        <tr>
                            <td>{{ row.vehicle_reg_no }}</td>
                            <td>{{ row.engine_no }}</td>
                            <td>{{ row.chassis_no }}</td>
                            <td>{{ row.model_no }}</td>
                            <td>{{ row.vehicle_type }}</td>
                            <td>{{ row.body_size }}</td>
                            <!-- <td>{{ veh.q_do_miter }}</td>
                        <td>{{ veh.vehicle_color }}</td>
                        <td>{{ veh.vehicle_type }}</td>
                        <td>{{ veh.branded }}</td>
                        <td>{{ veh.ownership_details }}</td>
                        <td>{{ veh.oparator }}</td>  -->
                            <td>{{ row.tyre_size }}</td>
                            <td>
                                <span v-if="row.status == 'a'" class="label label-sm label-info arrowed arrowed-righ"
                                    title="Active">
                                    Active
                                </span>
                                <span v-if="row.status == 'i'" class="label label-sm label-danger arrowed arrowed-righ"
                                    title="Deactive">
                                    Inactive
                                </span>
                            </td>
                            <td> <a href="" title="Edit Vehicle" @click.prevent="editVehicle(row)"><i
                                        class="fa fa-pencil"></i></a>&nbsp;
                                <a href="" class="button" @click.prevent="deleteVehicle(row.vehicle_id )"><i
                                        class="fa fa-trash"></i></a>

                                <a class="red" href="#" v-if="row.status == 'a'"
                                    onclick="return confirm('Are you sure you want to deactive this Vehecle?');"
                                    title="Deactive" @click.prevent="inactiveVehicle(row.vehicle_id )">
                                    <i class="ace-icon fa fa-arrow-circle-down bigger-130"></i>
                                </a>

                                <a class="green" href="#" v-if="row.status == 'i'"
                                    onclick="return confirm('Are you sure you want to active this Vehecle?');"
                                    title="Active" @click.prevent="activeVehicle(row.vehicle_id )">
                                    <i class="ace-icon fa fa-arrow-circle-up bigger-130"></i>
                                </a>


                            </td>
                            <!-- <td>{{ veh.type }}</td>
                        <td>{{ veh.type_details }}</td>
                        <td>{{ veh.hire_type }}</td> -->
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
new Vue({
    el: '#vehicle',
    data() {
        return {
            vehicle: {
                vehicle_id: '',
                vehicle_reg_no: '',
                engine_no: '',
                chassis_no: '',
                model_no: '',
                manufacture_year: '',
                body_size: '',
                q_do_miter: '',
                vehicle_color: '',
                loaded_weight: '',
                unloaded_weight: '',
                vehicle_type: '',
                brand: '',
                brand_name: '',
                driver: '',
                helper: '',
                seat_capacity: '',
                tyre_size: '',
                tyre_no: '',
                tyre_brand: '',
                own_or_hire: '',
                owner_name: '',
                owner_mobile: '',
                owner_address: '',
            },
            vehicles: [],
            drivers: [],
            helpers: [],
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
                    label: 'Vehecle Type',
                    field: 'vehicle_type',
                    align: 'center'
                },
                {
                    label: 'Body size',
                    field: 'body_size',
                    align: 'center'
                },
                {
                    label: 'Tyre Size',
                    field: 'tyre_size',
                    align: 'center'
                },
                {
                    label: 'Status',
                    field: 'status',
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
        this.getVehicle();
        this.getEmployee();
    },
    methods: {
        getVehicle() {
            axios.get('/get_all_vehicles').then(res => {
                this.vehicles = res.data;
            })
        },
        getEmployee() {
            axios.get('/get_employees').then(res => {
                res.data.forEach(element => {
                    if (element.Designation_Name == 'Driver') {
                        this.drivers.push(element);
                    }
                    if (element.Designation_Name == 'Helper') {
                        this.helpers.push(element);
                    }
                });
            })
        },
        saveVehicle() {
            if (this.vehicle.vehicle_reg_no == '') {
                alert('Please Enter Registration Number');
                return;
            }
            if (this.vehicle.engine_no == '') {
                alert('Please Enter Engine Number');
                return;
            }
            if (this.vehicle.chassis_no == '') {
                alert('Please Enter Chassis Number');
                return;
            }
            if (this.vehicle.model_no == '') {
                alert('Please Enter Model Number');
                return;
            }
            if (this.vehicle.manufacture_year == '') {
                alert('Please Enter Manufacture Year');
                return;
            }
            if (this.vehicle.body_size == '') {
                alert('Please Enter Body size');
                return;
            }
            if (this.vehicle.q_do_miter == '') {
                alert('Please Enter q do miter');
                return;
            }
            if (this.vehicle.vehicle_color == '') {
                alert('Please Enter vehicle color');
                return;
            }
            if (this.vehicle.vehicle_type == '') {
                alert('Select vehicle type');
                return;
            }
            if (this.vehicle.brand == '') {
                alert('Select a brand ');
                return;
            }
            if (this.vehicle.brand == 'brand' && this.vehicle.brand_name == '') {
                alert('Brand name required!');
                return;
            }
            if (this.vehicle.driver == '') {
                alert('Select a driver');
                return;
            }
            // if (this.vehicle.helper == '') {
            //     alert('Select a helper');
            //     return;
            // }
            if (this.vehicle.tyre_size == '') {
                alert('Please Enter tyre size');
                return;
            }
            if (this.vehicle.tyre_no == '') {
                alert('Please Enter tyre no');
                return;
            }
            if (this.vehicle.tyre_brand == '') {
                alert('Please Enter tyre brand');
                return;
            }
            if (this.vehicle.own_or_hire == '') {
                alert('Select a owner or hire');
                return;
            }
            if (this.vehicle.owner_name == '') {
                alert('Select a owner name');
                return;
            }
            if (this.vehicle.owner_mobile == '') {
                alert('Select a owner Mobile');
                return;
            }
            if (this.vehicle.owner_address == '') {
                alert('Select a owner Address');
                return;
            }
            if (this.vehicle.brand == 'non-brand') {
                this.vehicle.brand_name == ''
            }

            this.drivers.forEach(ele => {
                if (parseInt(ele.Employee_SlNo) == parseInt(this.vehicle.driver)) {
                    this.vehicle.driver_name = ele.Employee_Name;
                }
            })
            this.helpers.forEach(ele => {
                if (parseInt(ele.Employee_SlNo) == parseInt(this.vehicle.helper)) {
                    this.vehicle.helper_name = ele.Employee_Name;
                }
            })


            let url = '/save_vehicle';
            if (this.vehicle.vehicle_id != '') {
                url = "/update_vehicle";
            }

            axios.post(url, this.vehicle).then(res => {
                let r = res.data;
                console.log(r);
                alert(r.message);
                if (r.success) {
                    this.getVehicle();
                    this.clearForm();
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

        inactiveVehicle(id) {
            let inactive = confirm('Are Your Sure to Inactive the Vehecle?');
            if (inactive == false) {
                return;
            }
            axios.post('/inactive_vehicle', {
                vehicle_id: id
            }).then(res => {
                let r = res.data;
                alert(r.message);
                if (r.success) {
                    this.getVehicle();
                }
            })
        },

        activeVehicle(id) {
            let active = confirm('Are Your Sure to Active the Vehecle?');
            if (active == false) {
                return;
            }
            axios.post('/active_vehicle', {
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
            this.vehicle = {
                vehicle_id: '',
                vehicle_reg_no: '',
                engine_no: '',
                chassis_no: '',
                model_no: '',
                manufacture_year: '',
                body_size: '',
                q_do_miter: '',
                vehicle_color: '',
                oaded_weight: '',
                unloaded_weight: '',
                seat_capacity: '',
                vehicle_type: '',
                brand: '',
                brand_name: '',
                driver: '',
                helper: '',
                tyre_size: '',
                tyre_no: '',
                tyre_brand: '',
                own_or_hire: '',
                owner_name: '',
                owner_mobile: '',
                owner_address: '',
            }
        }
    }
})
</script>