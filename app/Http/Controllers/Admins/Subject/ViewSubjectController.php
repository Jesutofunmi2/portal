<?php

namespace App\Http\Controllers\Admins\Subject;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectResource;
use App\Repositories\Interfaces\SubjectRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ViewSubjectController extends Controller
{
    /**
    * Subject Repository class
    * @var obj
    */
    protected $subject;

    /**
    * Initialise Controller
    */
    public function __construct(SubjectRepositoryInterface $subject) {
        $this->middleware('auth:school_api');

        $this->subject = $subject;
    }

    /**
    * Retrieve all Subjects from a School
    *
    * @param Request $request
    * @return Resource 
     */
     public function index(Request $request) {
        if($this->permissionDeny('view-subject')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $subjects = $this->subject
        ->setSubject()
        ->orderBy('subject_name', 'asc')
        ->get();

        return SubjectResource::collection($subjects);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
