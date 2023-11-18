import MinistryDashboard from './components/Ministry/DashboardComponent.vue'
import SchoolDashboard from './components/School/DashboardComponent.vue'
import ParentDashboard from './components/Parent/DashboardComponent.vue'
import BurserDashboard from './components/Burser/DashboardComponent.vue'
import StudentDashboard from './components/Student/DashboardComponent.vue'
import TeacherDashboard from './components/Teacher/DashboardComponent.vue'
import AeozeoDashboard from './components/Aeozeo/DashboardComponent.vue'
import LiberianDashboard from './components/Liberian/DashboardComponent.vue'

// Ministry Admin routes

import MinistryLogin from './components/Ministry/LoginComponent.vue'

import CreateSecondarySchool from './components/Ministry/school/CreateSecondarySchoolComponent.vue'
import EditSecondarySchool from './components/Ministry/school/EditSecondarySchoolComponent.vue'
import ListSecondarySchool from './components/Ministry/school/ListSecondarySchoolComponent.vue'

import CreatePrimarySchool from './components/Ministry/school/CreatePrimarySchoolComponent.vue'
import EditPrimarySchool from './components/Ministry/school/EditPrimarySchoolComponent.vue'
import ListPrimarySchool from './components/Ministry/school/ListPrimarySchoolComponent.vue'

import CreateSchoolAdmin from './components/Ministry/schoolAdmin/CreateSchoolAdminComponent.vue'
import ListSchoolAdmin from './components/Ministry/schoolAdmin/ListSchoolAdminComponent.vue'
import EditSchoolAdmin from './components/Ministry/schoolAdmin/EditSchoolAdminComponent.vue'
import PrintSchoolAdmin from './components/Ministry/schoolAdmin/PrintSchoolAdminComponent.vue'

import MinistryListSchoolSurvey from './components/Ministry/school/survey/ListSchoolSurvey.vue'
import MinistryIdentitiesSurveyComponent from './components/Ministry/school/survey/IdentitiesSurveyComponent.vue'
import MinistryCharacteristicsSurveyComponent from './components/Ministry/school/survey/CharacteristicsSurveyComponent.vue'
import MinistryEnrollmentSurveyComponent from './components/Ministry/school/survey/EnrollmentSurveyComponent.vue'
import MinistryStaffSurveyComponent from './components/Ministry/school/survey/StaffSurveyComponent.vue'
import MinistryClassroomsSurveyComponent from './components/Ministry/school/survey/ClassroomsSurveyComponent.vue'
import MinistryFacilitiesSurveyComponent from './components/Ministry/school/survey/FacilitiesSurveyComponent.vue'
import MinistryPupilTeacherSurveyComponent from './components/Ministry/school/survey/PupilTeacherSurveyComponent.vue'
import MinistryUndertakingSurveyComponent from './components/Ministry/school/survey/UndertakingSurveyComponent.vue'


import CreateSingleTeacher from './components/Ministry/Teacher/CreateSingleTeacher.vue'
import ViewSchoolTeacher from './components/Ministry/Teacher/ViewSchoolTeacher.vue'
import EditSchoolTeacher from './components/Ministry/Teacher/EditSchoolTeacher.vue'
import CreateBatchTeacher from './components/Ministry/Teacher/CreateBatchTeacher.vue'

import CreateSingleStudent from './components/Ministry/Student/CreateSingleStudent.vue'
import ViewStudent from './components/Ministry/Student/ViewStudent.vue'
import ViewUnknownStudent from './components/Ministry/Student/ViewUnknownStudent.vue'
import ViewFloatingStudent from './components/Ministry/Student/ViewFloatingStudent.vue'
import MinistryEditStudent from './components/Ministry/Student/EditStudent.vue'
import CreateBatchStudent from './components/Ministry/Student/CreateBatchStudent.vue'
import MinistryEligibleStudent from './components/Ministry/Student/EligibleStudentComponent.vue'

import CreateSingleSubject from './components/Ministry/Subject/CreateSingleSubject.vue'
import ViewSubject from './components/Ministry/Subject/ViewSubject.vue'
import CreateBatchSubject from './components/Ministry/Subject/CreateBatchSubject.vue'
import EditSubject from './components/Ministry/Subject/EditSubject.vue'

import MinistryPermission from './components/Ministry/Permission/MinistryPermission.vue'
import AeozeoPermission from './components/Ministry/Permission/AeozeoPermission.vue'
import EditMinistryPermission from './components/Ministry/Permission/EditMinistryPermission.vue'
import SchoolAdminPermission from './components/Ministry/Permission/SchoolAdminPermission.vue'
import EditSchoolAdminPermission from './components/Ministry/Permission/EditSchoolAdminPermission.vue'
import TeacherPermission from './components/Ministry/Permission/TeacherPermission.vue'
import EditTeacherPermission from './components/Ministry/Permission/EditTeacherPermission.vue'

import CreateMinistryAccount from './components/Ministry/User/CreateMinistryAccount.vue'
import CreateAeozeoAccount from './components/Ministry/User/CreateAeozeoAccount.vue'
import EditAeozeoAccount from './components/Ministry/User/EditAeozeoAccount.vue'
import ListAeozeoAdmin from './components/Ministry/User/ListAeozeoAdmin.vue'
import MinistryEditProfile from './components/Ministry/User/EditProfile.vue'
import MinistryChangePassword from './components/Ministry/User/ChangePassword.vue'
import CreateCasAccount from './components/Ministry/User/CreateCasAccount.vue'
import ListCasAdmin from './components/Ministry/User/ListCasAdmin.vue'
import EditCasAccount from './components/Ministry/User/EditCasAccount.vue'

import MinistryViewResultCard from './components/Ministry/ScratchCard/ResultCard.vue'
import MinistryViewExamCard from './components/Ministry/ScratchCard/ExamCard.vue'

import MinistryDepartment from './components/Ministry/Department/MinistryDepartment.vue'
import MinistryCreateTask from './components/Ministry/Task/CreateTask.vue'
import MinistryViewTask from './components/Ministry/Task/ViewTask.vue'
import MinistryEditTask from './components/Ministry/Task/EditTask.vue'

import MinistrySchoolStatistics from './components/Ministry/Statistics/SchoolStatistics.vue'
import MinistryLgaSchoolStatistics from './components/Ministry/Statistics/LgaSchoolStatistics.vue'
import MinistryLgaBroadSchoolStatistics from './components/Ministry/Statistics/LgaBroadSchoolStatistics.vue'
import MinistryLgaResultStatistics from './components/Ministry/Statistics/LgaResultStatistics.vue'
import MinistryLgaSubjectStatistics from './components/Ministry/Statistics/LgaSubjectStatistics.vue'
import MinistryLgaBroadSubjectStatistics from './components/Ministry/Statistics/LgaBroadSubjectStatistics.vue'
import MinistryLgaStudentStatistics from './components/Ministry/Statistics/LgaStudentStatistics.vue'
import MinistryLgaSubjectTeachersStatistics from './components/Ministry/Statistics/LgaSubjectTeachersStatistics.vue'

import MinistrySchoolWallet from './components/Ministry/Wallet/WalletComponent.vue'
import MinistryCreateSchoolWallet from './components/Ministry/Wallet/CreateWalletComponent.vue'
import MinistryWalletTransaction from './components/Ministry/Wallet/TransactionComponent.vue'
import MinistryWalletAnalysis from './components/Ministry/Wallet/AnalysisComponent.vue'

import CreateSubjectCategory from './components/Ministry/Subject/CreateSubjectCategory.vue'
import ViewSubjectCategory from './components/Ministry/Subject/ViewSubjectCategory.vue'

