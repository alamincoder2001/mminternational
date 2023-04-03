<div id="Invoice">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<purchase-order v-bind:id="Id"></purchase-order>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/js/vue/components/salesInvoice.js"></script> -->
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/components/purchaseOrder.js"></script>
<script>
	new Vue({
		el: '#Invoice',
		components: {
			purchaseOrder
		},
		data() {
			return {
				Id: parseInt('<?php echo $id; ?>')
			}
		},
		created() {
			console.log(this.Id);
		}
	})
</script>