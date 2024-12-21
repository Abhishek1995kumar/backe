<?php

namespace App\Traits;

use App\Models\Admin\Admin;
use App\Models\Admin\AdminSalary;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\AdminHolidays;
use App\Models\Admin\AdminBankDetails;
use App\Models\Admin\AdminLeaveRequest;
use App\Models\Admin\AdminBankProccessing;
use App\Models\Admin\AdminDepartmentMaster;
use App\Models\Admin\AdminDesignationMaster;
use App\Models\Admin\AdminSalaryProccessing;
use App\Models\Admin\AdminSalaryTransaction;
use App\Models\Admin\AdminSalaryTdsDeduction;
use Throwable;

trait OnboardListQuery {
    public function onboardingListTrait() {
        try{
            $admin = Admin::where('deleted_at', NULL)
            ->where('status', 1)->count();

        $department = AdminDepartmentMaster::where('deleted_at', NULL)
            ->where('status', 1)->count();

        $designation = AdminDesignationMaster::where('deleted_at', NULL)
            ->where('status', 1)->count();

        $bankProcessing = AdminBankProccessing::where('deleted_at', NULL)->count();

        $bankDetails = AdminBankDetails::where('deleted_at', NULL)
            ->where('status', 1)->count();

        $holidays = AdminHolidays::where('deleted_at', NULL)
            ->count();

        $increament = AdminHolidays::where('deleted_at', NULL)
            ->count();

        $leaveRequest = AdminLeaveRequest::where('deleted_at', NULL)
            ->count();

        $salary = AdminSalary::where('deleted_at', NULL)
            ->where('status', 1)->count();

        $salaryTds = AdminSalaryTdsDeduction::where('deleted_at', NULL)
            ->count();

        $salaryProcess = AdminSalaryProccessing::where('deleted_at', NULL)
            ->where('status', 1)->count();

        $salaryTransaction = AdminSalaryTransaction::where('deleted_at', NULL)
            ->count();

        $details = [
            'admin' => $admin,
            'department' => $department,
            'designation' => $designation,
            'bankProcessing' => $bankProcessing,
            'bankDetails' => $bankDetails,
            'holidays' => $holidays,
            'increament' => $increament,
            'leaveRequest' => $leaveRequest,
            'salary' => $salary,
            'salaryTds' => $salaryTds,
            'salaryProcess' => $salaryProcess,
            'salaryTransaction' => $salaryTransaction
        ];

        if(!$details) {
            $fieldList = DB::table('admin_onboarding_modules')->select('*')->get();
            return view('admin.admin-onboarding.module-list', ['fieldList' => $fieldList, 'details' => $details]);

        }
            
        } catch(Throwable $th) {
            return redirect()->route('admin.dashboard')
                            ->with('error', 'An error occurred. Please try again.');
        }
    }
}
