<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>School Admins</title>
        
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
                    <tr style="border: 0px;">
                        <td colspan="6" style="text-align: center; border: 1px solid;">
                            <strong> MINISTRY OF EDUCATION, SCIENCE AND TECHNOLOGY, ONDO STATE </strong>
                        </td>
                    </tr>
                    <tr style="margin-bottom:10px;">
                        <td colspan="6"> &nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align: center; border: 1px solid;">
                            <strong> LIST OF AEOZEO ADMINS FOR {{strtoupper($lga->name)}} LGA </strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1">
                            S/N
                        </td>
                        <td colspan="3">
                            Name
                        </td>
                        <td colspan="2">
                           Phone
                        </td>
                    </tr>
                   @if (count($aeozeos))
                        @foreach ($aeozeos as $aeozeo)
                            <tr>
                                <td colspan="1">
                                   {{ $loop->iteration }}
                                </td>
                                <td colspan="3">
                                    {{ $aeozeo['name'] }}
                                </td>
                                <td colspan="2">
                                    {{ $aeozeo['phone'] }}
                                </td>
                            </tr>
                        @endforeach
                   @else
                    <tr>
                        <td colspan="6"> No AEOZEO Admin Available for this LGA</td>
                    </tr>
                   @endif
                    <tr style="margin-bottom:10px;">
                        <td colspan="6"> &nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align: center; border: 1px solid;">
                            <strong> LIST OF SCHOOL ADMINS FOR {{strtoupper($lga->name)}} LGA </strong>
                        </td>
                    </tr>
               
                    <tr style="border: 1px solid;">
						<th>S/N</th>
						<th>School Name</th>
                        <th>School Phone</th>
						<th>School Address</th>
						<th>Principal Name</th>
                        <th>School Admins</th>
					</tr>
                <tbody>
                    @php
						$sn = 1;
					@endphp
					@foreach ($schools as $school)
						<tr>
							<td style="border: 1px solid;">{{ $sn }}</td>
							<td style="border: 1px solid;">{{ strtoupper($school['school_name']) }} </td>
							<td style="border: 1px solid;">{{ $school['phone'] }}</td>
							<td style="border: 1px solid;">{{ $school['address'] }}</td>
							<td style="border: 1px solid;">{{ strtoupper($school['principal_name']) }}</td>
							<td style="border: 1px solid;">
                                @foreach ($school['admins'] as $admin)
                                <div style="margin:5px;" v-for="admin, index in school.admins" :key="index">
                                    <span>{{ $admin['name'] }}</span> | <span>{{ $admin['phone'] }}</span> <hr />
                                </div>
                                @endforeach
                            </td>
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