<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use App\Models\Admin\Permission;
use App\Models\Admin\SubPermission;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Admin\ChildPermission;
use Illuminate\Support\Facades\{DB, Log};
use App\Traits\{TemplateTraits, QueryTraits};

class TemplateController extends Controller {
    use TemplateTraits, QueryTraits;
    
    public function dashboard() {
        return view('admin.dashboard');
    }
    
    public function setModule() {
        try{
            $moduleTemplate = $this->getModuleAccessTrait();
            return view('admin.admin-layouts.master', [
                'moduleTemplate' => $moduleTemplate,
            ]);
        } catch(Throwable $th) {
            Log::error(['Trace String' => $th->getTraceAsString(),
                'error' => $th->getMessage(),
                'line number' => $th->getLine()
            ]);
        }
    }
    
    public function employeeCount() {
        $template = Admin::getDashboard();
        return view('', ['template'=>$template]);
    }

    public function createTemplate() {
        return view('admin.template.template_add');
    }


    public function saveTemplate(Request $request) {
        try{
            $data = $request->validate([
                ''
            ]);

        } catch(Throwable $th) {
            return Log::error([$th->getMessage(), $th->getTraceAsString()]);

        }
    }

    
    public function adminDetails() {
        $admins = $this->employeeListTraist();
        $data = $this->adminHeading();
        return view('admin.auth.admin-profile', [
            'admins' => $admins,
            'data' => $data,
        ]);
    }

    public function adminSettings() {
        $data = $this->adminHeading();
        $adminTemplate = $this->subModuleListTraitForSetting();
        return view('admin.auth.settings', [
            'data' => $data,
            'adminTemplate' => $adminTemplate,
        ]);
    }

    public function onboardingList() {
        try{
            $admin = $this->countAdminTraits();

            $department = $this->countDepartmentTraits();

            $designation = $this->countDesignationTraits();

            $bankProcessing = $this->countBankProcessTraits();
            
            $bankDetails = $this->countBankDetailsTraits();

            $holidays = $this->countHolidayTraits();

            $increament = $this->countIncrementTraits();

            $leaveRequest = $this->countLeavesTraits();

            $salary = $this->countSalaryTraits();

            $salaryTds = $this->countSalaryTdsTraits();

            $salaryProcess = $this->countSalaryProcessTraits();

            $salaryTransaction = $this->countSalaryTransactionTraits();

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

            $fieldList = DB::table('admin_onboarding_modules')->select('*')->get();
            
            return view('admin.admin-onboarding.module-list', ['fieldList' => $fieldList, 'details' => $details]);

        } catch(Throwable $th) {

        }
    }

    public function menuBuilderList(){
        try{
            $data = $this->adminHeading();
            $module = $this->moduleListTrait();
            $subModule = $this->subModuleListTrait();
            $childModule = $this->childModuleListTrait();
            return view('admin.auth.create-child-module', [
                'data' => $data,
                'module' => $module,
                'subModule' => $subModule,
                'childModule' => $childModule,
            ]);

        } catch(Throwable $th) {
            Log::error(['error' => $th->getMessage(), 'error line'=>$th->getLine(), 'Trash'=> $th->getTraceAsString()]);
            return response()->json([
                'errors' => $th->getTraceAsString(),
            ]);

        }
    }

    public function compassList(){
        try{
            return view('admin.auth.create-child-module', [
            ]);

        } catch(Throwable $th) {
            Log::error(['error' => $th->getMessage(), 'error line'=>$th->getLine(), 'Trash'=> $th->getTraceAsString()]);
            return response()->json([
                'errors' => $th->getTraceAsString(),
            ]);

        }
    }

    public function breadList(){
        try{
            return view('admin.auth.create-child-module', [
            ]);

        } catch(Throwable $th) {
            Log::error(['error' => $th->getMessage(), 'error line'=>$th->getLine(), 'Trash'=> $th->getTraceAsString()]);
            return response()->json([
                'errors' => $th->getTraceAsString(),
            ]);

        }
    }

    
    // Module/Sub module/Child Module List
    public function adminSubModuleManagement() {
        $header = $this->adminHeading();
        $adminTemplate = $this->adminSubModuleListTrait();
        $parentModuleId = Permission::where('status', 1)->pluck('id')->toArray();
        $userId = Auth::guard('admin')->user()->id;
        $details = [];
        foreach ($adminTemplate as $index => $template) {
            if (!empty($template->query)) {
                $query = str_replace(':user_id', $userId, $template->query);
                $result = DB::select($query);
                foreach ($result as $data) {
                    $templateData = [];
                    foreach ($data as $key => $value) {
                        $templateData[$key] = $value;
                    }
                    $details[$index]['query'] = $templateData;
                }

                if(in_array($template->module_id, $parentModuleId, true)) {
                    $details[$index] = [
                        'query' => $templateData,
                        'module_id' => $template->module_id,
                        'name' => $template->name,
                        'route' => $template->route,
                        'icon' => $template->icon,
                        'route_type' => $template->route_type,
                        'color_code' => $template->color_code,
                    ];
                }
            }
        }
        
        // switch ($details    ) {
        //     case 2:
        //         $viewName = 'admin.auth.sub-module-list';
        //         break;
        //     case 3:
        //         $viewName = 'admin.grocery.grocery-sub-module';
        //         break;
        //     case 4:
        //         $viewName = 'admin.hms.hms-sub-module';
        //         break;
        //     case 5:
        //         $viewName = 'admin.travel.sub-module-list';
        //         break;
        // }

        // if (empty($viewName)) {
        //     abort(404, 'View not found for the specified module');
        // }

        return view('admin.auth.sub-module-list', [
            'header' => $header,
            'details' => $details,
        ]);
    }

    public function childModuleManagement(){
        try{
            $data = $this->adminHeading();
            $childModule = ChildPermission::where('status', 1)->get();
            $allowedSubModuleIds = SubPermission::where('status', 1)->pluck('id')->toArray();
            $childModuleDetails = [];
            foreach($childModule as $index => $template) {
                if(!empty($template->query)) {
                    $query = $template->query;
                    try {
                        $totalRecordCount = DB::select($query);

                        foreach($totalRecordCount as $result) {
                            $templateData = [];
                            foreach($result as $key => $value) {
                                $templateData = $value;
                            }
                            $childModuleDetails[$index]['query'] = $templateData;
                        }

                        if (in_array($template->sub_module_id, $allowedSubModuleIds, true)) {
                            $childModuleDetails[$index] = [
                                'query' => $templateData,
                                'sub_module_id' => $template->sub_module_id,
                                'name' => $template->name,
                                'route' => $template->route,
                                'icon' => $template->icon,
                                'route_type' => $template->route_type,
                                'color_code' => $template->color_code,
                            ];
                        }

                    } catch (\Exception $e) {
                        Log::error('Error executing query for template ID: ' . $template->id . ' - ' . $e->getMessage());
                    }
                }
            }

            return view('admin.auth.child-module-list', [
                'data'=> $data,
                'childModuleDetails'=> $childModuleDetails,
            ]);

        } catch(Throwable $th) {
            Log::error(['error' => $th->getMessage(), 'error line'=>$th->getLine(), 'Trash'=> $th->getTraceAsString()]);
            return response()->json([
                'errors' => $th->getTraceAsString(),
            ]);

        }
    }
}
