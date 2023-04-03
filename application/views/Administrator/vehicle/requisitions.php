<style>
    .v-select {
        margin-bottom: 5px;
        width: 250px;
    }

    .v-select .dropdown-toggle {
        padding: 0px;
    }

    .v-select input[type=search],
    .v-select input[type=search]:focus {
        margin: 0px;
    }

    .v-select .selected-tag {
        margin: 0px;
    }
</style>

<div id="salesInvoiceReport" class="row">
    <div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
        <div class="form-group" style="margin-top:10px;">
            <label class="col-sm-2 col-sm-offset-2 control-label no-padding-right" style="text-align: right;"> Requisitions No </label>
            <label class="col-sm-1 control-label no-padding-right" style="width: 10px;"> : </label>
            <div class="col-sm-3">
                <v-select v-bind:options="requisitions" label="requisition_no" v-model="selectedRequisition" v-on:input="viewRequisition" placeholder="Select Requisition"></v-select>
            </div>
        </div>

        <!-- <div class="form-group">
            <div class="col-sm-2">
                <input type="button" class="btn btn-primary" value="Show Report" v-on:click="viewInvoice" style="margin-top:0px;width:150px;display: none;">
            </div>
        </div> -->
    </div>
    <div class="col-md-8 col-md-offset-2">
        <br>
        <!-- <sales-invoice v-bind:sales_id="selectedRequisition.requisition_id" v-if="viewRequisition"></sales-invoice> -->
        <requisition v-bind:requisition_id="selectedRequisition.requisition_id" v-if="showRequisition"></requisition>
    </div>
</div>



<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/js/vue/components/salesInvoice.js"></script> -->
<script src="<?php echo base_url(); ?>assets/js/vue/components/requisition.js"></script>

<script>
    Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#salesInvoiceReport',
        data() {
            return {
                requisitions: [],
                selectedRequisition: null,
                showRequisition: false
            }
        },
        created() {
            this.getRequisitins();
        },
        methods: {
            getRequisitins() {
                axios.get("/get-all-requisitions").then(res => {
                    // console.log(res);
                    this.requisitions = res.data.requisition;
                })
            },
            async viewRequisition() {

                this.showRequisition = false;
                await new Promise(r => setTimeout(r, 500));
                this.showRequisition = true;
            }
        }
    })
</script>