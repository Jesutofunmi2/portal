<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|


Route::middleware('auth:ministry_admin')->get('/user', function (Request $request) {
    //return $request->user(); 
    return 'yess';
});
*/

Route::post('ministry/login', "Auth\Ministry\AuthController@api_login")->name('ministry_api_login');
Route::post('school/login', "Auth\School\AuthController@api_login")->name('school_api_login');
Route::post('aeo-zeo/login', "Auth\AEO_ZEO\AEO_ZEOAuthController@api_login")->name('aeo_zeo_api_login');
Route::post('burser/login', "Auth\Burser\BurserAuthController@api_login")->name('burser_api_login');
Route::post('liberian/login', "Auth\Liberian\LiberianAuthController@api_login")->name('liberian_api_login');
Route::post('parent/login', "Auth\Parent\ParentAuthController@api_login")->name('parent_api_login');
Route::post('student/login', "Auth\Student\StudentAuthController@api_login")->name('student_api_login');
Route::post('teacher/login', "Auth\Teacher\TeacherAuthController@api_login")->name('teacher_api_login');

// this routes are general purpose, but the user must be authenticated on any guard
Route::group([
        'middleware' => 'userAuth',
        'prefix' => 'general'
    ], function () {
	Route::get('get_state', "General\GetStateController@getState");
    Route::get('get_state/all', "General\GetStateController@getAll");
    Route::get('get_lga', "General\GetStateController@getLga");
    Route::get('getSubjects', "General\HelperController@getSubjects");
    Route::get('getSubjects/byCategory', "General\HelperController@getSubjectsByCategory");
    Route::get('getSubjects/byId/{id}', "General\HelperController@getSubjectsById");
    Route::get('school/secondary/view', "General\GetSchoolController@index");
    Route::get('school/getClasses/{school_id}', "General\HelperController@getClasses");
    Route::get('school/getClassArms/{class_id}', "General\HelperController@getClassArms");

    //**************** NEW ROUTES ******************
    Route::get('school/getAllClassArms/{school_id}', "General\HelperController@getSchoolAllClassArms");
    Route::get('school/getClassesByCategory/{school_id}/{category}', "General\HelperController@getClassesByCategory");
    
    Route::get('school/info/{school_id}', "General\HelperController@getSchoolInfo");
    Route::get('school/teachers/{school_id}', "General\HelperController@getAllTeachers");
    
    Route::get('school/assign-subject-teacher/{school_id}/{teacher_id}/{subject_id}/{classarm_id}', "General\HelperController@assignSubjectTeacher");

    //**************** NEW ROUTES ******************
});

