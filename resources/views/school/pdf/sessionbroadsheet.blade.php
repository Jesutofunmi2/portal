<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Sessional BroadSheet</title>
        
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
                        <th colspan="2" rowspan="6"><img class="logo" style="width: 100px; height: auto;" src="{{ env('BASE_PATH_2').$logo }}"></th>
                        <th colspan="{{ $subject_count + 3 }}">MINISTRY OF EDUCATION {{ strtoupper($state) }} STATE</th>
                    </tr>
                    <tr >  
                        <th colspan="{{ $subject_count + 3 }}">BROADSHEET FOR {{ $category }}</th>
                    </tr>
                    <tr>   
                        <th colspan="{{ $subject_count + 3 }}">SCHOOL: {{ strtoupper($school) }}</th>
                    </tr>
                    <tr>
                        <th colspan="{{ $subject_count + 3 }}">SCHOOL LGA: {{ strtoupper($lga) }}</th>
                    </tr>
                    <tr>
                        <th colspan="{{ $subject_count + 3 }}">CLASS: {{ $class_name }}</th>
                    </tr>
                    <tr>
                        <th colspan="{{ $subject_count + 3 }}">{{ $session }}/{{ $session + 1 }} ACADEMIC SESSION</th>
                    </tr>
                </tbody>
                <thead>
                    <tr>
                        <th class="sn-col">S/N</th>
                        <th class="name-col">Name</th>
                        @foreach ($subjects as $subj)
                            <th>{{ $subj->code }}</th>
                        @endforeach
                        <th>CumAvg</th>
                        <th>Passes</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $stud)
                    <tr>
                        <td class="center">{{ $loop->iteration }}</td>
                        <td style="text-transform:uppercase;">
                            {{ $stud->surname }}
                            {{ $stud->firstname }}
                            {{ $stud->middlename }}
                        </td>
                        @forelse ($subjects as $subj)
                            @if (isset($results['id_'.$stud->id]['subj_'.$subj->id]))
                                <td class="center">
                                    {{ $results['id_'.$stud->id]['subj_'.$subj->id] }}
                                </td>
                            @else
                                <td class="center"></td>
                            @endif
                        @endforeach
                        <td class="center">{{ $results['id_'.$stud->id]['avg'] }}</td>
                        <td class="center">{{ $results['id_'.$stud->id]['passes'] }}</td>
                        <td class="center">{{ $results['id_'.$stud->id]['grade'] ?? '' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>
