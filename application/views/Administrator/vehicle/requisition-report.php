<div id="salesInvoice">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<requisition v-bind:requisition_id="salesId"></requisition>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/js/vue/components/salesInvoice.js"></script> -->
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/components/requisition.js"></script>
<script>
	new Vue({
		el: '#salesInvoice',
		components: {
			requisition
		},
		data() {
			return {
				salesId: parseInt('<?php echo $requisition_id; ?>')
			}
		}
	})
</script>