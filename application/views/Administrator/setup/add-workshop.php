<style>
    .saveBtn {
        padding: 7px 22px;
        background-color: #00acb5 !important;
        border-radius: 2px !important;
        border: none;
    }

    .saveBtn:hover {
        padding: 7px 22px;
        background-color: #06777c !important;
        border-radius: 2px !important;
        border: none;
    }
</style>
<div id="workshop">
    <div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom: 15px;">
        <form class="form-horizontal" v-on:submit.prevent="saveDate">
            <div class="col-md-6 col-md-offset-3">
                <div class="form-group">
                    <label class="control-label col-md-4">Workshop Name* :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" v-model="inputField.workshop_name">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Mobile No* :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" v-model="inputField.mobile_no" placeholder="Enter client name...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Address* :</label>
                    <div class="col-md-8">
                        <textarea class="form-control" v-model="inputField.address" placeholder="Enter address..." cols="30" rows="3"></textarea>
                    </div>
                </div>

                <div class="form-group clearfix">
                    <div class="col-md-12" style="text-align: right;">
                        <input type="submit" class="btn saveBtn" :disabled="saveProcess" value="Save">
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
                <datatable :columns="columns" :data="workshops" :filter-by="filter">
                    <template scope="{ row }">
                        <tr>
                            <td>{{ row.workshop_id }}</td>
                            <td>{{ row.workshop_name }}</td>
                            <td>{{ row.mobile_no }}</td>
                            <td>{{ row.address }}</td>
                            <td>{{ row.status }}</td>
                            <td>
                                <?php //if ($this->session->userdata('accountType') == 'm') { 
                                ?>
                                <a href="" v-on:click.prevent="editItem(row)"><i class="fa fa-pencil"></i></a>&nbsp;
                                <a href="" class="button" v-on:click.prevent="deleteItem(row.workshop_id )"><i class="fa fa-trash"></i></a>
                                <?php //} 
                                ?>
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
    new Vue({
        el: '#workshop',
        data() {
            return {
                inputField: {
                    workshop_id: '',
                    workshop_name: '',
                    mobile_no: '',
                    address: '',
                },
                workshops: [],
                saveProcess: false,
                columns: [{
                        label: 'Serial',
                        field: 'workshop_id',
                        align: 'center'
                    },
                    {
                        label: 'Wprkshop Name',
                        field: 'workshop_name',
                        align: 'center'
                    },
                    {
                        label: 'Mobile No',
                        field: 'mobile_no',
                        align: 'center'
                    },
                    {
                        label: 'Address',
                        field: 'address',
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
            this.getWorkshops();
        },
        methods: {
            getWorkshops() {
                axios.get('/get-workshop').then(res => {
                    this.workshops = res.data;
                })
            },
            saveDate() {
                if (this.inputField.workshop_name == '') {
                    alert('Workshop name required!');
                    return;
                }
                if (this.inputField.mobile_no == '') {
                    alert('Client mobile no required!');
                    return;
                }
                if (this.inputField.address == '') {
                    alert('Address required!');
                    return;
                }

                let url = '/save-workshop';

                this.saveProcess = true;

                axios.post(url, this.inputField).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.saveProcess = false;
                        this.getWorkshops();
                        this.clearForm();
                    } else {
                        this.saveProcess = false;
                    }
                })
            },
            editItem(data) {
                this.inputField.workshop_id = data.workshop_id;
                this.inputField.workshop_name = data.workshop_name;
                this.inputField.mobile_no = data.mobile_no;
                this.inputField.address = data.address;
            },
            deleteItem(id) {
                let deleteConfirm = confirm('Are Your Sure to delete the workshop?');
                if (deleteConfirm == false) {
                    return;
                }
                axios.post('/delete-workshop', {
                    workshop_id: id
                }).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.getWorkshops();
                    }
                })
            },
            clearForm() {
                this.inputField = {
                    workshop_id: '',
                    workshop_name: '',
                    mobile_no: '',
                    address: '',
                }
            }
        }
    })
</script>