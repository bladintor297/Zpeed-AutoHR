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
				width:700px;
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
                page-break-after: avoid;
            }
			.page {
				page-break-after: always;
            }
            .page:last-child {
                page-break-after: avoid;
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

			.invoice-box table tr.info daystion table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

            .invoice-box table tr.heading .al{
				background: #19875473;
                /* background-op:0.3; */
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

            .invoice-box table tr.heading .ml{
				background: #ffc1075d;
                /* background-op:0.3; */
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

            .invoice-box table tr.heading .el{
				background: #dc354659;
                /* background-op:0.3; */
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

				.invoice-box table tr.info daystion table td {
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

            .margin-top{
                margin-top: 50%;
                font-size: 4rem;
            }
		</style>
	</head>
	<?php use App\Http\Controllers\LeaveController;?>
	<body>
        {{-- <div class="page">
            <div class = "frame" > 
                <h1 class="text-center margin-top">Leave Report</h1>
                <h2 class="text-center" style="font-size:3rem;">{{$staff->name}}</h2>
            </div>
        </div> --}}

        <div class="page-main">
				<div class="invoice-box">
					<table cellpadding="0" cellspacing="0">
						<tr class="top">
							<td colspan="2">
								<h2 class="text-center">LEAVE REPORT</h2>
								<h3 class="text-center">Year: {{$currentyear}}</h3>
							</td>
						</tr>
			
						<tr class="info daystion">
							<td colspan="2">
								<table>
									<tr>
										<td>
											{{$staff->name}}<br />
											{{$staff->designation}}
										</td>
			
										<td>
											{{$staff->email}} | {{$staff->phone}}<br />
											<?php 
											$d1 = new \DateTime(date('Y-m-d'));
											$d2 = new \DateTime($staff->start_date);

											$diff = $d2->diff($d1);

												if ($diff->y === 0)
												echo 'Less than 1 year of service';

												else if ($diff->y === 1)
												echo '1 year of service';
												
												else
												echo $diff->y.' years of service';
											?>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						
						{{-- Annual Leave --}}

						<tr class="heading">
							<td class="al">Annual Leave</td>
			
							<td class="al">Total</td>
						</tr>
			
						<tr class="item">
							<td >1. Leave Entitlement</td>
			
							<td> {{$staff->ent_al}} days</td>
						</tr>
			
						<tr class="item">
							<td>2. Used Leave</td>
							
							<td> {{$staff->ent_al - $staff->bal_al}} days</td>
						</tr>
			
						<tr class="item">
							<td>3. Balance Leave</td>
			
							<td>{{$staff->bal_al}} days</td>
						</tr>

						<tr class="item">
							<td>4. Refresh Mode</td>
			
							<td> N/A </td>
						</tr>
			
						<tr class="item last">
							<td>5. Cashback Amount</td>
			
							<td>N/A</td>
						</tr>
			
						<tr class="total">
							<td></td>
			
							<td><h3>Total Leave: {{$staff->ent_al - $staff->bal_al}} days </h3></td>
						</tr><br>

						{{-- Medical LEave --}}
						<tr class="heading">
							<td class="ml">Medical Leave</td>
			
							<td class="ml">Total</td>
						</tr>
			
						<tr class="item">
							<td>1. Leave Entitlement</td>
			
							<td>{{$staff->ent_ml}} days</td>
						</tr>
			
						<tr class="item">
							<td>2. Used Leave</td>
							
							<td>{{$staff->ent_ml - $staff->bal_ml}}  days</td>
						</tr>
			
						<tr class="item">
							<td>3. Balance Leave</td>
			
							<td>{{$staff->bal_ml}} days</td>
						</tr>

						<tr class="total">
							<td></td>
			
							<td><h3>Total Leave:  {{$staff->ent_ml - $staff->bal_ml}} days </h3></td>
						</tr><br>

						{{-- Emergency Leave --}}
						<tr class="heading">
							<td class="el">Emergency Leave</td>
			
							<td class="el">Total</td>
						</tr>

						<tr class="item">
							<td>1. Used Leave</td>
							
							<td>{{$staff->ent_el}}  days</td>
						</tr>
		
						
						<tr class="total">
							<td></td>
			
							<td><h3>Total Leave: {{$staff->ent_el}}  days </h3></td>
						</tr>

					</table>
				</div>
			</div>
        @if(count($leave_record)>0) 
		@while($max >= $min)
			{{-- @if ($max !== $currentyear)	 --}}
			<div class="page">
				<div class="invoice-box">
					<table cellpadding="0" cellspacing="0">
						<tr class="top">
							<td colspan="2">
								<h2 class="text-center">LEAVE REPORT</h2>
								<h3 class="text-center">Year: {{$max}}</h3>
							</td>
						</tr>
			
						<tr class="info daystion">
							<td colspan="2">
								<table>
									<tr>
										<td>
											{{$staff->name}}<br />
											{{$staff->designation}}
										</td>
			
										<td>
											{{$staff->email}} | {{$staff->phone}}<br/>
											
										</td>
									</tr>
								</table>
							</td>
						</tr>
						
						{{-- Annual Leave --}}

						<tr class="heading">
							<td class="al">Annual Leave</td>
			
							<td class="al">Total</td>
						</tr>
			
						<tr class="item">
							<td >1. Leave Entitlement</td>
			
							<td> {{LeaveController::countLeave($staff->staff_id, $max)->total_al}} days</td>
						</tr>
			
						<tr class="item">
							<td>2. Used Leave</td>
							
							<td> {{LeaveController::countLeave($staff->staff_id, $max)->used_al}} days</td>
						</tr>
			
						<tr class="item">
							<td>3. Balance Leave</td>
			
							<td>{{LeaveController::countLeave($staff->staff_id, $max)->bal_al}} days</td>
						</tr>

						<tr class="item">
							<td>4. Refresh Mode</td>
			
							<td> 
								@if (LeaveController::countLeave($staff->staff_id, $max)->mode === '1')
								Carry Forward

								@else
								Cashback

								@endif
							</td>
						</tr>
			
						<tr class="item last">
							<td>5. Cashback Amount</td>
			
							<td>RM {{LeaveController::countLeave($staff->staff_id, $max)->cashback}}</td>
						</tr>
			
						<tr class="total">
							<td></td>
			
							<td><h3>Total Leave:  {{LeaveController::countLeave($staff->staff_id, $max)->used_al}} days </h3></td>
						</tr><br>

						{{-- Medical LEave --}}
						<tr class="heading">
							<td class="ml">Medical Leave</td>
			
							<td class="ml">Total</td>
						</tr>
			
						<tr class="item">
							<td>1. Leave Entitlement</td>
			
							<td>{{LeaveController::countLeave($staff->staff_id, $max)->total_ml}} days</td>
						</tr>
			
						<tr class="item">
							<td>2. Used Leave</td>
							
							<td>{{LeaveController::countLeave($staff->staff_id, $max)->used_ml}}  days</td>
						</tr>
			
						<tr class="item">
							<td>3. Balance Leave</td>
			
							<td>{{LeaveController::countLeave($staff->staff_id, $max)->bal_ml}}  days</td>
						</tr>

						<tr class="total">
							<td></td>
			
							<td><h3>Total Leave:  {{LeaveController::countLeave($staff->staff_id, $max)->used_ml}} days </h3></td>
						</tr><br>

						{{-- Emergency Leave --}}
						<tr class="heading">
							<td class="el">Emergency Leave</td>
			
							<td class="el">Total</td>
						</tr>

						<tr class="item">
							<td>1. Used Leave</td>
							
							<td>{{LeaveController::countLeave($staff->staff_id, $max)->total_el}}  days</td>
						</tr>
		
						
						<tr class="total">
							<td></td>
			
							<td><h3>Total Leave: {{LeaveController::countLeave($staff->staff_id, $max)->total_el}}  days </h3></td>
						</tr>

					</table>
				</div>
			</div>
			{{-- @endif --}}
			@php $max = $max - 1; @endphp
		@endwhile

        @endif
	
	</body>
</html>