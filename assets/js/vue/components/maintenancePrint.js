const maintenancePrint = Vue.component("maintenancePrint", {
  template: `
        <div>
            <div class="row">
                <div class="col-xs-12">
                    <a href="" v-on:click.prevent="print"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            
            <div id="invoiceContent">
                <div class="row"">
                    <div class="col-xs-12" style="text-align:center">
                        <div _h0986asdh>
                            <h2>Maintenance Record</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-7">
                        <strong>Workshop Name :</strong> {{ maintenance.workshop_name }}<br>
                        <strong>Vehicle Reg No :</strong> {{ maintenance.vehicle_reg_no }}<br>
                        <strong>Mechanic Name :</strong> {{ maintenance.mechanic_name }}<br>
                        <strong>Autmobile Engineer :</strong> {{ maintenance.autmobile_engineer }}<br>
                    </div>
                    <div class="col-xs-5 text-right">
                        <strong>In Date :</strong> {{ maintenance.date }}<br>
                        <strong>Out Date :</strong> {{ maintenance.out_date }}<br>
                        <strong>In Time :</strong> {{ maintenance.vehicle_in_time }}<br>
                        <strong>Out Time :</strong> {{ maintenance.vehicle_out_time }}<br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div _d9283dsc>
                            <table _a584de>
                                <thead>
                                    <tr style="background:#eee !important;">
                                        <td>Job Problems</td>
                                        <td>Job Progress</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align:left;">{{ maintenance.job_problems.replace( /(<([^>]+)>)/ig, '') }}</td>
                                        <td style="text-align:left;">{{ maintenance.job_progress.replace( /(<([^>]+)>)/ig, '') }}</td>
                                    </tr>
                                </tbody>
                            </table> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-7">
                        <table _a584de>
                            <thead>
                                <tr style="background:#eee !important;">
                                    <td>Sl.</td>
                                    <td>Parts Name</td>
                                    <td>Qty</td>
                                    <td>Rate</td>
                                    <td>Total Tk</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(req, sl) in spare_cart">
                                    <td>{{ sl + 1 }}</td>
                                    <td>{{ req.parts_name }}</td>
                                    <td>{{ req.qty }}</td>
                                    <td>{{ req.rate }}</td>
                                    <td>{{ req.total_tk }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-5">
                        <table _a584de>
                            <thead>
                                <tr style="background:#eee !important;">
                                    <td>Sl.</td>
                                    <td>Labour Name</td>
                                    <td>Total Tk</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(req, sl) in labour_cart">
                                    <td>{{ sl + 1 }}</td>
                                    <td>{{ req.labour_name }}</td>
                                    <td>{{ req.total_tk }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <table _a584de>
                            <thead>
                                <tr style="background:#eee !important;">
                                    <td>Sl.</td>
                                    <td>Parts Name</td>
                                    <td>New Parts Serial</td>
                                    <td>Old Parts Serial</td>
                                    <td>Install Date</td>
                                    <td>Expired Date</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(req, sl) in cart">
                                    <td>{{ sl + 1 }}</td>
                                    <td>{{ req.Product_Code }} - {{ req.Product_Name }}</td>
                                    <td>{{ req.new_parts_serial }}</td>
                                    <td>{{ req.old_parts_serial }}</td>
                                    <td>{{ req.install_date }}</td>
                                    <td>{{ req.expire_date }}</td>
                                </tr>
                            </tbody>
                      <!--      <tfoot style="font-weight:bold">
                                <tr>
                                    <td colspan="2" style="text-align:left">Total = </td>
                                    <td style="text-align:center">{{ cart.reduce((prev, curr)=>{return prev + parseFloat(curr.quantity)}, 0) }}</td>
                                    <td></td>
                                    <td style="text-align:center">{{ (cart.reduce((prev, curr)=>{return prev + parseFloat(curr.total_amount)}, 0)).toFixed(2) }}</td>
                                </tr>
                            </tfoot> -->
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div _d9283dsc>
                            <table _a584de>
                                <thead>
                                    <tr style="background:#eee !important;">
                                        <td>Spare Cost</td>
                                        <td>Labour Cost</td>
                                        <td>Other Cost</td>
                                        <td>Total Cost</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ maintenance.spare_cost }}</td>
                                        <td>{{ maintenance.labour_cost }}</td>
                                        <td>{{ maintenance.other_cost }}</td>
                                        <td>{{ maintenance.total_cost }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
         <!--        <div class="row">
                    <div class="col-xs-12">
                        <table _a584tde>
                            <thead>
                                <tr>
                                    <td style="width:15%;text-align:left">Requisition By</td>
                                    <td></td>
                                    <td style="width:12%;text-align:left">Sign & Date</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style="width:15%;text-align:left">Checked By</td>
                                    <td></td>
                                    <td style="width:12%;text-align:left">Sign & Date</td>
                                    <td></td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>    -->
            </div>
        </div>
    `,
  props: ["id"],
  data() {
    return {
      maintenance: {
        maintenance_id: "",
        date: moment().format("YYYY-MM-DD"),
        workshop_name: "",
        vehicle_id: "",
        vehicle_in_time: "",
        vehicle_out_time: "",
        mechanic_name: "",
        autmobile_engineer: "",
        spare_cost: "",
        labour_cost: "",
        other_cost: "",
        total_cost: 0,
        job_problems: "",
        job_progress: "",
        spare_parts: "",
        remarks: "",
      },
      cart: [],
      spare_cart: [],
      labour_cart: [],
      style: null,
      companyProfile: null,
      currentBranch: null,
    };
  },
  filters: {
    formatDateTime(dt, format) {
      return dt == "" || dt == null ? "" : moment(dt).format(format);
    },
  },
  created() {
    this.setStyle();
    this.getMaintenance();
    this.getCurrentBranch();
  },
  methods: {
    getMaintenance() {
      console.log(this.id);
      axios
        .post("/get-all-maintenance", { maintenance_id: this.id })
        .then((res) => {
          console.log(res);
          this.maintenance = res.data.maintenance[0];
          this.cart = res.data.maintenanceDetails;
          this.spare_cart = res.data.spare_cart;
          this.labour_cart = res.data.labour_cart;
        });
    },
    getCurrentBranch() {
      axios.get("/get_current_branch").then((res) => {
        this.currentBranch = res.data;
      });
    },
    setStyle() {
      this.style = document.createElement("style");
      this.style.innerHTML = `
                div[_h098asdh],h4{
                    font-weight: bold;
                    font-size:20px;
                }
                div[_h0986asdh],h2{
                    font-weight: bold;
                    margin-bottom:30px;
                }
                div[_h098asdh],p{
                    font-size:12px;
                    font-weight:normal
                }
                div[_d9283dsc]{
                    padding-top:15px;
                    // border-bottom: 1px solid #ccc;
                    // margin-bottom: 5px;
                }
                table[_a584de]{
                    width: 100%;
                    text-align:center;
                    margin-bottom: 10px;
                }                
                table[_a584de] thead{
                    font-weight:bold;
                }
                table[_a584de] td{
                    padding: 3px;
                    border: 1px solid #ccc;
                }

                table[_a584tde]{
                    width: 100%;
                    text-align:center;
                    margin-bottom: 10px;
                }
                table[_a584tde] thead{
                    font-weight:bold;
                }
                table[_a584tde] thead tr td{
                    padding: 3px;
                    border: 1px solid #ccc;
                }
                table[_a584tde] tbody tr td{
                    height: 40px;
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
    convertNumberToWords(amountToWord) {
      var words = new Array();
      words[0] = "";
      words[1] = "One";
      words[2] = "Two";
      words[3] = "Three";
      words[4] = "Four";
      words[5] = "Five";
      words[6] = "Six";
      words[7] = "Seven";
      words[8] = "Eight";
      words[9] = "Nine";
      words[10] = "Ten";
      words[11] = "Eleven";
      words[12] = "Twelve";
      words[13] = "Thirteen";
      words[14] = "Fourteen";
      words[15] = "Fifteen";
      words[16] = "Sixteen";
      words[17] = "Seventeen";
      words[18] = "Eighteen";
      words[19] = "Nineteen";
      words[20] = "Twenty";
      words[30] = "Thirty";
      words[40] = "Forty";
      words[50] = "Fifty";
      words[60] = "Sixty";
      words[70] = "Seventy";
      words[80] = "Eighty";
      words[90] = "Ninety";
      amount = amountToWord == null ? "0.00" : amountToWord.toString();
      var atemp = amount.split(".");
      var number = atemp[0].split(",").join("");
      var n_length = number.length;
      var words_string = "";
      if (n_length <= 9) {
        var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
        var received_n_array = new Array();
        for (var i = 0; i < n_length; i++) {
          received_n_array[i] = number.substr(i, 1);
        }
        for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
          n_array[i] = received_n_array[j];
        }
        for (var i = 0, j = 1; i < 9; i++, j++) {
          if (i == 0 || i == 2 || i == 4 || i == 7) {
            if (n_array[i] == 1) {
              n_array[j] = 10 + parseInt(n_array[j]);
              n_array[i] = 0;
            }
          }
        }
        value = "";
        for (var i = 0; i < 9; i++) {
          if (i == 0 || i == 2 || i == 4 || i == 7) {
            value = n_array[i] * 10;
          } else {
            value = n_array[i];
          }
          if (value != 0) {
            words_string += words[value] + " ";
          }
          if (
            (i == 1 && value != 0) ||
            (i == 0 && value != 0 && n_array[i + 1] == 0)
          ) {
            words_string += "Crores ";
          }
          if (
            (i == 3 && value != 0) ||
            (i == 2 && value != 0 && n_array[i + 1] == 0)
          ) {
            words_string += "Lakhs ";
          }
          if (
            (i == 5 && value != 0) ||
            (i == 4 && value != 0 && n_array[i + 1] == 0)
          ) {
            words_string += "Thousand ";
          }
          if (
            i == 6 &&
            value != 0 &&
            n_array[i + 1] != 0 &&
            n_array[i + 2] != 0
          ) {
            words_string += "Hundred and ";
          } else if (i == 6 && value != 0) {
            words_string += "Hundred ";
          }
        }
        words_string = words_string.split("  ").join(" ");
      }
      return words_string + " only";
    },
    async print() {
      let invoiceContent = document.querySelector("#invoiceContent").innerHTML;
      let printWindow = window.open(
        "",
        "PRINT",
        `width=${screen.width}, height=${screen.height}, left=0, top=0`
      );
      if (this.currentBranch.print_type == "3") {
        printWindow.document.write(`
                    <html>
                        <head>
                            <title>Invoice</title>
                            <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
                            <style>
                                body, table{
                                    font-size:11px;
                                }
                            </style>
                        </head>
                        <body>
                            <div style="text-align:center;">
                                <img src="/uploads/company_profile_thum/${this.currentBranch.Company_Logo_org}" alt="Logo" style="height:80px;margin:0px;" /><br>
                                <strong style="font-size:18px;">${this.currentBranch.Company_Name}</strong><br>
                                <p style="white-space:pre-line;">${this.currentBranch.Repot_Heading}</p>
                            </div>
                            ${invoiceContent}
                        </body>
                    </html>
                `);
      } else if (this.currentBranch.print_type == "2") {
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
                            html, body{
                                width:500px!important;
                            }
                            body, table{
                                font-size: 13px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="row">
                            <div class="col-xs-2"><img src="/uploads/company_profile_thum/${this.currentBranch.Company_Logo_org}" alt="Logo" style="height:80px;" /></div>
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
                        <div class="row">
                            <div class="col-xs-12">
                                ${invoiceContent}
                            </div>
                        </div>
                    </body>
                    </html>
				`);
      } else {
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
                            <table style="width:100%;">
                                <thead>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <img src="/uploads/company_profile_thum/${this.currentBranch.Company_Logo_org}" alt="Logo" style="height:80px;" />
                                                </div>
                                                <div class="col-xs-6" style="padding:10px 0px 0px 0px;text-align:center">
                                                    <strong style="font-size:32px;">${this.currentBranch.Company_Name}</strong><br>
                                                    <p style="white-space: pre-line;font-family:Lucida Handwriting">${this.currentBranch.Repot_Heading}</p>
                                                </div>
                                                <div class="col-xs-3" style="text-align: right;">
                                                    <img src="/uploads/company_profile_org/${this.currentBranch.iso_image}" alt="Logo" style="height:80px;" />
                                                </div>                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div style="border-bottom: 4px double #454545;margin-top:7px;margin-bottom:7px;"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    ${invoiceContent}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>
                                            <div style="width:100%;height:100px;">&nbsp;</div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="row" style="margin-bottom:5px;padding-bottom:6px;">
                                <div class="col-xs-6">
                                    <span style="text-decoration:overline;">PREPARED BY: M.R </span>
                                    
                                </div>
                                <div class="col-xs-6 text-right">
                                    <span style="text-decoration:overline;">APPROVED BY: PROPRIETOR</span>
                                </div>
                            </div>
                            <div style="position:fixed;left:0;bottom:15px;width:100%;">
                     
                            </div>
                        </div>
                        
                    </body>
                    </html>
				`);
      }
      let invoiceStyle = printWindow.document.createElement("style");
      invoiceStyle.innerHTML = this.style.innerHTML;
      printWindow.document.head.appendChild(invoiceStyle);
      printWindow.moveTo(0, 0);

      printWindow.focus();
      await new Promise((resolve) => setTimeout(resolve, 1000));
      printWindow.print();
      printWindow.close();
    },
  },
});
