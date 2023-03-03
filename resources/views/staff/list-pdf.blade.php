<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Staff List</title>

		<style>
            .page-main {
                page-break-after: avoid;
                size: landscape;
            }
            @page { 
                size: landscape;
            }
			.page {
				page-break-after: always;
                
                
            }
            .page:last-child {
                page-break-after: avoid;
            }
			/* .page-inside{
				text-align: center;
				justify-content: center;
				padding-top: 450px;
				font-size: 50px;
			} */

            #customers {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #customers td, #customers th {
                border: 1px solid #ddd;
                padding: 8px;
            }

            #customers tr:nth-child(even){background-color: #f2f2f2;}

            #customers tr:hover {background-color: #ddd;}

            #customers th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #04AA6D;
                color: white;
                text-align: center;
            }

            h1{
                text-align: center;
            }

		</style>
	</head>
	<body>

        
            <div class="page">
                <h1>Staff List</h1>

                <table id="customers">
                <tr>
                    <th style="width: 1%">ID</th>
                    <th style="width: 20%">Name</th>
                    <th style="width: 1%">NRIC</th>
                    <th style="width: 1%">Email</th>
                    <th style="width: 1%">Phone</th>
                    <th>Designation</th>
                    <th>Status</th>
                </tr>
                @foreach($staffs as $staff)
                    <tr>
                        <td>{{$staff->staff_id}}</td>
                        <td>{{$staff->name}}</td>
                        <td>{{$staff->nric}}</td>
                        <td>{{$staff->email}}</td>
                        <td>{{$staff->phone}}</td>
                        <td>{{$staff->designation}}</td>
                        <td>
                            @if ($staff->status === '0')
                            On Probation

                            @elseif ($staff->status === '2')
                            Resigned

                            @else
                            Permanent Staff
                            @endif
                        </td>
                    </tr>
                @endforeach
                </table>
            </div>

            <div class="page-main">
                <h1>Banking Details</h1>

                <table id="customers">
                <tr>
                    <th style="width: 1%">ID</th>
                    <th style="width: 20%">Name</th>
                    <th>Bank Name</th>
                    <th>Bank Number</th>
                    <th>Income Tax</th>
                </tr>

                @foreach($staffs as $staff)
                <tr>
                    <td>{{$staff->staff_id}}</td>
                    <td>{{$staff->name}}</td>
                    <td style="text-align: center">{{$staff->bank_name}}</td>
                    <td style="text-align: center">{{$staff->bank_acc}}</td>
                    <td style="text-align: center">{{$staff->income_tax}}</td>
                </tr>
                @endforeach
                </table>
            </div>
	</body>
</html>