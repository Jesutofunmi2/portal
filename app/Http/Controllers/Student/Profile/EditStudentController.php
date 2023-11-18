<?php

namespace App\Http\Controllers\Student\Profile;

use App\Http\Controllers\Controller;
use App\Http\Helper\ImageUploader;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class EditStudentController extends Controller
{
    protected $students;

    public function __construct(StudentRepositoryInterface $students) 
    {
        $this->students = $students;

        $this->middleware('auth:student_api');
    }

    public function index()
    {

        $student = $this->students->find(Auth::guard('student_api')->id());

        return response()->json([
            'data' => [
                'student' => $student,
            ]
        ]);

        //return new ShowTeacherResource($teacher);
    }

    public function update(Request $request)
    {
        $student_update = $this->students->find(Auth::guard('student_api')->id());

        $student = $this->students->setStudent();

        $student::$rules['password'] = 'sometimes|alpha_num|min:6|confirmed';
        $student::$rules['password_confirmation'] = 'sometimes|alpha_num|min:6';
        $student::$rules['parent_email'] = '';
        $student::$rules['term'] = '';
        $student::$rules['class_arm_id'] = '';
        $student::$rules['class_id'] = '';

        $this->validate($request, $student::$rules);

        $details = [
            'surname' => $request->input('surname'),
            'firstname' => $request->input('firstname'),
            'middlename' => $request->input('middlename'),
            'dob' => $request->input('dob'),
            'gender' => $request->input('gender'),
            'address' => $request->input('address'),
            'state_id' => $request->input('state_id'),
            'lga_id' => $request->input('lga_id'),
            'house_id' => $request->input('house_id'),
            'religion' => $request->input('religion'),
            'parent_fullname' => $request->input('parent_fullname'),
            'parent_address' => $request->input('parent_address'),
            'parent_email' => $request->input('parent_email'),
            'parent_phone' => $request->input('parent_phone'),
            'phone' => $request->input('phone'),
            'blood_group' => $request->input('blood_group'),       
        ];

        $student_update->update($details);

        return response()->json([
            'data' => [
                'message' => 'Student Updated successfully'
            ]
        ]);
    }

    public function passwordUpdate(Request $request)
    {
    
        $student_update = $this->students->find(Auth::guard('student_api')->id());

        $this->validate($request, [
            'old_password' => 'required|string',
            'new_password' => 'required|string|alpha_num|min:6',
            'confirm_password' => 'required|same:new_password|string|alpha_num|min:6|'
        ]);

        if(Hash::check($request->old_password, $student_update->password)) {
            $student_update->update([
                'password' => Hash::make($request->new_password)
            ]);
        } 
        else {
            return response()->json([
                'data' => [
                    'message' => 'Incorrect old password'
                ]
            ], 400);
        }

        return response()->json([
            'data' => [
                'message' => 'Password Updated successfully'
            ]
        ]);
    }

    public function passportUpdate(Request $request)
    {
    
        $student_update = $this->students->find(Auth::guard('student_api')->id());

        $this->validate($request, [
            'passport' => 'required|image|mimes:jpeg,jpg,png|max:2048'
        ]);

        if ($request->hasFile('passport')) {
            if ($student_update->passport != '/images/passports/no_img_da88a72526.gif') {
                if(file_exists(public_path(explode('?', ltrim($student_update->passport, '/'))[0])))
                {
                    unlink( public_path(explode('?', ltrim($student_update->passport, '/'))[0]) );
                }
                if(file_exists(public_path($student_update->passport)))
                {
                    unlink(public_path($student_update->passport));
                }
            }
            $image = $request->file('passport');
            $extension = $request->file('passport')->extension();
            $passport_path = md5(time())."-".$student_update->surname."-".$student_update->firstname.".".$extension;
            
            Image::make($image->getRealPath())->resize(250,null, function($constraint)
            {
                $constraint->aspectRatio();

            })->save(public_path() . '/images/passports/students/'.$passport_path);

            $student_update->passport = '/images/passports/students/'.$passport_path;

            $student_update->save();
        }

        return response()->json([
            'data' => [
                'message' => 'Passport Updated successfully'
            ]
        ]);
    }
}
