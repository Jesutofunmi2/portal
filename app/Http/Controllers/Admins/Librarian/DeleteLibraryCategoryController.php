<?php

namespace App\Http\Controllers\Admins\Librarian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\LibraryCategoryRepositoryInterface;
use App\Repositories\Interfaces\LibraryRepositoryInterface;
use Auth;
use Gate;

class DeleteLibraryCategoryController extends Controller
{
    //
    protected $lib;

    protected $lib_cat;

    public function __construct(LibraryRepositoryInterface $lib, 
    LibraryCategoryRepositoryInterface $lib_cat)
    {

    $this->middleware('auth:school_api');

    $this->lib = $lib;

    $this->lib_cat = $lib_cat;

    }


    public function index($id = null)
    {
            
        $lib_cat = $this->lib_cat->find($id);
        //Get number of books in the Library Category
        $books = $this->lib->setData()
        ->where('cat_id', $id)->count();

        //Check if Library Books are attached to the Category
        if ($books > 0) {

            return response()->json([
                'message' => 'This category is not empty, there are still books in this category'
            ], 422);

        } else {

            $lib_cat->delete();

            return response()->json([
                'data' => [
                    'message' => 'Library Category Deleted successfully'
                ]
            ]);

        }

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
