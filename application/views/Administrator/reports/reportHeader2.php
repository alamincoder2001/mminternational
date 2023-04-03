<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px !important;
        }

        body,
        table {
            font-size: 13px;
        }

        table th {
            text-align: center;
        }
    </style>
</head>

<body>
    <?php
    $branchId = $this->session->userdata('BRANCHid');
    $companyInfo = $this->Billing_model->company_branch_profile($branchId);
    ?>
    <div class="container">
        <!-- 
        <div class="row">
            <div class="col-xs-2"><img src="<?php echo base_url(); ?>uploads/company_profile_thum/<?php echo $companyInfo->Company_Logo_org; ?>" alt="Logo" style="height:80px;" /></div>
            <div class="col-xs-10" style="padding-top:20px;">
                <strong style="font-size:18px;"><?php echo $companyInfo->Company_Name; ?></strong><br>
                <p style="white-space: pre-line;"><?php echo $companyInfo->Repot_Heading; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div style="border-bottom: 4px double #454545;margin-top:7px;margin-bottom:7px;"></div>
            </div>
        </div> -->

        <div class="row">
            <div class="col-xs-12">
                <table style="width:100%">
                    <tr>
                        <td width:'33%'>Form No: MM1011</td>
                        <td style="text-align:center;width:33%">Version: 00</td>
                        <td style="text-align:right;width:33%">ISSUE DATE: 19.01.2020</td>
                    </tr>
                </table>
            </div>
            <div class="col-xs-3">
                <!-- <img src="<?php echo base_url(); ?>uploads/company_profile_thum/<?php echo $companyInfo->Company_Logo_org; ?>" alt="Logo" style="height:80px;" /> -->
            </div>
            <div class="col-xs-6" style="padding:10px 0px 0px 0px;text-align:center">
                <strong style="font-size:32px;"><?php echo $companyInfo->Company_Name; ?></strong><br>
                <!-- <p style="white-space: pre-line;font-family:Lucida Handwriting"><?php echo $companyInfo->Repot_Heading; ?></p> -->
            </div>
            <div class="col-xs-3" style="text-align: right;">
                <!-- <img src="<?php echo base_url(); ?>uploads/company_profile_org/<?php echo $companyInfo->iso_image; ?>" alt="Logo" style="height:80px;" /> -->
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-xs-12">
                <div style="border-bottom: 4px double #454545;margin-top:7px;margin-bottom:7px;"></div>
            </div>
        </div> -->
    </div>
</body>

</html>