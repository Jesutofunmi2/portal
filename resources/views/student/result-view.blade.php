<style>
    body{
      background-repeat: repeat;
      background-size: contain;
      background-position: center;
      background-size: 8000px 8000px;
    }
 @page {
    margin: 0px;
  }
	table{
		border-collapse: collapse;
		width: 100%;
		max-width: 1200px;
	}		
	td, th{
		border: 1px solid;
		text-align: center;
		font-size:14px;
	}

.comment_box_header {
	width: 100%; 
	border-bottom: 1px solid #000; 
	padding-bottom: 4px; 
	margin-top: 0px;
	font-weight: bold;
}

.classtop_row_box {
	width: 100%; 
	border-bottom: 1px solid #000; 
	padding-bottom: 2px; 
	margin-top: 0px;
	font-size:14px;
}
</style>
<body style='background-image: url("{{$logo}}");'>
	@php
		$controller = App\Http\Controllers\Admins\Result\ViewResultController::class;
	@endphp
<table style="width: 750px; margin: 20px auto auto auto;">
	<tbody style="border: 1px solid">
		<tr>
			<td style="border: 0px">
				<table>
					<tr>
						<td style="width:15%">
							<table>
								<tr>
									<td style="border: 0px">
										<img src="{{env('BASE_PATH').$schoolData->logo}}" style="width: 100px;height: auto;">
									</td>
								</tr>
							</table>
						</td>
						<td style="text-align: left; vertical-align: top;width:50%;">
							<table>
								<tr>
									<td><strong>MINISTRY OF EDUCATION EKITI STATE</strong></td>
								</tr>
								<tr>
								    @if($class_name[0] == 'S' )
								        <td>REPORT CARD FOR SENIOR SECONDARY SCHOOLS</td>
								    @elseif($class_name[0] == 'J' )
									    <td>REPORT CARD FOR JUNIOR SECONDARY SCHOOLS</td>
									@else
									   <td>REPORT CARD FOR UNITARY SCHOOLS</td>
									@endif
								</tr>
								<tr>
									<td>SCHOOL LGA: {{strtoupper($school_lga)}}</td>
								</tr>
								<tr>
									<td>SCHOOL: {{strtoupper($schoolData->name)}}</td>
								</tr>
								<tr>
									<td>ADDRESS: {{strtoupper($schoolData->address)}}</td>
								</tr>	
								<tr>
									<td>{{strtoupper($term)}} TERM {{$session_full}} SESSION</td>
								</tr>
								<tr>	
									<td>NEXT SESSION BEGINS : {{ null !== $schoolData->next_session_date ? \Carbon\Carbon::parse($schoolData->next_session_date)->format('jS F, Y ') : 'Date Not Available'}}</td>
								</tr>							
							</table>
						</td>
						<td style="width:35%" valign="top">
								<div class="classtop_row_box">CLASS : {{strtoupper($class_name)}} {{strtoupper($classarm_name)}}</div>								
                                <div class="classtop_row_box">{{strtoupper($student->surname.' '.$student->firstname.' '.$student->middlename)}}</div>
                                <div class="classtop_row_box">DATE OF BIRTH: {{ null !== $student->dob ? \Carbon\Carbon::parse($student->dob)->format('jS F, Y ') : 'Date Not Available'}}</div>
                                <div class="classtop_row_box">SEX: {{strtoupper($student->gender)}}</div>
                                <div class="classtop_row_box">OSSI NUMBER: {{$student->regnum}}</div>
                                <div class="classtop_row_box">YEAR: {{$session_full}}</div>
                                <div class="classtop_row_box">HOUSE : {{strtoupper($house_name)}}</div>
						</td>
						
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border: 0px">
			<table>	
				<tr>
					<td style="border: 0px">
						<table>
							<tr>
								<th style="border: 0px">ATTENDANCE <br> <em>(Regularity and Punctuality)</em></th>
							</tr>
						</table>
					</td>
					
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td style="border: 0px">
				<table>
				<tr>
					<td style="width:85%">
						<table>
								<tr>
									<th></th>
									<th>School</th>
									<th>Sports</th>
									<th>Other Activities Organised</th>
								</tr>
								<tr>
									<th>No of times School Opened/Activities held</th>
									<td>124</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<th>No of times School Opened/Activities held</th>
									<td>124</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<th>No of times Present</th>
									<td>124</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<th>No of times Punctual</th>
									<td>124</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<th>No of times Absent</th>
									<td></td>
									<td></td>
									<td></td>
								</tr>
						</table>
					</td>
					<td style="width:15%">
						<table>
							<tr>
								<td style="border: 0px">
									<img src="{{env('BASE_PATH').$student->passport}}" style="width: 100px;height: 100px;">
								</td>
							</tr>
						</table>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<!-- Start Here-->
			<tr>
			<td style="border: 0px">
				<table>
					<tr>
						@if($term == 'Third')
						<th colspan="13">ACADEMIC PERFORMANCE</th>
						@else				
						<th colspan="10">ACADEMIC PERFORMANCE</th>
						@endif
					</tr>
					<tr>
						<th width="18%"></th>
						<th>CA Score</th>
						<th>Exam Score</th>
						<th>Wei. Avg.</th>
						@if($term == 'Third')
						<th width="7%">1st Term W. Avg</th>
						<th width="7%">2nd Term W. Avg</th>
						<th width="7%">1st-2nd Cum</th>
						@else						
						<th>Last Cum</th>
						@endif
						<th>Cum Avg</th>
						<th>Class Avg.</th>
						<th>Grade</th>
						<th>Remarks</th>
						<th width="9%">Teacher's Signature</th>
					</tr>

					@forelse($student_results as $student_result)

					@php
					$first_second_score = $second_third_score = 0;
					$first_second_cum_avg = $second_third_cum_avg = 0;
					$first_second_score_count = $second_third_score_count = 0;

					if($term == 'Third'){
						$first_term_subject_weighted_avg = $controller::getSubjectWeightedAvgScore($student->id, $student_result->classarm_id, $student_result->class_id, $student_result->subject_id, 'First', $student_result->session);
						$second_term_subject_weighted_avg = $controller::getSubjectWeightedAvgScore($student->id, $student_result->classarm_id, $student_result->class_id, $student_result->subject_id, 'Second', $student_result->session);

						$first_term_subject_weighted_avg_print = ($first_term_subject_weighted_avg > 0) ? number_format($first_term_subject_weighted_avg, 1): 0;

						$second_term_subject_weighted_avg_print = ($second_term_subject_weighted_avg > 0) ? number_format($second_term_subject_weighted_avg, 1): 0;

						$first_second_score = $first_term_subject_weighted_avg + $second_term_subject_weighted_avg;

						$first_second_score_count = ($first_term_subject_weighted_avg > 0) ? $first_second_score_count+1: $first_second_score_count; 

						$first_second_score_count = ($second_term_subject_weighted_avg > 0) ? $first_second_score_count+1: $first_second_score_count; 

						$second_third_score_count = ($second_term_subject_weighted_avg > 0) ? $second_third_score_count+1: $second_third_score_count; 

						$second_third_score_count = ($second_third_score_count < 1 &&$second_term_subject_weighted_avg < 1 && $first_term_subject_weighted_avg > 0) ? $second_third_score_count+1: $second_third_score_count; 
						
						$second_third_score_count = ($student_result->weighted_average > 0) ? $second_third_score_count+1: $second_third_score_count; 

						$first_second_cum_avg = ($first_second_score_count > 0) ? $first_second_score / $first_second_score_count: 0;

						$first_second_cum_avg_print = ($first_second_cum_avg > 0) ? number_format($first_second_cum_avg, 1): 0;

						$second_third_score = $first_second_cum_avg + $student_result->weighted_average;

						$second_third_cum_avg = ($second_third_score_count > 0) ? $second_third_score / $second_third_score_count: 0;

						$score_cum_avg = $second_third_cum_avg;
					}
					else{
						$score_cum_avg = $controller::getSubjectCummulative($student_result->classarm_id, $student_result->class_id, $student_result->subject_id,$student_result->term, $student_result->session, $student->id, true);
					}
					@endphp

					@if($class_name_char == "J")
					@php
					$class_type = 'JSS';
					@endphp
					@else
					@php
					$class_type = 'SSS';
					@endphp
					@endif 

					@php
					$get_school_id = ($school_id == 7) ? $school_id: 362;
					@endphp

					@php
					$score_cum_avg_tmp = ceil($score_cum_avg);
					$grade_data = $controller::getResultScoreGrade($score_cum_avg_tmp, $class_type, $get_school_id);
					@endphp

					@php
					$grade_name = (!empty($grade_data)) ? $grade_data->name: '';
					$grade_remark = (!empty($grade_data)) ? $grade_data->remark: '';
					@endphp

					@php
					$subject_name = strtoupper($controller::getSubjectNameBySubjectID($student_result->subject_id));
					$subject_name = limitLongText ($subject_name, 20, 1);
					@endphp
					
			   <tr>
				   <th>{{$subject_name}}</th>
				   <td>{{$student_result->ca_score}}</td>
				   <td>{{$student_result->exam_score}}</td>
				   <td>{{$student_result->weighted_average}}</td>
				   @if($term == 'Third')
					   <td>{{$first_term_subject_weighted_avg_print}}</td>
					   <td>{{$second_term_subject_weighted_avg_print}}</td>	
					   <td>{{$first_second_cum_avg_print}}</td>
				   @else
					   <td>{{$controller::getSubjectCummulative($student_result->classarm_id, $student_result->class_id, $student_result->subject_id,$student_result->term, $student_result->session, auth('student')->id(), false)}}</td>					
				   @endif
				   <td>{{$score_cum_avg}}</td>
				   <td>{{number_format($controller::getSubjectAverageScore($student_result->classarm_id, $student_result->class_id, $student_result->subject_id, $student_result->term, $student_result->session), 1)}}</td>
				   <td>
					{{$grade_name}}                       
				   </td>
				   <td>
					{{$grade_remark}}                       
				   </td>
				   <td>
				   @if(!empty($controller::getSubjectTeacherSignature($student_result->subject_id,$student_result->classarm_id,$student_result->session )))
				   <img src="{{env('BASE_PATH').$controller::getSubjectTeacherSignature($student_result->subject_id,$student_result->classarm_id,$student_result->session)}}" style="width:120px; max-width: 120px;"/>
				   @endif
				   </td>
			   </tr>
			   @empty
			   
			   @endforelse
			   
			   @if($term == 'Third')
			   <tr>
				   <th colspan="13">
					   <img src="{{env('BASE_PATH').$promotion_img}}" style="max-height: 80px;">
				   </th>
			   </tr>
			   @endif
			   <tr>
				   @if($term == 'Third')
				   <th colspan="13">
					   GRADES: A-Excellent; B-Good; C-Average; D-Below Average; E-Poor;
				   </th>
				   @else				
				   <th colspan="10">
					   GRADES: A-Excellent; B-Good; C-Average; D-Below Average; E-Poor;
				   </th>
				   @endif
			   </tr>
		   </table>
	   </td>
   </tr>
   <tr>
	   <td style="border: 0px">
		   <table>	
			   <tr>
				   <td valign="top">
					   <div class="comment_box_header">
						   Class Teacher's Comments & Signature
					   </div>
					   <div>
						   <em style="font-size:13px;">
						   {{$comment_teacher}}
						   </em>
						   <br>
						   @if(!empty($teacher_signature))
						   <p style="margin: 0px; margin-top: 7px;">
							   <img src="{{env('BASE_PATH').$teacher_signature}}" style="width:100px; max-width: 100px; max-height: 40px;"/>
						   </p>
						   @else
						   <p style="margin: 0px; margin-top: 7px;">.........................................</p>
						   <p style="margin: 0px; margin-top:-10px">Signature</p>
						   @endif
					   </div>
				   </td>
				   <td valign="top">
					   <div class="comment_box_header">
						   House Master's Comments & Signature
					   </div>
					   <div>
						   <em style="font-size:13px;">
						   {{$comment_house}}
						   </em>
						   <br>
						   @if(!empty($house_master_signature))
						   <p style="margin: 0px; margin-top: 7px;">
							   <img src="{{env('BASE_PATH').$house_master_signature}}" style="width:100px; max-width: 100px; max-height: 40px;"/>
						   </p>
						   @else
						   <p style="margin: 0px; margin-top: 7px;">.........................................</p>
						   <p style="margin: 0px; margin-top:-10px">Signature</p>
						   @endif
					   </div>
				   </td>
			   </tr>
			   <tr>
				   <td valign="top">
					   <div class="comment_box_header">
						   Guardian Counsellor's Comments & Signature
					   </div>
					   <div>
						   <em style="font-size:13px;">
						   {{$comment_guard}}
						   </em>
						   <br>
						   @if(!empty($counsellor_sign))
						   <p style="margin: 0px; margin-top: 7px">
							   <img src="{{env('BASE_PATH').$counsellor_sign}}" style="width:100px; max-width: 100px; max-height: 40px;"/>
						   </p>
						   @else
						   <p style="margin: 0px; margin-top: 7px">.........................................</p>
						   <p style="margin: 0px; margin-top:-10px">Signature</p>
						   @endif
					   </div>
				   </td>
				   <td valign="top">
					   <div class="comment_box_header">
						   Principal Comments & Signature
					   </div>
					   <div>
						   <em style="font-size:13px;">
						   {{$comment_principal}}
						   </em>
						   <br>
						   @if(!empty($principal_sign))
						   <p style="margin: 0px; margin-top: 7px">
							   <img src="{{env('BASE_PATH').$principal_sign}}" style="width:100px; max-width: 100px; max-height: 40px;"/>
						   </p>
						   @else
						   <p style="margin: 0px; margin-top: 7px">.........................................</p>
						   <p style="margin: 0px; margin-top:-10px">Signature</p>
						   @endif
					   </div>
				   </td>
			   </tr>
		   </table>
	   </td>
   </tr>
		<!--end here-->
	</tbody>
</table>

</body>