<div id="Invoice">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<job-card-print v-bind:id="Id"></job-card-print>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/js/vue/components/salesInvoice.js"></script> -->
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/components/jobCardPrint.js"></script>
<script>
	new Vue({
		el: '#Invoice',
		components: {
			jobCardPrint
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