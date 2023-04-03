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
</style>

<div id="requisition" class="row">
    <div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
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
    </div>

    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Requisition Information</h4>
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
                        <form v-on:submit.prevent="addToCart()">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right"> Vehicle </label>
                                    <label class="col-sm-1">:</label>
                                    <div class="col-sm-7">
                                        <v-select v-bind:options="vehicles" v-model="selectedVehicle" label="vehicle_reg_no" placeholder="Select Vehciles"></v-select>
                                    </div>
                                    <div class="col-sm-1">
                                        <a href="<?= base_url('add_vehicle') ?>" class="btn btn-xs btn-danger" style="height: 29px; border: 0; width: 36px; margin-left: -10px;" target="_blank" title="Add New Product"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 7px;"></i></a>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right"> Parts Item </label>
                                    <label class="col-sm-1">:</label>
                                    <div class="col-sm-7">
                                        <v-select v-bind:options="parts" v-model="selectedParts" label="display_text" placeholder="Select Parts"></v-select>
                                    </div>
                                    <div class="col-sm-1">
                                        <a href="<?= base_url('product') ?>" class="btn btn-xs btn-danger" style="height: 29px; border: 0; width: 36px; margin-left: -10px;" target="_blank" title="Add New Product"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 7px;"></i></a>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right"> Quantity </label>
                                    <label class="col-sm-1">:</label>
                                    <div class="col-sm-8">
                                        <input type="text" v-model="quantity" class="form-control">
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right"> Purpose </label>
                                    <label class="col-sm-1">:</label>
                                    <div class="col-sm-8">
                                        <textarea placeholder="purpose" class="form-control" v-model="purpose"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right"> Remarks </label>
                                    <label class="col-sm-1">:</label>
                                    <div class="col-sm-8">
                                        <textarea placeholder="remarks" class="form-control" v-model="remarks"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right"> </label>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-default pull-right">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>


        <div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
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
        </div>
        <div class="col-xs-12 text-right" style="display: none;" :style="{display: carts.length > 0 ? '' : 'none'}">
            <button class="btn btn-success" style="margin-top: 20px;" v-on:click.prevent="saveRequisition">Save Requisition</button>
        </div>
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
                requisition: {
                    requisition_id: '<?php echo $requisition_id ?>',
                    requisition_no: '',
                    requisitionBy: '<?php echo $this->session->userdata('FullName'); ?>',
                    date: moment().format('YYYY-MM-DD'),
                },
                quantity: 0,
                purpose: '',
                remarks: '',
                carts: [],
                vehicles: [],
                selectedVehicle: null,
                parts: [],
                selectedParts: null,
            }
        },
        created() {
            this.getVehicle();
            this.getParts();
        },
        methods: {
            getVehicle() {
                axios.get('/get_vehicle').then(res => {
                    this.vehicles = res.data;
                })
            },
            getParts() {
                axios.get('/get_products').then(res => {
                    this.parts = res.data;
                })
            },
            addToCart() {
                if (this.selectedVehicle == null) {
                    alert('select a Vehicle');
                    return;
                }
                if (this.selectedParts == null) {
                    alert('select a Parts');
                    return;
                }
                if (this.requisition.quantity == '' || this.requisition.quantity == 0) {
                    alert('Quantity Required');
                    return;
                }

                let data = {
                    vehicle_id: this.selectedVehicle.vehicle_id,
                    vehicle_reg_no: this.selectedVehicle.vehicle_reg_no,
                    parts_id: this.selectedParts.Product_SlNo,
                    parts_name: this.selectedParts.Product_Name,
                    quantity: this.quantity,
                    purpose: this.purpose,
                    remarks: this.remarks,
                }

                let status = true;
                this.carts.forEach(ele => {
                    if (ele.vehicleId == data.vehicle_id && ele.partsId == data.parts_id) {
                        alert('The Vehicle and parts already added in Cart');
                        status = false;
                        return;
                    }
                });

                if (status) {
                    this.carts.push(data);
                    this.clearFrom();
                }


            },
            removeFromCart(index) {
                this.carts.splice(index, 1);
            },
            clearFrom() {
                this.selectedVehicle = null;
                this.selectedParts = null;
                this.quantity = 0;
                this.purpose = '';
                this.remarks = '';
            },
            saveRequisition() {
                if (this.carts.length == 0) {
                    alert('Cart is Empty!');
                    return;
                }

                let sum = this.carts.reduce(function(previousValue, currentValue) {
                    return previousValue + parseInt(currentValue.quantity)
                }, 0)
                this.requisition.total_quantity = sum;

                let filter = {
                    carts: this.carts,
                    req_data: this.requisition,
                }
                axios.post('save-requisition', filter).then(res => {
                    if (res.data.success) {
                        alert(res.data.message);
                        this.carts = [];
                    } else {
                        alert('Ops! Something going wrong! try again later')
                    }
                })
            }
        }

    });
</script>