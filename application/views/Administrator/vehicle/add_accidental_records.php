<style>
.saveBtn {
    padding: 7px 22px;
    background-color: #00acb5 !important;
    border-radius: 2px !important;
    border: none;
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
</style>

<div id="requisition" class="row">
    <!-- <div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
        <div class="row">
            <div class="form-group">
                <label class="col-sm-1 control-label no-padding" style="text-align: right;vertical-align: middle;line-height: 28px;"> Requisition No: </label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" v-model="requisition.requisition_no" readonly />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label no-padding" style="text-align: right;vertical-align: middle;line-height: 28px;"> Requisition By: </label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" v-model="requisition.requisitionBy" readonly />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label no-padding" style="text-align: right;width:120px;vertical-align: middle;line-height: 28px;"> Requisition Date: </label>
                <div class="col-sm-2">
                    <input class="form-control" type="date" v-model="requisition.date" />
                </div>
            </div>

            <div class="form-group">

            </div>
        </div>
    </div> -->

    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Accidental Information</h4>
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
                            <div class="col-sm-6">
                                <div class="form-group clearfix">
                                    <label class="col-sm-4 control-label no-padding-right"> Record Date :</label>
                                    <div class="col-sm-8">
                                        <input type="date" v-model="record.record_date" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right"> Vehicle No : </label>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-xs-11 col-sm-10" style="padding-right: 0;">
                                                <v-select v-bind:options="vehicles" v-model="selectedVehicle"
                                                    label="vehicle_reg_no" placeholder="Select Vehciles"></v-select>
                                            </div>
                                            <div class="col-xs-1 col-sm-2" style="text-align: right;">
                                                <a href="<?= base_url('add_vehicle') ?>" class="btn btn-xs btn-danger"
                                                    style=" height: 29px; border: 0; width: 26px; margin-left: -15px;"
                                                    target="_blank" title="Add New Product"><i class="fa fa-plus"
                                                        aria-hidden="true" style="margin-top: 7px;"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group clearfix">
                                    <label class="col-sm-4 control-label no-padding-right"> Type of Accidents :</label>
                                    <div class="col-sm-8">
                                        <input type="text" placeholder="Type of Accidents"
                                            v-model="record.type_of_accident" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-4 control-label no-padding-right"> Accident Category :</label>
                                    <div class="col-sm-8">
                                        <select v-model="record.accident_category" class="form-control" required
                                            style="padding: 0px 5px;height: 29px;border-radius: 4px;">
                                            <option value="" selected disabled>Select---</option>
                                            <option value="light">Light</option>
                                            <option value="medium">Medium</option>
                                            <option value="big">Big</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12" style="margin-top: 15px;">
                                <table class="table table-responsive table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Reason of Accidents</th>
                                            <th>Corrective Measure/ Root Case Analysis</th>
                                            <th style="width: 15%;">Comments</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="padding: 0px;">
                                                <!-- <textarea placeholder="Reason of Accidents" class="form-control"
                                                    v-model="record.reason_of_accident" rows="10" cols="30"
                                                    required></textarea> -->
                                                <template>
                                                    <div>
                                                        <mc-wysiwyg v-model="record.reason_of_accident" :height="150">
                                                        </mc-wysiwyg>
                                                    </div>
                                                </template>
                                            </td>
                                            <td style="padding: 0px;">
                                                <!-- <textarea placeholder="Corrective Measure/ Root Case Analysis "
                                                    class="form-control"
                                                    v-model="record.corrective_measure_or_root_case" rows="10" cols="30"
                                                    required></textarea> -->

                                                <template>
                                                    <div>
                                                        <mc-wysiwyg v-model="record.corrective_measure_or_root_case"
                                                            :height="150">
                                                        </mc-wysiwyg>
                                                    </div>
                                                </template>
                                            </td>
                                            <td style="padding: 0px;">
                                                <!-- <textarea v-model="record.comments" class="form-control" cols="30"
                                                    rows="10" placeholder="Comments.." required></textarea> -->

                                                <template>
                                                    <div>
                                                        <mc-wysiwyg v-model="record.comments" :height="150">
                                                        </mc-wysiwyg>
                                                    </div>
                                                </template>


                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                                <!-- <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right"> Reason of Accidents :</label>
                                    <div class="col-sm-9">
                                        <textarea placeholder="Reason of Accidents" class="form-control" v-model="record.reason_of_accident" rows="2" cols="30" required></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right"> Corrective Measure/ Root Case Analysis :</label>
                                    <div class="col-sm-9">

                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <label class="col-sm-3 control-label no-padding-right"> Comments :</label>
                                    <div class="col-sm-9">
                                        <textarea v-model="record.comments" class="form-control" cols="30" rows="2" placeholder="Comments.." required></textarea>
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right"> </label>
                                    <div class="col-sm-9" style="text-align: right;padding-right: 0px;">
                                        <input type="submit" value="Save Record" class="btn saveBtn">
                                    </div>
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
                            <th style="width:5%;color:#000;">Sl</th>
                            <th style="width:7%;color:#000;">Record Date</th>
                            <th style="width:10%;color:#000;">Vehicle</th>
                            <th style="width:8%;color:#000;">Type of Accidents</th>
                            <th style="width:20%;color:#000;">Reason of Accidents</th>
                            <th style="width:7%;color:#000;">Accident Category</th>
                            <th style="width:20%;color:#000;">Corrective Mesasure/Root Case Analysis</th>
                            <th style="width:17%;color:#000;">Comments</th>
                            <th style="width:8%;color:#000;">Action</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: accRecords.length > 0 ? '' : 'none'}">
                        <tr v-for="(record, sl) in accRecords">
                            <td>{{ sl + 1 }}</td>
                            <td>{{ record.record_date }}</td>
                            <td>{{ record.vehicle_reg_no }}</td>
                            <td>{{ record.type_of_accident }}</td>
                            <td>{{ record.reason_of_accident }}</td>
                            <td>{{ record.accident_category }}</td>
                            <td>{{ record.corrective_measure_or_root_case }}</td>
                            <td>{{ record.comments }}</td>
                            <td>
                                <a href="" title="Edit" @click.prevent="editRecord(record)"><i class="fa fa-pencil"></i></a>&nbsp;
                                <a href="" class="button" @click.prevent="deleteRecord(record.accidental_record_id)"><i class="fa fa-trash"></i></a>
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
<script src="https://unpkg.com/@mycure/vue-wysiwyg/dist/mc-wysiwyg.js"></script>

