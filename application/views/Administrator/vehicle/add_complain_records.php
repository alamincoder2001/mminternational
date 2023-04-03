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
        height: 28px;
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

    label.control-label {
        text-align: right;
    }

    input[type="text"],
    input[type="date"] {
        padding: 14px 7px;
    }

    .saveBtn {
        padding: 7px 22px;
        background-color: #00acb5 !important;
        border-radius: 2px !important;
        border: none;
    }
</style>

<div id="requisition" class="row">

    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Complain Information</h4>
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
                        <form v-on:submit.prevent="saveRecord">
                            <div class="col-sm-4">
                                <div class="form-group clearfix">
                                    <label class="col-sm-4 control-label no-padding-right"> Complain Date :</label>
                                    <div class="col-sm-8">
                                        <input type="date" v-model="record.complain_date" class="form-control">
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right"> Vehicle No : </label>
                                    <div class="col-sm-7">
                                        <v-select v-bind:options="vehicles" v-model="selectedVehicle" label="vehicle_reg_no" placeholder="Select Vehciles"></v-select>
                                    </div>
                                    <div class="col-sm-1">
                                        <a href="<?= base_url('add_vehicle') ?>" class="btn btn-xs btn-danger" style=" height: 29px; border: 0; width: 26px; margin-left: -15px;" target="_blank" title="Add New Product"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 7px;"></i></a>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right"> Driver Name : </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" v-model="selectedVehicle.driver_name" readonly>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12" style="margin-top: 15px;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Kinds of Complain</th>
                                            <th>Corrective Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="padding:0px;">
                                                <textarea placeholder="Kinds of Complain" class="form-control" v-model="record.kinds_of_complain" rows="10" cols="30" required></textarea>
                                            <td style="padding:0px;">
                                                <textarea placeholder="Corrective Action" class="form-control" v-model="record.corrective_action" rows="10" cols="30" required></textarea>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> </label>
                                <div class="col-sm-9" style="text-align: right;">
                                    <button type="submit" class="btn saveBtn">Save Record</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>


        <!-- <div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;margin-top:20px;">
            <div class="table-responsive">
                <table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
                    <thead>
                        <tr class="">
                            <th style="color:#000;">Sl</th>
                            <th style="color:#000;">Complain Date</th>
                            <th style="color:#000;">Vehicle</th>
                            <th style="color:#000;">Kinds Of Complain</th>
                            <th style="color:#000;">Corrective Action</th>
                            <th style="color:#000;">Action</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: complainRecords.length > 0 ? '' : 'none'}">
                        <tr v-for="(record, sl) in complainRecords">
                            <td>{{ sl + 1 }}</td>
                            <td>{{ record.complain_date }}</td>
                            <td>{{ record.vehicle_reg_no }}</td>
                            <td>{{ record.kinds_of_complain }}</td>
                            <td>{{ record.corrective_action }}</td>
                            <td>
                                <a href="" title="Edit" @click.prevent="editRecord(record)"><i class="fa fa-pencil"></i></a>&nbsp;
                                <a href="" class="button" @click.prevent="deleteRecord(record.complain_record_id)"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> -->

    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
    Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#requisition',
        data() {
            return {
                record: {
                    complain_record_id: '<?= $id ?>',
                    complain_date: moment().format('YYYY-MM-DD'),
                    vehicle_id: '',
                    kinds_of_complain: '',
                    corrective_action: '',
                },
                complainRecords: [],
                vehicles: [],
                selectedVehicle: {
                    vehicle_id: '',
                    vehicle_reg_no: 'Select Vehicle',
                    operator: '',
                },
            }
        },
        created() {
            this.getVehicle();
            // this.getComplainRecord();
            if (this.record.complain_record_id != '') {
                this.editRecord();
            }
        },
        methods: {
            getVehicle() {
                axios.get('/get_vehicle').then(res => {
                    this.vehicles = res.data;
                })
            },
            clearFrom() {
                this.record = {
                    complain_record_id: '',
                    complain_date: moment().format('YYYY-MM-DD'),
                    vehicle_id: '',
                    kinds_of_complain: '',
                    corrective_action: '',
                };
                this.selectedVehicle = {
                    vehicle_id: '',
                    vehicle_reg_no: 'Select Vehicle',
                    operator: '',
                };
            },
            saveRecord() {
                if (this.selectedVehicle.vehicle_id == '') {
                    alert('Select a Vehicle please.')
                    return;
                } else {
                    this.record.vehicle_id = this.selectedVehicle.vehicle_id;
                }

                let url = '/save-complain-record';
                if (this.record.complain_record_id != '' || this.record.complain_record_id != 0) {
                    url = '/update-complain-record';
                }

                // console.log(this.record);
                // return;

                axios.post(url, this.record).then(res => {
                    if (res.data.success) {
                        alert(res.data.message);
                        this.getComplainRecord();
                        // location.reload();
                        this.clearFrom();
                    } else {
                        alert('Ops! Something going wrong! try again later')
                    }
                })
            },
            editRecord(data) {
                axios.post('/get-complain-record', {
                    complain_record_id: this.record.complain_record_id
                }).then(res => {
                    result = res.data[0];

                    this.record.complain_record_id = result.complain_record_id;
                    this.record.complain_date = result.complain_date;
                    this.record.vehicle_id = result.vehicle_id;
                    this.record.kinds_of_complain = result.kinds_of_complain;
                    this.record.corrective_action = result.corrective_action;

                    this.vehicles.forEach(ele => {
                        if (ele.vehicle_id == result.vehicle_id) {
                            this.selectedVehicle = ele;
                        }
                    })

                })
            },

        }

    });
</script>