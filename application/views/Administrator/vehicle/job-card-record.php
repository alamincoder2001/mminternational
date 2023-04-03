<style>
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

	.table thead th {
		background-color: #007595 !important;
		color: white;
	}

	.record-table th,
	.record-table td {
		padding: 3px;
		border: 1px solid #ccc;
	}

	.record-table th {
		text-align: center;
	}
</style>
<div id="salesRecord">
	<div class="row" style="border-bottom: 1px solid #ccc;padding: 3px 0;">
		<div class="col-md-12">
			<form class="form-inline" id="searchForm" @submit.prevent="getResult">
				<div class="form-group">
					<label>Search Type</label>
					<select class="form-control" v-model="searchType" @change="getVehicle">
						<option value="">All</option>
						<option value="vehicle">By Vehicle</option>
					</select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'vehicle' ? '' : 'none'}">
					<label>Vehicle</label>
					<v-select v-bind:options="vehicles" v-model="selectedVehicle" label="vehicle_reg_no"></v-select>
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
	<div class="row" style="display:none" v-bind:style="{display: dataRecords.length > 0 ? '' : 'none'}">
		<div class="col-md-12" style="margin-bottom: 10px;">
			<a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
		</div>
		<div class="col-md-12">
			<div class="table-responsive" id="reportContent">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Job Card No</th>
							<th>Date</th>
							<th>Vehicle Name</th>
							<th>date IN</th>
							<th>date OUT</th>
							<!-- <th>Standint Date</th> -->
							<th>Work Details</th>
							<th>Req Spare Parts</th>
							<th>Job Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody style="text-align: center;">
						<template v-for="job in dataRecords">
							<tr>
								<td>{{ job.job_card_no }}</td>
								<td>{{ job.date }}</td>
								<td>{{ job.vehicle_reg_no }}</td>
								<td>{{ job.date_in }}</td>
								<td>{{ job.date_out }}</td>
								<!-- <td>{{ job.standint_date }}</td> -->
								<td>{{ job.work_details }}</td>
								<td>{{ job.req_spare_parts }}</td>
								<td>{{ job.job_status }}</td>
								<td style="text-align:center;width: 90px;">
									<a @click.prevent="completeJob(job.job_card_id)" style="font-size: 16px;color: green;" v-if="job.job_status == 'Pending' " href="" title="job complete">
										<i class="fa fa-check-square"></i>
									</a>
									<a href="" title="job card" v-bind:href="`/job_card_print/${job.job_card_id}`" target="_blank"><i class="fa fa-file"></i></a>
									<?php if ($this->session->userdata('accountType') != 'u') { ?>
										<a href="" title="Edit" v-bind:href="`/add-job-card/${job.job_card_id}`"><i class="fa fa-edit"></i></a>
										<a href="" title="Delete" @click.prevent="deleteItem(job.job_card_id)"><i class="fa fa-trash"></i></a>
									<?php } ?>
								</td>
							</tr>

						</template>
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
<script src="<?php echo base_url(); ?>assets/js/lodash.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#salesRecord',
		data() {
			return {
				searchType: '',
				dateFrom: moment().format('YYYY-MM-DD'),
				dateTo: moment().format('YYYY-MM-DD'),

				dataRecords: [],
				vehicles: [],
				selectedVehicle: null,
			}
		},
		methods: {
			completeJob(jobCardId) {
				let conf = confirm('Are you sure to update job status complete?');
				if (conf) {
					axios.post('/complete_Job', {
						jobCardId: jobCardId
					}).then(res => {
						alert(res.data.message)
						this.getResult();
					})
				}
			},
			getVehicle() {
				axios.get('/get_vehicle').then(res => {
					this.vehicles = res.data;
				})
			},
			getResult() {
				let filter = {
					vehicle_id: this.selectedVehicle == null || this.selectedVehicle.vehicle_id == '' ? '' : this.selectedVehicle.vehicle_id,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo,
				}
				// console.log(filter);
				// return;

				axios.post('/get-job-card', filter).then(res => {
						// console.log(res);
						this.dataRecords = res.data;
					})
					.catch(error => {
						// console.log(error);
						if (error.response) {
							alert(`${error.response.status}, ${error.response.statusText}`);
						}
					})

			},

			deleteItem(id) {
				let deleteConf = confirm('Are you sure?');
				if (deleteConf == false) {
					return;
				}
				axios.post('/delete-job-card', {
						job_card_id: id
					})
					.then(res => {
						let r = res.data;
						alert(r.message);
						if (r.success) {
							this.getResult();
						}
					})
					.catch(error => {
						if (error.response) {
							alert(`${error.response.status}, ${error.response.statusText}`);
						}
					})
			},
			async print() {
				let dateText = '';
				if (this.dateFrom != '' && this.dateTo != '') {
					dateText = `Statement from <strong>${this.dateFrom}</strong> to <strong>${this.dateTo}</strong>`;
				}

				let userText = '';
				if (this.selectedUser != null && this.selectedUser.FullName != '' && this.searchType == 'user') {
					userText = `<strong>Sold by: </strong> ${this.selectedUser.FullName}`;
				}

				let customerText = '';
				if (this.selectedCustomer != null && this.selectedCustomer.Customer_SlNo != '' && this.searchType == 'customer') {
					customerText = `<strong>Customer: </strong> ${this.selectedCustomer.Customer_Name}<br>`;
				}

				let employeeText = '';
				if (this.selectedEmployee != null && this.selectedEmployee.Employee_SlNo != '' && this.searchType == 'employee') {
					employeeText = `<strong>Employee: </strong> ${this.selectedEmployee.Employee_Name}<br>`;
				}

				let productText = '';
				if (this.selectedProduct != null && this.selectedProduct.Product_SlNo != '' && this.searchType == 'quantity') {
					productText = `<strong>Product: </strong> ${this.selectedProduct.Product_Name}`;
				}

				let categoryText = '';
				if (this.selectedCategory != null && this.selectedCategory.ProductCategory_SlNo != '' && this.searchType == 'category') {
					categoryText = `<strong>Category: </strong> ${this.selectedCategory.ProductCategory_Name}`;
				}


				let reportContent = `
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h3>Daily Maintenance Record</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								${userText} ${customerText} ${employeeText} ${productText} ${categoryText}
							</div>
							<div class="col-xs-6 text-right">
								${dateText}
							</div>
						</div>
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
						.record-table{
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