import SchoolIdCardRequestComponent from './components/Ministry/ID-Request/SchoolIdCardRequestComponent.vue'
import ListSchoolIdRequestComponent from './components/Ministry/ID-Request/ListSchoolIdRequestComponent.vue'

import ListSchoolPaymentComponent from './components/Ministry/PaymentHistory/ListSchoolPaymentComponent.vue'
import ICPRComponent from './components/Ministry/PaymentHistory/ICPRComponent.vue'
import SRRComponent from './components/Ministry/PaymentHistory/SRRComponent.vue'

import MinistryActivityLog from './components/Ministry/ActivityLog/MinistryActivityLogComponent.vue'
import ViewMinistryActivityLog from './components/Ministry/ActivityLog/MinistryActivityLogs.vue'
import SchoolActivityLog from './components/Ministry/ActivityLog/SchoolActivityLogComponent.vue'
import ViewSchoolActivityLog from './components/Ministry/ActivityLog/SchoolActivityLogs.vue'
import TeacherActivityLog from './components/Ministry/ActivityLog/TeacherActivityLogComponent.vue'
import ViewTeacherActivityLog from './components/Ministry/ActivityLog/TeacherActivityLogs.vue'
import StudentActivityLog from './components/Ministry/ActivityLog/StudentActivityLogComponent.vue'
import ViewStudentActivityLog from './components/Ministry/ActivityLog/StudentActivityLogs.vue'

import MinistryResultSummaryComponent from './components/Ministry/Result/ResultSummaryComponent'

import MinistryListInOutTeacherTransferComponent from './components/Ministry/Transfer/ListInOutTeacherTransferComponent.vue'
import MinistryNewTeacherTransfer from './components/Ministry/Transfer/NewTeacherTransferComponent.vue'
import MinistryProcessTeacherTransfer from './components/Ministry/Transfer/ProcessTeacherTransferComponent.vue'

// Liberian Routes
import LiberianLogin from './components/Liberian/LoginComponent.vue'
import LiberianExample from './components/Liberian/ExampleComponent.vue'

//School Admin Routes
import SchoolLogin from './components/School/LoginComponent.vue'

import CreateSchoolHouse from './components/School/schoolHouse/CreateSchoolHouseComponent.vue'
import EditSchoolHouse from './components/School/schoolHouse/EditSchoolHouseComponent.vue'
import ListSchoolHouse from './components/School/schoolHouse/ListSchoolHouseComponent.vue'

import AddDebtor from './components/School/debtor/AddDebtorComponent.vue'
import EditDebtor from './components/School/debtor/EditDebtorComponent.vue'
import ListDebtor from './components/School/debtor/ListDebtorComponent.vue'

import RegisterStudent from './components/School/student/RegisterStudentComponent.vue'
import BatchRegisterStudent from './components/School/student/BatchRegisterStudentComponent.vue'
import EditStudent from './components/School/student/EditStudentComponent.vue'
import ListStudent from './components/School/student/ListStudentComponent.vue'
import ListFloatingStudent from './components/School/student/ListFloatingStudentComponent.vue'
import EditFloatingStudent from './components/School/student/EditFloatingStudentComponent.vue'
import BatchStudentPassportUpload from './components/School/student/BatchStudentPassportUploadComponent.vue'
import EligibleStudent from './components/School/student/EligibleStudentComponent.vue'

import ListStudentSubject from './components/School/student/ListStudentSubjectComponent.vue'
import EditStudentSubject from './components/School/student/EditStudentSubjectComponent.vue'

import RegisterTeacher from './components/School/teacher/RegisterTeacherComponent.vue'
import BatchRegisterTeacher from './components/School/teacher/BatchRegisterTeacherComponent.vue'
import EditTeacher from './components/School/teacher/EditTeacherComponent.vue'
import ListTeacher from './components/School/teacher/ListTeacherComponent.vue'

import AddClassArm from './components/School/classarm/AddClassArmComponent.vue'
import ListClassArm from './components/School/classarm/ListClassArmComponent.vue'
import EditClassArm from './components/School/classarm/EditClassArmComponent.vue'

import ListClassArmSubject from './components/School/classarm/ListClassArmSubjectComponent.vue'
import EditClassArmSubject from './components/School/classarm/EditClassArmSubjectComponent.vue'
import ListClassArmTeacher from './components/School/classarm/ListClassArmTeacherComponent.vue'
import EditClassArmTeacher from './components/School/classarm/EditClassArmTeacherComponent.vue'
import ListClassArmCounsellor from './components/School/classarm/ListClassArmCounsellorComponent.vue'
import EditClassArmCounsellor from './components/School/classarm/EditClassArmCounsellorComponent.vue'
import AssignStudentComponent from './components/School/classarm/AssignStudentComponent.vue'
import RemoveStudentComponent from './components/School/classarm/RemoveStudentComponent.vue'
import AssignTeacherSubjectComponent from './components/School/classarm/AssignTeacherSubjectComponent.vue'

import AddClass from './components/School/clas/AddClassComponent.vue'
import ListClass from './components/School/clas/ListClassComponent.vue'
import EditClass from './components/School/clas/EditClassComponent.vue'

import CreateAdmin from './components/School/admins/CreateAdminComponent.vue'
import ListAdmin from './components/School/admins/ListAdminComponent.vue'
import EditAdmin from './components/School/admins/EditAdminComponent.vue'

import ChangeAdminPassword from './components/School/profile/ChangeAdminPasswordComponent.vue'
import EditAdminProfile from './components/School/profile/EditAdminProfileComponent.vue'
import EditSchoolProfile from './components/School/profile/EditSchoolProfileComponent.vue'
import EditSchoolLogo from './components/School/profile/EditSchoolLogoComponent.vue'
import EditSchoolCounSign from './components/School/profile/EditSchoolCounSignComponent.vue'

import AddLibraryCategory from './components/School/librarian/AddLibraryCategoryComponent.vue'
import ListLibraryCategory from './components/School/librarian/ListLibraryCategoryComponent.vue'
import EditLibraryCategory from './components/School/librarian/EditLibraryCategoryComponent.vue'

import AddBook from './components/School/librarian/AddBookComponent.vue'
import ListBook from './components/School/librarian/ListBookComponent.vue'
import EditBook from './components/School/librarian/EditBookComponent.vue'

import AddLibraryIssue from './components/School/librarian/AddLibraryIssueComponent.vue'
import ListLibraryIssue from './components/School/librarian/ListLibraryIssueComponent.vue'
import EditLibraryIssue from './components/School/librarian/EditLibraryIssueComponent.vue'

import ListTransaction from './components/School/wallet/ListTransactionComponent.vue'

import ListResult from './components/School/result/ListResultComponent.vue'
import BatchUploadResultSubject from './components/School/result/BatchUploadResultSubjectComponent.vue'
import BatchUploadResult from './components/School/result/BatchUploadResultComponent.vue'
import BatchUploadComment from './components/School/result/BatchUploadCommentComponent.vue'
import UpdateResultSign from './components/School/result/UpdateResultSignComponent.vue'
import PromotionStamp from './components/School/result/PromotionStampComponent.vue'
import LockRelease from './components/School/result/LockReleaseComponent.vue'
import ListTermBroadsheet from './components/School/result/ListTermBroadsheetComponent.vue'
import ListSessionBroadsheet from './components/School/result/ListSessionBroadsheetComponent.vue'
import ResultSummaryComponent from './components/School/result/ResultSummaryComponent.vue'

import ListInTeacherTransfer from './components/School/transfer/ListInTeacherTransferComponent.vue'
import ListOutTeacherTransfer from './components/School/transfer/ListOutTeacherTransferComponent.vue'
import NewTeacherTransfer from './components/School/transfer/NewTeacherTransferComponent.vue'
import ProcessTeacherTransfer from './components/School/transfer/ProcessTeacherTransferComponent.vue'
import ListStudentTransfer from './components/School/transfer/ListStudentTransferComponent.vue'

