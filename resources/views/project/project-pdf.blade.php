<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Project Report</title>

		<style>
            .page-main {
                page-break-after: avoid;
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
                background-color: #bb8c00;
                color: rgb(0, 0, 0);
                text-align: center;
            }

            h1{
                text-align: center;
                font-size: 25px;
            }

		</style>
	</head>
	<body>
        <div id="piechart"></div>

        

        
            <div class="page">
                <h1>Project: {{$project->name}}</h1>

                <table id="customers">
                    <tr>
                        <th style="width: 30%">Project Name</th>
                        <td>{{$project->name}}</td>
                    </tr>
                    <tr>
                        <th>Project Code</th>
                        <td>{{$project->code}}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($project->status === '0')
                            Ongoing

                            @else
                            Completed
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Start Date</th>
                        <td>{{date('j F, Y', strtotime($project->start_date));}}</td>
                    </tr>
                    <tr>
                        <th>End Date</th>
                        <td>
                            @if ($project->end_date === null)
                            N/A

                            @else
                            {{date('j F, Y', strtotime($project->end_date));}}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    
                    <tr>
                        <th>Total Claim</th>
                        <td>RM {{number_format((float)$totalall, 2, '.', '')}}</td>
                    </tr>
                    <tr>
                        <th>Total #Paid</th>
                        <td>RM {{number_format((float)$total, 2, '.', '')}}</td>
                    </tr>
                    <tr>
                        <th>Claim by</th>
                        <td>
                            @if (count($claimamount)>0)
                            <ol>
                                @foreach ($claimamount as $claim)
                                    
                                <li><span> 
                                    {{$claim['name'] }}<em style="padding-left: 20px">RM {{number_format((float)$claim['total'], 2, '.', '')}}</em>
                                    
                                <br></span></li>
                                @endforeach
                            </ol>
                                
                            @else
                            N/A
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

    
	</body>
</html>
