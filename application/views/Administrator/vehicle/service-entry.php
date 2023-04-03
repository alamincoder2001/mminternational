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
</style>
<div id="vehicle">
    <div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom: 15px;">
        <form class="form-horizontal" @submit.prevent="saveService">
            <div class="col-xs-6">
                <div class="form-group">
                    <label class="control-label col-xs-4">Select Vehicle No :</label>
                    <div class="col-xs-8">
                        <v-select v-bind:options="vehicles" v-model="selectedVehicle" label="vehicle_reg_no" placeholder="Select Vehciles"></v-select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-xs-4">Service Date :</label>
                    <div class="col-xs-8">
                        <input type="date" class="form-control" v-model="service.service_date">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-xs-4">Wash Date :</label>
                    <div class="col-xs-8">
                        <input type="date" class="form-control" v-model="service.wash_date">
                    </div>
                </div>

                <!-- <div class="form-group clearfix" style="margin-top: 10px;text-align:right">
                    <div class="col-md-7 col-md-offset-4">
                        <input type="submit" class="btn btn-success btn-sm" value="Save Service">
                    </div> -->
                <!-- </div> -->
            </div>
            <div class="col-xs-6">

                <div class="form-group">
                    <label class="control-label col-xs-4">Comments :</label>
                    <div class="col-xs-8">
                        <textarea class="form-control" v-model="service.comments" cols="30" rows="4"></textarea>

                    </div>
                </div>

                <div class="form-group clearfix" style="margin-top: 10px;text-align:right">
                    <div class="col-xs-12">
                        <input type="submit" class="btn btn-success btn-sm" value="Save Service">
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
                <datatable :columns="columns" :data="vehicleService" :filter-by="filter">
                    <template scope="{ row }">
                        <tr>
                            <td>{{ row.vehicle_reg_no }}</td>
                            <td>{{ row.service_date }}</td>
                            <td>{{ row.wash_date }}</td>
                            <td>{{ row.comments }}</td>

                            <td>
                                <a href="" title="Edit Service" @click.prevent="editService(row)"><i class="fa fa-pencil"></i></a>&nbsp;
                                <a href="" class="button" @click.prevent="deleteService(row.service_id )"><i class="fa fa-trash"></i></a>
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
                    service_id: '',
                    vehicle_id: '',
                    // vehicle_reg_no: '',
                    service_date: '',
                    wash_date: '',
                    comments: '',
                },
                vehicles: [],
                selectedVehicle: null,
                vehicleService: [],

                columns: [{
                        label: 'Vehicle No',
                        field: 'vehicle_reg_no',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Service Date',
                        field: 'service_date',
                        align: 'center'
                    },
                    {
                        label: 'Wash Date',
                        field: 'wash_date',
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
            this.getService();
        },
        methods: {
            getVehicle() {
                axios.get('/get_vehicle').then(res => {
                    this.vehicles = res.data;
                })
            },
            getService() {
                axios.get('/get-vehicle-service').then(res => {
                    console.log(res);
                    this.vehicleService = res.data;
                })
            },
            saveService() {
                if (this.selectedVehicle == null) {
                    alert('Please select a vechicle');
                    return;
                }
                if (this.service.service_date == '') {
                    alert('Please Enter Service date');
                    return;
                }
                if (this.service.wash_date == '') {
                    alert('Please Enter Wash Date');
                    return;
                }
                this.service.vehicle_id = this.selectedVehicle.vehicle_id;

                let url = '/save-vehicle-service';
                if (this.service.service_id != '') {
                    url = "/update-vehicle-service";
                }

                // console.log(this.service);
                // return;

                axios.post(url, this.service).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.getService();
                        this.clearForm();
                    }
                })
            },
            editService(data) {
                console.log(data);
                this.service.service_id = data.service_id;
                this.service.service_date = data.service_date;
                this.service.wash_date = data.wash_date;
                this.service.comments = data.comments;

                this.vehicles.forEach(element => {
                    if (element.vehicle_id == data.vehicle_id) {
                        this.selectedVehicle = element;
                        return;
                    }
                })

            },
            deleteService(id) {
                let deleteConfirm = confirm('Are Your Sure to delete the item?');
                if (deleteConfirm == false) {
                    return;
                }
                axios.post('/delete-vehicle-service', {
                    service_id: id
                }).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.getService();
                    }
                })
            },
            clearForm() {
                this.service = {
                    service_id: '',
                    // vehicle_reg_no: '',
                    service_date: '',
                    wash_date: '',
                    comments: '',
                }
            }
        }
    })
</script>