import SchoolIdComponent from './components/School/id-request/SchoolIdComponent.vue'
import PendingSchoolIdComponent from './components/School/id-request/PendingSchoolIdComponent.vue'
import ApproveSchoolIdComponent from './components/School/id-request/ApproveSchoolIdComponent.vue'

import ClassWallet from './components/School/wallet/WalletComponent.vue'
import ClassWalletTransaction from './components/School/wallet/ClasswalletTransactionComponent.vue'
import VerifyPaymentComponent from './components/School/wallet/VerifyPaymentComponent.vue';
import PaymentReceiptComponent from './components/School/wallet/PaymentReceiptComponent.vue';

//Bursar Routes
import BurserLogin from './components/Burser/LoginComponent.vue'
import BurserExample from './components/Burser/ExampleComponent.vue'

import ParentLogin from './components/Parent/LoginComponent.vue'
import ParentExample from './components/Parent/ExampleComponent.vue'

import AeozeoLogin from './components/Aeozeo/LoginComponent.vue'
import AeozeoCreateSecondarySchool from './components/Aeozeo/school/CreateSecondarySchoolComponent.vue'
import AeozeoEditSecondarySchool from './components/Aeozeo/school/EditSecondarySchoolComponent.vue'
import AeozeoListSecondarySchool from './components/Aeozeo/school/ListSecondarySchoolComponent.vue'

import AeozeoCreatePrimarySchool from './components/Aeozeo/school/CreatePrimarySchoolComponent.vue'
import AeozeoEditPrimarySchool from './components/Aeozeo/school/EditPrimarySchoolComponent.vue'
import AeozeoListPrimarySchool from './components/Aeozeo/school/ListPrimarySchoolComponent.vue'

import AeozeoCreateSchoolAdmin from './components/Aeozeo/schoolAdmin/CreateSchoolAdminComponent.vue'
import AeozeoListSchoolAdmin from './components/Aeozeo/schoolAdmin/ListSchoolAdminComponent.vue'
import AeozeoEditSchoolAdmin from './components/Aeozeo/schoolAdmin/EditSchoolAdminComponent.vue'

import AeozeoCreateSingleTeacher from './components/Aeozeo/Teacher/CreateSingleTeacher.vue'
import AeozeoViewSchoolTeacher from './components/Aeozeo/Teacher/ViewSchoolTeacher.vue'
import AeozeoEditSchoolTeacher from './components/Aeozeo/Teacher/EditSchoolTeacher.vue'
import AeozeoCreateBatchTeacher from './components/Aeozeo/Teacher/CreateBatchTeacher.vue'

import AeozeoCreateSingleStudent from './components/Aeozeo/Student/CreateSingleStudent.vue'
import AeozeoViewStudent from './components/Aeozeo/Student/ViewStudent.vue'
import AeozeoViewUnknownStudent from './components/Aeozeo/Student/ViewUnknownStudent.vue'
import AeozeoViewFloatingStudent from './components/Aeozeo/Student/ViewFloatingStudent.vue'
import AeozeoMinistryEditStudent from './components/Aeozeo/Student/EditStudent.vue'
import AeozeoCreateBatchStudent from './components/Aeozeo/Student/CreateBatchStudent.vue'
import AeozeoEligibleStudent from './components/Aeozeo/Student/EligibleStudentComponent.vue'

import AeozeoCreateSingleSubject from './components/Aeozeo/Subject/CreateSingleSubject.vue'
import AeozeoViewSubject from './components/Aeozeo/Subject/ViewSubject.vue'
import AeozeoCreateBatchSubject from './components/Aeozeo/Subject/CreateBatchSubject.vue'
import AeozeoEditSubject from './components/Aeozeo/Subject/EditSubject.vue'

import AeozeoMinistryEditProfile from './components/Aeozeo/User/EditProfile.vue'
import AeozeoMinistryChangePassword from './components/Aeozeo/User/ChangePassword.vue'

import AeozeoMinistryViewResultCard from './components/Aeozeo/ScratchCard/ResultCard.vue'
import AeozeoMinistryViewExamCard from './components/Aeozeo/ScratchCard/ExamCard.vue'

import AeozeoMinistryDepartment from './components/Aeozeo/Department/MinistryDepartment.vue'
import AeozeoMinistryCreateTask from './components/Aeozeo/Task/CreateTask.vue'
import AeozeoMinistryViewTask from './components/Aeozeo/Task/ViewTask.vue'
import AeozeoMinistryEditTask from './components/Aeozeo/Task/EditTask.vue'

import AeozeoMinistrySchoolStatistics from './components/Aeozeo/Statistics/SchoolStatistics.vue'
import AeozeoMinistryLgaSchoolStatistics from './components/Aeozeo/Statistics/LgaSchoolStatistics.vue'
import AeozeoMinistryLgaBroadSchoolStatistics from './components/Aeozeo/Statistics/LgaBroadSchoolStatistics.vue'
import AeozeoMinistryLgaResultStatistics from './components/Aeozeo/Statistics/LgaResultStatistics.vue'
import AeozeoMinistryLgaSubjectStatistics from './components/Aeozeo/Statistics/LgaSubjectStatistics.vue'
import AeozeoMinistryLgaBroadSubjectStatistics from './components/Aeozeo/Statistics/LgaBroadSubjectStatistics.vue'
import AeozeoMinistryLgaStudentStatistics from './components/Aeozeo/Statistics/LgaStudentStatistics.vue'
import AeozeoMinistryLgaSubjectTeachersStatistics from './components/Aeozeo/Statistics/LgaSubjectTeachersStatistics.vue'

import AeozeoCreateSubjectCategory from './components/Aeozeo/Subject/CreateSubjectCategory.vue'
import AeozeoViewSubjectCategory from './components/Aeozeo/Subject/ViewSubjectCategory.vue'

import AeozeoSchoolIdCardRequestComponent from './components/Aeozeo/ID-Request/SchoolIdCardRequestComponent.vue'
import AeozeoListSchoolIdRequestComponent from './components/Aeozeo/ID-Request/ListSchoolIdRequestComponent.vue'

import AeozeoListSchoolPaymentComponent from './components/Aeozeo/PaymentHistory/ListSchoolPaymentComponent.vue'
import AeozeoICPRComponent from './components/Aeozeo/PaymentHistory/ICPRComponent.vue'
import AeozeoSRRComponent from './components/Aeozeo/PaymentHistory/SRRComponent.vue'

import TeacherLogin from './components/Teacher/LoginComponent.vue'
import UpdateTeacherSubject from './components/Teacher/subject/UpdateTeacherSubjectComponent.vue'
import ListTeacherSubject from './components/Teacher/subject/ListTeacherSubjectComponent.vue'

import ChangeTeacherPassword from './components/Teacher/profile/ChangeTeacherPasswordComponent.vue'
import EditTeacherProfile from './components/Teacher/profile/EditTeacherProfileComponent.vue'
import ChangeTeacherSignature from './components/Teacher/profile/ChangeSignatureComponent.vue'
import TeacherOverview from './components/Teacher/profile/OverviewComponent.vue'

