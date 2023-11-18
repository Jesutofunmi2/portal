<template>
    <div class="row match-height">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="basic-layout-tooltip">
                        School Survey: Enrollment
                    </h4>

                    <SurveyProgress :currentPage="2"></SurveyProgress>
                    <a class="heading-elements-toggle"
                        ><i class="icon-ellipsis font-medium-3"></i
                    ></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <a data-action="collapse"
                                    ><i class="icon-minus4"></i
                                ></a>
                            </li>
                            <li>
                                <a data-action="reload"
                                    ><i class="icon-reload"></i
                                ></a>
                            </li>
                            <li>
                                <a data-action="expand"
                                    ><i class="icon-expand2"></i
                                ></a>
                            </li>
                            <li>
                                <a data-action="close"
                                    ><i class="icon-cross2"></i
                                ></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block">
                        <form
                            class="form"
                            novalidate
                            @submit.prevent="submitSurvey"
                        >
                            <div class="form-body">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="issueinput48">
                                            Number of Students with Birth Certificates in SSS 1
                                            </label>
                                       <!--Section 1-->
<table border="1px" style=" border-collapse: collapse;" width="100%">
    <tr>
        <th width="150">
            How many Students were enrolled with Birth certificates
        </th>
     
        <th width="150">
            <br>
            J S S 1
            <br> <br>
            <table border="1px" width="100%">
                <tr>
                    <td width="49%">
                        Male
                    </td>
                    <td width="49%">
                        Female
                    </td>
                </tr>
            </table>
        </th>

        <th width="150">
            <br>
            S S S 1
            <br> <br>
            <table border="1px" width="100%">
                <tr>
                    <td width="49%">
                        Male
                    </td>
                    <td width="49%">
                        Female
                    </td>
                </tr>
            </table>
        </th>
    </tr>
    
    <tr>
        <th>
            NPopC
        </th>
        <td>
            <table width="100%">
                <tr>
                    <td width="49%">
                        <input type="text" size="12"  style="height: 30px; width: 90%;">
                    </td>
                    <td width="49%">
                        <input type="text" size="12" style="height: 30px; width: 90%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table width="100%">
                <tr>
                    <td width="49%">
                        <input type="text" size="12"  style="height: 30px; width: 90%;">
                    </td>
                    <td width="49%">
                        <input type="text" size="12" style="height: 30px; width: 90%;">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            Others
        </th>
        <td>
            <table width="100%">
                <tr>
                    <td width="49%">
                        <input type="text" size="12" style="height: 30px; width: 90%;">
                    </td>
                    <td width="49%">
                        <input type="text" size="12" style="height: 30px; width: 90%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table width="100%">
                <tr>
                    <td width="49%">
                        <input type="text" size="12"  style="height: 30px; width: 90%;">
                    </td>
                    <td width="49%">
                        <input type="text" size="12" style="height: 30px; width: 90%;">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
        </div>
    </div>
</div>

<!--section 3-->
<div class="row">
<div class="form-group col-md-12">
    <label for="issueinput48">
    New entrants in JSS 1
</label>
    <!--Table 3--->
    <table border="1px" style=" border-collapse: collapse;">
    <tr>
        <td>

        </td>
        <th width="50%">
            New entrants in JSS1
        </th>
    </tr>
    <tr>
        <th>
            Student age 
        </th>
        <th>
            <table border="1px" width="100%" style="border-collapse: collapse;">
                <tr>
                    <th width="50%">
                        Male
                    </th>
                    <th width="50%">
                        Female
                    </th>
                </tr>
            </table>
        </th>
    </tr>
    <tr>
        <th>
            Below 12 years
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                </tr>
            </table>
        </th>
    </tr>
    <tr>
        <th>
            12 Years
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                </tr>
            </table>
        </th>
    </tr>
    <tr>
        <th>
            13 Years
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                </tr>
            </table>
        </th>
    </tr>
    <tr>
        <th>
            14 Years
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                </tr>
            </table>
        </th>
    </tr>
    <tr>
        <th>
            Above 14 years
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                </tr>
            </table>
        </th>
    </tr>
    <tr>
        <th>
            Total
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                </tr>
            </table>
        </th>
    </tr>
</table>
</div>
</div>

<!--section 4-->
<div class="row">
<div class="form-group col-md-12">
    <label for="issueinput48">
    Junior Secondary Enrolment by age for the current school year
