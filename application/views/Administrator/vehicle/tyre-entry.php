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
</style>

<div id="vehicle">
    <div class="row">
        <div class="col-12">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Tyre Entry</h4>
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
                            <form v-on:submit.prevent="saveTyre">
                                <div class="col-sm-5">
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
                                                    <v-select v-bind:options="vehicles" v-model="selectedVehicle"
                                                        label="vehicle_reg_no" placeholder="Select Vehciles"></v-select>
                                                </div>
                                                <div class="col-xs-1 col-sm-2" style="text-align: right;">
                                                    <a href="<?= base_url('add_vehicle') ?>"
                                                        class="btn btn-xs btn-danger"
                                                        style=" height: 29px; border: 0; width: 26px; margin-left: -15px;"
                                                        target="_blank" title="Add New Product"><i class="fa fa-plus"
                                                            aria-hidden="true" style="margin-top: 7px;"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group clearfix">
                                        <label class="control-label col-sm-4">Installation Date : </label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" v-model="tyre.installation_date">
                                        </div>
                                    </div>

                                    <div class="form-group clearfix">
                                        <label class="control-label col-sm-4">Current Date : </label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" v-model="tyre.expaire_date">
                                        </div>
                                    </div>


                                    <div class="form-group clearfix">
                                        <label class="control-label col-sm-4">Comments : </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" v-model="tyre.comments" cols="30"
                                                rows="2"></textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-7">
                                    <div class="form-group clearfix">
                                        <!-- <label class="control-label col-md-12" style="text-align:left">Multiple
                                            Tyre:</label> -->
                                        <div class="col-md-12">
                                            <table class="table table-bordered">
                                                <tr style="background: rgb(0 47 70);color:#fff">
                                                    <td style="width: 10%;">Sl.</td>
                                                    <td style="width: 30%;">Tyre Name</td>
                                                    <td style="width: 25%;">New Serial</td>
                                                    <td style="width: 25%;">Old Serial</td>
                                                    <td style="width: 10%;">#</td>
                                                </tr>
                                                <tr v-for=" (item,index) in parts_cart">

                                                    <td>{{ index }}</td>

                                                    <td>
                                                        <input class="form-control" type="text"
                                                            v-model="item.tyre_name">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text"
                                                            v-model.number="item.new_serial">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text"
                                                            v-model.number="item.old_serial">
                                                    </td>

                                                    <td>
                                                        <button class="addcartitem"
                                                            v-on:click.prevent="partsAddCartItem"> + </button>
                                                        <button v-if="index > 0" class="delcartitem"
                                                            v-on:click.prevent="delPartsCartItem(index)"> - </button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12" style="margin-top: 10px;text-align:right">
                                                <input type="submit" class="btn btn-success btn-sm" value="Save Tyre">
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
                            <td>{{ row.tyre_id }}</td>
                            <td>{{ row.vehicle_reg_no }}</td>
                            <td>{{ row.installation_date }}</td>
                            <td>{{ row.expaire_date }}</td>
                            <td>{{ row.comments }}</td>
                            <td>
                                <a href="" title="Edit" @click.prevent="editData(row)">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="" class="button" @click.prevent="deleteService(row.tyre_id )">
                                    <i class="fa fa-trash"></i>
                                </a>
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
            tyre: {
                tyre_id: '',
                vehicle_id: '',
                installation_date: moment().format('YYYY-MM-DD'),
                expaire_date: moment().format('YYYY-MM-DD'),
                comments: '',
            },

            parts_cart: [],
            AddBy: '',
            date: moment().format('YYYY-MM-DD'),
            vehicles: [],
            selectedVehicle: {
                vehicle_id: '',
                vehicle_reg_no: 'Select---',
            },
            gServices: [],
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
                    label: 'Installation Date',
                    field: 'installation_date',
                    align: 'center'
                },
                {
                    label: 'Current Date',
                    field: 'expaire_date',
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
        this.getAllTyreList();
        this.partsAddCartItem();
    },
    methods: {
        getVehicle() {
            axios.get('/get_vehicle').then(res => {
                this.vehicles = res.data;
            })
        },
        partsAddCartItem() {
            let item = {
                tyre_name: '',
                new_serial: '',
                old_serial: '',
            }
            this.parts_cart.push(item);
        },

        delPartsCartItem(index) {
            this.parts_cart.splice(index, 1)
        },
        getAllTyreList() {
            axios.get('/get-tyre-list').then(res => {
                // console.log(res);
                this.vehicleService = res.data;
            })
        },
        getAllTyreDetails() {
            axios.post('/get-all-tyre-details', {
                tyre_id: this.tyre.tyre_id
            }).then(res => {
                this.tyre = res.data.tyreDetails[0];
                this.parts_cart = res.data.spare_cart;
            })
        },

        saveTyre() {

            if (this.selectedVehicle.vehicle_id == '') {
                alert('Please select a vechicle');
                return;
            }
            if (this.tyre.installation_date == '') {
                alert('Please Enter installation Date');
                return;
            }
            if (this.tyre.expaire_date == '') {
                alert('Please Enter Expaire Date');
                return;
            }
            this.tyre.vehicle_id = this.selectedVehicle.vehicle_id;

            let filter = {
                data: this.tyre,
                cart: this.parts_cart
            }

            // console.log(filter);
            // return
            axios.post("/save-tyre-entry", filter).then(res => {
                let r = res.data;
                alert(r.message);
                if (r.success) {
                    this.getAllTyreList();
                    this.clearForm();
                }
            })
        },


        editData(data) {
            this.tyre.tyre_id = data.tyre_id;
            this.tyre.vehicle_id = data.vehicle_id;
            this.tyre.installation_date = data.installation_date;
            this.tyre.expaire_date = data.expaire_date;
            this.tyre.comments = data.comments;

            this.selectedVehicle = {
                vehicle_id: data.vehicle_id,
                vehicle_reg_no: data.vehicle_reg_no,
            }
            this.parts_cart = [];
            data.details.forEach(item => {
                let itemObj = {
                    tyre_name: item.tyre_name,
                    new_serial: item.new_serial,
                    old_serial: item.old_serial,
                }
                this.parts_cart.push(itemObj);
            })
        },
        deleteService(id) {
            let deleteConfirm = confirm('Are Your Sure to delete the item?');
            if (deleteConfirm == false) {
                return;
            }
            axios.post('/delete-tyre-entry', {
                tyre_id: id
            }).then(res => {
                let r = res.data;
                alert(r.message);
                if (r.success) {
                    this.getAllTyreList();
                }
            })
        },
        clearForm() {
            this.tyre = {
                tyre_id: '',
                vehicle_id: '',
                installation_date: moment().format('YYYY-MM-DD'),
                expaire_date: moment().format('YYYY-MM-DD'),
                comments: '',
            }
            this.parts_cart = [];
            this.partsAddCartItem()
            this.selectedVehicle = {
                vehicle_id: '',
                vehicle_reg_no: 'Select---',
            }
        }
    }
})
</script>