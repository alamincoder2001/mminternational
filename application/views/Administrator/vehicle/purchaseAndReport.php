<div id="purchaseChalan">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <purchase-chalan v-bind:purchase_id="purchaseId"> </purchase-chalan>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/components/purchaseChalan.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>
<script>
new Vue({
    el: '#purchaseChalan',
    components: {
        purchaseChalan
    },
    data() {
        return {
            purchaseId: parseInt('<?php echo $purchaseId;?>')
        }
    }
})
</script>