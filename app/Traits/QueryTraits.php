<?php

namespace App\Traits;


use Throwable;
use Illuminate\Support\Facades\{Auth, Log, DB};
use App\Models\Admin\{AdminSalary, AdminHolidays, AdminBankDetails, 
    AdminLeaveRequest, AdminBankProccessing, AdminSalaryProccessing, 
    AdminSalaryTdsDeduction, AdminSalaryTransaction, AdminDepartmentMaster, 
    AdminDesignationMaster, AdminRole, Admin, ChildPermission, AdminIncreament, Permission,
    AdminModuleMapping,
    AdminProduct, SubPermission};

trait QueryTraits {
    public function getAllModuleNameOnly() {
        $adminData = AdminModuleMapping::where('is_active', 1)
                    ->with(['parentModuleRelation', 'subModuleRelation', 'childModuleRelation'])
                    ->get();
        return $adminData;
    }

    public function currentUserDetailsTrait() {
        $adminData = Auth::guard('admin')->user()->id;
        return $adminData;
    }

    public function userLoginDetailsTrait() {
        $adminData = Auth::guard('admin')->user()->id;
        return $adminData;
    }

    public function getModuleAccessTrait() {
        return Permission::where('status', 1)
                ->where('deleted_at', null)
                ->orderBy('order')
                ->get();
    }

    public function editAdminProfileTraist($data) {
        try {
            $admin = Admin::where('id', Auth::guard('admin')->user()->id)
                          ->with(['getDesignation', 'getDepartment', 'getRole'])
                          ->first();
            if(!$admin) {
                Log::info('Admin not found or relationships are not set.');
                return null;
            }

            if ($admin->status == 1 && $admin->login_status == 1) {
                return $admin;
            } else {
                Log::info('Admin does not have active or correct login status.');
                return null;
            }

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            Log::error($th->getTraceAsString());
            return null;
        }
    }

    public function employeeListTraist() {
        try {
            return Admin::with(['getDesignation', 'getDepartment', 'getRole', 
                                'getSalary', 'getBank', 'getExperience'])
                          ->get();

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            Log::error($th->getTraceAsString());
            return null;
        }
    }

    public function getAllDepartmentDetails() {
        return AdminDepartmentMaster::where('status', 1)->get();
    }

    public function getSpecificDepartmentData($request) {
        return AdminDepartmentMaster::where('id', $request->department_id)->pluck('departments')->first();
    }

    public function getAllDesignationDetails() {
        return AdminDesignationMaster::where('status', 1)->get();
    }

    public function getAllDesignationNameOnly() {
        return AdminDesignationMaster::where('status', 1)->pluck('designation')->toArray();
    }

    public function getAllRoleDetails() {
        return AdminRole::where('status', 1)->get();
    }

    public function getAllRoleNameOnly() {
        return AdminRole::where('status', 1)->pluck('role_name')->toArray();
    }

    public function updateEmployeeProfileTraits($id) {
        return Admin::where('id', $id)->first();
    }

    public function changePasswordTraits($id) {
        try {
            // return Admin::where('is_active', 1)->where('login_status', 1)->first();
            return Auth::guard('admin')->user();

        } catch(Throwable $th) {
            Log::error($th->getTraceAsString());
        }
    }

    public function adminProductTraits() {
        return AdminProduct::where('deleted_at', NULL)
                ->where('status', 1)->get();
    }

    public function countAdminTraits() {
        return Admin::where('deleted_at', NULL)
                ->where('status', 1)->count();
    }

    public function countDepartmentTraits() {
        return AdminDepartmentMaster::where('deleted_at', NULL)
                ->where('status', 1)->count();
    }

    public function countDesignationTraits() {
        return AdminDesignationMaster::where('deleted_at', NULL)
                ->where('status', 1)->count();
    }

    public function countBankProcessTraits() {
        return AdminBankProccessing::where('deleted_at', NULL)->count();
    }

    public function countBankDetailsTraits() {
        return AdminBankDetails::where('deleted_at', NULL)
                ->where('status', 1)->count();
    }

    public function countHolidayTraits() {
        return AdminHolidays::where('deleted_at', NULL)
                ->count();
    }

    public function countIncrementTraits() {
        return AdminIncreament::where('deleted_at', NULL)
                ->count();
    }

    public function countLeavesTraits() {
        return AdminLeaveRequest::where('deleted_at', NULL)
                ->count();
    }

    public function countSalaryTraits() {
        return AdminSalary::where('deleted_at', NULL)
                ->where('status', 1)->count();
    }

    public function countSalaryTdsTraits() {
        return AdminSalaryTdsDeduction::where('deleted_at', NULL)
                ->count();
    }

    public function countSalaryProcessTraits() {
        return AdminSalaryProccessing::where('deleted_at', NULL)
                ->where('status', 1)->count();
    }

    public function countSalaryTransactionTraits() {
        return AdminSalaryTransaction::where('deleted_at', NULL)
                ->count();
    }

    // all module/sub module/child module query --
    public function moduleListTrait() {
        return Permission::where('status', 1)->get();
    }

    public function moduleUpdateTrait($id) {
        return Permission::where('status', 1)->where('id', $id)->first();
    }

    public function moduleTemplate() {
        return Permission::where('status', 1)
                ->where('deleted_at', null)
                ->orderBy('order')
                ->get();
    }
    
    public function moduleNameOnlyTemplate() {
        return Permission::where('status', 1)
                ->where('deleted_at', null)
                ->pluck('name','id')
                ->toArray();
    }

    public function subModuleNameAndIdOnlyTrait() {
        return SubPermission::where('status', 1)
                ->where('deleted_at', null)
                ->pluck('name','id')
                ->toArray();
    }

    public function subModuleListTrait() {
        return SubPermission::where('status', 1)
                ->with(['parentModuleFromSub'])
                ->get();
    }

    public function adminSubModuleListTrait() {
        return DB::table('admin_sub_module as asm')
                ->select('asm.*')
                ->join('admin_module as am', 'am.id', '=', 'asm.module_id')
                ->where('asm.module_id', 2)
                ->orderBy('asm.id', 'DESC')
                ->get();
        // return SubPermission::where('status', 1)->where('module_id', 2)
        // ->with(['parentModuleFromSub'])
        // ->get();
    }
    
    public function grocerySubModuleListTrait() {
        return DB::table('admin_sub_module as asm')
                ->join('admin_module as am', 'am.id', '=', 'asm.module_id')
                ->select('asm.*')
                ->where('asm.module_id', 3)
                ->orderBy('asm.id', 'desc')
                ->get();
        // return SubPermission::where('status', 1)->where('module_id', 3)
        // ->with(['parentModuleFromSub'])
        // ->get();
    }

    public function subModuleListTraitForSetting() {
        return SubPermission::where('status', 1)
                    ->with(['parentModuleFromSub'])
                    ->offset(5)
                    ->take(3)
                    ->get();
    }

    public function childModuleListTrait() {
        return ChildPermission::where('status', 1)
        ->with('subModuleFromChild')
        ->get();
    }
    
    // end all module/sub module/child module query --


}