// this routes are for only ministry admin
Route::post('ministry/logout', "Auth\Ministry\AuthController@api_logout")->name('ministry_api_logout');
Route::group([
    'middleware' => 'auth:ministry_api',
    'prefix' => 'ministry',
    'namespace' => 'Ministry'
    ], function () {
	Route::post('school/secondary/create', "School\CreateSchoolController@index");
    Route::get('school/secondary/view', "School\ViewSchoolController@index");
    Route::get('school/secondary/view/all', "School\ViewSchoolController@all");
    Route::get('school/secondary/{schoolID}/edit', "School\EditSchoolController@index");
    Route::post('school/secondary/{schoolID}/update', "School\EditSchoolController@update");
    Route::delete('school/secondary/{schoolID}/delete', "School\DeleteSchoolController@index");
    Route::post('school/primary/create', "School\CreatePrimarySchoolController@index");
    Route::get('school/primary/view', "School\ViewPrimarySchoolController@index");
    Route::get('school/primary/view', "School\ViewPrimarySchoolController@index");
    Route::get('school/primary/{schoolID}/edit', "School\EditPrimarySchoolController@index");
    Route::post('school/primary/{schoolID}/update', "School\EditPrimarySchoolController@update");
    Route::delete('school/primary/{schoolID}/delete', "School\DeletePrimarySchoolController@index");

    Route::post('school/admin/create', "SchoolAdmin\CreateSchoolAdminController@index");
    Route::get('school/admin/view', "SchoolAdmin\ViewSchoolAdminController@index");
    Route::get('school/admin/{id}/edit', "SchoolAdmin\EditSchoolAdminController@index");
    Route::post('school/admin/{id}/update', "SchoolAdmin\EditSchoolAdminController@update");
    Route::delete('school/admin/{id}/delete', "SchoolAdmin\DeleteSchoolAdminController@index");
    Route::get('school/admin/print', "SchoolAdmin\ViewSchoolAdminController@print");

    Route::post('school/teacher/create', "Teacher\CreateTeacherController@createSingleTeacher");
    Route::post('school/teacher/create/batch', "Teacher\CreateTeacherController@createBatchTeacher");
    Route::get('school/teacher/view', "Teacher\ViewTeacherController@index");
    Route::get('school/teacher/{id}/edit', "Teacher\EditTeacherController@index");
    Route::post('school/teacher/{id}/update', "Teacher\EditTeacherController@update");
    Route::delete('school/teacher/{id}/delete', "Teacher\DeleteTeacherController@index");

    Route::post('student/create', "Student\CreateStudentController@createSingleStudent");
    Route::post('student/create/batch', "Student\CreateStudentController@createBatchStudent");
    Route::get('student/view', "Student\ViewStudentController@index");
    Route::get('student/norminal-roll/download', "Student\ViewStudentController@getNorminalRoll");
    Route::get('student/unknown', "Student\UnknownStudentController@index");
    Route::get('student/unknown/view', "Student\UnknownStudentController@view");
    Route::post('student/unknown/gender/update', "Student\UnknownStudentController@update");
    Route::get('student/floating', "Student\FloatingStudentController@index");
    Route::post('student/floating/update', "Student\FloatingStudentController@update");

    Route::get('student/{id}/edit', "Student\EditStudentController@index");
    Route::post('student/{id}/update', "Student\EditStudentController@update");
    Route::delete('student/{id}/delete', "Student\DeleteStudentController@index");

    Route::post('subject/create', "Subject\SubjectController@createSingleSubject");
    Route::post('subject/update', "Subject\SubjectController@updateSubject");
    Route::post('subject/create/batch', "Subject\SubjectController@createBatchSubject");
    Route::delete('subject/{id}/delete', "Subject\SubjectController@deleteSubject");
    Route::get('subject/view', "Subject\SubjectController@viewSubject");

    Route::post('subject/category/create', "Subject\SubjectCategoryController@create");
    Route::delete('subject/category/{id}/delete', "Subject\SubjectCategoryController@delete");
    Route::get('subject/category/view', "Subject\SubjectCategoryController@view");
    Route::get('subject/category/view-subject', "Subject\SubjectCategoryController@viewSubjects");
    Route::put('subject/category/{id}/update', "Subject\SubjectCategoryController@update");
    Route::post('subject/category/toggle-subject', "Subject\SubjectCategoryController@toggleSubject");

    Route::get('permission/view', "Permission\PermissionController@getAllPermission");
    Route::get('permission/ministryAdmin/view', "Permission\MinistryPermissionController@getAdmins");
    Route::get('permission/aeozeoAdmin/view', "Permission\AeozeoPermissionController@getAdmins");
    Route::get('permission/ministryAdmin/getPermission', "Permission\MinistryPermissionController@getPermission");
    Route::post('permission/ministryAdmin/permission/all', "Permission\MinistryPermissionController@toggleAllPermission");
    Route::post('permission/ministryAdmin/permission/some', "Permission\MinistryPermissionController@toggleSomePermission");

    Route::get('permission/schoolAdmin/view', "Permission\SchoolAdminPermissionController@getAdmins");
    Route::get('permission/schoolAdmin/getPermission', "Permission\SchoolAdminPermissionController@getPermission");
    Route::post('permission/schoolAdmin/permission/all', "Permission\SchoolAdminPermissionController@toggleAllPermission");
    Route::post('permission/schoolAdmin/permission/some', "Permission\SchoolAdminPermissionController@toggleSomePermission");

    Route::get('permission/teacher/view', "Permission\TeacherPermissionController@getTeachers");

    Route::post('user/create', "User\CreateMinistryAccount@index");
    Route::post('user/aeozeo/create', "User\CreateMinistryAccount@createAeozeo");
    Route::post('user/cas-admin/create', "User\CreateMinistryAccount@createCasAdmin");
    Route::get('user/aeozeo/list', "User\EditMinistryAccount@aeozeoList");
    Route::get('user/cas-admin/list', "User\EditMinistryAccount@casAdminList");
    Route::post('user/password/change', "User\PasswordChange@index");
    Route::match(['post','get'], 'user/profile/edit', "User\EditMinistryAccount@index");

    Route::get('result/scratch-card/view', "Card\ResultScratchCardController@view");
    Route::post('result/scratch-card/generate', "Card\ResultScratchCardController@generate");
    Route::delete('result/scratch-card/{id}/delete', "Card\ResultScratchCardController@deleteOne");
    Route::post('result/scratch-card/delete/all', "Card\ResultScratchCardController@deleteAll");

    Route::get('exam/scratch-card/view', "Card\ExamScratchCardController@view");
    Route::post('exam/scratch-card/generate', "Card\ExamScratchCardController@generate");
    Route::delete('exam/scratch-card/{id}/delete', "Card\ExamScratchCardController@deleteOne");
    Route::post('exam/scratch-card/delete/all', "Card\ExamScratchCardController@deleteAll");

    Route::get('department', "Department\DepartmentController@get");
    Route::get('department/all', "Department\DepartmentController@getAll");
    Route::post('department/create', "Department\DepartmentController@create");
    Route::put('department/{department}/update', "Department\DepartmentController@update");
    Route::delete('department/{department}/delete', "Department\DepartmentController@delete");

    Route::get('task', "Task\TaskController@get");
    Route::post('task/create', "Task\TaskController@create");
    Route::put('task/{task}/update', "Task\TaskController@update");
    Route::get('task/{task}/view', "Task\TaskController@view");

    // statistics
    Route::get('school-statistics/overall', "Statistics\SchoolStatisticsController@overall");
    Route::get('school-statistics/schools', "Statistics\SchoolStatisticsController@allSchools");
    Route::get('school-statistics/schools/{schoolId}', "Statistics\SchoolStatisticsController@school");
    Route::get('lga/school-statistics/student', "Statistics\LgaSchoolStatisticsController@student");
    Route::get('lga/school-statistics/teacher', "Statistics\LgaSchoolStatisticsController@teacher");
    Route::get('lga/broad/school-statistics', "Statistics\LgaBroadSchoolStatisticsController@index");
    Route::get('lga/result-statistics', "Statistics\LgaResultStatisticsController@index");
    Route::get('lga/subject-statistics', "Statistics\LgaSubjectStatisticsController@index");
    Route::get('lga/broad-subject-statistics', "Statistics\LgaBroadSubjectStatisticsController@index");
    Route::get('lga/student-statistics', "Statistics\LgaStudentStatisticsController@student");
    Route::get('lga/student-statistics/all', "Statistics\LgaStudentStatisticsController@allStudent");
    Route::get('lga/subject-teachers-statistics', "Statistics\SubjectTeachersStatisticsController@teacher");
    Route::get('lga/subject-teachers-statistics/all', "Statistics\SubjectTeachersStatisticsController@allTeacher");

    Route::get('wallet/view', "Wallet\ViewWalletController@index");
    Route::post('wallet/add', "Wallet\WalletOperationController@add");
    Route::post('wallet/deduct', "Wallet\WalletOperationController@deduct");
    Route::post('wallet/reset', "Wallet\WalletOperationController@reset");
    Route::get('wallet/transaction', "Wallet\WalletOperationController@transaction");
    Route::get('wallet/analysis', "Wallet\WalletOperationController@analysis");
    Route::post('wallet/set-digital-fee', "Wallet\WalletOperationController@setDigitalFee");
    Route::get('created/wallet/view', "Wallet\ViewWalletController@getWallets");
    Route::post('wallet/create', "Wallet\ViewWalletController@createWalletAccount");
    Route::post('wallet/create/all', "Wallet\ViewWalletController@createAllWalletAccount");

    Route::get('school-id-card-request/schools', "SchoolID\ViewSchoolController@index");
    Route::get('school-id-card-request/statistics/{school_id}', "SchoolID\StudentIdCardController@statistics");
    Route::get('school-id-card-request/pending/{school_id}', "SchoolID\StudentIdCardController@pending");
    Route::get('school-id-card-request/approved/{school_id}', "SchoolID\StudentIdCardController@approved");
    Route::get('school-id-card-request/downloaded/{school_id}', "SchoolID\StudentIdCardController@downloaded");
    Route::post('school-id-card-request/operation/approve', "SchoolID\CardOperationController@approve");
    Route::post('school-id-card-request/operation/unapprove', "SchoolID\CardOperationController@unApprove");
    Route::post('school-id-card-request/operation/download', "SchoolID\CardOperationController@download");
    Route::post('school-id-card-request/operation/downloaded', "SchoolID\CardOperationController@downloaded");

    Route::get('payment-history/schools', "PaymentHistory\ViewSchoolController@index");
    Route::get('payment-history/transactions', "PaymentHistory\PaymentOperationController@digitalPaymentHistory");
    Route::get('payment-history/report/icpr', "PaymentHistory\PaymentOperationController@icpr");
    Route::get('payment-history/report/srr', "PaymentHistory\PaymentOperationController@srr");
    Route::get('payment-history/report/school/srr', "PaymentHistory\PaymentOperationController@report");

    Route::get('app/statistics', "DashboardController@appStat");
    Route::get('app/lga_summary', "DashboardController@studentSummary");

    Route::get('activities-log/ministry', "ActivityLog\MinistryLogController@index");
    Route::get('activities-log/ministry/{id}', "ActivityLog\MinistryLogController@getLogs");
    Route::get('activities-log/school', "ActivityLog\SchoolLogController@index");
    Route::get('activities-log/school/{id}', "ActivityLog\SchoolLogController@getLogs");
    Route::get('activities-log/teacher', "ActivityLog\TeacherLogController@index");
    Route::get('activities-log/teacher/{id}', "ActivityLog\TeacherLogController@getLogs");
    Route::get('activities-log/student', "ActivityLog\StudentLogController@index");
    Route::get('activities-log/student/{id}', "ActivityLog\StudentLogController@getLogs");

    Route::get('transfer/teachers-inward-outward', "Transfer\ViewInOutTeacherTransferController@index");
    Route::get('transfer/processteacher/{teacherID}', "Transfer\ProcessTeacherTransferController@index");
    Route::post('transfer/processteacher/{teacherID}/update', "Transfer\ProcessTeacherTransferController@update");
    Route::post('transfer/teacherconfirm', "Transfer\ProcessTeacherTransferController@confirmTransfer");
    Route::post('transfer/teacherdelete', "Transfer\ProcessTeacherTransferController@deleteTransfer");
});