import IdentitiesSurveyComponent from './components/School/profile/Survey/IdentitiesSurveyComponent.vue'
import CharacteristicsSurveyComponent from './components/School/profile/Survey/CharacteristicsSurveyComponent.vue'
import ListSchoolSurveyComponent from './components/School/profile/ListSchoolSurveyComponent.vue'
import EnrollmentSurveyComponent from './components/School/profile/Survey/EnrollmentSurveyComponent.vue'
import StaffSurveyComponent from './components/School/profile/Survey/StaffSurveyComponent.vue'
import ClassroomsSurveyComponent from './components/School/profile/Survey/ClassroomsSurveyComponent.vue'
import FacilitiesSurveyComponent from './components/School/profile/Survey/FacilitiesSurveyComponent.vue'
import PupilTeacherSurveyComponent from './components/School/profile/Survey/PupilTeacherSurveyComponent.vue'
import UndertakingSurveyComponent from './components/School/profile/Survey/UndertakingSurveyComponent.vue'
import StudentsbysubjectSurveyComponent from './components/School/profile/Survey/StudentsbysubjectSurveyComponent.vue'
import TeacherQualificationSurveyComponent from './components/School/profile/Survey/TeacherQualificationSurveyComponent.vue'
import FLHESurveyComponent from './components/School/profile/Survey/FLHESurveyComponent.vue'

import ListClassResultComponent from './components/Teacher/result/ListClassResultComponent.vue'
import UploadClassCommentComponent from './components/Teacher/result/UploadClassCommentComponent.vue'
import UploadClassResultComponent from './components/Teacher/result/UploadClassResultComponent.vue'
import UploadSubjectResultComponent from './components/Teacher/result/UploadSubjectResultComponent.vue'

import StudentLogin from './components/Student/LoginComponent.vue'
import EditStudentProfileComponent from './components/Student/Profile/EditStudentProfileComponent.vue'
import EditStudentPasswordComponent from './components/Student/Profile/EditStudentPasswordComponent.vue'
import EditStudentPassportComponent from './components/Student/Profile/EditStudentPassportComponent.vue'
import StudentPaymentReceiptComponent from './components/Student/Receipt/PaymentReceiptComponent.vue'

import StudentTransferComponent from './components/Student/StudentTransferComponent.vue'
import StudentResultComponent from './components/Student/StudentResultComponent.vue'

//cas components
import CasLogin from './components/Cas/LoginComponent.vue'

