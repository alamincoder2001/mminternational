<style>
th,
td,
tr {
    font-size: 10px;
    padding: 0px !important;
}

.table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 5px;
}

.v-select {
    margin-top: -2.5px;
    float: right;
    min-width: 180px;
    margin-left: 5px;
}

.v-select .dropdown-toggle {
    padding: 0px;
    height: 25px;
}

.v-select input[type=search],
.v-select input[type=search]:focus {
    margin: 0px;
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

#searchForm select {
    padding: 0;
    border-radius: 4px;
}

#searchForm .form-group {
    margin-right: 5px;
}

#searchForm * {
    font-size: 13px;
}

.record-table {
    width: 100%;
    border-collapse: collapse;
}

.record-table thead {
    background-color: #0097df;
    color: white;
}

.record-table th,
.record-table td {
    padding: 3px;
    border: 1px solid #454545;
}

.record-table th {
    text-align: center;
}
</style>
<div id="purchaseRecord">
    <div class="row" style="border-bottom: 1px solid #ccc;padding: 3px 0;">
        <div class="col-xs-12">
            <form class="form-inline" id="searchForm" @submit.prevent="getSearchResult">
                <div class="form-group">
                    <label>Search Type</label>
                    <select class="form-control" v-model="searchType" @change="onChangeSearchType">
                        <option value="">All</option>
                        <option value="vehicle">By Vehicle</option>
                    </select>
                </div>

                <div class="form-group" style="display:none;"
                    v-bind:style="{display: searchType == 'vehicle' ? '' : 'none'}">
                    <label>Vehicle</label>
                    <v-select v-bind:options="vehicles" v-model="selectedvehicle" label="vehicle_reg_no"></v-select>
                </div>

                <!-- <div class="form-group">
					<input type="date" class="form-control" v-model="dateFrom">
				</div>

				<div class="form-group">
					<input type="date" class="form-control" v-model="dateTo">
				</div> -->

                <div class="form-group" style="margin-top: -5px;">
                    <input type="submit" value="Search">
                </div>
            </form>
        </div>
    </div>

    <div class="row" style="margin-top:15px;display:none;"
        v-bind:style="{display: recordData.length > 0 ? '' : 'none'}">
        <div class="col-xs-6" style="margin-bottom: 10px;">
            <a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
        </div>

        <div class="col-xs-6" style="margin-bottom: 10px; text-align:right;">
            <a class="dataExport btn btn-sm btn-primary" data-type="excel">Export Excel</a>
        </div>

        <div class="col-xs-12">
            <div id="reportContent">
                <div class="row" id="dataTable">
                    <template v-for="(item,index) in recordData">
                        <div class="col-xs-4" style="padding: 2px;">
                            <table class="table table-bordered" style="display:none"
                                v-bind:style="{display: recordData.length > 0 ? '' : 'none'}" id="dataTable">
                                <thead v-if="index < 3">
                                    <th>Truck No</th>
                                    <th>Item</th>
                                    <th>Expairy DT</th>
                                    <th>Today</th>
                                    <th>Day of Expaired</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width: 20%;vertical-align: middle;" rowspan="5">
                                            {{ item.vehicle_reg_no}}</td>
                                        <th style="text-align: left;width: 20%;">Registration</th>
                                        <td style="width: 20%;">{{ item.registration_expire_date }}</td>
                                        <td style="width: 20%;">{{ item.today }}</td>
                                        <td style="width: 20%;"
                                            :style="{background:item.day_reg_expired>30 ? '' : '#ccc'}">
                                            {{ item.day_reg_expired }}</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">Road Permit</th>
                                        <td>{{ item.roadPermit_expire_date }}</td>
                                        <td>{{ item.today }}</td>
                                        <td :style="{background:item.day_road_permit_expired>30 ? '' : '#ccc'}">
                                            {{ item.day_road_permit_expired }}</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">Fitness</th>
                                        <td>{{ item.fitness_expire_date }}</td>
                                        <td>{{ item.today }}</td>
                                        <td :style="{background:item.day_fit_expired>30 ? '' : '#ccc'}">
                                            {{ item.day_fit_expired }}</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">Tax Token</th>
                                        <td>{{ item.taxToken_expire_date }}</td>
                                        <td>{{ item.today }}</td>
                                        <td :style="{background:item.day_token_expired>30 ? '' : '#ccc'}">
                                            {{ item.day_token_expired }}</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left;">Insurance</th>
                                        <td>{{ item.insurance_expire_date }}</td>
                                        <td>{{ item.today }}</td>
                                        <td :style="{background:item.day_insu_expired>30 ? '' : '#ccc'}">
                                            {{ item.day_insu_expired }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.base64.js"></script>
<script src="<?php echo base_url(); ?>assets/js/tableExport.jquery.json"></script>
<script src="<?php echo base_url(); ?>assets/js/tableExport.js"></script>

<script>
Vue.component('v-select', VueSelect.VueSelect);
new Vue({
    el: '#purchaseRecord',
    data() {
        return {
            searchType: '',
            dateFrom: moment().format('YYYY-MM-DD'),
            dateTo: moment().format('YYYY-MM-DD'),
            vehicles: [],
            selectedvehicle: null,
            recordData: [],
        }
    },
    methods: {
        onChangeSearchType() {
            if (this.searchType == 'vehicle') {
                this.getVehicle();
            }
        },
        getVehicle() {
            axios.get('/get_vehicle').then(res => {
                this.vehicles = res.data;
            })
        },
        getSearchResult() {
            let filter = {
                vehicle_id: this.selectedvehicle == null || this.selectedvehicle.vehicle_id == '' ? '' :
                    this.selectedvehicle.vehicle_id,
                // dateFrom: this.dateFrom,
                // dateTo: this.dateTo
            }

            axios.post("get_vehicle_license", filter)
                .then(res => {
                    this.recordData = res.data;
                })
                .catch(error => {
                    if (error.response) {
                        alert(`${error.response.status}, ${error.response.statusText}`);
                    }
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
					<?php $this->load->view('Administrator/reports/reportHeader_NoHeader.php'); ?>
				`);

            reportWindow.document.head.innerHTML += `
					<style>
						th,
						td,
						tr {
							font-size: 7px;
							padding: 0px !important;
							text-align:center;
						}
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


$(document).ready(function() {
    $(".dataExport").click(function() {
        var exportType = $(this).data('type');
        $('#dataTable').tableExport({
            type: exportType,
            escape: 'false',
            ignoreColumn: []
        });
    });
});
</script>