Route::group([
    'middleware' => 'auth:ministry_api',
    'prefix' => 'ministry',
    ], function () {
        Route::get('student/eligible/classes', "Admins\Student\EligibleStudentController@getClasses");
        Route::get('student/eligible', "Admins\Student\EligibleStudentController@index");
        Route::get('result/summary', "Admins\Result\ViewBroadsheetController@summary");
});


// this routes are for only school admin
Route::group([
    'middleware' => 'auth:school_api',
    'prefix' => 'school'
    ], function () {

    Route::post('logout', "Auth\School\AuthController@api_logout")->name('school_api_logout');
    //School house
    Route::post('schoolhouse/create', "Admins\SchoolHouse\CreateSchoolHouseController@index");
    Route::get('schoolhouse/view/all', "Admins\SchoolHouse\ViewSchoolHouseController@index");
    Route::get('schoolhouse/{houseID}/edit', "Admins\SchoolHouse\EditSchoolHouseController@index");
    Route::post('schoolhouse/{houseID}/update', "Admins\SchoolHouse\EditSchoolHouseController@update");
    Route::delete('schoolhouse/{houseID}/delete', "Admins\SchoolHouse\DeleteSchoolHouseController@index");
    //Student
    Route::post('student/register', "Admins\Student\RegisterStudentController@index");
    Route::post('student/batchregister', "Admins\Student\RegisterStudentController@batchRegistration");
    Route::get('student/view', "Admins\Student\ViewStudentController@index");
    Route::get('student/eligible/classes', "Admins\Student\EligibleStudentController@getClasses");
    Route::get('student/eligible', "Admins\Student\EligibleStudentController@index");
    Route::get('student/norminal-roll/download', "Admins\Student\ViewStudentController@getNorminalRoll");
    Route::get('student/view/all', "Admins\Student\ViewStudentController@getAll");
    Route::get('student/view/class', "Admins\Student\ViewStudentController@getClassStudents");
    Route::get('student/viewfloating', "Admins\Student\ViewStudentController@getFloating");
    Route::get('student/viewone/{studentID}', "Admins\Student\ViewStudentController@getOne");
    Route::get('student/{studentID}/edit', "Admins\Student\EditStudentController@index");
    Route::post('student/{studentID}/update', "Admins\Student\EditStudentController@update");
    Route::get('student/{studentID}/editfloating', "Admins\Student\EditStudentController@editFloating");
    Route::post('student/{studentID}/updatefloating', "Admins\Student\EditStudentController@updateFloating");
    Route::delete('student/{studentID}/delete', "Admins\Student\DeleteStudentController@index");
    Route::get('student/subject/viewall', "Admins\Student\ViewStudentSubjectController@index");
    Route::get('student/subject/{studentID}/edit', "Admins\Student\EditStudentSubjectController@index");
    Route::post('student/subject/{studentID}/update', "Admins\Student\EditStudentSubjectController@update");
    Route::post('student/passportupload', "Admins\Student\BatchPassportUploadController@index");
    //Teacher
    Route::post('teacher/register', "Admins\Teacher\RegisterTeacherController@index");
    Route::post('teacher/batchregister', "Admins\Teacher\RegisterTeacherController@batchRegistration");
    Route::get('teacher/view', "Admins\Teacher\ViewTeacherController@index");
    Route::get('teacher/view/all', "Admins\Teacher\ViewTeacherController@getAll");
    Route::get('teacher/{teacherID}/edit', "Admins\Teacher\EditTeacherController@index");
    Route::post('teacher/{teacherID}/update', "Admins\Teacher\EditTeacherController@update");
    Route::delete('teacher/{teacherID}/delete', "Admins\Teacher\DeleteTeacherController@index");
    Route::get('teacher/view/formatted', "Admins\Teacher\ViewTeacherController@getAllFormatted");
    //Classes
    Route::get('class/view/all', "Admins\Clas\ViewClassController@index");
    Route::post('class/add', "Admins\Clas\AddClassController@index");
    Route::get('class/{classID}/edit', "Admins\Clas\EditClassController@index");
    Route::post('class/{classID}/update', "Admins\Clas\EditClassController@update");
    Route::delete('class/{classID}/delete', "Admins\Clas\DeleteClassController@index");
    //Class Arms
    Route::get('classarm/view/{classID}', "Admins\ClassArm\ViewClassArmController@index");
    Route::get('classarm/viewall', "Admins\ClassArm\ViewClassArmController@getAll");
    Route::post('classarm/add', "Admins\ClassArm\AddClassArmController@index");
    Route::get('classarm/{classarmID}/edit', "Admins\ClassArm\EditClassArmController@index");
    Route::post('classarm/{classarmID}/update', "Admins\ClassArm\EditClassArmController@update");
    Route::delete('classarm/{classarmID}/delete', "Admins\ClassArm\DeleteClassArmController@index");
    Route::get('classarm/assign/student', "Admins\ClassArm\AssignStudentController@index");
    Route::post('classarm/assign/student', "Admins\ClassArm\AssignStudentController@assign");
    Route::post('classarm/reassign/student', "Admins\ClassArm\AssignStudentController@reassign");
    Route::post('classarm/remove/student', "Admins\ClassArm\AssignStudentController@remove");
    Route::post('classarm/assign/teacher/subject', "Admins\ClassArm\AssignTeacherSubjectController@index");

    //Class Arm Subjects
    Route::get('classarm/subject/viewall', "Admins\ClassArm\ViewClassArmSubjectController@index");
    Route::get('classarm/subject/view/{armID}', "Admins\ClassArm\ViewClassArmSubjectController@getSubjects");
    Route::get('classarm/subject/{classarmID}/edit', "Admins\ClassArm\EditClassArmSubjectController@index");
    Route::post('classarm/subject/{classarmID}/update', "Admins\ClassArm\EditClassArmSubjectController@update");
    Route::delete('classarm/subject/{classarmID}/delete', "Admins\ClassArm\DeleteClassArmSubjectController@index");
    Route::delete('classarm/subjects/{classarmSubjectID}/delete', "Admins\ClassArm\EditClassArmSubjectController@deleteClassarmSubject");
    Route::get('classarm/subject/{subjectId}/teachers', "Admins\ClassArm\EditClassArmSubjectController@getSubjectTeachers");
    
    
    //Class Arm Teachers
    Route::get('classarm/teacher/viewall', "Admins\ClassArm\ViewClassArmTeacherController@index");
    Route::get('classarm/teacher/{classarmID}/edit', "Admins\ClassArm\EditClassArmTeacherController@index");
    Route::post('classarm/teacher/{classarmID}/update', "Admins\ClassArm\EditClassArmTeacherController@update");
    Route::delete('classarm/teacher/{classarmID}/delete', "Admins\ClassArm\DeleteClassArmTeacherController@index");
    //Class Arm Counsellors
    Route::get('classarm/counsellor/viewall', "Admins\ClassArm\ViewClassArmCounsellorController@index");
    Route::get('classarm/counsellor/{classarmID}/edit', "Admins\ClassArm\EditClassArmCounsellorController@index");
    Route::post('classarm/counsellor/{classarmID}/update', "Admins\ClassArm\EditClassArmCounsellorController@update");
    Route::delete('classarm/counsellor/{classarmID}/delete', "Admins\ClassArm\DeleteClassArmCounsellorController@index");
    //Subjects
    Route::get('subject/view/all', "Admins\Subject\ViewSubjectController@index");
    //Debtors
    Route::post('debtor/add', "Admins\Debtor\AddDebtorController@index");
    Route::get('debtor/view/all', "Admins\Debtor\ViewDebtorController@index");
    Route::get('debtor/{debtorID}/edit', "Admins\Debtor\EditDebtorController@index");
    Route::post('debtor/{debtorID}/update', "Admins\Debtor\EditDebtorController@update");
    Route::delete('debtor/{debtorID}/delete', "Admins\Debtor\DeleteDebtorController@index");
    //Admins
    Route::post('admin/create', "Admins\Admins\CreateAdminController@index");
    Route::get('admin/view', "Admins\Admins\ViewAdminController@index");
    Route::get('admin/{id}/edit', "Admins\Admins\EditAdminController@index");
    Route::post('admin/{id}/update', "Admins\Admins\EditAdminController@update");
    Route::delete('admin/{id}/delete', "Admins\Admins\DeleteAdminController@index");
    //Permissions
    Route::get('permission/view/all', "Admins\Permission\ViewPermissionController@index");
    //Library
    Route::get('library/category/view/all', "Admins\Librarian\ViewLibraryCategoryController@index");
    Route::get('library/category/viewall', "Admins\Librarian\ViewLibraryCategoryController@getAll");
    Route::post('library/category/add', "Admins\Librarian\CreateLibraryCategoryController@index");
    Route::get('library/category/{catID}/edit', "Admins\Librarian\EditLibraryCategoryController@index");
    Route::post('library/category/{catID}/update', "Admins\Librarian\EditLibraryCategoryController@update");
    Route::delete('library/category/{catID}/delete', "Admins\Librarian\DeleteLibraryCategoryController@index");
    //Library Books
    Route::get('library/book/view/all', "Admins\Librarian\ViewBookController@index");
    Route::get('library/book/viewall', "Admins\Librarian\ViewBookController@getAll");
    Route::post('library/book/add', "Admins\Librarian\CreateBookController@index");
    Route::get('library/book/{bookID}/edit', "Admins\Librarian\EditBookController@index");
    Route::post('library/book/{bookID}/update', "Admins\Librarian\EditBookController@update");
    Route::delete('library/book/{bookID}/delete', "Admins\Librarian\DeleteBookController@index");
    //Library Issue
    Route::get('library/issue/view/all', "Admins\Librarian\ViewLibraryIssueController@index");
    Route::get('library/issue/viewall', "Admins\Librarian\ViewLibraryIssueController@getAll");
    Route::post('library/issue/add', "Admins\Librarian\CreateLibraryIssueController@index");
    Route::get('library/issue/{issueID}/edit', "Admins\Librarian\EditLibraryIssueController@index");
    Route::post('library/issue/{issueID}/update', "Admins\Librarian\EditLibraryIssueController@update");
    Route::delete('library/issue/{issueID}/delete', "Admins\Librarian\DeleteLibraryIssueController@index");
    //Profile
    Route::post('profile/changepass', "Admins\Profile\ChangePasswordController@index");
    Route::get('profile/edit', "Admins\Profile\EditProfileController@index");
    Route::get('profile/editschool', "Admins\Profile\EditProfileController@editSchool");
    Route::get('profile/editlogo', "Admins\Profile\EditLogoController@index");
    Route::get('profile/editcounsign', "Admins\Profile\EditCounSignController@index");
    Route::post('profile/update', "Admins\Profile\EditProfileController@update");
    Route::post('profile/updateschool', "Admins\Profile\EditProfileController@updateSchool");
    Route::post('profile/updatelogo', "Admins\Profile\EditLogoController@update");
    Route::post('profile/updatecounsign', "Admins\Profile\EditCounSignController@update");
    //Transaction
    Route::get('transaction/view', "Admins\Transaction\ViewTransactionController@index");
    //Wallet
    Route::get('wallet/view', "Admins\Wallet\ViewWalletController@index");
    //Result
    Route::get('result/view', "Admins\Result\ViewResultController@index");
    Route::get('result/check/print', "Admins\Result\ViewResultController@printResultCheck");
    Route::post('result/update', "Admins\Result\UpdateResultController@index");
    Route::delete('result/{resultID}/delete', "Admins\Result\DeleteResultController@index");
    Route::post('result/uploadsubject', "Admins\Result\UploadResultController@index");
    Route::post('result/uploadall', "Admins\Result\UploadResultController@uploadAll");
    Route::get('result/downloadtemplate', "Admins\Result\UploadResultController@downloadBatchFile");
    Route::get('result/downloadsubjtemplate', "Admins\Result\UploadResultController@downloadSubjectBatchFile");
    Route::post('result/uploadcomments', "Admins\Result\UploadCommentController@index");
    Route::get('result/downloadcommtemplate', "Admins\Result\UploadCommentController@downloadBatchFile");
    Route::get('result/editsign', "Admins\Result\UpdateResultSignController@index");
    Route::post('result/updatesign', "Admins\Result\UpdateResultSignController@update");
    Route::post('result/lockrelease', "Admins\Result\LockResultController@updateLockRelease");
    Route::post('result/lockreleaseall', "Admins\Result\LockResultController@updateLockReleaseAll");
    Route::post('result/promotionstamp', "Admins\Result\PromotionStampController@updatePromotionStamp");
    Route::post('result/promotionstampall', "Admins\Result\PromotionStampController@updatePromotionStampAll");
    Route::get('result/termbroadsheet', "Admins\Result\ViewBroadsheetController@termSheets");
    Route::get('result/sessionbroadsheet', "Admins\Result\ViewBroadsheetController@sessionSheets");
    Route::get('result/summary', "Admins\Result\ViewBroadsheetController@summary");

    //Transfers
    Route::get('transfer/teachersinward', "Admins\Transfer\ViewInTeacherTransferController@index");
    Route::get('transfer/teachersoutward', "Admins\Transfer\ViewOutTeacherTransferController@index");
    Route::get('transfer/newteacher', "Admins\Transfer\NewTeacherTransferController@index");
    Route::get('transfer/processteacher/{teacherID}', "Admins\Transfer\ProcessTeacherTransferController@index");
    Route::post('transfer/processteacher/{teacherID}/update', "Admins\Transfer\ProcessTeacherTransferController@update");
    Route::post('transfer/teacherconfirm', "Admins\Transfer\ProcessTeacherTransferController@confirmTransfer");
    Route::get('transfer/studenthistory', "Admins\Transfer\ViewStudentTransferController@index");
    //School
    Route::get('lgaschools/view/{lgaID}', "Admins\School\ViewSchoolController@index");

    // School ID Card
    Route::get('school-id-request/view/page', "Admins\SchoolID\ViewStudentController@view");
    Route::get('school-id-request/view/student', "Admins\SchoolID\ViewStudentController@index");
    Route::post('school-id-request/create', "Admins\SchoolID\StudentIdCardController@create");
    Route::get('school-id-request/pending', "Admins\SchoolID\StudentIdCardController@pending");
    Route::get('school-id-request/approved', "Admins\SchoolID\StudentIdCardController@approved");
    Route::post('school-id-request/cancel', "Admins\SchoolID\StudentIdCardController@cancel");

    Route::get('app/statistics', "Admins\DashboardController@appStat");
    Route::get('app/chart/data', "Admins\DashboardController@studentStat");

    Route::get('class-wallet', "Admins\Wallet\ClassWalletController@listClassWallet");
    Route::post('class-wallet/create', "Admins\Wallet\ClassWalletController@createClassWallet");
    Route::post('class-wallet/add', "Admins\Wallet\ClassWalletController@addToWallet");
    Route::get('class-wallet/transactions', "Admins\Wallet\ClassWalletController@transactions");

    Route::post('class-wallet/verify-payment', "Admins\Wallet\VerifyPaymentController@index");
    Route::post('class-wallet/verify-payment/bulk', "Admins\Wallet\VerifyPaymentController@bulkVerifyPayment");
    Route::match(['get', 'post'], 'class-wallet/payment-receipt', "Admins\Wallet\VerifyPaymentController@receipt");
    Route::get('class-wallet/students', "Admins\Wallet\VerifyPaymentController@students");
    Route::get('class-wallet/show', "Admins\Wallet\VerifyPaymentController@wallet");

    Route::get('surveys', "Admins\School\SchoolSurveyController@index");
    Route::post('surveys/create', "Admins\School\SchoolSurveyController@createSurvey");
    Route::post('surveys/create/identities', "Admins\School\SchoolSurveyController@identities");
    Route::post('surveys/create/characteristics', "Admins\School\SchoolSurveyController@characteristics");
    Route::post('surveys/create/enrollment', "Admins\School\SchoolSurveyController@enrollment");
    Route::post('surveys/create/staffs', "Admins\School\SchoolSurveyController@staffs");
    Route::get('surveys/show', "Admins\School\SchoolSurveyController@show");
});
Route::get('school/result/print', "Admins\Result\ViewResultController@printResult");

