<style>
    body{
      background-repeat: no-repeat;
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
		border: 0px solid;
		text-align: left;
		font-size:14px;
	}

.comment_box_header {
	width: 100%; 
	padding-bottom: 4px; 
	margin-top: 0px;
}

.classtop_row_box {
	width: 100%; 
	padding-bottom: 2px; 
	margin-top: 0px;
	font-size:14px;
}
</style>
<body style="width: 750px; border: 2px solid; margin: 15px auto auto auto;">
	
	@php
		$controller = App\Http\Controllers\Admins\Result\ViewResultController::class;

		function getResultScoreGrade($mark, $grades){
			foreach ($grades as $grade) {
                    if ($mark >= $grade->score_from && $mark <= $grade->score_to) {
                        return $grade;
                    }
                }

			return false;
    	}
	@endphp
<table style="background-image: url('{{$schoolLogoo}}');">
	<tbody>
		<tr>
			<td style="text-align: center;">
				<strong> MINISTRY OF EDUCATION, SCIENCE AND TECHNOLOGY, ONDO STATE </strong>
			</td>
		</tr>
		<tr>
			<td style="border-bottom: 1px solid;">
				<table>
					<tr>
						<td style="width:14%">
							<img src="{{$schoolLogo}}" style="width: 100px;height: auto;">
						</td>
						<td style="text-align: left; vertical-align: top; width:45%;">
							<table>
								<tr>
								    @if($class_name[0] == 'S' )
								        <td>REPORT SHEET FOR SENIOR SECONDARY SCHOOLS</td>
								    @elseif($class_name[0] == 'J' )
									    <td>REPORT SHEET FOR JUNIOR SECONDARY SCHOOLS</td>
									@else
									   <td>REPORT SHEET FOR UNITARY SCHOOLS</td>
									@endif
								</tr>
								<tr>
									<td>{{strtoupper($school_lga)}}</td>
								</tr>
								<tr>
									<td>{{strtoupper($schoolData->name)}}</td>
								</tr>
								<tr>
									<td>ADDRESS: {{strtoupper($schoolData->address)}}</td>
								</tr>
								<tr>
									<td>TEL: {{strtoupper($schoolData->phone)}}</td>
								</tr>
								<tr>
									<td>REPORT FOR {{strtoupper($term)}} TERM {{$session_full}} SESSION</td>
								</tr>
								<tr>	
									<td>NEXT SESSION BEGINS : {{ null !== $schoolData->next_session_date ? \Carbon\Carbon::parse($schoolData->next_session_date)->format('jS F, Y ') : 'N/A'}}</td>
								</tr>							
							</table>
						</td>
						<td style="width:27%" valign="top">
								<div class="classtop_row_box">CLASS : {{strtoupper($class_name)}} {{strtoupper($classarm_name)}}</div>								
                                <div class="classtop_row_box">{{strtoupper($student->surname.' '.$student->firstname.' '.$student->middlename)}}</div>
                                <div class="classtop_row_box">DATE OF BIRTH: {{ null !== $student->dob ? \Carbon\Carbon::parse($student->dob)->format('jS F, Y ') : 'N/A'}}</div>
                                <div class="classtop_row_box">SEX: {{strtoupper($student->gender)}}</div>
                                <div class="classtop_row_box">OSSI NUMBER: {{$student->regnum}}</div>
                                <div class="classtop_row_box">YEAR: {{$session_full}}</div>
                                <div class="classtop_row_box">HOUSE : {{strtoupper($house_name)}}</div>
						</td>
						<td style="width:14%">
							<img src="{{env('BASE_PATH_2').str_replace(' ', '%20', $student->passport)}}" style="width: 100px;height: 100px;">
						</td>
					</tr>
				</table>
			</td>
		</tr>
		
		<!-- Start Here-->
		<tr>
			<td style="padding:10px;">
				<table>
					<tr>
						@if($term == 'Third')
						<th colspan="14" style="text-align: center; padding-top:15px;">ACADEMIC PERFORMANCE</th>
						@else				
						<th colspan="12" style="text-align: center; padding-top:15px;">ACADEMIC PERFORMANCE</th>
						@endif
					</tr>
					<tr style="border: 1px solid">
						<th width="18%" style="border: 1px solid"></th>
						<th ali style="border: 1px solid; text-align: center;">CA 1</th>
						<th style="border: 1px solid; text-align: center;">CA 2</th>
						<th style="border: 1px solid; text-align: center;">Exam Score</th>
						<th style="border: 1px solid; text-align: center;">Total Score</th>
						@if($term == 'Third')
						<th width="7%" style="border: 1px solid; text-align: center;">1st Term W. Avg</th>
						<th width="7%" style="border: 1px solid; text-align: center;">2nd Term W. Avg</th>
						<th width="7%" style="border: 1px solid; text-align: center;">1st-2nd Cum</th>
						@else						
						<th style="border: 1px solid">Last Cum</th>
						@endif
						<th style="border: 1px solid; text-align: center;">Cum Avg</th>
						<th style="border: 1px solid; text-align: center;">Class Avg.</th>
						<th style="border: 1px solid; text-align: center;">Class Subj. Position</th>
						<th style="border: 1px solid; text-align: center;">Grade</th>
						<th style="border: 1px solid; text-align: center;">Remarks</th>
						<th style="border: 1px solid; text-align: center;" width="9%" >Subj. Teacher's Sign</th>
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

					@php
					$score_cum_avg_tmp = ceil($score_cum_avg);
					$grade_data = getResultScoreGrade($score_cum_avg_tmp, $grades);
					
					$grade_name = (!empty($grade_data)) ? $grade_data->grade: '';
					$grade_remark = (!empty($grade_data)) ? $grade_data->remark: '';
					@endphp

					@php
					$subject_name = strtoupper($controller::getSubjectNameBySubjectID($student_result->subject_id));
					$subject_name = $controller::limitLongText ($subject_name, 20, 1);
					@endphp
					
			   <tr style="border: 1px solid">
				   <th style="border: 1px solid">{{$subject_name}}</th>
				   <td style="border: 1px solid; text-align: center;">{{$student_result->ca_score}}</td>
				   <td style="border: 1px solid; text-align: center;">{{$student_result->ca2_score}}</td>
				   <td style="border: 1px solid; text-align: center;">{{$student_result->exam_score}}</td>
				   <td style="border: 1px solid; text-align: center;">{{$student_result->weighted_average}}</td>
				   @if($term == 'Third')
					   <td style="border: 1px solid; text-align: center;">{{$first_term_subject_weighted_avg_print}}</td>
					   <td style="border: 1px solid; text-align: center;">{{$second_term_subject_weighted_avg_print}}</td>	
					   <td style="border: 1px solid; text-align: center;">{{$first_second_cum_avg_print}}</td>
				   @else
					   <td style="border: 1px solid; text-align: center;">{{$controller::getSubjectCummulative($student_result->classarm_id, $student_result->class_id, $student_result->subject_id,$student_result->term, $student_result->session, $student->id, false)}}</td>					
				   @endif
				   <td style="border: 1px solid; text-align: center;">{{$score_cum_avg}}</td>
				   <td style="border: 1px solid; text-align: center;">{{number_format($controller::getSubjectAverageScore($student_result->classarm_id, $student_result->class_id, $student_result->subject_id, $student_result->term, $student_result->session), 1)}}</td>
				   <td style="border: 1px solid; text-align: center;">
					{{$controller::getClassSubjectPosition($student_result->classarm_id, $student_result->class_id, $student_result->subject_id, $student_result->term, $student_result->session, $student->id)}}                       
				   </td>
				   <td style="border: 1px solid; text-align: center;">
					{{$grade_name}}                       
				   </td>
				   <td style="border: 1px solid; font-size:0.8em; text-align: center;">
					{{$grade_remark}}                       
				   </td>
				   <td style="border: 1px solid; font-size:0.8em; text-transform: capitalize; text-align: center;">
					@if(!empty($controller::getSubjectTeacherSignature($student_result->subject_id,$student_result->classarm_id)))
						<img src="{{ $controller::getSubjectTeacherSignature($student_result->subject_id,$student_result->classarm_id) }}" style="width:75px; max-width: 75px;" />
					@endif
				   </td>
			   </tr>
			   @empty
			   
			   @endforelse
			   
			   
			   <tr>
				   @if($term == 'Third')
				   <th colspan="14" style="text-align:center; padding:5px;">
					   GRADES: A-Excellent; B-Good; C-Average; D-Below Average; E-Poor;
				   </th>
				   @else				
				   <th colspan="12" style="text-align:center; padding:5px;">
					   GRADES: A-Excellent; B-Good; C-Average; D-Below Average; E-Poor;
				   </th>
				   @endif
			   </tr>
			   @if($term == 'Third')
			   <tr>
				   <th colspan="13">
					   <img src="{{env('BASE_PATH_2').$promotion_img}}" style="max-height: 80px;">
				   </th>
			   </tr>
			   @endif
		   </table>
	   </td>
   </tr>

   <tr>
		<td style="padding-left:10px;">
			<table>	
				<tr>
					<td width="45%">
						<table>
							<tr>
								<th style="border: 0px; text-align: center;">ATTENDANCE <br> <span style="font-size:0.8em;"><em>(Regularity and Punctuality)</em></span></th>
							</tr>
						</table>
					</td>
					<td style="border: 0px; text-align: center;" width="55%">
						<strong> Total Number of Students: {{ $total_students }}</strong>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px;">
			<table>
				<tr>
					<td width="45%">
						<table >
								<tr>
									<td style="border: 1px solid"></td>
									<td style="border: 1px solid">School</td>
								</tr>
								<tr>
									<td style="border: 1px solid">No of times School Opened/Activities held</td>
									<td style="border: 1px solid">124</td>
								</tr>
								<tr>
									<td style="border: 1px solid">No of times School Opened/Activities held</td>
									<td style="border: 1px solid">124</td>
								</tr>
								<tr>
									<td style="border: 1px solid">No of times Present</td>
									<td style="border: 1px solid">124</td>
								</tr>
								<tr>
									<td style="border: 1px solid">No of times Absent</td>
									<td style="border: 1px solid"></td>
								</tr>
								<tr>
									<td colspan="2" style="border: 1px solid">&nbsp; </td>
								</tr>
						</table>
					</td>
					<td width="55%">
						
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td style="padding:0 10px 0 10px;">
			<table>
				<td style="border: 1px solid;" width="55%">
					<table>	
			   			<tr>
							<td  valign="top" style="text-align: center; border-bottom: 1px solid" >
								<div class="comment_box_header">
									Class Teacher's Comments & Signature
								</div>
								<div>
									<em style="font-size:13px;">
									{{$comment_teacher}}
									</em>
									<br>
									@if(!empty($teacher_signature))
									<p style="margin: 0px; margin-top: 5px;">
										<img src="{{env('BASE_PATH_2').$teacher_signature}}" style="width:100px; max-width: 100px; max-height: 40px;"/>
									</p>
									@else
									<p style="margin: 0px; margin-top: 5px;">.........................................</p>
									<p style="margin: 0px; margin-top:-10px">Signature</p>
									@endif
								</div>
							</td>
				   
						</tr>
						<tr>
							<td valign="top" style="text-align: center;">
								<div class="comment_box_header">
									Principal Comments & Signature
								</div>
								<div>
									<em style="font-size:13px;">
									{{$comment_principal}}
									</em>
									<br>
									@if(!empty($principal_sign))
									<p style="margin: 0px; margin-top: 5px">
										<img src="{{env('BASE_PATH_2').str_replace(' ', '%20', $principal_sign)}}" style="width:100px; max-width: 100px; max-height: 40px;"/>
									</p>
									@else
									<p style="margin: 0px; margin-top: 5px">.........................................</p>
									<p style="margin: 0px; margin-top:-10px">Signature</p>
									@endif
								</div>
							</td>
						</tr>
					</table>
				</td>
				<td style="font-size:0.8em;" width="45%">
					 <table>	
						<tr>
							<td colspan='6'  valign="top" style="border: 1px solid; font-size:1em;">
									Student's Skill and Behavior
							</td>
						</tr>
						<tr>
							<td valign="top" width="width:40%" style="border: 1px solid;">ASSESSMENT &gt;&gt;&gt;</td>
							<td valign="top" width="width:12%" style="border: 1px solid;">1 <br> <span style="font-size:0.9em;">(Fair)</span></td>
							<td valign="top" width="width:12%" style="border: 1px solid;">2 <br> <span style="font-size:0.9em;">(Pass)</span></td>
							<td valign="top" width="width:12%" style="border: 1px solid;">3 <br> <span style="font-size:0.9em;">(Good)</span></td>
							<td valign="top" width="width:12%" style="border: 1px solid;">4 <br> <span style="font-size:0.9em;">(Very Good)</span></td>
							<td valign="top" width="width:12%" style="border: 1px solid;">5 <br> <span style="font-size:0.9em;">(Excellent)</span></td>
						</tr>
						<tr>
							<td valign="top" style="border: 1px solid;">ATTENDANCE</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->punctuality <= 1)
									<span>E</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->punctuality == 2)
									<span>D</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->punctuality == 3)
									<span>C</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->punctuality == 4)
									<span>B</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->punctuality == 5)
									<span>A</span>
								@endif
							</td>
						</tr>
						<tr>
							<td valign="top" style="border: 1px solid;">ATTENTIVENESS</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->attentive_class <= 1)
									<span>E</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->attentive_class == 2)
									<span>D</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->attentive_class == 3)
									<span>C</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->attentive_class == 4)
									<span>B</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->attentive_class == 5)
									<span>A</span>
								@endif
							</td>
						</tr>
						<tr>
							<td valign="top" style="border: 1px solid;">HONESTY</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->self_control <= 1)
									<span>E</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->self_control == 2)
									<span>D</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->self_control == 3)
									<span>C</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->self_control == 4)
									<span>B</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->self_control == 5)
									<span>A</span>
								@endif
							</td>
						</tr>
						<tr>
							<td valign="top" style="border: 1px solid;">INDUSTRY</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->politeness <= 1)
									<span>E</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->politeness == 2)
									<span>D</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->politeness == 3)
									<span>C</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->politeness == 4)
									<span>B</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->politeness == 5)
									<span>A</span>
								@endif
							</td>
						</tr>
						<tr>
							<td valign="top" style="border: 1px solid;">NEATNESS</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->neatness <= 1)
									<span>E</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->neatness == 2)
									<span>D</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->neatness == 3)
									<span>C</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->neatness == 4)
									<span>B</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->neatness == 5)
									<span>A</span>
								@endif
							</td>
						</tr>
						<tr>
							<td valign="top" style="border: 1px solid;">RELATIONSHIP WITH OTHERS</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->relationship_others <= 1)
									<span>E</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->relationship_others == 2)
									<span>D</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->relationship_others == 3)
									<span>C</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->relationship_others == 4)
									<span>B</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->relationship_others == 5)
									<span>A</span>
								@endif
							</td>
						</tr>
						<tr>
							<td valign="top" style="border: 1px solid;">GAMES & SPORTS</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->attentive_class <= 1)
									<span>E</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->attentive_class == 2)
									<span>D</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->attentive_class == 3)
									<span>C</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->attentive_class == 4)
									<span>B</span>
								@endif
							</td>
							<td valign="top" style="border: 1px solid;">
								@if ($student_character_development && $student_character_development->attentive_class == 5)
									<span>A</span>
								@endif
							</td>
						</tr>
		   			</table>
				</td>
			</table>
		</td>
   </tr>
	
		<!--end here-->
	</tbody>
</table>

</body>
	
@if ($print_type == 'html')
	<script>
		print();
	</script>
	@php 
		dd();  
	@endphp
@endif

