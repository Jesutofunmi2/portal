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
                                            Number of Children with Birth
                                            Certificate
                                            </label>
                                       <!--Section 1-->
<table border="1px" style=" border-collapse: collapse;" width="100%">
    <tr>
        <th width="150">
            How many children were enrollled with Birth Certificates
        </th>
        <th>
            Pre-Primary
            <table border="1px" style="border-collapse: collapse; width: 100%;">
                <tr>
                    <td width="120">
                        Kindergarten 1/ECCD
                        <br> <br>
                        <table border="1px" style="border-collapse: collapse;">
                            <tr>
                                <td width="85">
                                    Male
                                </td>
                                <td width="85">
                                    Female
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="120">
                        Kindergarten 2/ECCD
                        <br> <br>
                        <table border="1px" style="border-collapse: collapse;">
                            <tr>
                                <td width="85">
                                    Male
                                </td>
                                <td width="85">
                                    Female
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="120">
                        Nursery 1
                        <br> <br>
                        <table border="1px" style="border-collapse: collapse;">
                            <tr>
                                <td width="80">
                                    Male
                                </td>
                                <td width="85">
                                    Female
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="120">
                        Nursery 2
                        <br> <br>
                        <table border="1px" style="border-collapse: collapse;">
                            <tr>
                                <td width="77">
                                    Male
                                </td>
                                <td width="85">
                                    Female
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="120">
                        Nursery 3 / One Year Pre-Primary
                        <table border="1px" style="border-collapse: collapse;">
                            <tr>
                                <td width="73">
                                    Male
                                </td>
                                <td width="85">
                                    Female
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </th>
        <th width="150">
            <br>
            Primary 1
            <br> <br>
            <table border="1px" style="border-collapse: collapse;">
                <tr>
                    <td width="85">
                        Male
                    </td>
                    <td width="85">
                        Female
                    </td>
                </tr>
            </table>
        </th>
    </tr>
    
    <tr>
        <th>
            National Population Commission
        </th>
        <td>
           <table>
               <tr>
                   <td>
                    <table >
                        <tr>
                            <td>
                                <input readonly type="text" v-model="enrollment.birth_cert_kd_one_male_npc" size="6" style="height: 30px; width: 90%;" name="" id="">
                            </td>
                            <td>
                                <input readonly type="text" v-model="enrollment.birth_cert_kd_one_female_npc" size="6" style="height: 30px; width: 90%;" name="" id="">
                            </td>
                        </tr>
                    </table>
                   </td>
                   <td>
                    <table>
                        <tr>
                            <td>
                                <input readonly v-model="enrollment.birth_cert_kd_two_male_npc" type="text" size="6" style="height: 30px; width: 90%;" name="" id="">
                            </td>
                            <td>
                                <input readonly type="text" v-model="enrollment.birth_cert_kd_two_female_npc" size="6" style="height: 30px; width: 90%;" name="" id="">
                            </td>
                        </tr>
                    </table>
                   </td>
                   <td>
                    <table>
                        <tr>
                            <td>
                                <input readonly type="text" size="6" v-model="enrollment.birth_cert_nus_one_male_npc" style="height: 30px; width: 90%;" name="" id="">
                            </td>
                            <td>
                                <input readonly type="text" size="6" v-model="enrollment.birth_cert_nus_one_female_npc" style="height: 30px; width: 90%;" name="" id="">
                            </td>
                        </tr>
                    </table>
                   </td>
                   <td>
                    <table>
                        <tr>
                            <td>
                                <input readonly type="text" v-model="enrollment.birth_cert_nus_two_male_npc" size="6" style="height: 30px; width: 90%;" name="" id="">
                            </td>
                            <td>
                                <input readonly type="text" v-model="enrollment.birth_cert_nus_two_female_npc" size="6" style="height: 30px; width: 90%;" name="" id="">
                            </td>
                        </tr>
                    </table>
                   </td>
                   <td>
                    <table>
                        <tr>
                            <td>
                                <input readonly type="text" size="6" v-model="enrollment.birth_cert_nus_three_male_npc" style="height: 30px; width: 90%;" name="" id="">
                            </td>
                            <td>
                                <input readonly type="text" size="6" v-model="enrollment.birth_cert_nus_three_female_npc" style="height: 30px; width: 90%;" name="" id="">
                            </td>
                        </tr>
                    </table>
                   </td>
               </tr>
           </table>
        </td>
        <td>
            <table >
                <tr>
                    <td>
                        <input readonly type="text" size="6" v-model="enrollment.birth_cert_pri_one_male_npc" style="height: 30px; width: 90%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" size="6" v-model="enrollment.birth_cert_pri_one_female_npc" style="height: 30px; width: 90%;" name="" id="">
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
           <table>
               <tr>
                   <td>
                    <table>
                        <tr>
                            <td>
                                <input readonly type="text" size="6" v-model="enrollment.birth_cert_kd_one_male_other" style="height: 30px; width: 90%;" name="" id="">
                            </td>
                            <td>
                                <input readonly type="text" size="6" v-model="enrollment.birth_cert_kd_one_female_other" style="height: 30px; width: 90%;" name="" id="">
                            </td>
                        </tr>
                    </table>
                   </td>
                   <td>
                    <table >
                        <tr>
                            <td>
                                <input readonly type="text" size="6" v-model="enrollment.birth_cert_kd_two_male_other" style="height: 30px; width: 90%;" name="" id="">
                            </td>
                            <td>
                                <input readonly type="text" size="6" v-model="enrollment.birth_cert_kd_two_female_other" style="height: 30px; width: 90%;" name="" id="">
                            </td>
                        </tr>
                    </table>
                   </td>
                   <td>
                    <table >
                        <tr>
                            <td>
                                <input readonly type="text" size="6" v-model="enrollment.birth_cert_nus_one_male_other" style="height: 30px; width: 90%;" name="" id="">
                            </td>
                            <td>
                                <input readonly type="text" size="6" v-model="enrollment.birth_cert_nus_one_female_other" style="height: 30px; width: 90%;" name="" id="">
                            </td>
                        </tr>
                    </table>
                   </td>
                   <td>
                    <table>
                        <tr>
                            <td>
                                <input readonly type="text" size="6" v-model="enrollment.birth_cert_nus_two_male_other" style="height: 30px; width: 90%;" name="" id="">
                            </td>
                            <td>
                                <input readonly type="text" size="6" v-model="enrollment.birth_cert_nus_two_female_other" style="height: 30px; width: 90%;" name="" id="">
                            </td>
                        </tr>
                    </table>
                   </td>
                   <td>
                    <table >
                        <tr>
                            <td>
                                <input readonly type="text" size="6" v-model="enrollment.birth_cert_pri_one_male_other" style="height: 30px; width: 90%;" name="" id="">
                            </td>
                            <td>
                                <input readonly type="text" size="6"  v-model="enrollment.birth_cert_pri_one_female_other" style="height: 30px; width: 90%;" name="" id="">
                            </td>
                        </tr>
                    </table>
                   </td>
               </tr>
           </table>
        </td>
        <td>
            <table >
                <tr>
                    <td>
                        <input readonly type="text" size="6" v-model="enrollment.birth_cert_nus_three_male_other" style="height: 30px; width: 90%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" size="6" v-model="enrollment.birth_cert_nus_three_female_other" style="height: 30px; width: 90%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
                                    </div>
                                </div>
                            </div>
                            <!--Section 2--->
                            <div class="row">
                                <div class="form-group col-md-12">
                                  <label for="issueinput48">
                                   ECDE Enrolment for the Current School Year by Age 
                                </label>
                                 <!--Table 2--->
                                     <table border="1px" style=" border-collapse: collapse;" width="100%">
    <tr>
        <th style="width:6%" >
            Pupil age
        </th>
        <th style="width:15%">
            Kindergateen 1/ ECCD
        </th>
        <th style="width:15%">
            Kindergateen 2/ ECCD
        </th>
        <th style="width:15%">
            Nursery 1
        </th>
        <th style="width:15%">
            Nursery 2
        </th>
        <th style="width:15%">
            Nursery 3 / One Year Pre-Primary
        </th>
        </tr>
        <tr>
           <th>
               No. of Streams
           </th>
           <td>
                <input readonly type="text" v-model="enrollment.ecde_enroll_streams_kd_one"  name="" id="" style="height: 30px; width: 96%;">
           </td>
           <td>
            <input readonly type="text" v-model="enrollment.ecde_enroll_streams_kd_two"  name="" id="" style="height: 30px; width:  96%;">
           </td>
           <td>
            <input readonly type="text" v-model="enrollment.ecde_enroll_streams_nus_one"  name="" id="" style="height: 30px; width:  96%;">
           </td>
           <td>
            <input readonly type="text" v-model="enrollment.ecde_enroll_streams_nus_two" name="" id="" style="height: 30px; width:  96%;">
           </td>
           <td>
            <input readonly type="text"  v-model="enrollment.ecde_enroll_streams_nus_three" name="" id="" style="height: 30px; width:  96%;">
           </td>
        </tr>
        <tr>
            <td>
                
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
        </tr>
        <tr>
            <th>
                Below 3 Years
            </th>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_below3_years_kd_one_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_below3_years_kd_one_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_below3_years_kd_two_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_below3_years_kd_two_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td colspan="3" style="background-color: #ff8c00;"></td>
        </tr>
        <tr>
            <th>
                3 Years
            </th>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_3_years_kd_one_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_3_years_kd_one_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_3_years_kd_two_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_3_years_kd_two_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_3_years_nus_one_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_3_years_nus_one_female" size="6" name="" id="" style="height: 30px; width: 90%;" >
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_3_years_nus_two_male" size="6" name="" id="" style="height: 30px; width: 90%;" >
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_3_years_nus_two_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_3_years_nus_three_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_3_years_nus_three_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th>
                4 Years
            </th>
            <td colspan="2" rowspan="3" style="background-color: #ff8c00;">
                
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_4_years_nus_one_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_4_years_nus_one_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_4_years_nus_two_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_4_years_nus_two_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_4_years_nus_three_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_4_years_nus_three_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th>
                5 Years
            </th>          
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_5_years_nus_one_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_5_years_nus_one_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_5_years_nus_two_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_5_years_nus_two_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_5_years_nus_three_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_5_years_nus_three_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th>
               Above 5 Years
            </th>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_above5_years_nus_one_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_above5_years_nus_one_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_above5_years_nus_two_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_above5_years_nus_two_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_above5_years_nus_three_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_above5_years_nus_three_female" size="6" name="" id="" style="height: 30px; width: 90%;">
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
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_total_kd_one_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text"  v-model="enrollment.ecde_enroll_total_kd_one_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_total_kd_two_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_total_kd_two_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_total_nus_one_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_total_nus_one_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_total_nus_two_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_total_nus_two_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_total_nus_three_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.ecde_enroll_total_nus_three_female" size="6" name="" id="" style="height: 30px; width: 90%;">
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
                                   New Entrants
                                </label>
                                 <!--Table 3--->
                                    <table border="1px" style=" border-collapse: collapse;">
    <tr>
        <td>

        </td>
        <th width="150">
            New Entrants in Primary 1
        </th>
        <th width="230">
            How many of the New Entrants attended any early childhood education 
        </th>
    </tr>
    <tr>
        <th>
            Pupil Age
        </th>
        <th>
            <table border="1px" style="border-collapse: collapse;">
                <tr>
                    <th width="80">
                        Male
                    </th>
                    <th width="80">
                        Female
                    </th>
                </tr>
            </table>
        </th>
        <th>
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
        </th>
    </tr>
    <tr>
        <th>
            Below 6 Years
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_below6_pri_one_male" size="5" style="height: 20; width: 90%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_below6_pri_one_female" size="5" style="height: 20; width: 90%;" name="" id="">
                    </td>
                </tr>
            </table>
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_below6_pri_one_male_attend" size="11" style="height: 20; width: 95%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text"  v-model="enrollment.new_entrant_below6_pri_one_female_attend" size="11" style="height: 20; width: 95%;" name="" id="">
                    </td>
                </tr>
            </table>
        </th>
    </tr>
    <tr>
        <th>
            6 Years
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_6_pri_one_male" size="5" style="height: 20; width: 90%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_6_pri_one_female" size="5" style="height: 20; width: 90%;" name="" id="">
                    </td>
                </tr>
            </table>
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_6_pri_one_male_attend" size="11" style="height: 20; width: 95%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_6_pri_one_female_attend" size="11" style="height: 20; width: 95%;" name="" id="">
                    </td>
                </tr>
            </table>
        </th>
    </tr>
    <tr>
        <th>
            7 Years
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_7_pri_one_male" size="5" style="height: 20; width: 90%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_7_pri_one_female" size="5" style="height: 20; width: 90%;" name="" id="">
                    </td>
                </tr>
            </table>
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_7_pri_one_male_attend" size="11" style="height: 20; width: 95%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_7_pri_one_female_attend" size="11" style="height: 20; width: 95%;" name="" id="">
                    </td>
                </tr>
            </table>
        </th>
    </tr>
    <tr>
        <th>
            8 Years
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_8_pri_one_male" size="5" style="height: 20; width: 90%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_8_pri_one_female" size="5" style="height: 20; width: 90%;" name="" id="">
                    </td>
                </tr>
            </table>
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_8_pri_one_male_attend" size="11" style="height: 20; width: 95%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_8_pri_one_female_attend" size="11" style="height: 20; width: 95%;" name="" id="">
                    </td>
                </tr>
            </table>
        </th>
    </tr>
    <tr>
        <th>
            9 Years
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_9_pri_one_male" size="5" style="height: 20; width: 90%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_9_pri_one_female" size="5" style="height: 20; width: 90%;" name="" id="">
                    </td>
                </tr>
            </table>
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_9_pri_one_male_attend" size="11" style="height: 20; width: 95%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_9_pri_one_female_attend" size="11" style="height: 20; width: 95%;" name="" id="">
                    </td>
                </tr>
            </table>
        </th>
    </tr>
    <tr>
        <th>
            10 Years
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_10_pri_one_male" size="5" style="height: 20; width: 90%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_10_pri_one_female" size="5" style="height: 20; width: 90%;" name="" id="">
                    </td>
                </tr>
            </table>
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_10_pri_one_male_attend" size="11" style="height: 20; width: 95%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_10_pri_one_female_attend" size="11" style="height: 20; width: 95%;" name="" id="">
                    </td>
                </tr>
            </table>
        </th>
    </tr>
    <tr>
        <th>
            11 Years
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_11_pri_one_male" size="5" style="height: 20; width: 90%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_11_pri_one_female" size="5" style="height: 20; width: 90%;" name="" id="">
                    </td>
                </tr>
            </table>
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_11_pri_one_male_attend" size="11" style="height: 20; width: 95%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_11_pri_one_female_attend" size="11" style="height: 20; width: 95%;" name="" id="">
                    </td>
                </tr>
            </table>
        </th>
    </tr>
    <tr>
        <th>
            Above 11 Years
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_above11_pri_one_male" size="5" style="height: 20; width: 90%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_above11_pri_one_female" size="5" style="height: 20; width: 90%;" name="" id="">
                    </td>
                </tr>
            </table>
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_above11_pri_one_male_attend" size="11" style="height: 20; width: 95%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_above11_pri_one_female_attend" size="11" style="height: 20; width: 95%;" name="" id="">
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
                        <input readonly type="text" v-model="enrollment.new_entrant_total_pri_one_male" size="5" style="height: 20; width: 90%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_total_pri_one_female" size="5" style="height: 20; width: 90%;" name="" id="">
                    </td>
                </tr>
            </table>
        </th>
        <th>
            <table>
                <tr>
                    <td>
                        <input readonly type="text"  v-model="enrollment.new_entrant_total_pri_one_male_attend" size="11" style="height: 20; width: 95%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.new_entrant_total_pri_one_female_attend" size="11" style="height: 20; width: 95%;" name="" id="">
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
                                   Primary enrolment for the current school year by age
                                </label>
                                 <!--Table 4--->
                                 <table border="1px" style=" border-collapse: collapse;">
    <tr>
        <th width="170">
            
        </th>
        <th>
            Primary 1
        </th>
        <th>
            Primary 2
        </th>
        <th>
            Primary 3
        </th>
        <th>
            Primary 4
        </th>
        <th>
            Primary 5
        </th>
        <th>
            Primary 6
        </th>
    </tr>
    <tr>
        <th>
            No. of Streams
        </th>
        <td>
            <input readonly type="text" v-model="enrollment.pri_enroll_current_streams_pri_one" size="11" style="height: 20; width: 94%;" name="" id="">
        </td>
        <td>
            <input readonly type="text" v-model="enrollment.pri_enroll_current_streams_pri_two"  size="11" style="height: 20; width: 94%;" name="" id="">
        </td>
        <td>
            <input readonly type="text" v-model="enrollment.pri_enroll_current_streams_pri_three" size="11" style="height: 20; width: 94%;" name="" id="">
        </td>
        <td>
            <input readonly type="text" v-model="enrollment.pri_enroll_current_streams_pri_four" size="11" style="height: 20; width: 94%;" name="" id="">
        </td>
        <td>
            <input readonly type="text" v-model="enrollment.pri_enroll_current_streams_pri_five" size="11" style="height: 20; width: 94%;" name="" id="">
        </td>
        <td>
            <input readonly type="text" v-model="enrollment.pri_enroll_current_streams_pri_six" size="11" style="height: 20; width: 94%;" name="" id="">
        </td>
    </tr>
    <tr>
        <th>
            NO. of streams with Multigrade Teaching
        </th>
        <td>
            <input readonly type="text" v-model="enrollment.pri_enroll_current_streams_pri_one_grade" size="11" style="height: 20; width: 94%;" name="" id="">
        </td>
        <td>
            <input readonly type="text" v-model="enrollment.pri_enroll_current_streams_pri_two_grade" size="11" style="height: 20; width: 94%;" name="" id="">
        </td>
        <td>
            <input readonly type="text" v-model="enrollment.pri_enroll_current_streams_pri_three_grade" size="11" style="height: 20; width: 94%;" name="" id="">
        </td>
        <td>
            <input readonly type="text" v-model="enrollment.pri_enroll_current_streams_pri_four_grade" size="11" style="height: 20; width: 94%;" name="" id="">
        </td>
        <td>
            <input readonly type="text" v-model="enrollment.pri_enroll_current_streams_pri_five_grade" size="11" style="height: 20; width: 94%;" name="" id="">
        </td>
        <td>
            <input readonly type="text" v-model="enrollment.pri_enroll_current_streams_pri_six_grade" size="11" style="height: 20; width: 94%;" name="" id="">
        </td>
    </tr>
    <tr>
        <th>
            Pupil age
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
            Below 6 Years
        </th>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_below6_pri_one_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_below6_pri_one_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_below6_pri_two_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_below6_pri_two_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_below6_pri_three_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_below6_pri_three_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_below6_pri_four_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_below6_pri_four_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_below6_pri_five_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_below6_pri_five_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_below6_pri_six_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_below6_pri_six_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            6 Years
        </th>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" size="4" v-model="enrollment.pri_enroll_current_6_pri_one_male" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" size="4" v-model="enrollment.pri_enroll_current_6_pri_one_female" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" size="4" v-model="enrollment.pri_enroll_current_6_pri_two_male" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" size="4" v-model="enrollment.pri_enroll_current_6_pri_two_female" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_6_pri_three_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_6_pri_three_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_6_pri_four_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_6_pri_four_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_6_pri_five_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_6_pri_five_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_6_pri_six_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_6_pri_six_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            7 Years
        </th>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_7_pri_one_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_7_pri_one_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_7_pri_two_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_7_pri_two_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_7_pri_three_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_7_pri_three_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_7_pri_four_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_7_pri_four_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_7_pri_five_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_7_pri_five_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_7_pri_six_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_7_pri_six_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            8 Years
        </th>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_8_pri_one_male"  size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_8_pri_one_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_8_pri_two_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_8_pri_two_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text"  v-model="enrollment.pri_enroll_current_8_pri_three_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_8_pri_three_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_8_pri_four_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_8_pri_four_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_8_pri_five_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_8_pri_five_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_8_pri_six_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_8_pri_six_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            9 Years
        </th>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_9_pri_one_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_9_pri_one_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_9_pri_two_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_9_pri_two_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_9_pri_three_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_9_pri_three_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_9_pri_four_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_9_pri_four_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_9_pri_five_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_9_pri_five_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_9_pri_six_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_9_pri_six_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            10 Years
        </th>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_10_pri_one_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_10_pri_one_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_10_pri_two_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_10_pri_two_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_10_pri_three_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_10_pri_three_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_10_pri_four_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_10_pri_four_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_10_pri_five_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_10_pri_five_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_10_pri_six_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_10_pri_six_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            11 Years
        </th>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_11_pri_one_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_11_pri_one_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_11_pri_two_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_11_pri_two_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_11_pri_three_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_11_pri_three_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_11_pri_four_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_11_pri_four_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_11_pri_five_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_11_pri_five_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_11_pri_six_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_11_pri_six_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            Above 11 Years
        </th>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_above11_pri_one_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_above11_pri_one_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_above11_pri_two_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_above11_pri_two_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_above11_pri_three_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_above11_pri_three_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_above11_pri_four_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_above11_pri_four_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_above11_pri_five_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_above11_pri_five_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_above11_pri_six_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_above11_pri_six_female" size="4" style="height: 20; width: 94%;" name="" id="">
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
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_total_pri_one_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_total_pri_one_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_total_pri_two_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_total_pri_two_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_total_pri_three_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_total_pri_three_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_total_pri_four_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_total_pri_four_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_total_pri_five_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_total_pri_five_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_total_pri_six_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_total_pri_six_female" size="4" style="height: 20; width: 94%;" name="" id="">
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
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_repeat_pri_one_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_repeat_pri_one_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_repeat_pri_two_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_repeat_pri_two_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_repeat_pri_three_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_repeat_pri_three_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text"  v-model="enrollment.pri_enroll_current_repeat_pri_four_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_repeat_pri_four_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" size="4" v-model="enrollment.pri_enroll_current_repeat_pri_five_male" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" size="4" v-model="enrollment.pri_enroll_current_repeat_pri_five_female" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_repeat_pri_six_male" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_repeat_pri_six_female" size="4" style="height: 20; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>
            Completed P6 for previous year
        </th>
        <td colspan="5" style="background-color: #ff8c00;">
            
        </td>
        <td>
            <table>
                <tr>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_completed_pri_six_male" size="4" style="height: 30px; width: 94%;" name="" id="">
                    </td>
                    <td>
                        <input readonly type="text" v-model="enrollment.pri_enroll_current_completed_pri_six_female" size="4" style="height: 30px; width: 94%;" name="" id="">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
                                </div>
                             </div>

                             <!--section 5-->
                             <div class="row">
                                <div class="form-group col-md-12">
                                  <label for="issueinput48">
                                   Pupil Flow in the Current Academic Year Primary School
                                </label>
                                 <!--Table 5--->
                                 <table border="1px" style=" border-collapse: collapse;" width="100%">
    <tr>
        <th width="120" rowspan="2">
            Pupil Flow
        </th>
        <th width="170">
            Primary 1
        </th>
        <th width="170">
            Primary 2
        </th>
        <th width="170">
            Primary 3
        </th>
        <th width="170">
            Primary 4
        </th>
        <th width="170">
            Primary 5
        </th>
        <th width="170">
            Primary 6
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
                            <input readonly type="text" v-model="enrollment.current_academic_dropout_pri_one_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_dropout_pri_one_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_dropout_pri_two_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_dropout_pri_two_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_dropout_pri_three_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_dropout_pri_three_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_dropout_pri_four_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_dropout_pri_four_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_dropout_pri_five_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_dropout_pri_five_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_dropout_pri_six_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_dropout_pri_six_female" size="6" name="" id="" style="height: 30px; width: 90%;">
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
                            <input readonly type="text" v-model="enrollment.current_academic_ti_pri_one_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_ti_pri_one_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_ti_pri_two_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_ti_pri_two_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_ti_pri_three_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_ti_pri_three_female" size="6" name="" id="" style="height: 30px; width: 90%;" >
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_ti_pri_four_male" size="6" name="" id="" style="height: 30px; width: 90%;" >
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_ti_pri_four_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_ti_pri_five_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_ti_pri_five_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_ti_pri_six_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_ti_pri_six_female" size="6" name="" id="" style="height: 30px; width: 90%;">
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
                            <input readonly type="text" v-model="enrollment.current_academic_to_pri_one_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_to_pri_one_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_to_pri_two_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_to_pri_two_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_to_pri_three_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_to_pri_three_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_to_pri_four_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_to_pri_four_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_to_pri_five_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_to_pri_five_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_to_pri_six_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_to_pri_six_female" size="6" name="" id="" style="height: 30px; width: 90%;">
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
                            <input readonly type="text" v-model="enrollment.current_academic_comp_pri_two_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_comp_pri_two_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_comp_pri_three_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_comp_pri_three_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>       
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_comp_pri_four_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_comp_pri_four_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_comp_pri_five_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_comp_pri_five_female" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_comp_pri_six_male" size="6" name="" id="" style="height: 30px; width: 90%;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.current_academic_comp_pri_six_female" size="6" name="" id="" style="height: 30px; width: 90%;">
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
                                   Number of Pupils with Special needs in the current school year
                                </label>
                                 <!--Table 6--->
                                 <table border="1px" style=" border-collapse: collapse;" width="100%">
    <tr>
        <th width="120" rowspan="2">
            Challenge that impacts the ability to learn
        </th>
        <th width="120">
            ECCD (KG1-KG2)
        </th>
        <th width="120">
            NURS (NR1-NR3)
        </th>
        <th width="120">
            NUR3 / One Year Pre-Primary
        </th>
        <th width="120">
            PRY 1
        </th>
        <th width="120">
            PRY 2
        </th>
        <th width="120">
            PRY 3
        </th>
        <th width="120">
            PRY 4
        </th>
        <th width="120">
            PRY 5
        </th>
        <th width="120">
            PRY 6
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
                            <input readonly type="text" v-model="enrollment.special_needs_blind_kd_one_two_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_blind_kd_one_two_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_blind_nus_one_three_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_blind_nus_one_three_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_blind_pre_pri_one_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_blind_pre_pri_one_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_blind_pri_one_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_blind_pri_one_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_blind_pri_two_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_blind_pri_two_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_blind_pri_three_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_blind_pri_three_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_blind_pri_four_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_blind_pri_four_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_blind_pri_five_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_blind_pri_five_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_blind_pri_six_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_blind_pri_six_female" size="3" name="" id="" style="height: 30px; width: 50px;">
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
                            <input readonly type="text" v-model="enrollment.special_needs_speech_kd_one_two_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_speech_kd_one_two_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_speech_nus_one_three_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_speech_nus_one_three_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_speech_pre_pri_one_male" size="6" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_speech_pre_pri_one_female" size="6" name="" id="" style="height: 30px; width: 50px" >
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_speech_pri_one_male" size="6" name="" id="" style="height: 30px; width: 50px;" >
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_speech_pri_one_female" size="6" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_speech_pri_two_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_speech_pri_two_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_speech_pri_three_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_speech_pri_three_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_speech_pri_four_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_speech_pri_four_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_speech_pri_five_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_speech_pri_five_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_speech_pri_six_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_speech_pri_six_female" size="3" name="" id="" style="height: 30px; width: 50px;">
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
                            <input readonly type="text" v-model="enrollment.special_needs_phy_kd_one_two_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_phy_kd_one_two_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_phy_nus_one_three_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_phy_nus_one_three_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_phy_pre_pri_one_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_phy_pre_pri_one_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_phy_pri_one_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_phy_pri_one_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_phy_pri_two_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_phy_pri_two_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_phy_pri_three_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_phy_pri_three_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_phy_pri_four_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_phy_pri_four_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_phy_pri_five_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_phy_pri_five_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_phy_pri_six_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_phy_pri_six_female" size="3" name="" id="" style="height: 30px; width: 50px;">
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
                            <input readonly type="text" v-model="enrollment.special_needs_ment_kd_one_two_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_ment_kd_one_two_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_ment_nus_one_three_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_ment_nus_one_three_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_ment_pre_pri_one_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_ment_pre_pri_one_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>       
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_ment_pri_one_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_ment_pri_one_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_ment_pri_two_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_ment_pri_two_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_ment_pri_three_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_ment_pri_three_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_ment_pri_four_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_ment_pri_four_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_ment_pri_five_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_ment_pri_five_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_ment_pri_six_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_ment_pri_six_female" size="3" name="" id="" style="height: 30px; width: 50px;">
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
                            <input readonly type="text" v-model="enrollment.special_needs_albi_kd_one_two_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_albi_kd_one_two_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_albi_nus_one_three_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_albi_nus_one_three_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_albi_pre_pri_one_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_albi_pre_pri_one_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>       
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_albi_pri_one_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_albi_pri_one_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_albi_pri_two_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_albi_pri_two_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_albi_pri_three_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_albi_pri_three_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_albi_pri_four_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_albi_pri_four_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_albi_pri_five_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_albi_pri_five_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_albi_pri_six_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_albi_pri_six_female" size="3" name="" id="" style="height: 30px; width: 50px;">
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
                            <input readonly type="text" v-model="enrollment.special_needs_auti_kd_one_two_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_auti_kd_one_two_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_auti_nus_one_three_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_auti_nus_one_three_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_auti_pre_pri_one_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_auti_pre_pri_one_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>       
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_auti_pri_one_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_auti_pri_one_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_auti_pri_two_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_auti_pri_two_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_auti_pri_three_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_auti_pri_three_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_auti_pri_four_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_auti_pri_four_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_auti_pri_five_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_auti_pri_five_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_auti_pri_six_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.special_needs_auti_pri_six_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
</table>
                                </div>
                             </div>

                              <!--section 7-->
                             <div class="row">
                                <div class="form-group col-md-12">
                                  <label for="issueinput48">
                                   Number of orphans By Grade 
                                </label>
                                 <!--Table 7--->
                                <table border="1px" style=" border-collapse: collapse;" width="100%">
    <tr>
        <th width="120" rowspan="2">
            Type
        </th>
        <th width="120">
            ECCD (KG1-KG2)
        </th>
        <th width="120">
            NURS (NR1-NR3)
        </th>
        <th width="120">
            NUR3 / One Year Pre-Primary
        </th>
        <th width="120">
            PRY 1
        </th>
        <th width="120">
            PRY 2
        </th>
        <th width="120">
            PRY 3
        </th>
        <th width="120">
            PRY 4
        </th>
        <th width="120">
            PRY 5
        </th>
        <th width="120">
            PRY 6
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
                Lost Mother
            </th>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_mother_kd_one_two_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_mother_kd_one_two_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_mother_nus_one_three_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_mother_nus_one_three_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_mother_pre_pri_one_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_mother_pre_pri_one_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_mother_pri_one_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_mother_pri_one_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_mother_pri_two_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_mother_pri_two_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_mother_pri_three_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_mother_pri_three_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_mother_pri_four_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_mother_pri_four_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_mother_pri_five_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_mother_pri_five_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_mother_pri_six_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_mother_pri_six_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th>
                Lost Father
            </th>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_father_kd_one_two_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_father_kd_one_two_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_father_nus_one_three_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_father_nus_one_three_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_father_pre_pri_one_male" size="6" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_father_pre_pri_one_female" size="6" name="" id="" style="height: 30px; width: 50px" >
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_father_pri_one_male" size="6" name="" id="" style="height: 30px; width: 50px;" >
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_father_pri_one_female" size="6" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_father_pri_two_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_father_pri_two_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_father_pri_three_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_father_pri_three_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_father_pri_four_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_father_pri_four_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_father_pri_five_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_father_pri_five_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_father_pri_six_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_father_pri_six_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th>
                Lost Both
            </th>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_both_kd_one_two_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_both_kd_one_two_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_both_nus_one_three_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_both_nus_one_three_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_both_pre_pri_one_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_both_pre_pri_one_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_both_pri_one_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_both_pri_one_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_both_pri_two_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_both_pri_two_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_both_pri_three_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_both_pri_three_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_both_pri_four_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_both_pri_four_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_both_pri_five_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_both_pri_five_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_both_pri_six_male" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                        <td>
                            <input readonly type="text" v-model="enrollment.orphans_both_pri_six_female" size="3" name="" id="" style="height: 30px; width: 50px;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
