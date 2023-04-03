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
				<div class="form-group">
					<label>Search Type</label>
					<select class="form-control" v-model="searchType" @change="onChangeSearchType">
						<option value="">All</option>
						<option value="supplier">By Supplier</option>
					</select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'supplier' ? '' : 'none'}">
					<label>supplier</label>
					<v-select v-bind:options="suppliers" v-model="selectedsupplier" label="display_name"></v-select>
				</div>

				<div class="form-group">
					<label>Date</label>
					<input type="date" class="form-control" v-model="dateFrom">
				</div>

				<div class="form-group">
					<label>to</label>
					<input type="date" class="form-control" v-model="dateTo">
				</div>

				<div class="form-group" style="margin-top: -5px;">
					<input type="submit" value="Search">
				</div>
			</form>
		</div>
	</div>

	<div class="row" style="margin-top:15px;display:none;" v-bind:style="{display: dataRecords.length > 0 ? '' : 'none'}">
		<div class="col-md-12" style="margin-bottom: 10px;">
			<a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
		</div>
		<div class="col-md-12">
			<div class="table-responsive" id="reportContent">

				<table class="record-table" style="display:none" v-bind:style="{display: dataRecords.length > 0  ? '' : 'none'}">
					<thead>
						<tr>
							<th>Sl</th>
							<th>Date</th>
							<th>supplier Name</th>
							<th>Date of Evaluation</th>
							<th>Period of Evaluation</th>
							<th>Evaluation By</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody style="text-align: center;">
						<tr v-for="(item,index) in dataRecords">
							<td>{{ index + 1 }}</td>
							<td>{{ item.date }}</td>
							<td>{{ item.Supplier_Name }}</td>
							<td>{{ item.date_of_evaluation }}</td>
							<td>{{ item.period_of_evaluation }}</td>
							<td>{{ item.evaluation_by }}</td>

							<td style="text-align:center;">
								<a href="" title="Invoice" v-bind:href="`/evaluation_print/${item.supplier_evaluation_id}`" target="_blank"><i class="fa fa-file"></i></a>
								<?php if ($this->session->userdata('accountType') != 'u') { ?>
									<a href="" title="Edit Supplier Evaluation" v-bind:href="`/supplier-evaluation/${item.supplier_evaluation_id}`" target="_blank"><i class="fa fa-pencil"></i></a>&nbsp;
									<a href="" class="button" @click.prevent="deleteSupEvaluation(item.supplier_evaluation_id)"><i class="fa fa-trash"></i></a>
								<?php } ?>
							</td>
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
<script src="<?php echo base_url(); ?>assets/js/lodash.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#salesRecord',
		data() {
			return {
				searchType: '',
				recordType: 'without_details',
				dateFrom: moment().format('YYYY-MM-DD'),
				dateTo: moment().format('YYYY-MM-DD'),

				suppliers: [],
				selectedsupplier: null,
				dataRecords: [],
				searchTypesForRecord: ['', 'supplier'],
				searchTypesForDetails: ['quantity', 'category'],
			}
		},
		methods: {
			onChangeSearchType() {
				this.sales = [];
				if (this.searchType == 'supplier') {
					this.getsupplier();
				}
			},
			getsupplier() {
				axios.get('/get_suppliers').then(res => {
					this.suppliers = res.data;
				})
			},

			getSearchResult() {
				let filter = {
					supplier_id: this.selectedsupplier == null || this.selectedsupplier.Supplier_SlNo == '' ? '' : this.selectedsupplier.Supplier_SlNo,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}

				let url = '/get-supplier-evaluation';

				// console.log(filter);
				// return;

				axios.post(url, filter).then(res => {
						console.log(res.data);
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
				let deleteConfirm = confirm('Are Your Sure to delete the item?');
				if (deleteConfirm == false) {
					return;
				}
				axios.post('/delete-complain-record', {
					complain_record_id: id
				}).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						this.getComplainRecord();
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
								<h3>Delivery points complain record From</h3>
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
					<?php $this->load->view('Administrator/reports/reportHeader2.php'); ?>
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

				// if (this.searchType == '' || this.searchType == 'user') {
				let rows = reportWindow.document.querySelectorAll('.record-table tr');
				rows.forEach(row => {
					row.lastChild.remove();
				})
				// }


				reportWindow.focus();
				await new Promise(resolve => setTimeout(resolve, 1000));
				reportWindow.print();
				reportWindow.close();
			}
		}
	})
</script>