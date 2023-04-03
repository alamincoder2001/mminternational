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

    <div class="row">

        <div class="col-sm-12">
            <div class="form-group">
                <h4 style="font-size:25px; text-align:center; color:green; font-weight:bold;">License Expair Reminder
                </h4>
            </div>
        </div>

        <div class="col-xs-12" style="margin-bottom: 10px;">
            <a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
        </div>

        <div class="col-sm-12 form-inline">
            <div class="form-group">
                <label for="filter" class="sr-only">Filter</label>
                <input type="text" class="form-control" v-model="filter" placeholder="Filter">
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive" id="reportContent">
                <datatable :columns="columns" :data="vehicleLicense" :filter-by="filter">
                    <template scope="{ row }">
                        <tr style="text-align:center">
                            <td>{{ row.vehicle_reg_no }}</td>
                            <td>{{ row.registration_expire_date }}</td>
                            <td> <span :style="{background: row.reg_remain_day >= 0 ? 'green' : 'red' }"
                                    style="color:white; border-radius:3px; padding:2px 4px; ">
                                    {{ row.reg_remain_day }} Days </span> </td>
                            <td>{{ row.roadPermit_expire_date }}</td>
                            <td> <span :style="{background: row.road_remain_day >= 0 ? 'green' : 'red' }"
                                    style="color:white; border-radius:3px; padding:2px 4px; ">{{ row.road_remain_day }}
                                    Days</span> </td>
                            <td>{{ row.fitness_expire_date }}</td>
                            <td> <span :style="{background: row.fitness_remain_day >= 0 ? 'green' : 'red' }"
                                    style="color:white; border-radius:3px; padding:2px 4px; ">
                                    {{ row.fitness_remain_day }}Days </span></td>
                            <td>{{ row.taxToken_expire_date }}</td>
                            <td> <span :style="{background: row.taxToken_remain_day >= 0 ? 'green' : 'red' }"
                                    style="color:white; border-radius:3px; padding:2px 4px; ">
                                    {{ row.taxToken_remain_day }} Days </span> </td>
                            <td>{{ row.insurance_expire_date }}</td>
                            <td> <span :style="{background: row.insurance_remain_day >= 0 ? 'green' : 'red' }"
                                    style="color:white; border-radius:3px; padding:2px 4px; ">
                                    {{ row.insurance_remain_day }} Days </span> </td>
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
                    label: 'Reg Reminder Day',
                    field: 'registration_reminder_day',
                    align: 'center'
                },
                {
                    label: 'Road Permit Expire Date',
                    field: 'roadPermit_expire_date',
                    align: 'center'
                },
                {
                    label: 'Road Permit Reminder Day',
                    field: 'roadPermit_reminder_day',
                    align: 'center'
                },
                {
                    label: 'Fitness Expire Date',
                    field: 'fitness_expire_date',
                    align: 'center'
                },
                {
                    label: 'Fitness Reminder Day',
                    field: 'fitness_reminder_day',
                    align: 'center'
                },
                {
                    label: 'Tax Token Expire Date',
                    field: 'taxToken_expire_date',
                    align: 'center'
                },
                {
                    label: 'Tax Token Reminder Day',
                    field: 'taxToken_reminder_day',
                    align: 'center'
                },
                {
                    label: 'Insurence Expire Date',
                    field: 'insurance_expire_date',
                    align: 'center'
                },
                {
                    label: 'Insurence Reminder Day',
                    field: 'insurance_reminder_day',
                    align: 'center'
                },
            ],
            page: 1,
            per_page: 10,
            filter: ''
        }
    },
    created() {
        //this.getVehicle();
        this.getLicense();
    },
    methods: {

        getLicense() {
            axios.get('/license-expair-reminderList').then(res => {
                // console.log(res);
                this.vehicleLicense = res.data;
            })
        },

        async print() {

            let reportContent = `
					<div class="container">						
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#reportContent').innerHTML}
							</div>
						</div>
					</div>
				`;

            var reportWindow = window.open('', 'PRINT', `height=${screen.height}, width=${screen.width}`);
            reportWindow.document.write(`
					<?php $this->load->view('Administrator/reports/reportHeader.php'); ?>
				`);

            reportWindow.document.head.innerHTML += `
					<style>
						.table {
							width: 100%;
							max-width: 100%;
							margin-bottom: 5px;
						}

						table{
							width: 100%;
							border-collapse: collapse;
						}
						.record-table thead{
							background-color: #0097df;
							color:white;
						}
						.record-table th, .record-table td{
							padding: 3px;
							border: 1px solid #454545;
						}
						.record-table th{
							text-align: center;
						}
					</style>
				`;
            reportWindow.document.body.innerHTML += reportContent;

            if (this.searchType == '' || this.searchType == 'user') {
                let rows = reportWindow.document.querySelectorAll('.record-table tr');
                rows.forEach(row => {
                    row.lastChild.remove();
                })
            }


            reportWindow.focus();
            await new Promise(resolve => setTimeout(resolve, 1000));
            reportWindow.print();
            reportWindow.close();
        }

    }
})
</script>