// this routes are for only AEO or ZEO admin
Route::group([
    'middleware' => 'auth:ministry_api',
    'prefix' => 'aeo-zeo'
    ], function () {

    Route::post('logout', "Auth\AEO_ZEO\AEO_ZEOAuthController@api_logout")->name('aeo_zeo_api_logout');

});

// this routes are for only bursers
Route::group([
    'middleware' => 'auth:burser_api',
    'prefix' => 'burser'
    ], function () {

    Route::post('logout', "Auth\Burser\BurserAuthController@api_logout")->name('burser_api_logout');

});

// this routes are for only liberian
Route::group([
    'middleware' => 'auth:liberian_api',
    'prefix' => 'liberian'
    ], function () {

    Route::post('logout', "Auth\Liberian\LiberianAuthController@api_logout")->name('liberian_api_logout');

});

// this routes are for only parent 
Route::group([
    'middleware' => 'auth:parent_api',
    'prefix' => 'parent'
    ], function () {

    Route::post('logout', "Auth\Parent\ParentAuthController@api_logout")->name('parent_api_logout');

});

// this routes are for only student
Route::group([
    'middleware' => 'auth:student_api',
    'prefix' => 'student',
    ], function () {

    Route::post('logout', "Auth\Student\StudentAuthController@api_logout")->name('student_api_logout');
    Route::get('dashboard', "Student\DashboardController@index");
    Route::get('profile/edit', "Student\Profile\EditStudentController@index");
    Route::post('profile/update', "Student\Profile\EditStudentController@update");
    Route::post('passport/update', "Student\Profile\EditStudentController@passportUpdate");
    Route::put('password/update', "Student\Profile\EditStudentController@passwordUpdate");

    Route::get('payment-receipt', "Student\StudentReceiptController@index");

    Route::get('transfer/current-school', "Student\StudentTransferController@currentSchool");
    Route::post('transfer/submit', "Student\StudentTransferController@index");

    Route::get('result/check', "Student\StudentResultController@printResultCheck");
    Route::get('result/session', "Student\StudentResultController@studentSession");
});