</table>
                                </div>
                             </div>
                        </form>
                        <div class="form-actions">
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
                //first row
                birth_cert_kd_one_male_npc : null,
                birth_cert_kd_one_female_npc : null,
                birth_cert_kd_one_male_other : null,
                birth_cert_kd_one_female_other : null,
                birth_cert_kd_two_male_npc : null,
                birth_cert_kd_two_female_npc : null,
                birth_cert_kd_two_male_other : null,
                birth_cert_kd_two_female_other : null,
                birth_cert_nus_one_male_npc : null,
                birth_cert_nus_one_female_npc : null,
                birth_cert_nus_one_male_other : null,
                birth_cert_nus_one_female_other : null,
                birth_cert_nus_two_male_npc : null,
                birth_cert_nus_two_female_npc : null,
                birth_cert_nus_two_male_other : null,
                birth_cert_nus_two_female_other : null,
                birth_cert_nus_three_male_npc : null,
                birth_cert_nus_three_female_npc : null,
                birth_cert_nus_three_male_other : null,
                birth_cert_nus_three_female_other : null,
                birth_cert_pri_one_male_npc : null,
                birth_cert_pri_one_female_npc : null,
                birth_cert_pri_one_male_other : null,
                birth_cert_pri_one_female_other : null,
                //second row
                ecde_enroll_streams_kd_one : null,
                ecde_enroll_streams_kd_two : null,
                ecde_enroll_streams_nus_one : null,
                ecde_enroll_streams_nus_two : null,
                ecde_enroll_streams_nus_three : null,

                ecde_enroll_below3_years_kd_one_male : null,
                ecde_enroll_below3_years_kd_one_female : null,
                ecde_enroll_below3_years_kd_two_male : null,
                ecde_enroll_below3_years_kd_two_female : null,
                ecde_enroll_3_years_kd_one_male : null,
                ecde_enroll_3_years_kd_one_female : null,
                ecde_enroll_3_years_kd_two_male : null,
                ecde_enroll_3_years_kd_two_female : null,
                ecde_enroll_3_years_nus_one_male : null,
                ecde_enroll_3_years_nus_one_female : null,
                ecde_enroll_3_years_nus_two_male : null,
                ecde_enroll_3_years_nus_two_female : null,
                ecde_enroll_3_years_nus_three_male : null,
                ecde_enroll_3_years_nus_three_female : null,
                
                ecde_enroll_4_years_nus_one_male : null,
                ecde_enroll_4_years_nus_one_female : null,
                ecde_enroll_4_years_nus_two_male : null,
                ecde_enroll_4_years_nus_two_female : null,
                ecde_enroll_4_years_nus_three_male : null,
                ecde_enroll_4_years_nus_three_female : null,

                ecde_enroll_5_years_nus_one_male : null,
                ecde_enroll_5_years_nus_one_female : null,
                ecde_enroll_5_years_nus_two_male : null,
                ecde_enroll_5_years_nus_two_female : null,
                ecde_enroll_5_years_nus_three_male : null,
                ecde_enroll_5_years_nus_three_female : null,

                ecde_enroll_above5_years_nus_one_male : null,
                ecde_enroll_above5_years_nus_one_female : null,
                ecde_enroll_above5_years_nus_two_male : null,
                ecde_enroll_above5_years_nus_two_female : null,
                ecde_enroll_above5_years_nus_three_male : null,
                ecde_enroll_above5_years_nus_three_female : null,

                ecde_enroll_total_kd_one_male : null,
                ecde_enroll_total_kd_one_female : null,
                ecde_enroll_total_kd_two_male : null,
                ecde_enroll_total_kd_two_female : null,
                ecde_enroll_total_nus_one_male : null,
                ecde_enroll_total_nus_one_female : null,
                ecde_enroll_total_nus_two_male : null,
                ecde_enroll_total_nus_two_female : null,
                ecde_enroll_total_nus_three_male : null,
                ecde_enroll_total_nus_three_female : null,

                //third row
                new_entrant_below6_pri_one_male : null,
                new_entrant_below6_pri_one_female : null,
                new_entrant_below6_pri_one_male_attend : null,
                new_entrant_below6_pri_one_female_attend : null,

                new_entrant_6_pri_one_male : null,
                new_entrant_6_pri_one_female : null,
                new_entrant_6_pri_one_male_attend : null,
                new_entrant_6_pri_one_female_attend : null,

                new_entrant_7_pri_one_male : null,
                new_entrant_7_pri_one_female : null,
                new_entrant_7_pri_one_male_attend : null,
                new_entrant_7_pri_one_female_attend : null,

                new_entrant_8_pri_one_male : null,
                new_entrant_8_pri_one_female : null,
                new_entrant_8_pri_one_male_attend : null,
                new_entrant_8_pri_one_female_attend : null,

                new_entrant_9_pri_one_male : null,
                new_entrant_9_pri_one_female : null,
                new_entrant_9_pri_one_male_attend : null,
                new_entrant_9_pri_one_female_attend : null,

                new_entrant_10_pri_one_male : null,
                new_entrant_10_pri_one_female : null,
                new_entrant_10_pri_one_male_attend : null,
                new_entrant_10_pri_one_female_attend : null,

                new_entrant_11_pri_one_male : null,
                new_entrant_11_pri_one_female : null,
                new_entrant_11_pri_one_male_attend : null,
                new_entrant_11_pri_one_female_attend : null,

                new_entrant_above11_pri_one_male : null,
                new_entrant_above11_pri_one_female : null,
                new_entrant_above11_pri_one_male_attend : null,
                new_entrant_above11_pri_one_female_attend : null,

                new_entrant_total_pri_one_male : null,
                new_entrant_total_pri_one_female : null,
                new_entrant_total_pri_one_male_attend : null,
                new_entrant_total_pri_one_female_attend : null,

                // forth row
                pri_enroll_current_streams_pri_one : null,
                pri_enroll_current_streams_pri_two : null,
                pri_enroll_current_streams_pri_three : null,
                pri_enroll_current_streams_pri_four : null,
                pri_enroll_current_streams_pri_five : null,
                pri_enroll_current_streams_pri_six : null,

                pri_enroll_current_streams_pri_one_grade : null,
                pri_enroll_current_streams_pri_two_grade : null,
                pri_enroll_current_streams_pri_three_grade : null,
                pri_enroll_current_streams_pri_four_grade : null,
                pri_enroll_current_streams_pri_five_grade : null,
                pri_enroll_current_streams_pri_six_grade : null,

                pri_enroll_current_below6_pri_one_male : null,
                pri_enroll_current_below6_pri_one_female : null,
                pri_enroll_current_below6_pri_two_male : null,
                pri_enroll_current_below6_pri_two_female : null,
                pri_enroll_current_below6_pri_three_male : null,
                pri_enroll_current_below6_pri_three_female : null,
                pri_enroll_current_below6_pri_four_male : null,
                pri_enroll_current_below6_pri_four_female : null,
                pri_enroll_current_below6_pri_five_male : null,
                pri_enroll_current_below6_pri_five_female : null,
                pri_enroll_current_below6_pri_six_male : null,
                pri_enroll_current_below6_pri_six_female : null,

                pri_enroll_current_6_pri_one_male : null,
                pri_enroll_current_6_pri_one_female : null,
                pri_enroll_current_6_pri_two_male : null,
                pri_enroll_current_6_pri_two_female : null,
                pri_enroll_current_6_pri_three_male : null,
                pri_enroll_current_6_pri_three_female : null,
                pri_enroll_current_6_pri_four_male : null,
                pri_enroll_current_6_pri_four_female : null,
                pri_enroll_current_6_pri_five_male : null,
                pri_enroll_current_6_pri_five_female : null,
                pri_enroll_current_6_pri_six_male : null,
                pri_enroll_current_6_pri_six_female : null,

                pri_enroll_current_7_pri_one_male : null,
                pri_enroll_current_7_pri_one_female : null,
                pri_enroll_current_7_pri_two_male : null,
                pri_enroll_current_7_pri_two_female : null,
                pri_enroll_current_7_pri_three_male : null,
                pri_enroll_current_7_pri_three_female : null,
                pri_enroll_current_7_pri_four_male : null,
                pri_enroll_current_7_pri_four_female : null,
                pri_enroll_current_7_pri_five_male : null,
                pri_enroll_current_7_pri_five_female : null,
                pri_enroll_current_7_pri_six_male : null,
                pri_enroll_current_7_pri_six_female : null,

                pri_enroll_current_8_pri_one_male : null,
                pri_enroll_current_8_pri_one_female : null,
                pri_enroll_current_8_pri_two_male : null,
                pri_enroll_current_8_pri_two_female : null,
                pri_enroll_current_8_pri_three_male : null,
                pri_enroll_current_8_pri_three_female : null,
                pri_enroll_current_8_pri_four_male : null,
                pri_enroll_current_8_pri_four_female : null,
                pri_enroll_current_8_pri_five_male : null,
                pri_enroll_current_8_pri_five_female : null,
                pri_enroll_current_8_pri_six_male : null,
                pri_enroll_current_8_pri_six_female : null,

                pri_enroll_current_9_pri_one_male : null,
                pri_enroll_current_9_pri_one_female : null,
                pri_enroll_current_9_pri_two_male : null,
                pri_enroll_current_9_pri_two_female : null,
                pri_enroll_current_9_pri_three_male : null,
                pri_enroll_current_9_pri_three_female : null,
                pri_enroll_current_9_pri_four_male : null,
                pri_enroll_current_9_pri_four_female : null,
                pri_enroll_current_9_pri_five_male : null,
                pri_enroll_current_9_pri_five_female : null,
                pri_enroll_current_9_pri_six_male : null,
                pri_enroll_current_9_pri_six_female : null,

                pri_enroll_current_10_pri_one_male : null,
                pri_enroll_current_10_pri_one_female : null,
                pri_enroll_current_10_pri_two_male : null,
                pri_enroll_current_10_pri_two_female : null,
                pri_enroll_current_10_pri_three_male : null,
                pri_enroll_current_10_pri_three_female : null,
                pri_enroll_current_10_pri_four_male : null,
                pri_enroll_current_10_pri_four_female : null,
                pri_enroll_current_10_pri_five_male : null,
                pri_enroll_current_10_pri_five_female : null,
                pri_enroll_current_10_pri_six_male : null,
                pri_enroll_current_10_pri_six_female : null,

                pri_enroll_current_11_pri_one_male : null,
                pri_enroll_current_11_pri_one_female : null,
                pri_enroll_current_11_pri_two_male : null,
                pri_enroll_current_11_pri_two_female : null,
                pri_enroll_current_11_pri_three_male : null,
                pri_enroll_current_11_pri_three_female : null,
                pri_enroll_current_11_pri_four_male : null,
                pri_enroll_current_11_pri_four_female : null,
                pri_enroll_current_11_pri_five_male : null,
                pri_enroll_current_11_pri_five_female : null,
                pri_enroll_current_11_pri_six_male : null,
                pri_enroll_current_11_pri_six_female : null,

                pri_enroll_current_above11_pri_one_male : null,
                pri_enroll_current_above11_pri_one_female : null,
                pri_enroll_current_above11_pri_two_male : null,
                pri_enroll_current_above11_pri_two_female : null,
                pri_enroll_current_above11_pri_three_male : null,
                pri_enroll_current_above11_pri_three_female : null,
                pri_enroll_current_above11_pri_four_male : null,
                pri_enroll_current_above11_pri_four_female : null,
                pri_enroll_current_above11_pri_five_male : null,
                pri_enroll_current_above11_pri_five_female : null,
                pri_enroll_current_above11_pri_six_male : null,
                pri_enroll_current_above11_pri_six_female : null,

                pri_enroll_current_total_pri_one_male : null,
                pri_enroll_current_total_pri_one_female : null,
                pri_enroll_current_total_pri_two_male : null,
                pri_enroll_current_total_pri_two_female : null,
                pri_enroll_current_total_pri_three_male : null,
                pri_enroll_current_total_pri_three_female : null,
                pri_enroll_current_total_pri_four_male : null,
                pri_enroll_current_total_pri_four_female : null,
                pri_enroll_current_total_pri_five_male : null,
                pri_enroll_current_total_pri_five_female : null,
                pri_enroll_current_total_pri_six_male : null,
                pri_enroll_current_total_pri_six_female : null,

                pri_enroll_current_repeat_pri_one_male : null,
                pri_enroll_current_repeat_pri_one_female : null,
                pri_enroll_current_repeat_pri_two_male : null,
                pri_enroll_current_repeat_pri_two_female : null,
                pri_enroll_current_repeat_pri_three_male : null,
                pri_enroll_current_repeat_pri_three_female : null,
                pri_enroll_current_repeat_pri_four_male : null,
                pri_enroll_current_repeat_pri_four_female : null,
                pri_enroll_current_repeat_pri_five_male : null,
                pri_enroll_current_repeat_pri_five_female : null,
                pri_enroll_current_repeat_pri_six_male : null,
                pri_enroll_current_repeat_pri_six_female : null,

                pri_enroll_current_completed_pri_six_male : null,
                pri_enroll_current_completed_pri_six_female : null,

                // Row four
                current_academic_dropout_pri_one_male : null,
                current_academic_dropout_pri_one_female : null,
                current_academic_dropout_pri_two_male : null,
                current_academic_dropout_pri_two_female : null,
                current_academic_dropout_pri_three_male : null,
                current_academic_dropout_pri_three_female : null,
                current_academic_dropout_pri_four_male : null,
                current_academic_dropout_pri_four_female : null,
                current_academic_dropout_pri_five_male : null,
                current_academic_dropout_pri_five_female : null,
                current_academic_dropout_pri_six_male : null,
                current_academic_dropout_pri_six_female : null,

                current_academic_ti_pri_one_male : null,
                current_academic_ti_pri_one_female : null,
                current_academic_ti_pri_two_male : null,
                current_academic_ti_pri_two_female : null,
                current_academic_ti_pri_three_male : null,
                current_academic_ti_pri_three_female : null,
                current_academic_ti_pri_four_male : null,
                current_academic_ti_pri_four_female : null,
                current_academic_ti_pri_five_male : null,
                current_academic_ti_pri_five_female : null,
                current_academic_ti_pri_six_male : null,
                current_academic_ti_pri_six_female : null,

                current_academic_to_pri_one_male : null,
                current_academic_to_pri_one_female : null,
                current_academic_to_pri_two_male : null,
                current_academic_to_pri_two_female : null,
                current_academic_to_pri_three_male : null,
                current_academic_to_pri_three_female : null,
                current_academic_to_pri_four_male : null,
                current_academic_to_pri_four_female : null,
                current_academic_to_pri_five_male : null,
                current_academic_to_pri_five_female : null,
                current_academic_to_pri_six_male : null,
                current_academic_to_pri_six_female : null,

                current_academic_comp_pri_two_male : null,
                current_academic_comp_pri_two_female : null,
                current_academic_comp_pri_three_male : null,
                current_academic_comp_pri_three_female : null,
                current_academic_comp_pri_four_male : null,
                current_academic_comp_pri_four_female : null,
                current_academic_comp_pri_five_male : null,
                current_academic_comp_pri_five_female : null,
                current_academic_comp_pri_six_male : null,
                current_academic_comp_pri_six_female : null,

                //Row six
                special_needs_blind_kd_one_two_male : null,
                special_needs_blind_kd_one_two_female : null,
                special_needs_blind_nus_one_three_male : null,
                special_needs_blind_nus_one_three_female : null,
                special_needs_blind_pre_pri_one_male : null,
                special_needs_blind_pre_pri_one_female : null,
                special_needs_blind_pri_one_male : null,
                special_needs_blind_pri_one_female : null,
                special_needs_blind_pri_two_male : null,
                special_needs_blind_pri_two_female : null,
                special_needs_blind_pri_three_male : null,
                special_needs_blind_pri_three_female : null,
                special_needs_blind_pri_four_male : null,
                special_needs_blind_pri_four_female : null,
                special_needs_blind_pri_five_male : null,
                special_needs_blind_pri_five_female : null,
                special_needs_blind_pri_six_male : null,
                special_needs_blind_pri_six_female : null,

                special_needs_speech_kd_one_two_male : null,
                special_needs_speech_kd_one_two_female : null,
                special_needs_speech_nus_one_three_male : null,
                special_needs_speech_nus_one_three_female : null,
                special_needs_speech_pre_pri_one_male : null,
                special_needs_speech_pre_pri_one_female : null,
                special_needs_speech_pri_one_male : null,
                special_needs_speech_pri_one_female : null,
                special_needs_speech_pri_two_male : null,
                special_needs_speech_pri_two_female : null,
                special_needs_speech_pri_three_male : null,
                special_needs_speech_pri_three_female : null,
                special_needs_speech_pri_four_male : null,
                special_needs_speech_pri_four_female : null,
                special_needs_speech_pri_five_male : null,
                special_needs_speech_pri_five_female : null,
                special_needs_speech_pri_six_male : null,
                special_needs_speech_pri_six_female : null,

                special_needs_phy_kd_one_two_male : null,
                special_needs_phy_kd_one_two_female : null,
                special_needs_phy_nus_one_three_male : null,
                special_needs_phy_nus_one_three_female : null,
                special_needs_phy_pre_pri_one_male : null,
                special_needs_phy_pre_pri_one_female : null,
                special_needs_phy_pri_one_male : null,
                special_needs_phy_pri_one_female : null,
                special_needs_phy_pri_two_male : null,
                special_needs_phy_pri_two_female : null,
                special_needs_phy_pri_three_male : null,
                special_needs_phy_pri_three_female : null,
                special_needs_phy_pri_four_male : null,
                special_needs_phy_pri_four_female : null,
                special_needs_phy_pri_five_male : null,
                special_needs_phy_pri_five_female : null,
                special_needs_phy_pri_six_male : null,
                special_needs_phy_pri_six_female : null,

                special_needs_ment_kd_one_two_male : null,
                special_needs_ment_kd_one_two_female : null,
                special_needs_ment_nus_one_three_male : null,
                special_needs_ment_nus_one_three_female : null,
                special_needs_ment_pre_pri_one_male : null,
                special_needs_ment_pre_pri_one_female : null,
                special_needs_ment_pri_one_male : null,
                special_needs_ment_pri_one_female : null,
                special_needs_ment_pri_two_male : null,
                special_needs_ment_pri_two_female : null,
                special_needs_ment_pri_three_male : null,
                special_needs_ment_pri_three_female : null,
                special_needs_ment_pri_four_male : null,
                special_needs_ment_pri_four_female : null,
                special_needs_ment_pri_five_male : null,
                special_needs_ment_pri_five_female : null,
                special_needs_ment_pri_six_male : null,
                special_needs_ment_pri_six_female : null,

                special_needs_albi_kd_one_two_male : null,
                special_needs_albi_kd_one_two_female : null,
                special_needs_albi_nus_one_three_male : null,
                special_needs_albi_nus_one_three_female : null,
                special_needs_albi_pre_pri_one_male : null,
                special_needs_albi_pre_pri_one_female : null,
                special_needs_albi_pri_one_male : null,
                special_needs_albi_pri_one_female : null,
                special_needs_albi_pri_two_male : null,
                special_needs_albi_pri_two_female : null,
                special_needs_albi_pri_three_male : null,
                special_needs_albi_pri_three_female : null,
                special_needs_albi_pri_four_male : null,
                special_needs_albi_pri_four_female : null,
                special_needs_albi_pri_five_male : null,
                special_needs_albi_pri_five_female : null,
                special_needs_albi_pri_six_male : null,
                special_needs_albi_pri_six_female : null,

                special_needs_auti_kd_one_two_male : null,
                special_needs_auti_kd_one_two_female : null,
                special_needs_auti_nus_one_three_male : null,
                special_needs_auti_nus_one_three_female : null,
                special_needs_auti_pre_pri_one_male : null,
                special_needs_auti_pre_pri_one_female : null,
                special_needs_auti_pri_one_male : null,
                special_needs_auti_pri_one_female : null,
                special_needs_auti_pri_two_male : null,
                special_needs_auti_pri_two_female : null,
                special_needs_auti_pri_three_male : null,
                special_needs_auti_pri_three_female : null,
                special_needs_auti_pri_four_male : null,
                special_needs_auti_pri_four_female : null,
                special_needs_auti_pri_five_male : null,
                special_needs_auti_pri_five_female : null,
                special_needs_auti_pri_six_male : null,
                special_needs_auti_pri_six_female : null,

                //row seven
                orphans_mother_kd_one_two_male : null,
                orphans_mother_kd_one_two_female : null,
                orphans_mother_nus_one_three_male : null,
                orphans_mother_nus_one_three_female : null,
                orphans_mother_pre_pri_one_male : null,
                orphans_mother_pre_pri_one_female : null,
                orphans_mother_pri_one_male : null,
                orphans_mother_pri_one_female : null,
                orphans_mother_pri_two_male : null,
                orphans_mother_pri_two_female : null,
                orphans_mother_pri_three_male : null,
                orphans_mother_pri_three_female : null,
                orphans_mother_pri_four_male : null,
                orphans_mother_pri_four_female : null,
                orphans_mother_pri_five_male : null,
                orphans_mother_pri_five_female : null,
                orphans_mother_pri_six_male : null,
                orphans_mother_pri_six_female : null,

                orphans_father_kd_one_two_male : null,
                orphans_father_kd_one_two_female : null,
                orphans_father_nus_one_three_male : null,
                orphans_father_nus_one_three_female : null,
                orphans_father_pre_pri_one_male : null,
                orphans_father_pre_pri_one_female : null,
                orphans_father_pri_one_male : null,
                orphans_father_pri_one_female : null,
                orphans_father_pri_two_male : null,
                orphans_father_pri_two_female : null,
                orphans_father_pri_three_male : null,
                orphans_father_pri_three_female : null,
                orphans_father_pri_four_male : null,
                orphans_father_pri_four_female : null,
                orphans_father_pri_five_male : null,
                orphans_father_pri_five_female : null,
                orphans_father_pri_six_male : null,
                orphans_father_pri_six_female : null,

                orphans_both_kd_one_two_male : null,
                orphans_both_kd_one_two_female : null,
                orphans_both_nus_one_three_male : null,
                orphans_both_nus_one_three_female : null,
                orphans_both_pre_pri_one_male : null,
                orphans_both_pre_pri_one_female : null,
                orphans_both_pri_one_male : null,
                orphans_both_pri_one_female : null,
                orphans_both_pri_two_male : null,
                orphans_both_pri_two_female : null,
                orphans_both_pri_three_male : null,
                orphans_both_pri_three_female : null,
                orphans_both_pri_four_male : null,
                orphans_both_pri_four_female : null,
                orphans_both_pri_five_male : null,
                orphans_both_pri_five_female : null,
                orphans_both_pri_six_male : null,
                orphans_both_pri_six_female : null,
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
                .get(`/api/ministry/school/survey/show?survey=${this.surveyId}`)
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
                            name: "ministry-login",
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
           
            this.$router.push({
                name: "ministry-staff-school-survey",
                params: { surveyId: this.surveyId }
            });
        },

        previousStage() {
            this.$router.push({
                name: "ministry-characteristics-school-survey",
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
