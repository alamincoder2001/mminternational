<style>
    label {
        text-align: right;
    }

    .v-select {
        margin-bottom: 5px;
    }

    .v-select .dropdown-toggle {
        padding: 2px;
    }

    .v-select input[type=search],
    .v-select input[type=search]:focus {
        margin: 0px;
        height: 24px;
    }
</style>

<div id="vehicle">
    <div class="row">
        <div class="col-12">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">General Service Entry</h4>
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
                        <div class="row" style="margin-bottom: 14px;">
                            <form v-on:submit.prevent="saveGService">
                                <div class="col-sm-5 col-lg-offset-1">
                                    <div class="form-group clearfix">
                                        <label class="col-sm-4 control-label"> Date : </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" v-model="date" readonly />
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="control-label col-sm-4">Select Vehicle : </label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-xs-11 col-sm-10 no-padding-right">
                                                    <v-select v-bind:options="vehicles" v-model="selectedVehicle" label="vehicle_reg_no" placeholder="Select Vehciles"></v-select>
                                                </div>
                                                <div class="col-xs-1 col-sm-2" style="text-align: right;">
                                                    <a href="<?= base_url('add_vehicle') ?>" class="btn btn-xs btn-danger" style=" height: 29px; border: 0; width: 26px; margin-left: -15px;" target="_blank" title="Add New Product"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 7px;"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="control-label col-sm-4">Owner Name : </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" v-model="selectedVehicle.owner_name" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="control-label col-sm-4">Owner Mobile : </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" v-model="selectedVehicle.owner_mobile" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group clearfix">
                                        <label class="control-label col-sm-4">General Service : </label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-xs-11 col-sm-10 no-padding-right">
                                                    <v-select v-bind:options="gServices" v-model="selectedGServices" label="general_service_name" placeholder="Select Service"></v-select>
                                                </div>
                                                <div class=" col-xs-1 col-sm-2" style="text-align: right;">
                                                    <a href="<?= base_url('add-general-service-list') ?>" class="btn btn-xs btn-danger" style=" height: 29px; border: 0; width: 26px; margin-left: -15px;" target="_blank" title="Add General Service List"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 7px;"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group clearfix">
                                        <label class="control-label col-sm-4">Start Date : </label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" v-model="service.start_date">
                                        </div>
                                    </div>

                                    <div class="form-group clearfix">
                                        <label class="control-label col-sm-4">End Date : </label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" v-model="service.end_date">
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="control-label col-sm-4">Comments : </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" v-model="service.comments" cols="30" rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12" style="margin-top: 10px;text-align:right">
                                            <input type="submit" class="btn btn-success btn-sm" value="Save Service">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
                <datatable :columns="columns" :data="vehicleService" :filter-by="filter">
                    <template scope="{ row }">
                        <tr>
                            <td>{{ row.general_service_id }}</td>
                            <td>{{ row.vehicle_reg_no }}</td>
                            <td>{{ row.general_service_name }}</td>
                            <td>{{ row.start_date }}</td>
                            <td>{{ row.end_date }}</td>
                            <td>{{ row.comments }}</td>

                            <td>
                                <a href="" title="Edit Service" @click.prevent="editService(row)"><i class="fa fa-pencil"></i></a>&nbsp;
                                <a href="" class="button" @click.prevent="deleteService(row.general_service_id )"><i class="fa fa-trash"></i></a>
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
                service: {
                    general_service_id: '',
                    vehicle_id: '',
                    general_service_list_id: '',
                    start_date: moment().format('YYYY-MM-DD'),
                    end_date: '',
                    comments: '',
                },
                AddBy: '',
                date: moment().format('YYYY-MM-DD'),
                vehicles: [],
                selectedVehicle: {
                    vehicle_id: '',
                    owner_mobile: '',
                    owner_name: '',
                    vehicle_reg_no: 'Select---',
                },
                gServices: [],
                selectedGServices: {
                    id: '',
                    general_service_name: 'Select---',
                },
                vehicleService: [],

                columns: [{
                        label: 'Id No',
                        field: 'general_service_id',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Vehicle No',
                        field: 'vehicle_reg_no',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Service Name',
                        field: 'general_service_name',
                        align: 'center'
                    },
                    {
                        label: 'Start Date',
                        field: 'start_date',
                        align: 'center'
                    },
                    {
                        label: 'End Date',
                        field: 'end_date',
                        align: 'center'
                    },
                    {
                        label: 'Comments',
                        field: 'comments',
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
            this.getGeneralServiceList();
            this.getAllGeneralService();
        },
        methods: {
            getVehicle() {
                axios.get('/get_vehicle').then(res => {
                    this.vehicles = res.data;
                })
            },
            getGeneralServiceList() {
                axios.post('/get-general-service_list', {
                    status: 'Active'
                }).then(res => {
                    this.gServices = res.data;
                })
            },
            getAllGeneralService() {
                axios.get('/get-all-general-service').then(res => {
                    console.log(res);
                    this.vehicleService = res.data;
                })
            },
            saveGService() {
                if (this.selectedVehicle.vehicle_id == '') {
                    alert('Please select a vechicle');
                    return;
                }
                if (this.selectedGServices.id == '') {
                    alert('Please Select General Service');
                    return;
                }
                if (this.service.start_date == '') {
                    alert('Please Enter Start Date');
                    return;
                }
                if (this.service.end_date == '') {
                    alert('Please Enter End Date');
                    return;
                }
                this.service.vehicle_id = this.selectedVehicle.vehicle_id;
                this.service.general_service_list_id = this.selectedGServices.id;

                let url = '/save-general-service';
                if (this.service.general_service_id != '') {
                    url = "/update-general-service";
                }

                // console.log(this.service);
                // return;

                axios.post(url, this.service).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        if (this.service.general_service_id != '') {
                            this.selectedVehicle = {
                                vehicle_id: '',
                                owner_mobile: '',
                                owner_name: '',
                                vehicle_reg_no: 'Select---',
                            }
                        }
                        this.getAllGeneralService();
                        this.clearForm();
                    }
                })
            },
            editService(data) {
                // console.log(data);
                this.service.general_service_id = data.general_service_id;
                this.service.vehicle_id = data.vehicle_id;
                this.service.general_service_list_id = data.general_service_list_id;
                this.service.start_date = data.start_date;
                this.service.end_date = data.end_date;
                this.service.comments = data.comments;

                this.vehicles.forEach(element => {
                    if (element.vehicle_id == data.vehicle_id) {
                        this.selectedVehicle = element;
                        return;
                    }
                })
                this.gServices.forEach(element => {
                    if (element.id == data.general_service_list_id) {
                        this.selectedGServices = element;
                        return;
                    }
                })

            },
            deleteService(id) {
                let deleteConfirm = confirm('Are Your Sure to delete the item?');
                if (deleteConfirm == false) {
                    return;
                }
                axios.post('/delete-general-service', {
                    general_service_id: id
                }).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.getAllGeneralService();
                    }
                })
            },
            clearForm() {
                this.service = {
                    general_service_id: '',
                    vehicle_id: '',
                    general_service_list_id: '',
                    start_date: moment().format('YYYY-MM-DD'),
                    end_date: '',
                    comments: '',
                }
                this.selectedGServices = {
                    id: '',
                    general_service_name: 'Select---',
                }
            }
        }
    })
</script>