<script>
Vue.component('v-select', VueSelect.VueSelect);
Vue.use(McWysiwyg.default);
new Vue({
    el: '#requisition',
    data() {
        return {
            record: {
                accidental_record_id: '<?php echo $id; ?>',
                record_date: moment().format('YYYY-MM-DD'),
                vehicle_id: '',
                type_of_accident: '',
                accident_category: '',
                reason_of_accident: '',
                corrective_measure_or_root_case: '',
                comments: '',
            },
            accRecords: [],
            vehicles: [],
            selectedVehicle: null,
        }
    },
    created() {
        this.getVehicle();
        if (this.record.accidental_record_id != '') {
            this.editRecord();
        }
        // this.getAccidentalRecord();
    },
    methods: {
        getVehicle() {
            axios.get('/get_vehicle').then(res => {
                this.vehicles = res.data;
            })
        },
        // getAccidentalRecord() {
        //     axios.get('/get-accidental-record').then(res => {
        //         this.accRecords = res.data;
        //     })
        // },
        clearFrom() {
            this.record = {
                accidental_record_id: '',
                record_date: moment().format('YYYY-MM-DD'),
                vehicle_id: '',
                type_of_accident: '',
                accident_category: '',
                reason_of_accident: '',
                corrective_measure_or_root_case: '',
                comments: '',
            };
            this.selectedVehicle = null;
        },
        saveRecord() {
            if (this.selectedVehicle == null) {
                alert('Select a Vehicle please.')
                return;
            } else {
                this.record.vehicle_id = this.selectedVehicle.vehicle_id;
            }

            let url = '/save-accidental-record';
            if (this.record.accidental_record_id != 0) {
                url = '/update-accidental-record';
            }

            // console.log(this.record);
            // return;

            axios.post(url, this.record).then(res => {
                if (res.data.success) {
                    alert(res.data.message);
                    let conf = confirm('Do you want to view record?')
                    if (conf) {
                        window.open('/accidental_print/' + res.data.id);
                    }
                    // this.getAccidentalRecord();
                    // location.reload();
                    this.clearFrom();
                } else {
                    alert('Ops! Something going wrong! try again later')
                }
            })
        },
        editRecord() {
            let id = this.record.accidental_record_id;
            axios.post('/get-accidental-record', {
                accidental_record_id: id
            }).then(res => {
                result = res.data[0];

                this.record.accidental_record_id = result.accidental_record_id;
                this.record.record_date = result.record_date;
                this.record.vehicle_id = result.vehicle_id;
                this.record.type_of_accident = result.type_of_accident;
                this.record.accident_category = result.accident_category;
                this.record.reason_of_accident = result.reason_of_accident;
                this.record.corrective_measure_or_root_case = result.corrective_measure_or_root_case;
                this.record.comments = result.comments;

                this.vehicles.forEach(ele => {
                    if (ele.vehicle_id == result.vehicle_id) {
                        this.selectedVehicle = ele;
                    }
                })

            })
        },
        // deleteRecord(id) {
        //     let deleteConfirm = confirm('Are Your Sure to delete the item?');
        //     if (deleteConfirm == false) {
        //         return;
        //     }
        //     axios.post('/delete-accidental-record', {
        //         accidental_record_id: id
        //     }).then(res => {
        //         let r = res.data;
        //         alert(r.message);
        //         if (r.success) {
        //             this.getAccidentalRecord();
        //         }
        //     })
        // },
    }

});
</script>