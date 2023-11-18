<?php

namespace App\Http\Controllers\Ministry\Subject;

use Auth;
use Gate;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\SubjectCategory;
use App\Http\Helper\ExcelHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SubjectCategoryController extends Controller
{

    public function create(Request $request): JsonResponse
    {
        if($this->permissionDeny('create-subject')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $this->validate($request, [
            'name' => ['required', 'string', 'unique:subject_categories,name']
            ]);

        SubjectCategory::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'data' => [
                'message' => 'Subject Category Created Successfully'
            ]
        ]);
    }

    public function delete($id): JsonResponse
    {
        if($this->permissionDeny('delete-subject')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        DB::transaction(function() use ($id) {
            $delete = SubjectCategory::findOrFail($id);
            $delete->delete();

            // we remove the id of deleted subject category from subjects
            Subject::where('subject_category', $id)->update(['subject_category' => null]);
        });
        
        return response()->json([
            'data' => [
                'message' => 'Category Deleted Successfully'
            ]
        ]);
    }

    public function view(Request $request): JsonResponse
    {
        if($this->permissionDeny('view-subject')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $categories = SubjectCategory::all();

        return response()->json([
            'data' => [
                'categories' => $categories
            ]
        ]);
    }

    public function viewSubjects(Request $request): JsonResponse
    {
        if($this->permissionDeny('view-subject')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $this->validate($request, ['id' => 'required|integer']);

        $category_name = SubjectCategory::findOrFail($request->id)->name;

        $subjects = Subject::where('subject_category', $request->id)->get();
        $available_subjects = Subject::where('subject_category', null)->get();

        return response()->json([
            'data' => [
                'subjects' => $subjects,
                'available_subjects' => $available_subjects,
                'category_name' => $category_name
            ]
        ]);
    }

    public function update(Request $request, int $id = null): JsonResponse
    {
        if($this->permissionDeny('update-subject')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $this->validate($request, [
            'name' => ['required', 'string', 'unique:subject_categories,name,'.$id]
            ]);


        SubjectCategory::find($id)->update(['name' => $request->name]);

        return response()->json([
            'data' => [
                'message' => 'Category Updated Successfully'
            ]
        ]);
    }

    public function toggleSubject(Request $request): JsonResponse
    {
        if($this->permissionDeny('update-subject')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $this->validate($request, [
            'id' => 'required|integer',
            'subject_id' => 'required|integer',
            'action' => 'required|integer',
            ]);
        
        $msg = '';

        if($request->action == 1) {
            $a = Subject::find($request->subject_id)->update(['subject_category' => $request->id]);
           
            $msg = 'Subject Added Successfully';
        }

        if($request->action == 0) {
            Subject::find($request->subject_id)->update(['subject_category' => null]);
            $msg = 'Subject Removed Successfully';
        }

        $subjects = Subject::where('subject_category', $request->id)->get();
        $available_subjects = Subject::where('subject_category', null)->get();

        return response()->json([
            'data' => [
                'subjects' => $subjects,
                'available_subjects' => $available_subjects,
                'message' => $msg
            ]
        ]);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
