<style>
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

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'vehicle' ? '' : 'none'}">
					<label>Vehicle</label>
					<v-select v-bind:options="vehicles" v-model="selectedvehicle" label="vehicle_reg_no"></v-select>
				</div>

				<div class="form-group">
					<input type="date" class="form-control" v-model="dateFrom">
				</div>

				<div class="form-group">
					<input type="date" class="form-control" v-model="dateTo">
				</div>

				<div class="form-group" style="margin-top: -5px;">
					<input type="submit" value="Search">
				</div>
			</form>
		</div>
	</div>

	<div class="row" style="margin-top:15px;display:none;" v-bind:style="{display: recordData.length > 0 ? '' : 'none'}">
		<div class="col-xs-12" style="margin-bottom: 10px;">
			<a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
		</div>
		<div class="col-xs-12">
			<div id="reportContent">
				<h3 style="text-align:center;margin-top: 0px;font-weight:bold">General Service Report</h3>
				<table class="table table-bordered" style="display:none" v-bind:style="{display: recordData.length > 0 ? '' : 'none'}">
					<thead>
						<th>SL.</th>
						<th>Date</th>
						<th>Vehicle No</th>
						<th>Service Name</th>
						<th>Start Date</th>
						<th>End Date</th>
						<th>Comments</th>
					</thead>
					<tbody>
						<tr v-for="(item,index) in recordData">
							<td>{{ ++index}}</td>
							<td>{{ item.date}}</td>
							<td>{{ item.vehicle_reg_no}}</td>
							<td>{{ item.general_service_name}}</td>
							<td>{{ item.start_date}}</td>
							<td>{{ item.end_date}}</td>
							<td>{{ item.comments}}</td>
						</tr>
					</tbody>
				</table>
			</div>
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
				if (this.searchType == '') {
					this.selectedvehicle = null;
				}
				let filter = {
					vehicle_id: this.selectedvehicle == null || this.selectedvehicle.vehicle_id == '' ? '' : this.selectedvehicle.vehicle_id,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}

				axios.post("get-all-general-service", filter)
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