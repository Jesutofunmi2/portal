<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Eligible Student BroadSheet</title>
        
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
    <body >
        <div class="page">
            <table>
                <tbody>
                    <tr>
                        <th colspan="2" rowspan="5"><img class="logo" style="width: 100px; height: auto;" src="{{ $schoolLogo }}"></th>
                        <th colspan="8">{{ strtoupper($state) }} STATE MINISTRY OF EDUCATION, SCIENCE AND TECHNOLOGY</th>
                    </tr>
                    <tr >  
                        <th colspan="8">LIST OF ELIGIBLE STUDENTS FOR EXAMINATION</th>
                    </tr>
                    <tr>   
                        <th colspan="8">SCHOOL: {{ strtoupper($schoolData->name) }}</th>
                    </tr>
                    <tr>
                        <th colspan="8">SCHOOL LGA: {{ strtoupper($school_lga) }}</th>
                    </tr>
                    <tr>
                        <th colspan="2"></th>
                        <th colspan="3">PAYMENT HISTORY</th>
                        <th colspan="2">ADMISSION STATUS</th>
                        <th colspan="1"></th>
                    </tr>
                   
                </tbody>
                <thead>
                    <tr>
                        <th class="sn-col">S/N</th>
                        <th class="name-col">STUDENT NAME</th>
                        <th>OSSI NO</th>
                        <th>PRESENT CLASS</th>
                        <th>{{ $sessions['third'] }}</th>
                        <th>{{ $sessions['second'] }}</th>
                        <th>{{ $sessions['first'] }}</th>
                        <th>MODE OF ADMISSION</th>
                        <th>ADMISSION YEAR</th>
                        <th>SCHOOL REMARK</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $data)
                    <tr>
                        <td class="center">{{ $loop->iteration }}</td>
                        <td>
                            {{ $data['fullname'] }}
                        </td>
                        <td>
                            {{ $data['regnum'] }}
                        </td>
                        <td>
                            {{ $data['class'] }}
                        </td>
                        <td>
                            {{ $data['third_payment'] }}
                        </td>
                        <td>
                            {{ $data['second_payment'] }}
                        </td>
                        <td>
                            {{ $data['first_payment'] }}
                        </td>
                        <td>
                            {{ $data['admission_mode'] }}
                        </td>
                        <td>
                            {{ $data['reg_date'] }}
                        </td>
                        <td>
                            {{ $data['remark'] }}
                        </td>
                    </tr>
                    @endforeach

                    <tr>
                        <td colspan="10" align="center">
                            Payment Summary
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            Total Debt for {{ $sessions['third'] }}: NGN{{ $third_session_debt }}
                        </td>
                        <td colspan="3">
                            Total Paid for {{ $sessions['third'] }}: NGN{{ $third_session_paid }}
                        </td>
                        <td colspan="4">
                            Overall Total for {{ $sessions['third'] }}: NGN{{ $third_session_total }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            Total Debt for {{ $sessions['second'] }}: NGN{{ $second_session_debt }}
                        </td>
                        <td colspan="3">
                            Total Paid for {{ $sessions['second'] }}: NGN{{ $second_session_paid }}
                        </td>
                        <td colspan="4">
                            Overall Total for {{ $sessions['second'] }}: NGN{{ $second_session_total }}
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3">
                            Total Debt for {{ $sessions['first'] }}: NGN{{ $first_session_debt }}
                        </td>
                        <td colspan="3">
                            Total Paid for {{ $sessions['first'] }}: NGN{{ $first_session_paid }}
                        </td>
                        <td colspan="4">
                            Overall Total for {{ $sessions['first'] }}: NGN{{ $first_session_total }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            Total Debt: NGN{{ $debt }}
                        </td>
                        <td colspan="3">
                            Total Paid: NGN{{ $paid }}
                        </td>
                        <td colspan="4">
                            Overall Total: NGN{{ $total }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>

</html>