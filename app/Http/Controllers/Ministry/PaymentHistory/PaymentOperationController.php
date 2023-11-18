<?php

namespace App\Http\Controllers\Ministry\PaymentHistory;

use App\Http\Controllers\Controller;
use App\Http\Resources\ICPRResource;
use App\Http\Resources\TransactionResource;
use App\Models\Classes;
use App\Models\PaymentItems;
use App\Models\School;
use App\Models\Student\Student;
use App\Models\Transaction;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentOperationController extends Controller
{
    protected $school;

    public function __construct(SchoolRepositoryInterface $school) {

        $this->middleware('auth:ministry_api');

        $this->school = $school;

    }

    public function digitalPaymentHistory(Request $request): AnonymousResourceCollection 
    {
        $request->validate(['school_id' => 'required|integer']);

        $histories = Transaction::query()->whereSchoolId($request->school_id)->orderBy('id', 'desc')->get();
        return TransactionResource::collection($histories);
    }

    public function icpr(Request $request): AnonymousResourceCollection
    {
        $request->validate(['session' => 'sometimes|integer', 'lga_id' => 'sometimes|integer']);

        $query = $this->school->setSchool()->query();
        $school_table = $this->school->setSchool()->getTable();

        $user = Auth::guard('ministry_api')->user();

        $schools = $query
                        ->when($user && $user->is_aeozeo, function($q) use ($user) {
                            return $q->whereIn('lga_id', $user->lgas);
                        })
                        ->when($request->query('session'), 
                            function ($query, $session) use ($school_table) {
                                $query->select(
                                    $school_table.'.name',
                                    DB::raw('(SELECT COUNT(*) FROM student_id_card_requests WHERE student_id_card_requests.school_id = '.$school_table.'.id and student_id_card_requests.session = '.$session.') as total'),
                                    DB::raw('(SELECT COUNT(*) FROM student_id_card_requests WHERE student_id_card_requests.is_verified = false and student_id_card_requests.is_downloaded = false and student_id_card_requests.school_id = '.$school_table.'.id and student_id_card_requests.session = '.$session.') as pending'),
                                    DB::raw('(SELECT COUNT(*) FROM student_id_card_requests WHERE student_id_card_requests.is_verified = true and student_id_card_requests.is_downloaded = false and student_id_card_requests.school_id = '.$school_table.'.id and student_id_card_requests.session = '.$session.') as approved'),
                                    DB::raw('(SELECT COUNT(*) FROM student_id_card_requests WHERE student_id_card_requests.is_verified = true and student_id_card_requests.is_downloaded = true and student_id_card_requests.school_id = '.$school_table.'.id and student_id_card_requests.session = '.$session.') as downloaded')
                                );
                            },
                            function($query) use ($school_table) {
                                $query->select(
                                    $school_table.'.name',
                                    DB::raw('(SELECT COUNT(*) FROM student_id_card_requests WHERE student_id_card_requests.school_id = '.$school_table.'.id) as total'),
                                    DB::raw('(SELECT COUNT(*) FROM student_id_card_requests WHERE student_id_card_requests.is_verified = false and student_id_card_requests.is_downloaded = false and student_id_card_requests.school_id = '.$school_table.'.id ) as pending'),
                                    DB::raw('(SELECT COUNT(*) FROM student_id_card_requests WHERE student_id_card_requests.is_verified = true and student_id_card_requests.is_downloaded = false and student_id_card_requests.school_id = '.$school_table.'.id) as approved'),
                                    DB::raw('(SELECT COUNT(*) FROM student_id_card_requests WHERE student_id_card_requests.is_verified = true and student_id_card_requests.is_downloaded = true and student_id_card_requests.school_id = '.$school_table.'.id) as downloaded')
                                );
                            }
                        )       
                        ->when($request->query('lga_id'), function ($q, $lga_id) { 
                            return $q->where('lga_id', $lga_id);}
                        )
                        ->orderBy('id','desc')->paginate(40);

        return ICPRResource::collection($schools);
    }

    public function srr(Request $request): AnonymousResourceCollection
    {
        $request->validate(['lga_id' => 'sometimes|integer']);

        $query = $this->school->setSchool()->query();
        $school_table = $this->school->setSchool()->getTable();

        $user = Auth::guard('ministry_api')->user();

        $schools = $query->select($school_table.'.id', $school_table.'.name')
                        ->when($user && $user->is_aeozeo, function($q) use ($user) {
                            return $q->whereIn('lga_id', $user->lgas);
                        })
                        ->when($request->query('lga_id'), function ($q, $lga_id) { 
                            return $q->where('lga_id', $lga_id);}
                        )
                        ->orderBy('id','desc')->paginate(60);

        return ICPRResource::collection($schools);
    }

    public function report(Request $request): JsonResponse
    {
        $request->validate([
            'session' => 'required|integer',
            'school_id' => 'required|integer'
        ]);
        
        $session = $request->session;
        $digital_fee = optional(PaymentItems::find(1))->cost;
        $schoolName = School::find($request->school_id)->name;
        $school_id = $request->school_id;

        // $jss1_class = Classes::whereSchoolId($request->school_id)->where('class_name', 'like', 'J%')
        //                             ->where(function($query) {
        //                                 return $query->where('class_name', 'like', '%1%')
        //                                     ->orWhere('class_name', 'like', '%one%');
        //                             })
        //                             ->with('class_arms')
        //                             ->get();
        
        // $jss1_class_ids = $jss1_class->pluct('id')->toArray();

        // $jss1_sts = Student::where('school_id', $request->school_id)
        //             ->whereHas('classarms', function($query) use ($session, $jss1_class_ids) {
        //                 $query->where('session', $session)->whereIn('class_id', $jss1_class_ids);
        //             })
        //             ->count();

        // $jss1_mp = Student::where('school_id', $request->school_id)
        //             ->whereHas('digitalPayment', function($query) {
        //                 $query->where('is_verified', 1);
        //             })
        //             ->whereHas('classarms', function($query) use ($session, $jss1_class_ids) {
        //                 $query->where('session', $session)->whereIn('class_id', $jss1_class_ids);
        //             })
        //             ->count();

        // $jss1_total_results = 0;
        // $jss1_results = $jss1_class->map(function ($jss1_c) use ($session, $school_id, &$jss1_total_results) {
        //     $class_arms_result = $jss1_c->class_arms->map(function ($class_arm) use ($session, $school_id, &$jss1_total_results) {
        //         $classarm_result_count = $this->getStudentResultCount($school_id, $session, $class_arm->class_id, $class_arm->id);
        //         $jss1_total_results += $classarm_result_count;

        //         return [
        //             'classarm_id' => $class_arm->id,
        //             'classarm_name' => $class_arm->class_arm,
        //             'classarm_result_count' => $classarm_result_count
        //         ];
        //     });

        //     return [
        //         'class_id' => $jss1_c->id,
        //         'class_name' => $jss1_c->class_name,
        //         'class_arms_result' => $class_arms_result
        //     ];
        // });

        $jss1_sts = Student::where('school_id', $request->school_id)
                        ->whereHas('classarms', function($query) use ($session) {
                            $query->where('session', $session)->whereHas('classes', function($query) {
                                $query->where('class_name', 'like', 'J%')->where(function($query) {
                                    return $query->where('class_name', 'like', '%1%')->orWhere('class_name', 'like', '%one%');
                                });
                            });
                         })
                        ->count();

        $jss1_mp = Student::where('school_id', $request->school_id)
                    ->whereHas('digitalPayment', function($query) {
                        $query->where('is_verified', 1);
                    })
                    ->whereHas('classarms', function($query) use ($session) {
                        $query->where('session', $session)->whereHas('classes', function($query) {
                            $query->where('class_name', 'like', 'J%')->where(function($query) {
                                return $query->where('class_name', 'like', '%1%')->orWhere('class_name', 'like', '%one%');
                            });
                        });
                    })
                    ->count();

        $jss2_sts = Student::where('school_id', $request->school_id)
                    ->whereHas('classarms', function($query) use ($session) {
                        $query->where('session', $session)->whereHas('classes', function($query) {
                            $query->where('class_name', 'like', 'J%')->where(function($query) {
                                return $query->where('class_name', 'like', '%2%')->orWhere('class_name', 'like', '%two%');
                            });
                        });
                        })
                    ->count();

        $jss2_mp = Student::where('school_id', $request->school_id)
                    ->whereHas('digitalPayment', function($query) {
                        $query->where('is_verified', 1);
                    })
                    ->whereHas('classarms', function($query) use ($session) {
                        $query->where('session', $session)->whereHas('classes', function($query) {
                            $query->where('class_name', 'like', 'J%')->where(function($query) {
                                return $query->where('class_name', 'like', '%2%')->orWhere('class_name', 'like', '%two%');
                            });
                        });
                    })
                    ->count();

        $jss3_sts = Student::where('school_id', $request->school_id)
                    ->whereHas('classarms', function($query) use ($session) {
                        $query->where('session', $session)->whereHas('classes', function($query) {
                            $query->where('class_name', 'like', 'J%')->where(function($query) {
                                return $query->where('class_name', 'like', '%3%')->orWhere('class_name', 'like', '%three%');
                            });
                        });
                        })
                    ->count();

        $jss3_mp = Student::where('school_id', $request->school_id)
                    ->whereHas('digitalPayment', function($query) {
                        $query->where('is_verified', 1);
                    })
                    ->whereHas('classarms', function($query) use ($session) {
                        $query->where('session', $session)->whereHas('classes', function($query) {
                            $query->where('class_name', 'like', 'J%')->where(function($query) {
                                return $query->where('class_name', 'like', '%3%')->orWhere('class_name', 'like', '%three%');
                            });
                        });
                    })
                    ->count();

        $sss1_sts = Student::where('school_id', $request->school_id)
                    ->whereHas('classarms', function($query) use ($session) {
                        $query->where('session', $session)->whereHas('classes', function($query) {
                            $query->where('class_name', 'like', 'S%')->where(function($query) {
                                return $query->where('class_name', 'like', '%1%')->orWhere('class_name', 'like', '%one%');
                            });
                        });
                        })
                    ->count();

        $sss1_mp = Student::where('school_id', $request->school_id)
                    ->whereHas('digitalPayment', function($query) {
                        $query->where('is_verified', 1);
                    })
                    ->whereHas('classarms', function($query) use ($session) {
                        $query->where('session', $session)->whereHas('classes', function($query) {
                            $query->where('class_name', 'like', 'S%')->where(function($query) {
                                return $query->where('class_name', 'like', '%1%')->orWhere('class_name', 'like', '%one%');
                            });
                        });
                        
                    })
                    ->count();

        $sss2_sts = Student::where('school_id', $request->school_id)
                    ->whereHas('classarms', function($query) use ($session) {
                        $query->where('session', $session)->whereHas('classes', function($query) {
                            $query->where('class_name', 'like', 'S%')->where(function($query) {
                                return $query->where('class_name', 'like', '%2%')->orWhere('class_name', 'like', '%two%');
                            });
                        });
                        })
                    ->count();

        $sss2_mp = Student::where('school_id', $request->school_id)
                    ->whereHas('digitalPayment', function($query) {
                        $query->where('is_verified', 1);
                    })
                    ->whereHas('classarms', function($query) use ($session) {
                        $query->where('session', $session)->whereHas('classes', function($query) {
                            $query->where('class_name', 'like', 'S%')->where(function($query) {
                                return $query->where('class_name', 'like', '%2%')->orWhere('class_name', 'like', '%two%');
                            });
                        });
                    })
                    ->count();

        $sss3_sts = Student::where('school_id', $request->school_id)
                    ->whereHas('classarms', function($query) use ($session) {
                        $query->where('session', $session)->whereHas('classes', function($query) {
                            $query->where('class_name', 'like', 'S%')->where(function($query) {
                                    return $query->where('class_name', 'like', '%3%')->orWhere('class_name', 'like', '%three%');
                                });
                            });
                        })
                    ->count();

        $sss3_mp = Student::where('school_id', $request->school_id)
                    ->whereHas('digitalPayment', function($query) {
                        $query->where('is_verified', 1);
                    })
                    ->whereHas('classarms', function($query) use ($session) {
                        $query->where('session', $session)->whereHas('classes', function($query) {
                            $query->where('class_name', 'like', 'S%')->where(function($query) {
                                    return $query->where('class_name', 'like', '%3%')->orWhere('class_name', 'like', '%three%');
                            });
                        });
                        
                    })
                    ->count();

        $tnos = Student::where('school_id', $request->school_id)
            ->whereHas('classarms', function($query) use ($session) {
                $query->where('session', $session);
            })->count();

        $tap = Student::where('school_id', $request->school_id)
                        ->whereHas('digitalPayment', function($query) use ($session) {
                            $query->where('is_verified', 1)->where('session', $session);
                        })->count();

        $tosp = Student::where('school_id', $request->school_id)
                        ->whereDoesntHave('digitalPayment', function($query) use ($session) {
                            $query->where('is_verified', 1)->where('session', $session);
                        })->count();

        return response()->json([
            'data' => [
                'name' => $schoolName,
                'jss1_sts' => $jss1_sts,
                'jss1_mp' => 'NGN'.number_format($jss1_mp * $digital_fee, 2),
                'jss2_sts' => $jss2_sts,
                'jss2_mp' => 'NGN'.number_format($jss2_mp * $digital_fee, 2),
                'jss3_sts' => $jss3_sts,
                'jss3_mp' => 'NGN'.number_format($jss3_mp * $digital_fee, 2),
                'sss1_sts' => $sss1_sts,
                'sss1_mp' => 'NGN'.number_format($sss1_mp * $digital_fee, 2),
                'sss2_sts' => $sss2_sts,
                'sss2_mp' => 'NGN'.number_format($sss2_mp * $digital_fee, 2),
                'sss3_sts' => $sss3_sts,
                'sss3_mp' => 'NGN'.number_format($sss3_mp * $digital_fee, 2),
                'tnos' => $tnos,
                'tap' => 'NGN'.number_format($tap * $digital_fee, 2),
                'tosp' => 'NGN'.number_format($tosp * $digital_fee, 2),
            ]
        ]);
    }

    protected function getStudentResultCount($school_id,$session, $class_id, $classarm_id)
    {
        return DB::table('student_results')
            ->where('session', $session)
            ->where('class_id', $class_id)
            ->where('classarm_id', $classarm_id)
            ->where('school_id', $school_id)
            ->groupBy('student_id')
            ->count();
    }
}