// this routes are for only teacher
Route::group([
    'middleware' => 'auth:teacher_api',
    'prefix' => 'teacher'
    ], function () {

    Route::post('logout', "Auth\Teacher\TeacherAuthController@api_logout")->name('teacher_api_logout');
    //Subjects
    Route::get('subject/view/all', "Teacher\Subject\ViewSubjectController@index");
    Route::get('subject/viewall', "Teacher\Subject\ViewSubjectController@getAll");
    Route::post('subject/update', "Teacher\Subject\UpdateSubjectController@index");
    Route::delete('subject/{subjID}/delete', "Teacher\Subject\DeleteSubjectController@index");

    Route::get('subjectclass/{subject_id}/{session}', "Teacher\ClassArm\ViewTeacherClassController@getSubjectClass");
    Route::get('class/{session?}', "Teacher\ClassArm\ViewTeacherClassController@index");
    //Profile
    Route::post('profile/changepass', "Teacher\Profile\ChangePasswordController@index");
    Route::get('profile/edit', "Teacher\Profile\EditProfileController@index");
    Route::post('profile/update', "Teacher\Profile\EditProfileController@update");
    Route::get('profile/signature', "Teacher\Profile\UpdateSignatureController@index");
    Route::post('profile/change-signature', "Teacher\Profile\UpdateSignatureController@update");

    Route::get('overview', "Teacher\Profile\OverviewController@index");
    Route::post('overview/update', "Teacher\Profile\OverviewController@update");

    Route::get('result/downloadtemplate', "Teacher\Result\UploadResultController@downloadBatchFile");
    Route::get('result/downloadsubjtemplate', "Teacher\Result\UploadResultController@downloadSubjectBatchFile");
    Route::post('result/uploadsubject', "Teacher\Result\UploadResultController@index");
    Route::post('result/uploadall', "Teacher\Result\UploadResultController@uploadAll");

    Route::get('result/downloadcommtemplate', "Teacher\Result\UploadCommentController@downloadBatchFile");
    Route::post('result/uploadcomments', "Teacher\Result\UploadCommentController@index");
    Route::get('result/view', "Teacher\Result\ViewResultController@index");

    Route::get('classarms/view', "Teacher\Student\ViewStudentController@classarms");
    Route::get('students/view', "Teacher\Student\ViewStudentController@index");
    
    //**************** NEW ROUTES ******************
    Route::get('classarms/subjects', "Teacher\ClassArm\ViewClassArmSubjectController@index");
    Route::get('classarms/class/subjects', "Teacher\ClassArm\ViewClassArmSubjectController@classArmSubject");
    //**************** NEW ROUTES ******************
    
    Route::get('dashboard', "Teacher\DashboardController@index");
});

