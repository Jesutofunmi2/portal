<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\Interfaces\StudentRepositoryInterface',
        'App\Repositories\Repo\StudentRepository'
        );
       $this->app->bind('App\Repositories\Interfaces\TeacherRepositoryInterface',
        'App\Repositories\Repo\TeacherRepository'
        );
       $this->app->bind('App\Repositories\Interfaces\ClassRepositoryInterface',
        'App\Repositories\Repo\ClassRepository'
        );
       $this->app->bind('App\Repositories\Interfaces\ClassArmRepositoryInterface',
        'App\Repositories\Repo\ClassArmRepository'
        );
        $this->app->bind('App\Repositories\Interfaces\DebtorPenaltyRepositoryInterface',
        'App\Repositories\Repo\DebtorPenaltyRepository'
        );
       $this->app->bind('App\Repositories\Interfaces\SubjectRepositoryInterface',
        'App\Repositories\Repo\SubjectRepository'
        );
       $this->app->bind('App\Repositories\Interfaces\StudentResultRepositoryInterface',
        'App\Repositories\Repo\StudentResultRepository'
        );
       $this->app->bind('App\Repositories\Interfaces\AdminRepositoryInterface',
        'App\Repositories\Repo\AdminRepository'
        );
       $this->app->bind('App\Repositories\Interfaces\PermissionRepositoryInterface',
        'App\Repositories\Repo\PermissionRepository'
        );

       $this->app->bind('App\Repositories\Interfaces\ResultVoucherRepositoryInterface',
        'App\Repositories\Repo\ResultVoucherRepository'
        );

       $this->app->bind('App\Repositories\Interfaces\SuperAdminRepositoryInterface',
        'App\Repositories\Repo\SuperAdminRepository'
        );

       $this->app->bind('App\Repositories\Interfaces\NgStatesRepositoryInterface',
        'App\Repositories\Repo\NgStatesRepository'
        );

       $this->app->bind('App\Repositories\Interfaces\NgStatesLGARepositoryInterface',
        'App\Repositories\Repo\NgStatesLGARepository'
        );

       $this->app->bind('App\Repositories\Interfaces\SchoolRepositoryInterface',
        'App\Repositories\Repo\SchoolRepository'
        );

       $this->app->bind('App\Repositories\Interfaces\OndoLGARepositoryInterface',
        'App\Repositories\Repo\OndoLGARepository'
        );

       $this->app->bind('App\Repositories\Interfaces\PracticalSkillRepositoryInterface',
        'App\Repositories\Repo\PracticalSkillRepository'
        );

       $this->app->bind('App\Repositories\Interfaces\StudentHouseRepositoryInterface',
        'App\Repositories\Repo\StudentHouseRepository'
        );

       $this->app->bind('App\Repositories\Interfaces\CharacterAttitudeRepositoryInterface',
        'App\Repositories\Repo\CharacterAttitudeRepository'
        );

       $this->app->bind('App\Repositories\Interfaces\PaymentRepositoryInterface',
        'App\Repositories\Repo\PaymentRepository'
        );

       $this->app->bind('App\Repositories\Interfaces\PaymentRecipientRepositoryInterface',
        'App\Repositories\Repo\PaymentRecipientRepository'
        );
       
       $this->app->bind('App\Repositories\Interfaces\PaymentItemsRepositoryInterface',
        'App\Repositories\Repo\PaymentItemsRepository'
        );

       $this->app->bind('App\Repositories\Interfaces\LibraryRepositoryInterface',
        'App\Repositories\Repo\LibraryRepository'
        );

       $this->app->bind('App\Repositories\Interfaces\LibraryCategoryRepositoryInterface',
        'App\Repositories\Repo\LibraryCategoryRepository'
        );

       $this->app->bind('App\Repositories\Interfaces\LibraryIssueRepositoryInterface',
        'App\Repositories\Repo\LibraryIssueRepository'
        );

       $this->app->bind('App\Repositories\Interfaces\SubjectUnofferedRepositoryInterface',
        'App\Repositories\Repo\SubjectUnofferedRepository'
        );

       $this->app->bind('App\Repositories\Interfaces\StudentCommentsRepositoryInterface',
        'App\Repositories\Repo\StudentCommentsRepository'
        );

       $this->app->bind('App\Repositories\Interfaces\TaskRepositoryInterface',
        'App\Repositories\Repo\TaskRepository'
        );
       
       $this->app->bind('App\Repositories\Interfaces\MinistryDepartmentRepositoryInterface',
        'App\Repositories\Repo\MinistryDepartmentRepository'
        );

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
