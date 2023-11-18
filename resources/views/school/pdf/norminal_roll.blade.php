<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Norminal Roll</title>
        
        <style>
            body {
                background-image: url('https://odsgmoest.org.ng/eportal/public/images/logo-bg.png');
                background-attachment:fixed;
                font-family: Verdana, sans-serif;
                font-size: 0.96em;
                margin-left: 0;
                margin-right: 0;
            }
            .page {
                width: 100%;
                margin-left: 0;
                margin-right: 0;
            }
            table, tr, th, td {
                border: 0.3mm solid #000;
                border-collapse: collapse;
                border-spacing: 0;
                font-size: 0.96em;
            }
            table {
                margin-left: auto;
                margin-right: auto;
                width: 100%;
            }
            .center {
                text-align: center;
            }
            .sn-col {
                width: 1mm;
            }
            .name-col {
                width: 55mm;
            }
            .logo {
                height: 45mm;
            }
        </style>
    </head>
    <body >
        <div class="page">
            <table>
                <tbody>
                    <tr>
                        <td colspan="6">
                            <table>
                                <tr>
                                    <td style="width:20%" colspan="6">
                                        <img src="{{$schoolLogo}}" style="width: 100px; height: auto;">
                                    </td>
                                    <td style="text-align: center; vertical-align: top; width:80%;">
                                        <table>
                                            <tr>
                                                <td style="text-align: center; border: 1px solid;">
                                                    <strong> MINISTRY OF EDUCATION, SCIENCE AND TECHNOLOGY, ONDO STATE </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center; border: 1px solid;">NORMINAL ROLL FOR {{strtoupper($schoolData->name)}}</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center; border: 1px solid;">{{strtoupper($school_lga)}}</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center; border: 1px solid;">ADDRESS: {{strtoupper($schoolData->address)}}</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center; border: 1px solid;">TEL: {{strtoupper($schoolData->phone)}}</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center; border: 1px solid;">CLASS: {{strtoupper($class)}} ({{ strtoupper($class_arm) }})</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center; border: 1px solid;">SESSION: {{strtoupper($session)}}  {{strtoupper($term)}} TERM</td>
                                            </tr>
                                                                    
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>

                    </tr>
                </tbody>
                <thead>
                    <tr style="border: 1px solid;">
						<th>S/N</th>
						<th>Student's Fullname</th>
						<th>OSSI Number</th>
						<th>Gender</th>
						<th>Parent Name</th>
						<th>Parent Phone</th>
					</tr>
                </thead>
                <tbody>
                    @php
						$sn = 1;
					@endphp
					@foreach ($students as $student)
						<tr>
							<td style="border: 1px solid;">{{ $sn }}</td>
							<td style="border: 1px solid;">{{ strtoupper($student->surname) }} {{ strtoupper($student->firstname) }} {{ strtoupper($student->middlename) }}</td>
							<td style="border: 1px solid;">{{ $student->regnum }}</td>
							<td style="border: 1px solid;">{{ strtoupper($student->gender) }}</td>
							<td style="border: 1px solid;">{{ strtoupper($student->parent_fullname) }}</td>
							<td style="border: 1px solid;">{{ $student->parent_phone }}</td>
						</tr>
						@php
							$sn++;
						@endphp
					@endforeach
                </tbody>
            </table>
        </div>
    </body>

</html>