Route::group([
    'middleware' => 'isPublicUser',
    'prefix' => 'public/ministry',
    'namespace' => 'Ministry'
    ],
    function () {
    // statistics
    Route::get('school-statistics/overall', "Statistics\SchoolStatisticsController@overall");
    Route::get('school-statistics/schools', "Statistics\SchoolStatisticsController@allSchools");
    Route::get('school-statistics/schools/{schoolId}', "Statistics\SchoolStatisticsController@school");
    Route::get('lga/school-statistics/student', "Statistics\LgaSchoolStatisticsController@student");
    Route::get('lga/school-statistics/teacher', "Statistics\LgaSchoolStatisticsController@teacher");
    Route::get('lga/broad/school-statistics', "Statistics\LgaBroadSchoolStatisticsController@index");
    Route::get('lga/result-statistics', "Statistics\LgaResultStatisticsController@index");
    Route::get('lga/subject-statistics', "Statistics\LgaSubjectStatisticsController@index");
    Route::get('lga/broad-subject-statistics', "Statistics\LgaBroadSubjectStatisticsController@index");
    Route::get('lga/student-statistics', "Statistics\LgaStudentStatisticsController@student");
    Route::get('lga/student-statistics/all', "Statistics\LgaStudentStatisticsController@allStudent");
    Route::get('lga/subject-teachers-statistics', "Statistics\SubjectTeachersStatisticsController@teacher");
    Route::get('lga/subject-teachers-statistics/all', "Statistics\SubjectTeachersStatisticsController@allTeacher");
});

