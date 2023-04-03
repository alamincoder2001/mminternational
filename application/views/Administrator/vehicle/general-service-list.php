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
            <div class="col-sm-6 col-md-offset-3">
                <div class="form-group">
                    <label class="control-label col-sm-4">General Service Name :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" v-model="inputData.general_service_name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Status :</label>
                    <div class="col-sm-8">
                        <select class="form-control" v-model="inputData.status">
                            <option value="" selected>Select---</option>
                            <option value="Active" selected>Active</option>
                            <option value="Inactive" selected>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="form-group clearfix" style="margin-top: 10px;text-align:right">
                    <div class="col-xs-12">
                        <input type="submit" class="btn btn-success btn-sm" value="Save Service List">
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
                <datatable :columns="columns" :data="generalServiceList" :filter-by="filter">
                    <template scope="{ row }">
                        <tr>
                            <td :style="{color: row.status == 'Active' ? '' : 'red'}">{{ row.id }}</td>
                            <td :style="{color: row.status == 'Active' ? '' : 'red'}">{{ row.general_service_name }}</td>
                            <td :style="{color: row.status == 'Active' ? '' : 'red'}">{{ row.status }}</td>

                            <td>
                                <a :style="{color: row.status == 'Active' ? '' : 'red'}" href="" title="Edit Service" @click.prevent="editService(row)"><i class="fa fa-pencil"></i></a>&nbsp;
                                <a :style="{color: row.status == 'Active' ? '' : 'red'}" href="" class="button" @click.prevent="deleteService(row.service_id )"><i class="fa fa-trash"></i></a>
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
                inputData: {
                    id: '',
                    general_service_name: '',
                    status: '',
                },
                generalServiceList: [],

                columns: [{
                        label: 'id',
                        field: 'id',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'General Service Name',
                        field: 'general_service_name',
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
            this.getService();
        },
        methods: {
            getService() {
                axios.get('/get-general-service-list').then(res => {
                    this.generalServiceList = res.data;
                })
            },
            saveService() {
                if (this.inputData.general_service_name == '') {
                    alert('General service name required!');
                    return;
                }
                if (this.inputData.status == '') {
                    alert('Status required!');
                    return;
                }
                let url = '/save-general-service-list';

                axios.post(url, this.inputData).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.getService();
                        this.clearForm();
                    }
                })
            },
            editService(data) {
                this.inputData.id = data.id;
                this.inputData.general_service_name = data.general_service_name;
                this.inputData.status = data.status;
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
                this.inputData = {
                    id: '',
                    general_service_name: '',
                    status: '',
                }
            }
        }
    })
</script>