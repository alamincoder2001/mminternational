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
<div id="salesRecord">
	<div class="row" style="border-bottom: 1px solid #ccc;padding: 3px 0;">
		<div class="col-md-12">
			<form class="form-inline" id="searchForm" @submit.prevent="getSearchResult">
				<div class="form-group" style="margin-right: 20px;">
					<label>Type : </label>
					<select class="form-control" v-model="searchFor" style="width: 120px;" v-on:input="onChangeType">
						<option value="" disabled>Select---</option>
						<option value="washing">Washing</option>
						<option value="service">Service</option>
					</select>
				</div>
				<div class="form-group" style="margin-right: 20px;">
					<label>Month : </label>
					<select class="form-control" v-model="month" style="width: 120px;">
						<option value="" disabled>Select---</option>
						<option value="01">January</option>
						<option value="02">February</option>
						<option value="03">March</option>
						<option value="04">April</option>
						<option value="05">May</option>
						<option value="06">June</option>
						<option value="07">July</option>
						<option value="08">August</option>
						<option value="09">September</option>
						<option value="10">October</option>
						<option value="11">November</option>
						<option value="12">December</option>
					</select>
				</div>

				<div class="form-group">
					<label>Year : </label>
					<select v-model="year" class="form-control" style="padding: 0px 5px;width:120px">
						<?php
						$y = date('Y');
						for ($i = $y - 5; $i < $y + 5; $i++) { ?>
							<option value="<?= $i ?>"><?= $i ?></option>
						<?php }
						?>
					</select>
				</div>

				<div class="form-group" style="margin-top: -5px;">
					<input type="submit" value="Search">
				</div>
			</form>
		</div>
	</div>

	<div class="row" style="display: none;" :style="{display:resData.length > 0 ? '' : 'none'}">
		<div class="col-md-12" style="margin-bottom: 10px;">
			<a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
		</div>
		<div class="col-md-12">
			<div class="table-responsive" id="reportContent">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Sl</th>
							<th>Truck No</th>
							<th>Driver Name</th>
							<th v-if="searchFor == 'washing' || searchFor == ''">Wash Date</th>
							<th v-if="searchFor == 'service' || searchFor == ''">Service Date</th>
							<th>Comments</th>
						</tr>
					</thead>
					<tbody style="text-align: center;">
						<tr v-for="(item,index) in resData">
							<td>{{ index + 1 }}</td>
							<td>{{ item.vehicle_reg_no }}</td>
							<td>{{ item.driver_name }}</td>
							<td v-if="searchFor == 'washing' || searchFor == ''">{{ item.wash_date }}</td>
							<td v-if="searchFor == 'service' || searchFor == ''">{{ item.service_date }}</td>
							<td>{{ item.comments }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row" style="display: none;margin-top: 10px;" :style="{display: isEmpty ? '' : 'none'}">
		<div class="col-md-12">
			<p style="color:red;font-size:16px; padding:15px;text-align:center;border:1px solid #ddd;">No Record Found! </p>
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
				month: '',
				year: moment().format('YYYY'),
				searchFor: '',
				resData: [],
				isEmpty: false,
			}
		},
		methods: {
			onChangeType() {
				// this.resData = [];
			},
			getSearchResult() {
				if (this.searchFor == '') {
					alert('Select a Type')
					return;
				}
				let year = this.year;
				if (this.month == '') {
					newDate = year;
				} else {
					newDate = year + '-' + this.month
				}
				let filter = {
					date: newDate,
					searchFor: this.searchFor
				}
				axios.post("get-washing-service-schedule", filter).then(res => {
					this.isEmpty = false;
					this.resData = [];
					if (res.data.length > 0) {
						this.resData = res.data;
					} else {
						this.isEmpty = true;
					}
				})
				// .catch(error => {
				// 	console.log(error);
				// 	// if (error.response) {
				// 	// 	alert(`${error.response.status}, ${error.response.statusText}`);
				// 	// }
				// })
			},
			getMonth() {
				if (this.month == 01) {
					return 'JAN'
				} else if (this.month == 02) {
					return 'FEB'
				} else if (this.month == 03) {
					return 'MAR'
				} else if (this.month == 04) {
					return 'APR'
				} else if (this.month == 05) {
					return 'MAY'
				} else if (this.month == 06) {
					return 'JUN'
				} else if (this.month == 07) {
					return 'JUL'
				} else if (this.month == 08) {
					return 'AUG'
				} else if (this.month == 09) {
					return 'SEP'
				} else if (this.month == 10) {
					return 'OCT'
				} else if (this.month == 11) {
					return 'NOV'
				} else if (this.month == 12) {
					return 'DEC'
				}
			},

			async print() {
				let dateText = '';
				if (this.dateFrom != '' && this.dateTo != '') {
					dateText = `Statement from Month: <strong>${this.getMonth()}, ${this.year}`;
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
								<h5>MONTHLY WASHING/SERVICEING SCHEDULE FORM</h5>
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