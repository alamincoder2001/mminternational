const purchaseChalan = Vue.component('purchase-chalan', {
    template: `
        <div>
            <div class="row">
                <div class="col-xs-12">
                    <a href="" v-on:click.prevent="print"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            
            <div id="invoiceContent">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <div _h098asdh>
                            Purchase Chalan
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div _d9283dsc></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <table _a584de>
                            <thead>
                                <tr>
                                    <td>Description</td>
                                    <td>Requisition Quantity</td>
                                    <td>Issue Quantity</td>
                                    <td>Current Stock</td>
                                    <td>Remarks</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ cart[0].Product_Name }}</td>
                                    <td>{{ cart[0].requisition_quantity }}</td>
                                    <td>{{ totalIssueQty }}</td>
                                    <td> {{ cart[0].current_quantity  }} </td>
                                    <td> {{ cart[0].PurchaseDetails_Note}} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
    
                </div>
                <div class="row">

                </div>
            </div>
        </div>
    `,
    props: ['purchase_id'],
    data(){
        return {
            purchase:{
                PurchaseMaster_InvoiceNo: null,
                previous_due: null,
                PurchaseMaster_Description: null,
                AddBy: null
            },
            cart: [],
            totalIssueQty: 0.0,
            style: null,
            companyProfile: null,
            currentBranch: null
        }
    },
    created(){
        this.setStyle();
        this.getPurchase();
        this.getCurrentBranch();
    },
    methods:{
        getPurchase(){
            
            axios.post('/get_purchase_chalan', {purchaseId: this.purchase_id}).then(res=>{
                this.cart = res.data.purchaseDetails;
                this.totalIssueQty = res.data.issueQuantity;
            })
        },

        getCurrentBranch() {
            axios.get('/get_current_branch').then(res => {
                this.currentBranch = res.data;
            })
        },

        setStyle(){
            this.style = document.createElement('style');
            this.style.innerHTML = `
                div[_h098asdh]{
                    /*background-color:#e0e0e0;*/
                    font-weight: bold;
                    font-size:15px;
                    margin-bottom:15px;
                    padding: 5px;
                    border-top: 1px dotted #454545;
                    border-bottom: 1px dotted #454545;
                }
                div[_d9283dsc]{
                    padding-bottom:25px;
                    border-bottom: 1px solid #ccc;
                    margin-bottom: 15px;
                }
                table[_a584de]{
                    width: 100%;
                    text-align:center;
                }
                table[_a584de] thead{
                    font-weight:bold;
                }
                table[_a584de] td{
                    padding: 3px;
                    border: 1px solid #ccc;
                }
                table[_t92sadbc2]{
                    width: 100%;
                }
                table[_t92sadbc2] td{
                    padding: 2px;
                }
            `;
            document.head.appendChild(this.style);
        },

        async print(){
            let invoiceContent = document.querySelector('#invoiceContent').innerHTML;
            let printWindow = window.open('', 'PRINT', `width=${screen.width}, height=${screen.height}, left=0, top=0`);
            
            printWindow.document.write(`
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <title>Invoice</title>
                    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
                    <style>
                        body, table{
                            font-size: 13px;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-2"><img src="/uploads/company_profile_thum/${this.currentBranch.Company_Logo_thum}" alt="Logo" style="height:80px;" /></div>
                            <div class="col-xs-10" style="padding-top:20px;">
                                <strong style="font-size:18px;">${this.currentBranch.Company_Name}</strong><br>
                                <p style="white-space:pre-line;">${this.currentBranch.Repot_Heading}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div style="border-bottom: 4px double #454545;margin-top:7px;margin-bottom:7px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                ${invoiceContent}
                            </div>
                        </div>
                    </div>
                    <div class="container" style="position:fixed;bottom:15px;width:100%;">
                        <div class="row" style="border-bottom:1px solid #ccc;margin-bottom:5px;padding-bottom:6px;">
                            <div class="col-xs-6">
                                <span style="text-decoration:overline;">Received by</span><br><br>
                                ** THANK YOU FOR YOUR BUSINESS **
                            </div>
                            <div class="col-xs-6 text-right">
                                <span style="text-decoration:overline;">Authorized Signature</span>
                            </div>
                        </div>

                        <div class="row" style="font-size:12px;">
                            <div class="col-xs-6">
                                Print Date: ${moment().format('DD-MM-YYYY h:mm a')}, Printed by: ${this.purchase.AddBy}
                            </div>
                            <div class="col-xs-6 text-right">
                                Developed by: Link-Up Technologoy, Contact no: 01911978897
                            </div>
                        </div>
                    </div>
                </body>
                </html>
            `);
            let invoiceStyle = printWindow.document.createElement('style');
            invoiceStyle.innerHTML = this.style.innerHTML;
            printWindow.document.head.appendChild(invoiceStyle);
            printWindow.moveTo(0, 0);
            
            printWindow.focus();
            await new Promise(resolve => setTimeout(resolve, 1000));
            printWindow.print();
            printWindow.close();
        }
    }
})