</label>
    <!--Table 4--->
    <table border="1px" style=" border-collapse: collapse;">
    <tr>
        <th width="170">
            
        </th>
        <th>
            JSS 1
        </th>
        <th>
            JSS 2
        </th>
        <th>
            JSS 3
        </th>
    </tr>
    <tr>
        <th>
            No. of Streams
        </th>
        <td>
            <input type="text" size="11" style="height: 20; width: 94%;">
        </td>
        <td>
            <input type="text"  size="11" style="height: 20; width: 94%;">
        </td>
        <td>
            <input type="text" size="11" style="height: 20; width: 94%;">
        </td>
    </tr>
    <tr>
        <th>
            NO. of streams with Multigrade Teaching
        </th>
        <td>
            <input type="text" size="11" style="height: 20; width: 94%;">
        </td>
        <td>
            <input type="text" size="11" style="height: 20; width: 94%;">
        </td>
        <td>
            <input type="text" size="11" style="height: 20; width: 94%;">
        </td>
    </tr>
    <tr>
        <th>
            Ages
        </th>
        <td>
            <table border="1px" style=" border-collapse: collapse;">
                <tr>
                    <th width="67">
                        Male
                    </th>
                    <th width="67">
                        Female
                    </th>
                </tr>
            </table>
        </td>
        <td>
            <table border="1px" style=" border-collapse: collapse;">
                <tr>
                    <th width="67">
                        Male
                    </th>
                    <th width="67">
                        Female
                    </th>
                </tr>
            </table>
        </td>
        <td>
            <table border="1px" style=" border-collapse: collapse;">
                <tr>
                    <th width="67">
                        Male
                    </th>
                    <th width="67">
                        Female
                    </th>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            Below 12 years
        </th>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            12 Years
        </th>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            13 Years
        </th>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            14 Years
        </th>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text"  size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text"  size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            Above 14 years
        </th>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            Total
        </th>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            Repeaters
        </th>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            Completed JSS3 for previous year
        </th>
        <td colspan="2" style="background-color: #ff8c00;">
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 30px; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 30px; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</div>
</div>

<!--section 3-->
<div class="row">
<div class="form-group col-md-12">
    <label for="issueinput48">
    New entrants in SSS 1
</label>
    <!--Table 3--->
    <table border="1px" style=" border-collapse: collapse;">
    <tr>
        <td>

        </td>
        <th width="50%">
            New entrants in SSS1
        </th>
    </tr>
    <tr>
        <th>
            Student age 
        </th>
        <th>
            <table border="1px" width="100%" style="border-collapse: collapse;">
                <tr>
                    <th width="50%">
                        Male
                    </th>
                    <th width="50%">
                        Female
                    </th>
                </tr>
            </table>
        </th>
    </tr>
    <tr>
        <th>
            Below 15 years
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                </tr>
            </table>
        </th>
    </tr>
    <tr>
        <th>
            15 Years
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                </tr>
            </table>
        </th>
    </tr>
    <tr>
        <th>
            16 Years
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                </tr>
            </table>
        </th>
    </tr>
    <tr>
        <th>
            17 Years
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                </tr>
            </table>
        </th>
    </tr>
    <tr>
        <th>
            Above 17 years
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                </tr>
            </table>
        </th>
    </tr>
    <tr>
        <th>
            Total
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                    <td>
                        <input type="text" size="16" style="height: 20; width: 90%;">
                    </td>
                </tr>
            </table>
        </th>
    </tr>
</table>
</div>
</div>
    <!--section 5-->

    <!--section 4-->
<div class="row">
<div class="form-group col-md-12">
    <label for="issueinput48">
        Senior  Secondary Enrolment by age for the current school year
</label>
    <!--Table 4--->
    <table border="1px" style=" border-collapse: collapse;">
    <tr>
        <th width="170">
            
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
    <tr>
        <th>
            No. of Streams
        </th>
        <td>
            <input type="text" size="11" style="height: 20; width: 94%;">
        </td>
        <td>
            <input type="text"  size="11" style="height: 20; width: 94%;">
        </td>
        <td>
            <input type="text" size="11" style="height: 20; width: 94%;">
        </td>
    </tr>
    <tr>
        <th>
            NO. of streams with Multigrade Teaching
        </th>
        <td>
            <input type="text" size="11" style="height: 20; width: 94%;">
        </td>
        <td>
            <input type="text" size="11" style="height: 20; width: 94%;">
        </td>
        <td>
            <input type="text" size="11" style="height: 20; width: 94%;">
        </td>
    </tr>
    <tr>
        <th>
            Ages
        </th>
        <td>
            <table border="1px" style=" border-collapse: collapse;">
                <tr>
                    <th width="67">
                        Male
                    </th>
                    <th width="67">
                        Female
                    </th>
                </tr>
            </table>
        </td>
        <td>
            <table border="1px" style=" border-collapse: collapse;">
                <tr>
                    <th width="67">
                        Male
                    </th>
                    <th width="67">
                        Female
                    </th>
                </tr>
            </table>
        </td>
        <td>
            <table border="1px" style=" border-collapse: collapse;">
                <tr>
                    <th width="67">
                        Male
                    </th>
                    <th width="67">
                        Female
                    </th>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            Below 15 years
        </th>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            15 Years
        </th>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            16 Years
        </th>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            17 Years
        </th>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text"  size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text"  size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            Above 17 years
        </th>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            Total
        </th>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            Repeaters
        </th>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 20; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            Completed SSS 3 for previous year
        </th>
        <td colspan="2" style="background-color: #ff8c00;">
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="text" size="4" style="height: 30px; width: 94%;">
                    </td>
                    <td>
                        <input type="text" size="4" style="height: 30px; width: 94%;">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</div>
