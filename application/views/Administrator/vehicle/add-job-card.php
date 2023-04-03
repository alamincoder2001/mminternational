<style>
    .v-select {
        margin-bottom: 5px;
    }

    .v-select .dropdown-toggle {
        padding: 0px;
        border-radius: 0px !important;
    }

    .v-select input[type=search],
    .v-select input[type=search]:focus {
        margin: 0px;
        height: 26px;
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
        padding-right: 0px;
    }

    input[type="text"],
    input[type="date"] {
        padding: 13px 7px;
        border-radius: 0px !important;
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

<div id="requisition" class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Job Card Information</h4>
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
                    <div class="row" style="margin-bottom: 14px;border-bottom: 1px dotted #aaa;padding-bottom: 10px;">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="col-sm-4 control-label" style="vertical-align: middle;line-height: 28px;"> Job Card No </label>
                                <label class="col-sm-1"> : </label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" v-model="inputField.job_card_no" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="col-sm-4 control-label" style="vertical-align: middle;line-height: 28px;"> Added By </label>
                                <label class="col-sm-1"> : </label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" v-model="AddBy" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="col-sm-4 control-label" style="vertical-align: middle;line-height: 28px;"> Date </label>
                                <label class="col-sm-1"> : </label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" v-model="inputField.date" readonly />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 0px;">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="col-sm-4 control-label" style="vertical-align: middle;line-height: 28px;"> Vehicle </label>
                                <label class="col-sm-1"> : </label>
                                <div class="col-sm-7">
                                    <v-select v-bind:options="vehicles" v-model="selectedVehicle" label="vehicle_reg_no" placeholder="Select Vehciles"></v-select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="col-sm-4 control-label" style="vertical-align: middle;line-height: 28px;"> Tyre Size </label>
                                <label class="col-sm-1"> : </label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" v-model="selectedVehicle.tyre_size" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="col-sm-4 control-label" style="vertical-align: middle;line-height: 28px;"> Date IN </label>
                                <label class="col-sm-1"> : </label>
                                <div class="col-sm-7">
                                    <input type="date" class="form-control" v-model="inputField.date_in" />
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Vehicle Information -->
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="col-sm-4 control-label" style="vertical-align: middle;line-height: 28px;"> Model </label>
                                <label class="col-sm-1"> : </label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" v-model="selectedVehicle.model_no" readonly />
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="col-sm-4 control-label" style="vertical-align: middle;line-height: 28px;"> Manufac. Date</label>
                                <label class="col-sm-1"> : </label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" v-model="selectedVehicle.manufacture_year" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="col-sm-4 control-label" style="vertical-align: middle;line-height: 28px;"> Date OUT</label>
                                <label class="col-sm-1"> : </label>
                                <div class="col-sm-7">
                                    <input type="date" class="form-control" v-model="inputField.date_out" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Close Vehicle Information -->

                    <div class="row" style="margin-top:14px">
                        <div class="col-sm-12" style="padding: 0 23px;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr style="background: #eee;">
                                        <!-- <th width="140px">STANDING DATE</th> -->
                                        <th>DETAILS OF THE WORKS TO BE DONE</th>
                                        <th>REQUIRED SPARE PARTS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <!-- <td style="padding: 0px;">
                                            <input type="date" class="form-control" v-model="inputField.standint_date">
                                        </td> -->
                                        <td style="padding: 0px;">
                                            <!-- <textarea name="editor1111" id="editor1" cols="30" rows="10" v-model="inputField.work_details"></textarea> -->
                                            <mc-wysiwyg v-model="inputField.work_details" :height="150" style="text-align: left;"></mc-wysiwyg>
                                        </td>
                                        <td style="padding: 0px;">
                                            <!-- <textarea placeholder="required spare parts..." class="form-control" style="border: none;" cols="30" rows="10" v-model="inputField.req_spare_parts"></textarea> -->

                                            <mc-wysiwyg v-model="inputField.req_spare_parts" :height="150" style="text-align: left;"></mc-wysiwyg>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>


                            <div class="form-group">
                                <div class="col-sm-12 no-padding-right">
                                    <button v-on:click="saveJob" type="submit" class="btn btn-success pull-right">SAVE JOB</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- <div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
            <div class="table-responsive">
                <table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
                    <thead>
                        <tr class="">
                            <th style="width:5%;color:#000;">Sl</th>
                            <th style="width:20%;color:#000;">Vehicle</th>
                            <th style="width:20%;color:#000;">Parts Name</th>
                            <th style="width:7%;color:#000;">Qty</th>
                            <th style="width:20%;color:#000;">Purpose</th>
                            <th style="width:20%;color:#000;">Remarks</th>
                            <th style="width:8%;color:#000;">Action</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: carts.length > 0 ? '' : 'none'}">
                        <tr v-for="(requisition, sl) in carts">
                            <td>{{ sl + 1 }}</td>
                            <td>{{ requisition.vehicle_reg_no }}</td>
                            <td>{{ requisition.parts_name }}</td>
                            <td>{{ requisition.quantity }}</td>
                            <td>{{ requisition.purpose }}</td>
                            <td>{{ requisition.remarks }}</td>
                            <td>
                                <a href="" v-on:click.prevent="removeFromCart(sl)"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> -->
        <!-- <div class="col-xs-12 text-right" style="display: none;" :style="{display: carts.length > 0 ? '' : 'none'}">
            <button class="btn btn-success" style="margin-top: 20px;" v-on:click.prevent="saveRequisition">Save Requisition</button>
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
    Vue.component('McWysiwyg', McWysiwyg.default);
    // Vue.use(McWysiwyg.default);

    new Vue({
        el: '#requisition',
        data() {
            return {
                inputField: {
                    job_card_id: '<?php echo $jobCardId; ?>',
                    job_card_no: '<?php echo $jobCardNo; ?>',
                    date: moment().format('YYYY-MM-DD'),
                    vehicle_id: '',
                    date_in: '',
                    date_out: '',
                    standint_date: '',
                    work_details: '',
                    req_spare_parts: '',
                },
                AddBy: '<?php echo $this->session->userdata('FullName'); ?>',
                vehicles: [],
                selectedVehicle: {
                    vehicle_id: '',
                    model_no: '',
                    manufacture_year: '',
                    tyre_size: ''
                },
                // parts: [],
                // selectedParts: null,
            }
        },
        created() {
            this.getVehicle();
            // this.getParts();
            if (this.inputField.job_card_id != '') {
                this.getJobCard();
            }
        },
        methods: {
            getVehicle() {
                axios.get('/get_vehicle').then(res => {
                    this.vehicles = res.data;
                })
            },
            // getParts() {
            //     axios.get('/get_products').then(res => {
            //         this.parts = res.data;
            //     })
            // },

            clearFrom() {
                this.selectedVehicle = null;
                this.selectedParts = null;
                this.quantity = 0;
                this.purpose = '';
                this.remarks = '';
            },
            saveJob() {
                if (this.selectedVehicle == null || this.selectedVehicle.vehicle_id == '') {
                    alert('Select a vehicle please');
                    return;
                }
                if (this.inputField.date_in == '') {
                    alert('Date IN is empty!');
                    return;
                }
                // if (this.inputField.date_out == '') {
                //     alert('Date OUT is empty!');
                //     return;
                // }

                // if (this.inputField.standint_date == '') {
                //     alert('Standing date is empty!');
                //     return;
                // }
                if (this.inputField.work_details == '') {
                    alert('Details of the work is empty!');
                    return;
                }
                if (this.inputField.req_spare_parts == '') {
                    alert('Require spare parts is empty!');
                    return;
                }

                this.inputField.vehicle_id = this.selectedVehicle.vehicle_id;

                let url = '/save-job-card';
                if (this.inputField.job_card_id != '') {
                    url = '/update-job-card';
                }

                // console.log(this.inputField);
                // return;

                axios.post(url, this.inputField).then(res => {
                    // console.log(res);
                    if (res.data.success) {
                        alert(res.data.message);
                        let conf = confirm('Do you want to view invoice?');
                        if (conf) {
                            window.open('/job_card_print/' + res.data.jobId, '_blank');
                        }
                        setTimeout(() => {
                            location.reload();
                        }, 500)
                    } else {
                        alert('Ops! Something going wrong! try again later')
                    }
                })
            },
            async getJobCard() {
                await axios.post('/get-job-card', {
                    job_card_id: this.inputField.job_card_id
                }).then(res => {
                    if (res.data.length > 0) {
                        // this.inputField = {
                        //     job_card_id: res.data[0].job_card_id,
                        //     job_card_no: res.data[0].job_card_no,
                        //     date: res.data[0].date,
                        //     vehicle_id: res.data[0].vehicle_id,
                        //     date_in: res.data[0].date_in,
                        //     date_out: res.data[0].date_out,
                        //     standint_date: res.data[0].standint_date,
                        //     work_details: res.data[0].work_details,
                        this.inputField.req_spare_parts = 'hello'
                        // }

                        this.vehicles.forEach(element => {
                            if (parseInt(element.vehicle_id) == parseInt(res.data[0].vehicle_id)) {
                                this.selectedVehicle = element;
                            }
                        });
                    } else {
                        alert('No Data Found');
                    }
                })
            }
        }

    });
</script>