Route::group([
    'middleware' => 'isPublicUser',
    'prefix' => 'public/general'
], function () {
    Route::get('get_state', "General\GetStateController@getState");
    Route::get('get_state/all', "General\GetStateController@getAll");
    Route::get('get_lga', "General\GetStateController@getLga");
    Route::get('getSubjects', "General\HelperController@getSubjects");
    Route::get('getSubjects/byCategory', "General\HelperController@getSubjectsByCategory");
    Route::get('getSubjects/byId/{id}', "General\HelperController@getSubjectsById");
    Route::get('school/secondary/view', "General\GetSchoolController@index");
    Route::get('school/getClasses/{school_id}', "General\HelperController@getClasses");
    Route::get('school/getClassArms/{class_id}', "General\HelperController@getClassArms");

    //**************** NEW ROUTES ******************
    Route::get('school/getAllClassArms/{school_id}', "General\HelperController@getSchoolAllClassArms");
    Route::get('school/getClassesByCategory/{school_id}/{category}', "General\HelperController@getClassesByCategory");

    Route::get('school/info/{school_id}', "General\HelperController@getSchoolInfo");
    Route::get('school/teachers/{school_id}', "General\HelperController@getAllTeachers");

    Route::get('school/assign-subject-teacher/{school_id}/{teacher_id}/{subject_id}/{classarm_id}', "General\HelperController@assignSubjectTeacher");

    //**************** NEW ROUTES ******************
});
