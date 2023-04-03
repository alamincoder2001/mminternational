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
                        <!-- <option value="customer">By Customer</option>
						<option value="employee">By Employee</option>
						<option value="category">By Category</option>
						<option value="quantity">By Quantity</option> -->
                        <option value="vehicle">By Vehicle</option>
                        <option value="workshop">By Workshop</option>
                    </select>
                </div>

                <div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'customer' && customers.length > 0 ? '' : 'none'}">
                    <label>Customer</label>
                    <v-select v-bind:options="customers" v-model="selectedCustomer" label="display_name"></v-select>
                </div>

                <div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'employee' && employees.length > 0 ? '' : 'none'}">
                    <label>Employee</label>
                    <v-select v-bind:options="employees" v-model="selectedEmployee" label="Employee_Name"></v-select>
                </div>

                <div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'quantity' && products.length > 0 ? '' : 'none'}">
                    <label>Product</label>
                    <v-select v-bind:options="products" v-model="selectedProduct" label="display_text" @input="sales = []"></v-select>
                </div>

                <div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'category' && categories.length > 0 ? '' : 'none'}">
                    <label>Category</label>
                    <v-select v-bind:options="categories" v-model="selectedCategory" label="ProductCategory_Name">
                    </v-select>
                </div>

                <div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'vehicle' && vehicles.length > 0 ? '' : 'none'}">
                    <label>Vehicle</label>
                    <v-select v-bind:options="vehicles" v-model="selectedVehicle" label="vehicle_reg_no"></v-select>
                </div>

                <div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'workshop' ? '' : 'none'}">
                    <label>Workshop</label>
                    <v-select v-bind:options="workshops" v-model="selectedWorkshop" label="workshop_name"></v-select>
                </div>

                <!-- <div class="form-group" v-bind:style="{display: searchTypesForRecord.includes(searchType) ? '' : 'none'}">
					<label>Record Type</label>
					<select class="form-control" v-model="recordType" @change="requisitions = []">
						<option value="without_details">Without Details</option>
						<option value="with_details">With Details</option>
					</select>
				</div> -->

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

    <div class="row" style="margin-top:15px;display:none;" v-bind:style="{display: dataRecords.length > 0 ? '' : 'none'}">
        <div class="col-xs-6" style="margin-bottom: 10px;">
            <a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
        </div>


        <div class="col-xs-6" style="margin-bottom: 10px; text-align:right;">
            <a class="dataExport btn btn-sm btn-primary" data-type="excel">Export Excel</a>
        </div>

        <div class="col-md-12" id="dataTable">
            <div class="table-responsive" id="reportContent">

                <table class="record-table" v-if="recordType == 'with_details'" style="display:none" v-bind:style="{display: (searchTypesForRecord.includes(searchType)) && recordType == 'with_details' ? '' : 'none'}">
                    <thead>
                        <tr>
                            <th>Requisition No.</th>
                            <th>Date</th>
                            <th>Saved By</th>
                            <th>Vehicle Name</th>
                            <th>Parts Name</th>
                            <th>Purpose</th>
                            <th>Quantity</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">
                        <template v-for="sale in dataRecords">
                            <tr>
                                <td>{{ sale.requisition_no }}</td>
                                <td>{{ sale.date }}</td>
                                <td>{{ sale.User_Name }}</td>
                                <td>{{ sale.requisitionDetails[0].vehicle_reg_no }}</td>
                                <td>{{ sale.requisitionDetails[0].Product_Name }}</td>
                                <td>{{ sale.requisitionDetails[0].purpose }}</td>
                                <td>{{ sale.requisitionDetails[0].quantity }}</td>

                                <td style="text-align:center;">
                                    <a href="" title="Requisition Form" v-bind:href="`/requisition_print/${sale.requisition_id}`" target="_blank"><i class="fa fa-file"></i></a>
                                    <!-- <a href="" title="Chalan" v-bind:href="`/chalan/${sale.SaleMaster_SlNo}`" target="_blank"><i class="fa fa-file-o"></i></a> -->
                                    <?php if ($this->session->userdata('accountType') != 'u') { ?>
                                        <!-- <a v-if="sale.purchase_order_status == 'pending'" href="" title="Edit Requisition"
                                        v-bind:href="`/requisition_edit/${sale.requisition_id}`"><i
                                            class="fa fa-edit"></i></a> -->
                                        <a v-if="sale.purchase_order_status == 'pending'" href="" title="Delete Sale" @click.prevent="deleteRequisition(sale.requisition_id)"><i class="fa fa-trash"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr v-for="(product, sl) in sale.requisitionDetails.slice(1)">
                                <td colspan="3" v-bind:rowspan="sale.requisitionDetails.length - 1" v-if="sl == 0"></td>
                                <td>{{ product.vehicle_reg_no }}</td>
                                <td style="text-align:center;">{{ product.Product_Name }}</td>
                                <td style="text-align:center;">{{ product.purpose }}</td>
                                <td style="text-align:center;">{{ product.quantity }}</td>
                                <td></td>
                            </tr>
                            <tr style="font-weight:bold;">
                                <td colspan="6" style="font-weight:normal;text-align:left"><strong>Note: </strong></td>
                                <td style="text-align:center;">Total
                                    Quantity<br>{{ sale.requisitionDetails.reduce((prev, curr) => {return prev + parseFloat(curr.quantity)}, 0) }}
                                </td>

                                <td></td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <table class="record-table" v-else style="display:none" v-bind:style="{display: (searchTypesForRecord.includes(searchType)) && recordType == 'without_details' ? '' : 'none'}" id="dataTable">
                    <thead>
                        <tr>
                            <th>Vehicle Reg No.</th>
                            <th>Date</th>
                            <th>Workshop Name</th>
                            <th>Mechanic Name</th>
                            <th>Autmobile Engineer</th>
                            <th>Job Problems</th>
                            <th>Job Progress</th>
                            <th>S. Parts Cost</th>
                            <th>Labour Cost</th>
                            <th>Other Cost</th>
                            <th>Total Cost</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">
                        <tr v-for="item in dataRecords">
                            <td>{{ item.vehicle_reg_no }}</td>
                            <td>{{ item.date }}</td>
                            <td>{{ item.workshop_name }}</td>
                            <td>{{ item.mechanic_name }}</td>
                            <td>{{ item.autmobile_engineer }}</td>
                            <td>{{ item.job_problems.replace( /(<([^>]+)>)/ig, '') }} </td>
                            <td>{{ item.job_progress.replace( /(<([^>]+)>)/ig, '') }} </td>
                            <td>{{ item.spare_cost }}</td>
                            <td>{{ item.labour_cost }}</td>
                            <td>{{ item.other_cost }}</td>
                            <td>{{ item.total_cost }}</td>
                            <td>
                                <a v-if="item.image1" :href="<?php base_url() ?>'/uploads/maintanance_img/' + item.image1" target="_blank">Image1</a> <br>
                                <a v-if="item.image2" :href="<?php base_url() ?>'/uploads/maintanance_img/' + item.image2" target="_blank">Image2</a>
                            </td>

                            <td style="text-align:center;">
                                <a href="" title="Invoice" v-bind:href="`/maintanance_print/${item.maintenance_id}`" target="_blank"><i class="fa fa-file"></i></a>
                                <!-- <a href="" title="Chalan" v-bind:href="`/chalan/${item.SaleMaster_SlNo}`" target="_blank"><i class="fa fa-file-o"></i></a> -->
                                <?php if ($this->session->userdata('accountType') != 'u') { ?>
                                    <a href="" title="Edit" v-bind:href="`/daily-maintenance/${item.maintenance_id}`"><i class="fa fa-edit"></i></a>
                                    <a href="" title="Delete" @click.prevent="deleteItem(item.maintenance_id)"><i class="fa fa-trash"></i></a>
                                <?php } ?>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td colspan="11" style="text-align:right;">Total</td>
                            <td style="text-align:center;">
                                {{ dataRecords.reduce((prev, curr)=>{return prev + parseFloat(curr.total_cost)}, 0) | decimal }}
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
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

<script src="<?php echo base_url(); ?>assets/js/jquery.base64.js"></script>
<script src="<?php echo base_url(); ?>assets/js/tableExport.jquery.json"></script>
<script src="<?php echo base_url(); ?>assets/js/tableExport.js"></script>

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
                customers: [],
                selectedCustomer: null,
                employees: [],
                selectedEmployee: null,
                products: [],
                selectedProduct: null,
                users: [],
                selectedUser: null,
                categories: [],
                selectedCategory: null,
                vehicles: [],
                selectedWorkshop: [],
                workshops: [],
                selectedVehicle: null,
                requisitions: [],
                dataRecords: [],
                searchTypesForRecord: ['', 'vehicle', 'workshop', 'user', 'customer', 'employee'],
                searchTypesForDetails: ['quantity', 'category']
            }
        },
        methods: {
            onChangeSearchType() {
                this.sales = [];
                if (this.searchType == 'quantity') {
                    this.getProducts();
                } else if (this.searchType == 'user') {
                    this.getUsers();
                } else if (this.searchType == 'category') {
                    this.getCategories();
                } else if (this.searchType == 'customer') {
                    this.getCustomers();
                } else if (this.searchType == 'employee') {
                    this.getEmployees();
                } else if (this.searchType == 'vehicle') {
                    this.getVehicle();
                } else if (this.searchType == 'workshop') {
                    this.getWorkshops();
                }
            },
            getVehicle() {
                axios.get('/get_vehicle').then(res => {
                    this.vehicles = res.data;
                })
            },

            getWorkshops() {
                axios.get('/get-workshop').then(res => {
                    this.workshops = res.data;
                })
            },
            getProducts() {
                // axios.get('/get_products').then(res => {
                // 	this.products = res.data;
                // })
            },
            getCustomers() {
                // axios.get('/get_customers').then(res => {
                // 	this.customers = res.data;
                // })
            },
            getEmployees() {
                // axios.get('/get_employees').then(res => {
                // 	this.employees = res.data;
                // })
            },
            getUsers() {
                axios.get('/get_users').then(res => {
                    this.users = res.data;
                })
            },
            getCategories() {
                // axios.get('/get_categories').then(res => {
                // 	this.categories = res.data;
                // })
            },
            getSearchResult() {
                if (this.searchType != 'customer') {
                    this.selectedCustomer = null;
                }

                if (this.searchType != 'employee') {
                    this.selectedEmployee = null;
                }

                if (this.searchType != 'quantity') {
                    this.selectedProduct = null;
                }

                if (this.searchType != 'category') {
                    this.selectedCategory = null;
                }
                if (this.searchType != 'user') {
                    this.selectedUser = null;
                }
                if (this.searchType != 'vehicle') {
                    this.selectedVehicle = null;
                }

                if (this.searchType != 'workshop') {
                    this.selectedWorkshop = null;
                }

                if (this.searchTypesForRecord.includes(this.searchType)) {
                    this.getSalesRecord();
                } else {
                    this.getSaleDetails();
                }
            },
            getSalesRecord() {

                let filter = {
                    // userFullName: this.selectedUser == null || this.selectedUser.FullName == '' ? '' : this.selectedUser.FullName,
                    // customerId: this.selectedCustomer == null || this.selectedCustomer.Customer_SlNo == '' ? '' : this.selectedCustomer.Customer_SlNo,
                    // employeeId: this.selectedEmployee == null || this.selectedEmployee.Employee_SlNo == '' ? '' : this.selectedEmployee.Employee_SlNo,
                    vehicle_id: this.selectedVehicle == null || this.selectedVehicle.vehicle_id == '' ? '' : this.selectedVehicle.vehicle_id,
                    workshop_id: this.selectedWorkshop == null || this.selectedWorkshop.workshop_id == '' ? '' : this.selectedWorkshop.workshop_id,
                    dateFrom: this.dateFrom,
                    dateTo: this.dateTo,
                    recordType: 'without_details'
                }

                let url = '/get-maintenance-report';

                if (this.recordType == 'with_details') {
                    filter.recordType = 'with_details'
                }

                // console.log(filter);
                // return;

                axios.post(url, filter).then(res => {
                        console.log(res);
                        this.dataRecords = res.data;
                    })
                    .catch(error => {
                        // console.log(error);
                        if (error.response) {
                            alert(`${error.response.status}, ${error.response.statusText}`);
                        }
                    })
            },
            getSaleDetails() {
                let filter = {
                    categoryId: this.selectedCategory == null || this.selectedCategory.ProductCategory_SlNo ==
                        '' ? '' : this.selectedCategory.ProductCategory_SlNo,
                    productId: this.selectedProduct == null || this.selectedProduct.Product_SlNo == '' ? '' : this.selectedProduct.Product_SlNo,
                    dateFrom: this.dateFrom,
                    dateTo: this.dateTo
                }

                axios.post('/get_saledetails', filter)
                    .then(res => {
                        let sales = res.data;

                        if (this.selectedProduct == null) {
                            sales = _.chain(sales)
                                .groupBy('ProductCategory_ID')
                                .map(sale => {
                                    return {
                                        category_name: sale[0].ProductCategory_Name,
                                        products: _.chain(sale)
                                            .groupBy('Product_IDNo')
                                            .map(product => {
                                                return {
                                                    product_code: product[0].Product_Code,
                                                    product_name: product[0].Product_Name,
                                                    quantity: _.sumBy(product, item => Number(item
                                                        .SaleDetails_TotalQuantity))
                                                }
                                            })
                                            .value()
                                    }
                                })
                                .value();
                        }
                        this.sales = sales;
                    })
                    .catch(error => {
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
                axios.post('/delete-maintenance', {
                        maintenance_id: id
                    })
                    .then(res => {
                        let r = res.data;
                        alert(r.message);
                        if (r.success) {
                            this.getSearchResult();
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
                    dateText =
                        `Statement from <strong>${this.dateFrom}</strong> to <strong>${this.dateTo}</strong>`;
                }

                let userText = '';
                if (this.selectedUser != null && this.selectedUser.FullName != '' && this.searchType ==
                    'user') {
                    userText = `<strong>Sold by: </strong> ${this.selectedUser.FullName}`;
                }

                let customerText = '';
                if (this.selectedCustomer != null && this.selectedCustomer.Customer_SlNo != '' && this
                    .searchType == 'customer') {
                    customerText = `<strong>Customer: </strong> ${this.selectedCustomer.Customer_Name}<br>`;
                }

                let employeeText = '';
                if (this.selectedEmployee != null && this.selectedEmployee.Employee_SlNo != '' && this
                    .searchType == 'employee') {
                    employeeText = `<strong>Employee: </strong> ${this.selectedEmployee.Employee_Name}<br>`;
                }

                let productText = '';
                if (this.selectedProduct != null && this.selectedProduct.Product_SlNo != '' && this
                    .searchType == 'quantity') {
                    productText = `<strong>Product: </strong> ${this.selectedProduct.Product_Name}`;
                }

                let categoryText = '';
                if (this.selectedCategory != null && this.selectedCategory.ProductCategory_SlNo != '' && this
                    .searchType == 'category') {
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