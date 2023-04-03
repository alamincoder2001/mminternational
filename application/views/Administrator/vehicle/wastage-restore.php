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
</style>
<div id="stock">
	<div class="row">
		<div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">

			<div class="form-group" style="margin-top:10px;">
				<label class="col-sm-1 col-sm-offset-1 control-label no-padding-right"> Select Parts </label>
				<div class="col-sm-2" style="margin-left:15px;">
					<v-select v-bind:options="products" v-model="selectedProduct" label="display_text"></v-select>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-2" style="margin-left:15px;">
					<input type="button" class="btn btn-primary" value="Show" v-on:click="getStock" style="margin-top:0px;border:0px;height:28px;">
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<a href="" v-on:click.prevent="print"><i class="fa fa-print"></i> Print</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive" id="stockContent">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Product Name</th>
							<th>Wastage Quantity</th>
							<th>Already Restore Quantity</th>
							<th>New Restore Quantity</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="product in stock">
							<td>{{ product.Product_Name }}</td>
							<td>{{ product.wastage_qty }}</td>
							<td>{{ product.wastage_restore_qty }}</td>
							<td v-if="product.wastage_qty != 0">
								<input type="number" v-model="newQty">
							</td>
							<td v-else></td>
							<td>
								<button v-on:click="updateStock" class="btn btn-sm btn-info">Save</button>
							</td>
						</tr>
					</tbody>
					<tfoot>
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

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#stock',
		data() {
			return {
				products: [],
				selectedProduct: null,
				stock: {},
				newQty: '',
			}
		},
		created() {
			this.getProducts();
		},
		methods: {
			getStock() {
				if (this.selectedProduct == null) {
					alert('Select a product');
					return;
				}
				axios.post('/get_product_current_stock', {
					productId: this.selectedProduct.Product_SlNo
				}).then(res => {
					this.stock = res.data;
				})
			},
			getProducts() {
				axios.post('/get_products', {
					isService: 'false'
				}).then(res => {
					this.products = res.data;
				})
			},
			updateStock() {
				if (parseInt(this.newQty) > parseInt(this.stock[0].wastage_qty)) {
					alert('max qty is ' + this.stock[0].wastage_qty + ' allow');
					return;
				}
				let filter = {
					productId: this.selectedProduct.Product_SlNo,
					newQty: this.newQty
				}

				axios.post('/update-current-stock', filter).then(res => {
					alert(res.data.message);
					this.getStock();
					this.newQty = '';
				})

			}

		}
	})
</script>