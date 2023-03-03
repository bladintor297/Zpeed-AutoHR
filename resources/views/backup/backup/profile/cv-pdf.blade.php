<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Claim Report</title>

		<style>
            .page-main {
                page-break-after: avoid;
                margin-left: 20px;
                margin-right: 20px;
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
                text-align: start;
            }

            .text-primary{
                color:#3B71CA;
            }
            
            .text-maroon{
                color: #800000;
            }

            .fs7{
                font-size: 15px;
                
            }

            h4, p{
                margin-left: 20px;
                padding-bottom:5px;
                margin-right: 20px;
            }

            p{
                margin-top: -20px;
            }

            .content {
                margin-top: 50px;
                width: 500px;
                padding: 20px;
                overflow: hidden;

                position: absolute;
                left: 50%;
                -ms-transform: translateX(-50%) translateY(-50%);
                -webkit-transform: translate(-50%,-50%);
                transform: translate(-50%,-50%);
            }

            .content img {
                margin-right: 15px;
                float: left;
                margin-top: 7px;
            }

            .content h3,
            .content p{
                margin-left: 15px;
                display: block;
            }

		</style>
	</head>
	<body>

        
            <div class="page-main">
                <div class="content">
                    @if ($staff->picture === "https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png")
                    <img src="https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png" width="110" height="110" alt="" >
                        
                    @else
                    <img src="{{public_path().'/storage/upload/profile/'.$staff->picture}}" width="auto" height="110" alt="" >

                    @endif
                    <h3 class="text-primary fs7" style="text-transform:uppercase; margin-bottom:-15px;" >{{$staff->name}}</h3>
                    <h3>
                        <span class="text-maroon fs7">{{$staff->address}}<br><br>
                        Tel: {{$staff->phone}} | Email: <span class="text-primary"><u>{{$staff->email}}</u></span>
                    </h3>
                </div>
               

                <p style="padding-top: 150px;"></p>
                <br>
                <h4>Skills Summary</h4>
                <p align="justify">{{$skill_summary}}</p>

                <h4>Qualifications</h4>
                <ul>
                    <li>
                        <p>{{$staff->qualification}} ({{$staff->university}}) ({{$staff->year}})</p>
                    </li>
                </ul>

                <h4>Professional Certificates</h4>
                <ul>
                    @foreach ($certs as $cert)
                    <li>
                        <p style="padding-bottom: 5px;">{{$cert->name}} </p>
                    </li>
                    @endforeach
                </ul>
                


            </div>

	</body>
</html>