</div>


    <div class="row">
    <div class="form-group col-md-12">
        <label for="issueinput48">
            Student Flow for the Current Academic Year
    </label>
        <!--Table 5--->
        <table border="1px" style=" border-collapse: collapse;" width="100%">
    <tr>
        <th width="120" rowspan="2">
            Student Flow
        </th>
        <th width="170">
            JSS 1
        </th>
        <th width="170">
            JSS 2
        </th>
        <th width="170">
            JSS 3
        </th>
        <th width="170">
            SSS 1
        </th>
        <th width="170">
            SSS 2
        </th>
        <th width="170">
            SSS 3
        </th>
        </tr>
        
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
                <table border="1px" style="border-collapse: collapse;" width="100%">
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
                <table border="1px" style="border-collapse: collapse;" width="100%">
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
                <table border="1px" style="border-collapse: collapse;" width="100%">
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
                <table border="1px" style="border-collapse: collapse;" width="100%">
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
        <tr>
            <th>
                Dropout
            </th>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th>
                Transfer In
            </th>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;" >
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;" >
                        </td>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th>
                Transfer Out
            </th>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th>
                Promoted
            </th>  
            <td rowspan="2" style="background-color: #ff8c00;"></td> 
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>       
            <td rowspan="2" style="background-color: #ff8c00;"></td> 
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input type="text" size="6" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
</table>
                                </div>
                             </div>

                             <!--section 6-->
                             <div class="row">
                                <div class="form-group col-md-12">
                                  <label for="issueinput48">
                                    Students with Special needs in the current school year
                                </label>
                                 <!--Table 6--->
                                 <table border="1px" style=" border-collapse: collapse;" width="100%">
    <tr>
        <th width="120" rowspan="2">
            Challenge that impacts the ability to learn
        </th>
        <th width="120">
            JSS 1
        </th>
        <th width="120">
            JSS 2
        </th>
        <th width="120">
            JSS 3
        </th>
        <th width="120">
            SSS 1
        </th>
        <th width="120">
            SSS 2
        </th>
        <th width="120">
            SSS 3
        </th>
        </tr>
        
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
                <table border="1px" style="border-collapse: collapse;" width="100%">
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
                <table border="1px" style="border-collapse: collapse;" width="100%">
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
                <table border="1px" style="border-collapse: collapse;" width="100%">
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
                <table border="1px" style="border-collapse: collapse;" width="100%">
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
        <tr>
            <th>
                Blind / visually impaired
            </th>
            
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th>
                Hearing / speech impaired            </th>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th>
                Physically Challenged
            </th>
            
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th>
                Mentally challenged
            </th>  
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th>
                Albinism
            </th>  
           
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>       
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th>
                Autism
            </th>  
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>       
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input type="text" size="3" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
</table>
</div>
</div>

        <div class="row">
            <div class="form-group col-md-12">
                <label for="issueinput48">
                    NABTEB examination in the previous school year
                </label>
                <!--Table 6--->
                <table border="1px" style=" border-collapse: collapse;" width="100%">
                    <tr>
                        <th width="60%">
                        </th>
                        <th width="13%">
                            Male
                        </th>
                        <th width="13%">
                            Female
                        </th>
                        <th width="13%">
                            Total
                        </th>
                    </tr>
                    <tr>
                        <td width="60%">
                            How many students were registered for NABTEB?
                        </td>
                        <td width="13%">
                            <input type="text" size="6" style="height: 30px; width: 100px;">
                        </td>
                        <td width="13%">
                            <input type="text" size="6" style="height: 30px; width: 100px;">
                        </td>
                        <td width="13%">
                            <input type="text" size="6" style="height: 30px; width: 100px;">
                        </td>
                    </tr>
                    <tr>
                        <td width="60%">
                            How many students took part in the NABTEB?
                        </td>
                        <td width="13%">
                            <input type="text" size="6" style="height: 30px; width: 100px;">
                        </td>
                        <td width="13%">
                            <input type="text" size="6" style="height: 30px; width: 100px;">
                        </td>
                        <td width="13%">
                            <input type="text" size="6" style="height: 30px; width: 100px;">
                        </td>
                    </tr>
                    <tr>
                        <td width="60%">
                            How many students passed (5 credit including English and Maths) in NABTEB exams?
                        </td>
                        <td width="13%">
                            <input type="text" size="6" style="height: 30px; width: 100px;">
                        </td>
                        <td width="13%">
                            <input type="text" size="6" style="height: 30px; width: 100px;">
                        </td>
                        <td width="13%">
                            <input type="text" size="6" style="height: 30px; width: 100px;">
                        </td>
                    </tr>
                </table>
            </div>
            </div>
        </form>
        <div class="form-actions">
            <button
                type="submit"
                class="btn btn-success"
                v-if="! is_submitted"
                @click="submitSurvey()"
            >
                <i class="icon-check2"></i> Save
            </button>
            <button
                type="button"
                class="btn btn-warning mr-1"
                @click="previousStage()"
            >
                &lt;&lt; Previous Stage
            </button>
            <button
                type="button"
                class="btn btn-primary mr-1"
                @click="nextStage()"
            >
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
import SurveyProgress from "../../../Shared/School/SurveyProgress.vue";
export default {
    components: {
        SurveyProgress
    },

    data() {
        return {
            surveyId: this.$route.params.surveyId,
            validationErrors: [],
            enrollment: {
                
            },
            survey : null,

            is_submitted : false
        };
    },
    mounted() {
        window.scrollTo(0, 0);
        this.getSurvey();
    },

    methods: {
        getSurvey() {
            this.$loading(true);
            axios
                .get(`/api/school/surveys/show?survey=${this.surveyId}`)
                .then(res => {
                    this.survey = res.data.data;
                    this.is_submitted = this.survey.submit_status;
                    
                    if(this.survey.enrollments) {
                         this.enrollment = this.survey.enrollments;
                    }

                    this.$loading(false);
                })
                .catch(error => {
                    this.$loading(false);
                    if (!error.response) {
                        this.$alert(
                            "You do not have internet access",
                            "Network Error",
                            "error"
                        );
                        return;
                    }

                    if (error.response.status === 401) {
                        let return_url = window.location.pathname;
                        this.$router.push({
                            name: "school-login",
                            params: { return_url: return_url }
                        });
                    }

                    if (error.response.status === 403) {
                        this.$alert(
                            "Sorry, you do not have the permission to perfrom this action",
                            "No Permission",
                            "error"
                        );
                    }
                });
        },

        submitSurvey() {

            let data = {
                'survey' : this.surveyId,
                'enrollment' : this.enrollment
            }

            this.$loading(true);

            axios
                .post("/api/school/surveys/create/enrollment", data)
                .then(response => {
                    this.survey = response.data.data;
                    this.$loading(false);
                    this.flashMessage.success({
                        title: "Successful",
                        message: "Survey saved successfully",
                        time: 15000,
                        flashMessageStyle: {
                            backgroundColor: "linear-gradient(#e66465, #9198e5)"
                        }
                    });
                    this.getSurvey();
                    this.nextStage();
                })
                .catch(error => {
                    this.$loading(false);
                    if (!error.response) {
                        this.$alert(
                            "You do not have internet access",
                            "Network Error",
                            "error"
                        );
                        return;
                    }
                    if (error.response.status == 422) {
                        this.validationErrors = error.response.data.errors;
                        this.flashMessage.error({
                            title: "Validation Error",
                            message:
                                "There is an Error with the Data you supplied",
                            time: 15000
                        });
                    }
                    if (error.response.status === 401) {
                        let return_url = window.location.pathname;
                        this.$router.push({
                            name: "school-login",
                            params: { return_url: return_url }
                        });
                    }
                    if (error.response.status === 403) {
                        this.$alert(
                            "Sorry, you do not have the permission to perfrom this action",
                            "No Permission",
                            "error"
                        );
                    }
                });
        },

        nextStage() {
            // // if (this.survey.enrollments == null) {
            // //     this.$alert(
            // //         "Sorry, you have to complete this stage.",
            // //         "Not Allowed",
            // //         "error"
            // //     );
            // //     return;
            // }

            this.$router.push({
                name: "staff-school-survey",
                params: { surveyId: this.surveyId }
            });
        },

        previousStage() {
            this.$router.push({
                name: "characteristics-school-survey",
                params: { surveyId: this.surveyId }
            });
        }
    }
};
</script>

<style scoped>
.small_text {
    font-size: 0.8rem;
}
.move_down {
    padding-top: 20px;
}

table,
tr,
td, 
th {
    text-align: center;
}

</style>