export const routes = [

    {path: '/ministry/login:return_url', name:'ministry-login', component:MinistryLogin},
    {path: '/school/login:return_url', name:'school-login', component:SchoolLogin},
    {path: '/burser/login:return_url', name:'burser-login', component:BurserLogin},
    {path: '/aeo_zeo/login:return_url', name:'aeo_zeo-login', component:AeozeoLogin},
    {path: '/student/login:return_url', name:'student-login', component:StudentLogin},
    {path: '/parent/login:return_url', name:'parent-login', component:ParentLogin},
    {path: '/teacher/login:return_url', name:'teacher-login', component:TeacherLogin},
    {path: '/liberian/login:return_url', name:'liberian-login', component:LiberianLogin},
    {path: '/cas/login:return_url', name:'cas-login', component:CasLogin},

    {path: '/ministry/dashboard', name:'ministry-dashboard', component:MinistryDashboard},
    {path: '/ministry/school/secondary/create', name:'create-secondary-school', component:CreateSecondarySchool},
    {path: '/ministry/school/secondary/edit/:schoolID', name:'edit-secondary-school', component:EditSecondarySchool},
    {path: '/ministry/school/secondary/list', name:'list-secondary-school', component:ListSecondarySchool},

    {path: '/ministry/school/survey', name:'list-school-survey', component:MinistryListSchoolSurvey},
    {path: '/ministry/school/survey/:surveyId/identitties', name:'ministry-identities-school-survey', component:MinistryIdentitiesSurveyComponent},
    {path: '/ministry/school/survey/:surveyId/characteristics', name:'ministry-characteristics-school-survey', component:MinistryCharacteristicsSurveyComponent},
    {path: '/ministry/school/survey/:surveyId/enrollment', name:'ministry-enrollment-school-survey', component:MinistryEnrollmentSurveyComponent},
    {path: '/ministry/school/survey/:surveyId/staff', name:'ministry-staff-school-survey', component:MinistryStaffSurveyComponent},
    {path: '/ministry/school/survey/:surveyId/classrooms', name:'ministry-classrooms-school-survey', component:MinistryClassroomsSurveyComponent},
    {path: '/ministry/school/survey/:surveyId/facilities', name:'ministry-facilities-school-survey', component:MinistryFacilitiesSurveyComponent},
    {path: '/ministry/school/survey/:surveyId/pupilteacher', name:'ministry-pupilteacher-school-survey', component:MinistryPupilTeacherSurveyComponent},
    {path: '/ministry/school/survey/:surveyId/undertaking', name:'ministry-undertaking-school-survey', component:MinistryUndertakingSurveyComponent},


    {path: '/ministry/school/primary/create', name:'create-primary-school', component:CreatePrimarySchool},
    {path: '/ministry/school/primary/edit/:schoolID', name:'edit-primary-school', component:EditPrimarySchool},
    {path: '/ministry/school/primary/list', name:'list-primary-school', component:ListPrimarySchool},
    {path: '/ministry/school/admin/create', name:'create-school-admin', component:CreateSchoolAdmin},
    {path: '/ministry/school/admin/list', name:'list-school-admin', component:ListSchoolAdmin},
    {path: '/ministry/school/admin/edit/:adminId', name:'edit-school-admin', component:EditSchoolAdmin},
    {path: '/ministry/school/admin/print', name:'print-school-admin', component:PrintSchoolAdmin},
    
    {path: '/ministry/teacher/create', name:'create-single-teacher', component:CreateSingleTeacher},
    {path: '/ministry/teacher/view', name:'view-school-teacher', component:ViewSchoolTeacher},
    {path: '/ministry/teacher/edit/:teacherId', name:'edit-school-teacher', component:EditSchoolTeacher},
    {path: '/ministry/teacher/create/batch', name:'create-batch-teacher', component:CreateBatchTeacher},
    
    {path: '/ministry/student/create', name:'create-single-student', component:CreateSingleStudent},
    {path: '/ministry/student/view', name:'view-registered-student', component:ViewStudent},
    {path: '/ministry/student/unknown', name:'view-unknown-student', component:ViewUnknownStudent},
    {path: '/ministry/student/floating', name:'view-floating-student', component:ViewFloatingStudent},
    {path: '/ministry/student/edit/:studentId', name:'ministry-edit-student', component:MinistryEditStudent},
    {path: '/ministry/student/create/batch', name:'create-batch-student', component:CreateBatchStudent},
    {path: '/ministry/student/eligible', name:'ministry-eligible-student', component:MinistryEligibleStudent},
    
    {path: '/ministry/subject/create', name:'create-single-subject', component:CreateSingleSubject},
    {path: '/ministry/subject/view', name:'view-registered-subject', component:ViewSubject},
    {path: '/ministry/subject/create/batch', name:'create-batch-subject', component:CreateBatchSubject},
    {path: '/ministry/subject/edit/:subjectId', name:'edit-subject', component:EditSubject},

    {path: '/ministry/subject/category/create', name:'create-subject-category', component:CreateSubjectCategory},
    {path: '/ministry/subject/category-subjects/:categoryId', name:'view-category-subject', component:ViewSubjectCategory},
    
    {path: '/ministry/permission/ministry', name:'ministry-admin-permission', component:MinistryPermission},
    {path: '/ministry/permission/aeozeo', name:'aeozeo-admin-permission', component:AeozeoPermission},
    {path: '/ministry/permission/schoolAdmin', name:'school-admin-permission', component:SchoolAdminPermission},
    {path: '/ministry/permission/teacher', name:'teacher-permission', component:TeacherPermission},
    {path: '/ministry/permission/ministry/:userId', name:'edit-ministry-admin-permission', component:EditMinistryPermission},
    {path: '/ministry/permission/schoolAdmin/:userId', name:'edit-school-admin-permission', component:EditSchoolAdminPermission},
    {path: '/ministry/permission/teacher/:userId', name:'edit-teacher-permission', component:EditTeacherPermission},

    {path: '/ministry/create/account', name:'ministry-create-account', component:CreateMinistryAccount},
    {path: '/ministry/create/aeozeo/account', name:'ministry-create-aeozeo-account', component:CreateAeozeoAccount},
    {path: '/ministry/edit/aeozeo/account/:adminId', name:'ministry-edit-aeozeo-account', component:EditAeozeoAccount},
    {path: '/ministry/aeozeo/list', name:'ministry-list-aeozeo-admin', component:ListAeozeoAdmin},
    {path: '/ministry/password/change', name:'ministry-change-password', component:MinistryChangePassword},
    {path: '/ministry/profile/edit', name:'ministry-edit-profile', component:MinistryEditProfile},
    {path: '/ministry/create/cas-admin/account', name:'ministry-create-cas-admin-account', component:CreateCasAccount},
    {path: '/ministry/cas-admin/list', name:'ministry-list-cas-admin', component:ListCasAdmin},
    {path: '/ministry/edit/cas-admin/account/:adminId', name:'ministry-edit-cas-admin-account', component:EditCasAccount},

    {path: '/ministry/result/scratch-card/view', name:'ministry-result-scratch-card-view', component:MinistryViewResultCard},
    {path: '/ministry/exam/scratch-card/view', name:'ministry-exam-scratch-card-view', component:MinistryViewExamCard},

    {path: '/ministry/department', name:'ministry-department', component:MinistryDepartment},
    {path: '/ministry/task/create', name:'ministry-create-task', component:MinistryCreateTask},
    {path: '/ministry/task/view', name:'ministry-view-task', component:MinistryViewTask},
    {path: '/ministry/task/edit/:taskId', name:'ministry-edit-task', component:MinistryEditTask},
   
    {path: '/ministry/school-statistics', name:'ministry-school-statistics', component:MinistrySchoolStatistics},
    {path: '/ministry/lga/school-statistics', name:'ministry-lga-school-statistics', component:MinistryLgaSchoolStatistics},
    {path: '/ministry/lga/broad/school-statistics', name:'ministry-lga-broad-school-statistics', component:MinistryLgaBroadSchoolStatistics},
    {path: '/ministry/lga/result-statistics', name:'ministry-lga-result-statistics', component:MinistryLgaResultStatistics},
    {path: '/ministry/lga/subject-statistics', name:'ministry-lga-subject-statistics', component:MinistryLgaSubjectStatistics},
    {path: '/ministry/lga/broad-subject-statistics', name:'ministry-lga-broad-subject-statistics', component:MinistryLgaBroadSubjectStatistics},
    {path: '/ministry/lga/student-statistics', name:'ministry-lga-student-statistics', component:MinistryLgaStudentStatistics},
    {path: '/ministry/lga/subject-teachers-statistics', name:'ministry-lga-subject-teachers-statistics', component:MinistryLgaSubjectTeachersStatistics},

    {path: '/ministry/schools-wallet', name:'ministry-schools-wallet', component:MinistrySchoolWallet},
    {path: '/ministry/create/schools-wallet', name:'ministry-create-wallet', component:MinistryCreateSchoolWallet},
    {path: '/ministry/wallet/transaction/:schoolId', name:'ministry-wallet-transaction', component:MinistryWalletTransaction},
    {path: '/ministry/wallet/analysis/:schoolId', name:'ministry-wallet-analysis', component:MinistryWalletAnalysis},

    {path: '/ministry/school-id-card-request/schools', name:'ministry-school-id-request', component:ListSchoolIdRequestComponent},
    {path: '/ministry/school-id-card-request/:schoolID', name:'ministry-school-id-card-request', component:SchoolIdCardRequestComponent},

    {path: '/ministry/payment-history', name:'ministry-school-payment-history', component:ListSchoolPaymentComponent},
    {path: '/ministry/payment-history/icpr', name:'ministry-payment-history-icpr', component:ICPRComponent},
    {path: '/ministry/payment-history/srr', name:'ministry-payment-history-srr', component:SRRComponent},

    {path: '/ministry/ministry-activities-log', name:'ministry-activities-log', component:MinistryActivityLog},
    {path: '/ministry/ministry-activities-log/:adminId', name:'view-ministry-activities-log', component:ViewMinistryActivityLog},
    {path: '/ministry/school-activities-log', name:'school-activities-log', component:SchoolActivityLog},
    {path: '/ministry/school-activities-log/:adminId', name:'view-school-activities-log', component:ViewSchoolActivityLog},
    {path: '/ministry/teacher-activities-log', name:'teacher-activities-log', component:TeacherActivityLog},
    {path: '/ministry/teacher-activities-log/:adminId', name:'view-teacher-activities-log', component:ViewTeacherActivityLog},
    {path: '/ministry/student-activities-log', name:'student-activities-log', component:StudentActivityLog},
    {path: '/ministry/student-activities-log/:adminId', name:'view-student-activities-log', component:ViewStudentActivityLog},
    
    {path: '/ministry/result/summary', name:'ministry-result-summary', component:MinistryResultSummaryComponent},

    {path: '/ministry/transfer/teachers', name: 'list-teacher-transfer', component: MinistryListInOutTeacherTransferComponent},
    {path: '/ministry/transfer/new/teacher', name: 'ministry-new-teacher-transfer', component: MinistryNewTeacherTransfer},
    {path: '/ministry/transfer/process/teacher/:teacherID', name: 'ministry-process-teacher-transfer', component: MinistryProcessTeacherTransfer},

    // school routes
    {path: '/school/dashboard', name:'school-dashboard', component:SchoolDashboard},
    {path: '/school/house/create', name:'create-school-house', component:CreateSchoolHouse},
    {path: '/school/house/edit/:houseID', name:'edit-school-house', component:EditSchoolHouse},
    {path: '/school/house/list', name:'list-school-house', component:ListSchoolHouse},

    {path: '/school/debtor/add', name:'add-debtor', component:AddDebtor},
    {path: '/school/debtor/edit/:debtorID', name:'edit-debtor', component:EditDebtor},
    {path: '/school/debtor/list', name:'list-debtor', component:ListDebtor},

    {path: '/school/student/register', name:'register-student', component:RegisterStudent},
    {path: '/school/student/batchregister', name:'batch-register-student', component:BatchRegisterStudent},
    {path: '/school/student/edit/:studentID', name:'edit-student', component:EditStudent},
    {path: '/school/student/list', name:'list-student', component:ListStudent},
    {path: '/school/student/listfloating', name:'list-floating-student', component:ListFloatingStudent},
    {path: '/school/student/editfloating/:studentID', name:'edit-floating-student', component:EditFloatingStudent},
    {path: '/school/student/passportupload', name:'batch-upload-student-passport', component:BatchStudentPassportUpload},
    {path: '/school/student/eligible', name:'eligible-student', component:EligibleStudent},

    {path: '/school/student/subject/list', name:'list-student-subject', component:ListStudentSubject},
    {path: '/school/student/subject/edit/:studentID', name:'edit-student-subject', component:EditStudentSubject},

    {path: '/school/teacher/register', name:'register-teacher', component:RegisterTeacher},
    {path: '/school/teacher/batchregister', name:'batch-register-teacher', component:BatchRegisterTeacher},
    {path: '/school/teacher/edit/:teacherID', name:'edit-teacher', component:EditTeacher},
    {path: '/school/teacher/list', name:'list-teacher', component:ListTeacher},

    {path: '/school/classarm/add', name:'add-classarm', component:AddClassArm},
    {path: '/school/classarm/list', name:'list-classarm', component:ListClassArm},
    {path: '/school/classarm/edit/:classArmID', name:'edit-classarm', component:EditClassArm},
    {path: '/school/classarm/subject/list', name:'list-classarm-subject', component:ListClassArmSubject},
    {path: '/school/classarm/subject/edit/:classArmID', name:'edit-classarm-subject', component:EditClassArmSubject},
    {path: '/school/classarm/teacher/list', name:'list-classarm-teacher', component:ListClassArmTeacher},
    {path: '/school/classarm/teacher/edit/:classArmID', name:'edit-classarm-teacher', component:EditClassArmTeacher},
    {path: '/school/classarm/counsellor/list', name:'list-classarm-counsellor', component:ListClassArmCounsellor},
    {path: '/school/classarm/counsellor/edit/:classArmID', name:'edit-classarm-counsellor', component:EditClassArmCounsellor},
    {path: '/school/classarm/student/list', name:'list-classarm-student', component:AssignStudentComponent},
    {path: '/school/classarm/student/remove', name:'remove-classarm-student', component:RemoveStudentComponent},
    {path: '/school/classarm/teacher/subject', name:'assign-teacher-subject', component:AssignTeacherSubjectComponent},

    {path: '/school/class/add', name:'add-class', component:AddClass},
    {path: '/school/class/list', name:'list-class', component:ListClass},
    {path: '/school/class/edit/:classID', name:'edit-class', component:EditClass},

    {path: '/school/admin/create', name:'create-admin', component:CreateAdmin},
    {path: '/school/admin/list', name:'list-admin', component:ListAdmin},
    {path: '/school/admin/edit/:adminID', name:'edit-admin', component:EditAdmin},

    {path: '/school/profile/changepass', name:'change-admin-password', component:ChangeAdminPassword},
    {path: '/school/adminprofile/edit/', name:'edit-admin-profile', component:EditAdminProfile},
    {path: '/school/profile/edit/', name:'edit-admin-school-profile', component:EditSchoolProfile},
    {path: '/school/logo/edit/', name:'edit-school-logo', component:EditSchoolLogo},
    {path: '/school/counsign/edit/', name:'edit-school-counsign', component:EditSchoolCounSign},

    {path: '/school/library/category/add', name:'add-library-category', component:AddLibraryCategory},
    {path: '/school/library/category/list', name:'list-library-category', component:ListLibraryCategory},
    {path: '/school/library/category/edit/:catID', name:'edit-library-category', component:EditLibraryCategory},

    {path: '/school/library/book/add', name:'add-library-book', component:AddBook},
    {path: '/school/library/book/list', name:'list-library-book', component:ListBook},
    {path: '/school/library/book/edit/:bookID', name:'edit-library-book', component:EditBook},

    {path: '/school/library/issue/add', name:'add-library-issue', component:AddLibraryIssue},
    {path: '/school/library/issue/list', name:'list-library-issue', component:ListLibraryIssue},
    {path: '/school/library/issue/edit/:issueID', name:'edit-library-issue', component:EditLibraryIssue},

    {path: '/school/transaction/list', name:'list-school-transaction', component:ListTransaction},

    {path: '/school/result/list', name:'list-school-result', component:ListResult},
    {path: '/school/result/uploadbysubject', name:'upload-school-subject-result', component:BatchUploadResultSubject},
    {path: '/school/result/uploadall', name:'upload-school-result', component:BatchUploadResult},
    {path: '/school/result/comment/upload', name:'upload-result-comment', component:BatchUploadComment},
    {path: '/school/result/updatesign', name:'update-result-sign',component:UpdateResultSign},
    {path: '/school/result/promotionstamp', name:'result-promotion-stamp',component:PromotionStamp},
    {path: '/school/result/lockrelease', name:'result-lock-release',component:LockRelease},
    {path: '/school/result/termbroadsheet', name: 'list-term-broadsheet', component: ListTermBroadsheet},
    {path: '/school/result/sessionbroadsheet', name: 'list-session-broadsheet', component: ListSessionBroadsheet},
    {path: '/school/result/summary', name: 'list-result-summary', component: ResultSummaryComponent},

    {path: '/school/transfer/teacherinward', name: 'list-teacher-transfer-inward', component: ListInTeacherTransfer},
    {path: '/school/transfer/teacheroutward', name: 'list-teacher-transfer-outward', component: ListOutTeacherTransfer},
    {path: '/school/transfer/new/teacher', name: 'new-teacher-transfer', component: NewTeacherTransfer},
    {path: '/school/transfer/process/teacher/:teacherID', name: 'process-teacher-transfer', component: ProcessTeacherTransfer},
    {path: '/school/transfer/student', name: 'list-student-transfer', component: ListStudentTransfer},

    {path: '/school/school-id-card-request', name:'school-id-request', component:SchoolIdComponent},
    {path: '/school/school-id-card-request/appoved', name:'approve-school-id-request', component:ApproveSchoolIdComponent},
    {path: '/school/school-id-card-request/pending', name:'pending-school-id-request', component:PendingSchoolIdComponent},

    {path: '/school/class-wallet', name:'class-wallet', component:ClassWallet},
    {path: '/school/class-wallet/transactions/:walletId', name:'class-wallet-transaction', component:ClassWalletTransaction},
    {path: '/school/class-wallet/verify-payment', name:'verify-payment', component:VerifyPaymentComponent},
    {path: '/school/class-wallet/payment-receipt', name:'payment-receipt', component:PaymentReceiptComponent},

    {path: '/liberian/dashboard', name:'liberian-dashboard', component:LiberianDashboard},
    {path: '/liberian/example', name:'liberian-example-page', component:LiberianExample},

    {path: '/burser/dashboard', name:'burser-dashboard', component:BurserDashboard},
    {path: '/burser/example', name:'burser-example-page', component:BurserExample},

    {path: '/parent/dashboard', name:'parent-dashboard', component:ParentDashboard},
    {path: '/parent/example', name:'parent-example-page', component:ParentExample},

    {path: '/teacher/dashboard', name:'teacher-dashboard', component:TeacherDashboard},
    {path: '/teacher/subject/update', name:'update-teacher-subject', component:UpdateTeacherSubject},
    {path: '/teacher/subject/list', name:'list-teacher-subject', component:ListTeacherSubject},

    {path: '/teacher/profile/changepass', name:'change-teacher-password', component:ChangeTeacherPassword},
    {path: '/teacher/profile/edit/', name:'edit-teacher-profile', component:EditTeacherProfile},
    {path: '/teacher/signature', name:'change-teacher-signature', component:ChangeTeacherSignature},
    {path: '/teacher/overview', name:'edit-teacher-overview', component:TeacherOverview},

    {path: '/school/survey/:surveyId/identitties', name:'identities-school-survey', component:IdentitiesSurveyComponent},
    {path: '/school/survey', name:'school-survey', component:ListSchoolSurveyComponent},
    {path: '/school/survey/:surveyId/characteristics', name:'characteristics-school-survey', component:CharacteristicsSurveyComponent},
    {path: '/school/survey/:surveyId/enrollment', name:'enrollment-school-survey', component:EnrollmentSurveyComponent},
    {path: '/school/survey/:surveyId/staff', name:'staff-school-survey', component:StaffSurveyComponent},
    {path: '/school/survey/:surveyId/classrooms', name:'classrooms-school-survey', component:ClassroomsSurveyComponent},
    {path: '/school/survey/:surveyId/facilities', name:'facilities-school-survey', component:FacilitiesSurveyComponent},
    {path: '/school/survey/:surveyId/pupilteacher', name:'pupilteacher-school-survey', component:PupilTeacherSurveyComponent},
    {path: '/school/survey/:surveyId/undertaking', name:'undertaking-school-survey', component:UndertakingSurveyComponent},
    {path: '/school/survey/:surveyId/studentsbysubject', name:'studentsbysubject-school-survey', component:StudentsbysubjectSurveyComponent},
    {path: '/school/survey/:surveyId/teacherqualification', name:'teacherqualification-school-survey', component:TeacherQualificationSurveyComponent},
    {path: '/school/survey/:surveyId/flhe', name:'flhe-school-survey', component:FLHESurveyComponent},
    


    {path: '/teacher/upload-subject-result', name:'teacher-upload-subject-result', component:UploadSubjectResultComponent},
    {path: '/teacher/upload-class-result', name:'teacher-upload-class-result', component:UploadClassResultComponent},
    {path: '/teacher/upload-class-comment', name:'teacher-upload-class-comment', component:UploadClassCommentComponent},
    {path: '/teacher/list-class-result', name:'teacher-list-class-result', component:ListClassResultComponent},

    {path: '/aeo_zeo/dashboard', name:'aeo-zeo-dashboard', component:AeozeoDashboard},
    {path: '/aeo_zeo/school/secondary/create', name:'aeo-zeo-create-secondary-school', component:AeozeoCreateSecondarySchool},
    {path: '/aeo_zeo/school/secondary/edit/:schoolID', name:'aeo-zeo-edit-secondary-school', component:AeozeoEditSecondarySchool},
    {path: '/aeo_zeo/school/secondary/list', name:'aeo-zeo-list-secondary-school', component:AeozeoListSecondarySchool},

    {path: '/aeo_zeo/school/primary/create', name:'aeo-zeo-create-primary-school', component:AeozeoCreatePrimarySchool},
    {path: '/aeo_zeo/school/primary/edit/:schoolID', name:'aeo-zeo-edit-primary-school', component:AeozeoEditPrimarySchool},
    {path: '/aeo_zeo/school/primary/list', name:'aeo-zeo-list-primary-school', component:AeozeoListPrimarySchool},
    {path: '/aeo_zeo/school/admin/create', name:'aeo-zeo-create-school-admin', component:AeozeoCreateSchoolAdmin},
    {path: '/aeo_zeo/school/admin/list', name:'aeo-zeo-list-school-admin', component:AeozeoListSchoolAdmin},
    {path: '/aeo_zeo/school/admin/edit/:adminId', name:'aeo-zeo-edit-school-admin', component:AeozeoEditSchoolAdmin},
    
    {path: '/aeo_zeo/teacher/create', name:'aeo-zeo-create-single-teacher', component:AeozeoCreateSingleTeacher},
    {path: '/aeo_zeo/teacher/view', name:'aeo-zeo-view-school-teacher', component:AeozeoViewSchoolTeacher},
    {path: '/aeo_zeo/teacher/edit/:teacherId', name:'aeo-zeo-edit-school-teacher', component:AeozeoEditSchoolTeacher},
    {path: '/aeo_zeo/teacher/create/batch', name:'aeo-zeo-create-batch-teacher', component:AeozeoCreateBatchTeacher},
    
    {path: '/aeo_zeo/student/create', name:'aeo-zeo-create-single-student', component:AeozeoCreateSingleStudent},
    {path: '/aeo_zeo/student/view', name:'aeo-zeo-view-registered-student', component:AeozeoViewStudent},
    {path: '/aeo_zeo/student/unknown', name:'aeo-zeo-view-unknown-student', component:AeozeoViewUnknownStudent},
    {path: '/aeo_zeo/student/floating', name:'aeo-zeo-view-floating-student', component:AeozeoViewFloatingStudent},
    {path: '/aeo_zeo/student/edit/:studentId', name:'aeo-zeo-ministry-edit-student', component:AeozeoMinistryEditStudent},
    {path: '/aeo_zeo/student/create/batch', name:'aeo-zeo-create-batch-student', component:AeozeoCreateBatchStudent},
    {path: '/aeo_zeo/student/eligible', name:'aeozeo-eligible-student', component:AeozeoEligibleStudent},

    {path: '/aeo_zeo/subject/create', name:'aeo-zeo-create-single-subject', component:AeozeoCreateSingleSubject},
    {path: '/aeo_zeo/subject/view', name:'aeo-zeo-view-registered-subject', component:AeozeoViewSubject},
    {path: '/aeo_zeo/subject/create/batch', name:'aeo-zeo-create-batch-subject', component:AeozeoCreateBatchSubject},
    {path: '/aeo_zeo/subject/edit/:subjectId', name:'aeo-zeo-edit-subject', component:AeozeoEditSubject},

    {path: '/aeo_zeo/subject/category/create', name:'aeo-zeo-create-subject-category', component:AeozeoCreateSubjectCategory},
    {path: '/aeo_zeo/subject/category-subjects/:categoryId', name:'aeo-zeo-view-category-subject', component:AeozeoViewSubjectCategory},

    {path: '/aeo_zeo/password/change', name:'aeo-zeo-ministry-change-password', component:AeozeoMinistryChangePassword},
    {path: '/aeo_zeo/profile/edit', name:'aeo-zeo-ministry-edit-profile', component:AeozeoMinistryEditProfile},

    {path: '/aeo_zeo/result/scratch-card/view', name:'aeo-zeo-ministry-result-scratch-card-view', component:AeozeoMinistryViewResultCard},
    {path: '/aeo_zeo/exam/scratch-card/view', name:'aeo-zeo-ministry-exam-scratch-card-view', component:AeozeoMinistryViewExamCard},

    {path: '/aeo_zeo/department', name:'aeo-zeo-ministry-department', component:AeozeoMinistryDepartment},
    {path: '/aeo_zeo/task/create', name:'aeo-zeo-ministry-create-task', component:AeozeoMinistryCreateTask},
    {path: '/aeo_zeo/task/view', name:'aeo-zeo-ministry-view-task', component:AeozeoMinistryViewTask},
    {path: '/aeo_zeo/task/edit/:taskId', name:'aeo-zeo-ministry-edit-task', component:AeozeoMinistryEditTask},
   
    {path: '/aeo_zeo/school-statistics', name:'aeo-zeo-ministry-school-statistics', component:AeozeoMinistrySchoolStatistics},
    {path: '/aeo_zeo/lga/school-statistics', name:'aeo-zeo-ministry-lga-school-statistics', component:AeozeoMinistryLgaSchoolStatistics},
    {path: '/aeo_zeo/lga/broad/school-statistics', name:'aeo-zeo-ministry-lga-broad-school-statistics', component:AeozeoMinistryLgaBroadSchoolStatistics},
    {path: '/aeo_zeo/lga/result-statistics', name:'aeo-zeo-ministry-lga-result-statistics', component:AeozeoMinistryLgaResultStatistics},
    {path: '/aeo_zeo/lga/subject-statistics', name:'aeo-zeo-ministry-lga-subject-statistics', component:AeozeoMinistryLgaSubjectStatistics},
    {path: '/aeo_zeo/lga/broad-subject-statistics', name:'aeo-zeo-ministry-lga-broad-subject-statistics', component:AeozeoMinistryLgaBroadSubjectStatistics},
    {path: '/aeo_zeo/lga/student-statistics', name:'aeo-zeo-ministry-lga-student-statistics', component:AeozeoMinistryLgaStudentStatistics},
    {path: '/aeo_zeo/lga/subject-teachers-statistics', name:'aeo-zeo-ministry-lga-subject-teachers-statistics', component:AeozeoMinistryLgaSubjectTeachersStatistics},

    {path: '/aeo_zeo/school-id-card-request/schools', name:'aeo-zeo-ministry-school-id-request', component:AeozeoListSchoolIdRequestComponent},
    {path: '/aeo_zeo/school-id-card-request/:schoolID', name:'aeo-zeo-ministry-school-id-card-request', component:AeozeoSchoolIdCardRequestComponent},

    {path: '/aeo_zeo/payment-history', name:'aeo-zeo-ministry-school-payment-history', component:AeozeoListSchoolPaymentComponent},
    {path: '/aeo_zeo/payment-history/icpr', name:'aeo-zeo-ministry-payment-history-icpr', component:AeozeoICPRComponent},
    {path: '/aeo_zeo/payment-history/srr', name:'aeo-zeo-ministry-payment-history-srr', component:AeozeoSRRComponent},

    {path: '/student/dashboard', name:'student-dashboard', component:StudentDashboard},
    {path: '/student/profile/edit', name:'student-profile-edit', component:EditStudentProfileComponent},
    {path: '/student/password/edit', name:'student-password-edit', component:EditStudentPasswordComponent},
    {path: '/student/passport/edit', name:'student-passport-edit', component:EditStudentPassportComponent},

    {path: '/student/receipt/print', name:'student-receipt-print', component:StudentPaymentReceiptComponent},
    {path: '/student/transfer/form', name:'student-transfer-form', component:StudentTransferComponent},
    {path: '/student/view/result', name:'student-view-result', component:StudentResultComponent},

    // cas 
  
    {path: '/cas/dashboard', name:'cas-dashboard', component:MinistryDashboard},
    {path: '/cas/school/secondary/create', name:'cas-create-secondary-school', component:CreateSecondarySchool},
    {path: '/cas/school/secondary/edit/:schoolID', name:'cas-edit-secondary-school', component:EditSecondarySchool},
    {path: '/cas/school/secondary/list', name:'cas-list-secondary-school', component:ListSecondarySchool},

    {path: '/cas/school/survey', name:'cas-list-school-survey', component:MinistryListSchoolSurvey},
    {path: '/cas/school/survey/:surveyId/identitties', name:'cas-identities-school-survey', component:MinistryIdentitiesSurveyComponent},
    {path: '/cas/school/survey/:surveyId/characteristics', name:'cas-characteristics-school-survey', component:MinistryCharacteristicsSurveyComponent},
    {path: '/cas/school/survey/:surveyId/enrollment', name:'cas-enrollment-school-survey', component:MinistryEnrollmentSurveyComponent},
    {path: '/cas/school/survey/:surveyId/staff', name:'cas-staff-school-survey', component:MinistryStaffSurveyComponent},
    {path: '/cas/school/survey/:surveyId/classrooms', name:'cas-classrooms-school-survey', component:MinistryClassroomsSurveyComponent},
    {path: '/cas/school/survey/:surveyId/facilities', name:'cas-facilities-school-survey', component:MinistryFacilitiesSurveyComponent},
    {path: '/cas/school/survey/:surveyId/pupilteacher', name:'cas-pupilteacher-school-survey', component:MinistryPupilTeacherSurveyComponent},
    {path: '/cas/school/survey/:surveyId/undertaking', name:'cas-undertaking-school-survey', component:MinistryUndertakingSurveyComponent},


    {path: '/cas/school/primary/create', name:'cas-create-primary-school', component:CreatePrimarySchool},
    {path: '/cas/school/primary/edit/:schoolID', name:'cas-edit-primary-school', component:EditPrimarySchool},
    {path: '/cas/school/primary/list', name:'cas-list-primary-school', component:ListPrimarySchool},
    {path: '/cas/school/admin/create', name:'cas-create-school-admin', component:CreateSchoolAdmin},
    {path: '/cas/school/admin/list', name:'cas-list-school-admin', component:ListSchoolAdmin},
    {path: '/cas/school/admin/edit/:adminId', name:'cas-edit-school-admin', component:EditSchoolAdmin},
    {path: '/cas/school/admin/print', name:'cas-print-school-admin', component:PrintSchoolAdmin},
    
    {path: '/cas/teacher/create', name:'cas-create-single-teacher', component:CreateSingleTeacher},
    {path: '/cas/teacher/view', name:'cas-view-school-teacher', component:ViewSchoolTeacher},
    {path: '/cas/teacher/edit/:teacherId', name:'cas-edit-school-teacher', component:EditSchoolTeacher},
    {path: '/cas/teacher/create/batch', name:'cas-create-batch-teacher', component:CreateBatchTeacher},
    
    {path: '/cas/student/create', name:'cas-create-single-student', component:CreateSingleStudent},
    {path: '/cas/student/view', name:'cas-view-registered-student', component:ViewStudent},
    {path: '/cas/student/unknown', name:'cas-view-unknown-student', component:ViewUnknownStudent},
    {path: '/cas/student/floating', name:'cas-view-floating-student', component:ViewFloatingStudent},
    {path: '/cas/student/edit/:studentId', name:'cas-edit-student', component:MinistryEditStudent},
    {path: '/cas/student/create/batch', name:'cas-create-batch-student', component:CreateBatchStudent},
    {path: '/cas/student/eligible', name:'cas-eligible-student', component:MinistryEligibleStudent},
    
    {path: '/cas/subject/create', name:'cas-create-single-subject', component:CreateSingleSubject},
    {path: '/cas/subject/view', name:'cas-view-registered-subject', component:ViewSubject},
    {path: '/cas/subject/create/batch', name:'cas-create-batch-subject', component:CreateBatchSubject},
    {path: '/cas/subject/edit/:subjectId', name:'cas-edit-subject', component:EditSubject},

    {path: '/cas/subject/category/create', name:'cas-create-subject-category', component:CreateSubjectCategory},
    {path: '/cas/subject/category-subjects/:categoryId', name:'cas-view-category-subject', component:ViewSubjectCategory},
    

    {path: '/cas/password/change', name:'cas-change-password', component:MinistryChangePassword},
    {path: '/cas/create/cas-admin/account', name:'cas-create-cas-admin-account', component:CreateCasAccount},
    {path: '/cas/cas-admin/list', name:'cas-list-cas-admin', component:ListCasAdmin},
    {path: '/cas/edit/cas-admin/account/:adminId', name:'cas-edit-cas-admin-account', component:EditCasAccount},

    {path: '/cas/school-statistics', name:'cas-school-statistics', component:MinistrySchoolStatistics},
    {path: '/cas/lga/school-statistics', name:'cas-lga-school-statistics', component:MinistryLgaSchoolStatistics},
    {path: '/cas/lga/broad/school-statistics', name:'cas-lga-broad-school-statistics', component:MinistryLgaBroadSchoolStatistics},
    {path: '/cas/lga/result-statistics', name:'cas-lga-result-statistics', component:MinistryLgaResultStatistics},
    {path: '/cas/lga/subject-statistics', name:'cas-lga-subject-statistics', component:MinistryLgaSubjectStatistics},
    {path: '/cas/lga/broad-subject-statistics', name:'cas-lga-broad-subject-statistics', component:MinistryLgaBroadSubjectStatistics},
    {path: '/cas/lga/student-statistics', name:'cas-lga-student-statistics', component:MinistryLgaStudentStatistics},
    {path: '/cas/lga/subject-teachers-statistics', name:'cas-lga-subject-teachers-statistics', component:MinistryLgaSubjectTeachersStatistics},

    {path: '/cas/school-id-card-request/schools', name:'cas-school-id-request', component:ListSchoolIdRequestComponent},
    {path: '/cas/school-id-card-request/:schoolID', name:'cas-school-id-card-request', component:SchoolIdCardRequestComponent},

    {path: '/cas/result/summary', name:'cas-result-summary', component:MinistryResultSummaryComponent},

    {path: '/cas/transfer/teachers', name: 'cas-list-teacher-transfer', component: MinistryListInOutTeacherTransferComponent},
    {path: '/cas/transfer/new/teacher', name: 'cas-new-teacher-transfer', component: MinistryNewTeacherTransfer},
    {path: '/cas/transfer/process/teacher/:teacherID', name: 'cas-process-teacher-transfer', component: MinistryProcessTeacherTransfer},

  ]