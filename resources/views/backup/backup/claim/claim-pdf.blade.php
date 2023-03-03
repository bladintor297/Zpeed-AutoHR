<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Claim Report</title>

		<style>
            
			.frame{
				position: absolute;
				top:0;
				bottom: 0;
				left: 0;
				right: 0;
				
				margin: auto;
				display: flex;
				justify-content: center;
				width:500px;
				border: dashed rgb(0, 0, 0) 3px;
			}

			.frame img{
				max-height: 100%;
  				max-width: 100%;
			}


			/* .img {
			position: absolute;
			margin-left: auto;
			margin-right: auto;
			width: 50%;
			
			} */

            .page-main {
                page-break-after: always;
            }
			.page {
				page-break-after: always;
            }
            .page:last-child {
                page-break-after: unset;
            }
			.page-inside{
				text-align: center;
				justify-content: center;
				padding-top: 450px;
				font-size: 50px;
			}
            
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}

			.text-center{
				text-align: center;
			}
		</style>
	</head>
	<body>
    <?php use App\Http\Controllers\ClaimController;?>
		<div class="page-main">
            <div class="invoice-box">
                <table cellpadding="0" cellspacing="0">
                    <tr class="top">
                        <td colspan="2">
                            <h2 class="text-center">CLAIM FORM</h2>
                            
                            <table>
                                <tr>
                                    <td class="title">
                                        <img src="{{ public_path().'/storage/images/zpeed-logo.png' }}" style="width: 100%; max-width: 300px" />
                                    </td>
        
                                    <td>
                                        ClaimID #: {{$id}}<br />
                                        Total Claim: RM {{number_format((float)ClaimController::countAmount($id), 2, '.', '')}}

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
        
                    <tr class="information">
                        <td colspan="2">
                            <table>
                                <tr>
                                    <td>
                                        3-30, Jalan Puteri 4/8,<br />
                                        Bandar Puteri<br />
                                        47100 Puchong
                                    </td>
        
                                    <td>
                                        {{$staff->name}}<br />
                                        {{$staff->phone}}<br />
                                        {{$staff->email}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
        
                    <tr class="heading">
                        <td>Payment Method</td>
        
                        <td> </td>
                    </tr>
        
                    <tr class="details">
                        <td>Online Transfer</td>
        
                        <td>
                            <?php 
                              
                                ?>
                        </td>
                    </tr>
        
                    <tr class="heading">
                        <td>Claims</td>
        
                        <td>Price</td>
                    </tr>
        
                    <tr class="item">
                        <td>1. Milleage Claim</td>
        
                        <td>RM {{number_format((float)$total_milleage, 2, '.', '')}}</td>
                    </tr>
        
                    <tr class="item">
                        <td>2. Parking, Tolls and Taxi</td>
                        
                        <td>RM {{number_format((float)$total_parking, 2, '.', '')}}</td>
                    </tr>
        
                    <tr class="item">
                        <td>3. Accomodation</td>
                        <td>RM {{number_format((float)$total_accomodation, 2, '.', '')}}</td>
                    </tr>
        
        
                    <tr class="item">
                        <td>4. Project Equipments</td>
        
                        <td>RM {{number_format((float)$total_equipment, 2, '.', '')}}</td>
                    </tr>
        
                    <tr class="item">
                        <td>5. Meals</td>
        
                        <td>RM {{number_format((float)$total_meal, 2, '.', '')}}</td>
                    </tr>

                    <tr class="item last">
                        <td>6. Office Expenses</td>
        
                        <td>RM {{number_format((float)$total_office, 2, '.', '')}}</td>
                    </tr>

                    <tr class="item last">
                        <td>7. Others</td>
        
                        <td>RM {{number_format((float)$total_others, 2, '.', '')}}</td>
                    </tr>
        
                    <tr class="total">
                        <td></td>
        
                        <td><h3>Total: RM {{number_format((float)$total_amount, 2, '.', '')}} </h3></td>
                    </tr>
                </table>
            </div>
        </div>
	
    
    @foreach ($claims as $claim)
        @if ($claim->type === 'parking')
            <div class="page">
                <div class="frame">
                    <h2 class="text-center">PARKING RECEIPTS</h2> 
                    <img src='{{public_path().'/storage/receipts/parking/'.$claim->receipt}}' style="width:80%"alt = "No receipt" />
                </div>
            </div>
        @endif

        @if ($claim->type === 'accomodation')
            <div class="page">
                <div class="frame">
                    <h2 class="text-center">ACCOMODATION RECEIPTS</h2> 
                    <img src='{{public_path().'/storage/receipts/accomodation/'.$claim->receipt}}' style="width:80%"alt = "No receipt" />
                </div>
            </div>
        @endif

        @if ($claim->type === 'equipment')
            <div class="page">
                <div class="frame">
                    <h2 class="text-center">PROJECT EQUIPMENT RECEIPTS</h2> 
                    <img src='{{public_path().'/storage/receipts/equipment/'.$claim->receipt}}' style="width:80%"alt = "No receipt" />
                </div>
            </div>
        @endif

        @if ($claim->type === 'meal')
            <div class="page">
                <div class="frame">
                    <h2 class="text-center">MEAL RECEIPTS</h2> 
                    <img src='{{public_path().'/storage/receipts/meal/'.$claim->receipt}}' style="width:80%"alt = "No receipt" />
                </div>
            </div>
        @endif

        @if ($claim->type === 'office')
            <div class="page">
                <div class="frame">
                    <h2 class="text-center">OFFICE EXPENSES RECEIPTS</h2> 
                    <img src='{{public_path().'/storage/receipts/office/'.$claim->receipt}}' style="width:80%"alt = "No receipt" />
                </div>
            </div>
        @endif

        @if ($claim->type === 'others')
            <div class="page">
                <div class="frame">
                    <h2 class="text-center">OTHERS RECEIPTS</h2> 
                    <img src='{{public_path().'/storage/others/office/'.$claim->receipt}}' style="width:80%"alt = "No receipt" />
                </div>
            </div>
        @endif
    @endforeach
    
	
	</body>
</html>