<template>
   <div class="row match-height">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">School Survey: Studentsbysubjects</h4>
					
					<SurveyProgress :currentPage="6"></SurveyProgress>
					<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
					<div class="heading-elements">
						<ul class="list-inline mb-0">
							<li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
							<li><a data-action="reload"><i class="icon-reload"></i></a></li>
							<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
							<li><a data-action="close"><i class="icon-cross2"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="card-body collapse in">
					<div class="card-block">

						<form class="form" novalidate @submit.prevent="submitSurvey">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<label for="" Style="Font-weight:bold">NUMBER OF STUDENTS BY SUBJECT</label> <br>
                <span class="small"> Number of Students by Subject and trade in the current academic Year</span>
                <table border="1px" style=" border-collapse: collapse;" width="10%">
                    <tr>
                        <th width="200">
                            Subject and trade Area
                        </th>
                        <th>
                            Number of Students by Subject
                            <table border="1px" style=" border-collapse: collapse;" width="100%">
                                <tr>
                                    <th>
                                        JSS 1
                                    </th>
                                    <th>
                                        JSS 2
                                    </th>
                                    <th>
                                        JSS 3
                                    </th>
                                    <th>
                                        SSS 1
                                    </th>
                                    <th>
                                        SSS 2
                                    </th>
                                    <th>
                                        SSS 3
                                    </th>
                                </tr>
                            </table>
                        </th>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table border="1px" style="border-collapse: collapse;">
                                            <tr>
                                                <th width="120">
                                                    Male
                                                </th>
                                                <th width="120">
                                                    Female
                                                </th>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table border="1px" style="border-collapse: collapse;">
                                            <tr>
                                                <th width="120">
                                                    Male
                                                </th>
                                                <th width="120">
                                                    Female
                                                </th>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table border="1px" style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <th width="120">
                                                    Male
                                                </th>
                                                <th width="120">
                                                    Female
                                                </th>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table border="1px" style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <th width="120">
                                                    Male
                                                </th>
                                                <th width="120">
                                                    Female
                                                </th>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table border="1px" style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <th width="120">
                                                    Male
                                                </th>
                                                <th width="120">
                                                    Female
                                                </th>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table border="1px" style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <th width="120">
                                                    Male
                                                </th>
                                                <th width="120">
                                                    Female
                                                </th>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>English</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Mathematics</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Basic Science</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Biology</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Physics</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Chemistry</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Health Science</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Agric Science</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Home Economics</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Basic Technology</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Food and Nutrition</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>History</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Geography</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Economics</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Technical Drawing</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Business Studies</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>PHE</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>French</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Igbo</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Hausa</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Yoruba</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Arabic</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Electrical Installation</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Computer Operation</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Basic Computer Electronics</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Computer Programming</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Wood Metal Finishing</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Furniture Design and Construction</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Automechics</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Building Construction</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>General Woodwork</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Electrical/Electronics</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Clothing & Textile Design</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Upholstery</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Introduction to Building</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Walls, Floors and Ceiling Finishing</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Concreting</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Garment Construction</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Brick, Block Laying</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Refrigeration And Air Conditioning</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Fabrication And Welding</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Plumbing</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Other- please specify</th>
                        <td>
                            <table border="1px" style=" border-collapse: collapse;" width="0">
                                <tr>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="border-collapse: collapse;" width="0">
                                            <tr>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                                <td>
                                                    <input type="text" size="3" style="height: 30px; width: 59px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table><br><br>
									</div>
								</div>
							</div>

						</form>
							<div class="form-actions">
								<button type="submit" class="btn btn-success" 
								 @click="submitSurvey()">
									<i class="icon-check2"></i> Save
								</button>
								<button type="button" class="btn btn-warning mr-1" @click="previousStage()">
									&lt;&lt; Previous Stage
								</button>
								<button type="button" class="btn btn-primary mr-1" @click="nextStage()">
									Next Stage &gt;&gt;
								</button>
							</div>
							
					</div>
				</div>
			</div>
		</div>
		<FlashMessage></FlashMessage>

	</div>
	
</template>

<script>
	import SurveyProgress from '../../../Shared/School/SurveyProgress.vue';
    export default {
		components: {
			SurveyProgress
		},

		data(){
			return {
				surveyId : this.$route.params.surveyId,
				est_year: null,
				location_type: null,
				share_facilities: null,
				education_level: null,
				school_type: null,
				school_shift: null,
				multi_grade: null,
				facilities_sharing: null,
				ave_distance: null,
				spd: null,
				student_boarding: null,
				sbmc: null,
				pta: null,
				last_inspect: null,
				conditional_cash: null,
				receive_grant: null,
				security_gate: null,
				school_owner: null,
				long_distance: null,
				inspect_number: null,
				inspect_by: null,
				validationErrors: [],
				survey: null,
			}
		},
        mounted() {
			window.scrollTo(0, 0);
			this.getSurvey();
        },

		methods : {
			getSurvey() {
				this.$loading(true)
				axios.get(`/api/school/surveys/show?survey=${this.surveyId}`)
				.then((res) => {
					this.survey = res.data.data;
					let characteristics = this.survey.characteristic;
					if(characteristics != null) {
					
						this.data_exist = true;
						this.est_year = characteristics.est_year;
					}
					this.$loading(false)
				})
				.catch((error) => {
                    this.$loading(false);
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}

					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
							name: 'school-login',
							params: { return_url: return_url }
							});
					}

                    if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				})
			},
			
            submitSurvey() {
				let data = new FormData;
				data.append('inspect_by', this.inspect_by)
				
				this.$loading(true)

                axios.post('/api/school/surveys/create/characteristics', data)
				.then(response => {
					this.survey = response.data.data;
					this.$loading(false)
					this.flashMessage.success({
						title: 'Successful',
						message: 'Survey saved successfully',
						time: 15000,
						flashMessageStyle: {
							backgroundColor: 'linear-gradient(#e66465, #9198e5)'
						}
					});
					this.nextStage();
                })
				.catch(error => {
					this.$loading(false)
					if (!error.response) {
						this.$alert("You do not have internet access","Network Error","error");
						return ;
					}
					if (error.response.status == 422){
					this.validationErrors = error.response.data.errors;
					this.flashMessage.error({title: 'Validation Error', 
											message: 'There is an Error with the Data you supplied',
											time: 15000, });
					}
					if(error.response.status === 401){
						let return_url = window.location.pathname;
						this.$router.push({
							name: 'school-login',
							params: { return_url: return_url }
							});
					}
					if(error.response.status === 403){
						this.$alert("Sorry, you do not have the permission to perfrom this action","No Permission","error");
					}
				});
			},

			nextStage() {
				// if(this.survey.characteristic == null) {
				// 	this.$alert("Sorry, you have to complete this stage.","Not Allowed","error");
				// 	return;
				// }

				this.$router.push({
					name: 'pupilteacher-school-survey',
					params: { surveyId: this.surveyId }
                });
			},

			previousStage() {
				
				this.$router.push({
					name: 'facilities-school-survey',
					params: { surveyId: this.surveyId }
                });
			}
		}
    }
</script>

<style scoped>
.small_text {
	font-size: 0.8rem;
}
.move_down {
	padding-top: 20px;
}
th{
	text-align: center;
}
</style>