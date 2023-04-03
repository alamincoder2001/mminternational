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

    input[type="file"] {
        padding: 2px;
    }

    /* .form-control {
        height: 30px !important;
    } */
</style>
<div id="vehicle">
    <div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom: 15px;">
        <form class="form-horizontal" @submit.prevent="saveLicense">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="control-label col-sm-4">Select Vehicle No :</label>
                    <div class="col-sm-4">
                        <v-select v-bind:options="vehicles" v-model="selectedVehicle" label="vehicle_reg_no" placeholder="Select Vehciles"></v-select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4">Registration Expire Date :</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" v-model="license.registration_expire_date" required>
                    </div>
                    <div class="col-sm-4 no-padding-left">
                        <input type="file" v-on:change="onFileChangeReg" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4">Road Permit Expire Date :</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" v-model="license.roadPermit_expire_date" required>
                    </div>
                    <div class="col-sm-4 no-padding-left">
                        <input type="file" class="form-control" v-on:change="onFileChangeRP">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4">Fitness Expire Date :</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" v-model="license.fitness_expire_date" required>
                    </div>
                    <div class="col-sm-4 no-padding-left">
                        <input type="file" class="form-control" v-on:change="onFileChangeFT">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4">Tax Token Expire Date :</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" v-model="license.taxToken_expire_date" required>
                    </div>
                    <div class="col-sm-4 no-padding-left">
                        <input type="file" class="form-control" v-on:change="onFileChangeTT">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4">Insurance Expire Date :</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" v-model="license.insurance_expire_date" required>
                    </div>
                    <div class="col-sm-4 no-padding-left">
                        <input type="file" class="form-control" v-on:change="onFileChangeINS">
                    </div>
                </div>

                <div class="form-group clearfix" style="margin-top: 10px;text-align:right">
                    <div class="col-sm-12">
                        <input type="submit" class="btn btn-success btn-sm" value="Save License">
                    </div>
                </div>

            </div>
            <!-- <div class="col-sm-6">

                <div class="form-group">
                    <label class="control-label col-sm-4">File Upload :</label>
                    <div class="col-sm-8">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Registration :</label>
                    <div class="col-sm-8">
                        <input type="file" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Registration :</label>
                    <div class="col-sm-8">
                        <input type="file" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Registration :</label>
                    <div class="col-sm-8">
                        <input type="file" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Registration :</label>
                    <div class="col-sm-8">
                        <input type="file" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Registration :</label>
                    <div class="col-sm-8">
                        <input type="file" class="form-control">
                    </div>
                </div>
            </div> -->
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
                <datatable :columns="columns" :data="vehicleLicense" :filter-by="filter">
                    <template scope="{ row }">
                        <tr>
                            <td>{{ row.vehicle_reg_no }}</td>
                            <td>{{ row.registration_expire_date }}</td>
                            <td>{{ row.roadPermit_expire_date }}</td>
                            <td>{{ row.fitness_expire_date }}</td>
                            <td>{{ row.taxToken_expire_date }}</td>
                            <td>{{ row.insurance_expire_date }}</td>

                            <td>
                                <a href="" title="Edit License" @click.prevent="editLicense(row)"><i class="fa fa-pencil"></i></a>&nbsp;
                                <a href="" class="button" @click.prevent="deleteLicense(row.license_id )"><i class="fa fa-trash"></i></a>
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
                license: {
                    license_id: '',
                    vehicle_id: '',
                    registration_expire_date: '',
                    roadPermit_expire_date: '',
                    fitness_expire_date: '',
                    taxToken_expire_date: '',
                    insurance_expire_date: '',
                },
                registrationImg: '',
                roadPermitImg: '',
                fitnessImg: '',
                taxTokenImg: '',
                insuranceImg: '',
                vehicles: [],
                selectedVehicle: null,
                vehicleLicense: [],

                columns: [{
                        label: 'Vehicle No',
                        field: 'vehicle_reg_no',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Registration Expire Date',
                        field: 'registration_expire_date',
                        align: 'center'
                    },
                    {
                        label: 'Road Permit Expire Date',
                        field: 'roadPermit_expire_date',
                        align: 'center'
                    },
                    {
                        label: 'Fitness Expire Date',
                        field: 'fitness_expire_date',
                        align: 'center'
                    },
                    {
                        label: 'Tax Token Expire Date',
                        field: 'taxToken_expire_date',
                        align: 'center'
                    },
                    {
                        label: 'Insurence Expire Date',
                        field: 'insurance_expire_date',
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
            this.getLicense();
        },
        methods: {
            getVehicle() {
                axios.get('/get_vehicle').then(res => {
                    this.vehicles = res.data;
                })
            },
            getLicense() {
                axios.get('/get-vehicle-license').then(res => {
                    // console.log(res);
                    this.vehicleLicense = res.data;
                })
            },
            saveLicense() {
                if (this.selectedVehicle == null) {
                    alert('Please select a vechicle');
                    return;
                }
                if (this.license.registration_expire_date == '') {
                    alert('Registration Expire Date Required!');
                    return;
                }
                if (this.license.roadPermit_expire_date == '') {
                    alert('Road Permit Expire Date Required!');
                    return;
                }
                if (this.license.fitness_expire_date == '') {
                    alert('Fitness Expire Date Required!');
                    return;
                }
                if (this.license.taxToken_expire_date == '') {
                    alert('Tax Token Expire Date Required!');
                    return;
                }
                if (this.license.insurance_expire_date == '') {
                    alert('Insurence Expire Date Required!');
                    return;
                }

                this.license.vehicle_id = this.selectedVehicle.vehicle_id;
                this.license.vehicle_reg_no = this.selectedVehicle.vehicle_reg_no;

                let url = '/save-vehicle-license';
                if (this.license.license_id != '') {
                    url = "/update-vehicle-license";
                }

                // console.log(this.license);
                // return;

                let fd = new FormData();
                fd.append('registrationImg', this.registrationImg);
                fd.append('roadPermitImg', this.roadPermitImg);
                fd.append('fitnessImg', this.fitnessImg);
                fd.append('taxTokenImg', this.taxTokenImg);
                fd.append('insuranceImg', this.insuranceImg);
                fd.append('data', JSON.stringify(this.license));

                axios.post(url, fd).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.getLicense();
                        this.clearForm();
                    }
                })
            },
            editLicense(data) {
                // console.log(data);
                this.license.license_id = data.license_id;
                this.license.registration_expire_date = data.registration_expire_date;
                this.license.roadPermit_expire_date = data.roadPermit_expire_date;
                this.license.fitness_expire_date = data.fitness_expire_date;
                this.license.taxToken_expire_date = data.taxToken_expire_date;
                this.license.insurance_expire_date = data.insurance_expire_date;

                this.vehicles.forEach(element => {
                    if (element.vehicle_id == data.vehicle_id) {
                        this.selectedVehicle = element;
                        return;
                    }
                })

            },
            deleteLicense(id) {
                let deleteConfirm = confirm('Are Your Sure to delete the item?');
                if (deleteConfirm == false) {
                    return;
                }
                axios.post('/delete-vehicle-license', {
                    license_id: id
                }).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.getLicense();
                    }
                })
            },
            clearForm() {
                this.license = {
                    license_id: '',
                    vehicle_id: '',
                    registration_expire_date: '',
                    roadPermit_expire_date: '',
                    fitness_expire_date: '',
                    taxToken_expire_date: '',
                    insurance_expire_date: '',
                }
                this.registrationImg = '';
                this.insuranceImg = '';
                this.taxTokenImg = '';
                this.roadPermitImg = '';
                this.fitnessImg = '';

                this.selectedVehicle = null;
            },
            onFileChangeReg(e) {
                this.registrationImg = e.target.files[0];
            },
            onFileChangeRP(e) {
                this.roadPermitImg = e.target.files[0];
            },
            onFileChangeFT(e) {
                this.fitnessImg = e.target.files[0];
            },
            onFileChangeTT(e) {
                this.taxTokenImg = e.target.files[0];
            },
            onFileChangeINS(e) {
                this.insuranceImg = e.target.files[0];
            }
        }
    })
</script>