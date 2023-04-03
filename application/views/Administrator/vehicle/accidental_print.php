<div id="Invoice">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<accidental-report-print v-bind:id="Id"></accidental-report-print>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/js/vue/components/salesInvoice.js"></script> -->
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/components/accidentalReportPrint.js"></script>
<script>
	new Vue({
		el: '#Invoice',
		components: {
			accidentalReportPrint
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