<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Third Term Result Summary</title>
        
        <style>
        
            body {
                background-image: url('https://odsgmoest.org.ng/eportal/public/images/logo-bg.png');
                background-attachment:fixed;
                font-family: Verdana, sans-serif;
                font-size: 1em;
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
                font-size: 0.92em;
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
    <body>
        <div class="page">
            <table>
                <tbody>
                    <tr>
                        <th colspan="1" rowspan="5"><img class="logo" style="width: 100px; height: auto;" src="{{ env('BASE_PATH_2').$logo }}"></th>
                        <th colspan="4">MINISTRY OF EDUCATION {{ strtoupper($state) }} STATE</th>
                    </tr>
                    <tr>   
                        <th colspan="5">SCHOOL: {{ strtoupper($school) }}</th>
                    </tr>
                    <tr>
                        <th colspan="5">SCHOOL LGA: {{ strtoupper($lga) }}</th>
                    </tr>
                    <tr>
                        <th colspan="5">CLASS: {{ $class_name }} THIRD TERM RESULT SUMMARY</th>
                    </tr>
                    <tr>
                        <th colspan="5">{{ $session }}/{{ $session + 1 }} ACADEMIC SESSION</th>
                    </tr>
                </tbody>
                <thead>
                    <tr style="border: 1px solid;">
						<th>S/N</th>
						<th>Student's Fullname</th>
						<th>OSSI Number</th>
						<th>Gender</th>
                        <th>Status</th>
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
                            <td style="border: 1px solid;">{{ $status_text }}</td>
						</tr>
						@php
							$sn++;
						@endphp
					@endforeach
                </tbody>
            </table>
            <p>
            <table>
                <tr style="border: 1px solid;">
                    <th>RESULT SUMMARY</th>
                </tr>
                <tr style="border: 1px solid;">
                    <td>Promoted Student</td>
                    <td>{{ $promoted_count }}</td>
                </tr>
                <tr style="border: 1px solid;">
                    <td>To Repeat Student</td>
                    <td>{{ $to_repeat_count }}</td>
                </tr>
                <tr style="border: 1px solid;">
                    <td>Withdraw Student</td>
                    <td>{{ $withdraw_count }}</td>
                </tr>
                <tr style="border: 1px solid;">
                    <td>Promoted on trial Student</td>
                    <td>{{ $promoted_on_trial_count }}</td>
                </tr>
                <tr style="border: 1px solid;">
                    <td>No Result Stamp</td>
                    <td>{{ $no_stamp_count }}</td>
                </tr>
                <tr style="border: 1px solid;">
                    <td>No Result Available</td>
                    <td>{{ $no_result_count }}</td>
                </tr>
                <tr style="border: 1px solid;">
                    <td>Total Student</td>
                    <td>{{ $total_students }}</td>
                </tr>
        </div>
    </body>
</html>
