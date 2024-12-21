<?php

namespace App\Http\Controllers\Admin;

use Error;
use mysqli;
use Throwable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\SubModuleExport;
use App\Exports\ChildModuleExport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Traits\{ValidationTraits, QueryTraits, TemplateTraits};
use App\Models\Admin\{Admin, ChildPermission, Permission, SubPermission};

class ModuleController extends Controller {
    use ValidationTraits, QueryTraits, TemplateTraits;

    public function downloadAllSampleModuleExcelLinkUrl(Request $request) {
        $whichFunctionIsCreateExcel = $request->query('whichFunctionIsCreateExcel');
        $excelDownload = $request->query('excelDownload');
        return view('admin.auth.excel-link-show', compact('whichFunctionIsCreateExcel', 'excelDownload'));
    }

    public function index() {
        try {
            $module = $this->moduleListTrait();
            if ($module) {
                return view('admin.auth.module-list', [
                    'module' => $module
                ]);
            }
        } catch (Throwable $th) {
            throw $th;
        }
    }

    // module crud start --
        public function moduleList() {
            try {
                $data = $this->adminHeading();
                $module = $this->moduleListTrait();
                if (empty($module)) {
                    return redirect('/admin/tool/dashboard')->with('error', 'Internal server error.');
                }

                return view('admin.auth.create-module', [
                    'data' => $data,
                    'module' => $module,
                ]);
            } catch (Throwable $th) {
                throw $th;
            }
        }

        public function createModule(Request $request) {
            try {
                $validator = $this->moduleValidation($request->all());
                if ($validator->fails()) {
                    return $validator->errors();
                }

                Permission::create([
                    'name' => $request->name,
                    'icon' => $request->icon,
                    'route' => $request->route,
                    'order' => $request->order,
                    'status' => 1,
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Module created successfully !',
                ]);
            } catch (Throwable $th) {
                throw $th;
            }
        }

        public function editModule(Request $request) {
            try {
                $module = $this->moduleUpdateTrait($request->id);
                return view('admin.auth.module-list', ['module' => $module]);
            } catch (Throwable $th) {
                throw $th;
            }
        }

        public function updateModule(Request $request) {
            try {
                $validator = $this->moduleUpdateValidation($request->all());
                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'error',
                        'errors' => $validator->errors(),
                    ], 422);
                }

                $module = $this->moduleUpdateTrait($request->id);
                if ($module) {
                    $module->insert($request->all());
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Module updated successfully !',
                    ]);
                }
            } catch (Throwable $th) {
                throw $th;
            }
        }

        public function showModule(Request $request) {
            try {
                $module = $this->moduleUpdateTrait($request->id);
                return view('admin.auth.module-list', ['module' => $module]);
            } catch (Throwable $th) {
                throw $th;
            }
        }

        public function deleteModule(Request $request) {
            try {
                $del = $this->moduleUpdateTrait($request->id);
                if (!empty($del)) {
                    $del->delete();
                    if ($del->deleted_at != null) {
                        if ($del->deleted_at != null) {
                            $del->update(['status' => 0, 'deleted_at' => Carbon::now()]);
                        }
                    }
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Module deleted successfully !',
                    ]);
                }
                return response()->json([
                    'status' => 'error',
                    'message' => 'Module id is found!',
                ]);
            } catch (Throwable $th) {
                throw $th;
            }
        }
    // module crud end 

    //  sub module crud start --
        public function subModuleList() {
            try {
                $data = $this->adminHeading();
                $parentModule = $this->moduleListTrait();
                $subModules = $this->subModuleListTrait();

                foreach ($subModules as $parent) {
                    if ($parent['parent_module_from_sub']) {
                        foreach ($parent['parent_module_from_sub']->toArray() as $key => $value) {
                            $parent->$key = $value;
                        }
                    }
                }

                return view('admin.auth.create-sub-module', [
                    'data' => $data,
                    'parentModule' => $parentModule,
                    'subModules' => $subModules,
                ]);
            } catch (Throwable $th) {
                throw $th;
            }
        }

        public function showSubModule() {
            $subModule = $this->subModuleListTrait();
            return view('admin.auth.create-sub-module', [
                'subModule' => $subModule,
            ]);
        }

        public function createSubModule(Request $request) {
            try {
                $validator = $this->subModuleCreateValidation($request->all());
                if ($validator->fails()) {
                    return $validator->errors();
                }

                $subModule = new SubPermission();
                $subModule->module_id = $request->input('module_id');
                $subModule->icon = $request->input('icon');
                $subModule->route = $request->input('route');
                $subModule->route_type = $request->input('route_type');
                $subModule->order = $request->input('order');
                $subModule->query = $request->input('query');
                $subModule->color_code = $request->input('color_code');
                $subModule->name = $request->input('name');
                $subModule->status = 1;
                $subModule->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Sub module created successfully !',
                ]);
            } catch (Throwable $th) {
                throw $th;
            }
        }

        public function editSubModule(Request $request) {
            try {
                $module = $this->moduleTemplate($request->id);
                return view('admin.auth.module-list', ['module' => $module]);
            } catch (Throwable $th) {
                throw $th;
            }
        }

        public function updateSubModule(Request $request) {}

        public function deleteSubModule(Request $request) {}
    //  sub module crud end --



    // Child module crud start --
        public function childModuleList() {
            try {
                $data = $this->adminHeading();
                $module = $this->moduleListTrait();
                $subModule = $this->subModuleListTrait();
                $childModule = $this->childModuleListTrait();

                if (empty($module)) {
                    return redirect('/admin/tool/dashboard')->with('error', 'Internal server error.');
                }

                return view('admin.auth.create-child-module', [
                    'data' => $data,
                    'module' => $module,
                    'subModule' => $subModule,
                    'childModule' => $childModule,
                ]);
            } catch (Throwable $th) {
                throw $th;
                return response()->json([
                    'errors' => $th->getMessage()
                ]);
            }
        }

        public function showChildModule(Request $request) {
            try {
                $subModule = $this->subModuleListTrait();
                return view('admin.auth.create-child-module', [
                    'subModule' => $subModule,
                ]);
            } catch (Throwable $th) {
                throw $th;
            }
        }

        public function createChildModule(Request $request) {
            try {
                $validator = $this->childModuleCreateValidation($request->all());
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()]);
                }

                // Check if sub_module_id exists
                $subModule = SubPermission::find($request->input('sub_module_id'));
                if (!$subModule) {
                    return response()->json(['error' => 'Please select a valid sub module'], 400);
                }

                $adminChildModule = new ChildPermission();
                $adminChildModule->sub_module_id = $request->input('sub_module_id');
                $adminChildModule->name = $request->input('name');
                $adminChildModule->icon = $request->input('icon');
                $adminChildModule->route = $request->input('route');
                $adminChildModule->query = $request->input('query');
                $adminChildModule->route_type = $request->input('route_type');
                $adminChildModule->order = $request->input('order');
                $adminChildModule->color_code = $request->input('color_code');
                $adminChildModule->status = 1;

                // Save the model to the database
                $adminChildModule->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Child Module created successfully!',
                ]);
            } catch (Throwable $th) {
                Log::error(['error' => $th->getMessage(), 'error line' => $th->getLine(), 'Trace' => $th->getTraceAsString()]);
                return response()->json([
                    'errors' => $th->getMessage(),
                ], 500);
            }
        }
    // Child module crud end --

    // Bulk Module/Sub Module/ Child Module start ---
        public function downloadSubModuleExcelSheet(Request $request) {
            try {
                $whichFunctionIsCreateExcel = "download Sub Module Excel Sheet";
                $validator = $this->bulkSubModuleCreateValidation($request->all());
                if ($validator->fails()) {
                    errorLog($validator->errors());
                    return $validator->errors();
                }
                $parentModuleName = $this->moduleNameOnlyTemplate($request);
                if (empty($parentModuleName)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Parent module details not found, please check your Parent module details'
                    ], 404);
                }

                $subModuleSheet = env('FORMATTED_ROWS', 100);
                // $fileToBeName = $parentModuleName.'-'.'module-sample-'.time().'.xls';
                $fileToBeName = 'sub-module-sample-' . time() . '.xls';
                $diskToStore = env("MEDIA_DISK", 'public');
                $storagePath = 'Module/Sub/Sample/' . $fileToBeName;
                $createBy = $this->currentUserDetailsTrait();
                $adminNameAndId = Admin::where('id', $createBy)->pluck('name')->first();
                $adminNameAndIdArray = array('Super Admin', 'Admin', 'E-comm', $adminNameAndId);
                $insideSheetValidation = [
                    'Sub module name is required, please enter sub module name (e.g User Audit)',
                    'who is create sub module, please select sub module creater name',
                    'Parent module name is required, please select valid parent module name',
                    'Sub module color code, please enter color code  (e.g #fffff or red/blue/..)',
                    'Sub module icon is required, please enter module icon',
                    'Sub module route is required, please must be enter sub module route (e.g admin/dashboard or admin.dashboard)',
                    'Sub module route type is required, please must be enter sub module route type (e.g url or route)',
                    'Sub module order is required, please must be enter sub module order (e.g 1 or 2 or any numeric value)'
                ];

                $dropdown = [];
                if (count($parentModuleName) == 0 || empty($parentModuleName)) {
                    return "Parent module details not found, please check your Parent module details";
                }

                try {
                    $columns = [
                        'Sub Module Name',
                        'Sub Module Created By',
                        'Parent Module Name',
                        'Sub Module Color Code',
                        'Sub Module Icon',
                        'Sub Module Route',
                        'Sub Module Route Type',
                        'Sub Module Order'
                    ];

                    $dropdown = [
                        'sub_module_created_index' => 1,
                        'sub_module_created_option' => $adminNameAndIdArray,
                        'parent_module_index' => 2,
                        'parent_module_option' => $parentModuleName,
                    ];
                    Excel::store(new SubModuleExport($columns, $subModuleSheet, $insideSheetValidation, $dropdown), $storagePath, $diskToStore, \Maatwebsite\Excel\Excel::XLSX);
                    $excelDownload = Storage::disk($diskToStore)->url($storagePath);
                    $excelDownload = asset('storage/' . $storagePath);

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Excel generated successfully.',
                        'excelDownload' => $excelDownload,
                        'fileToBeName' => $fileToBeName,
                        'redirectUrl' => url('admin/all/sample/download/link') . '?whichFunctionIsCreateExcel=' . $whichFunctionIsCreateExcel,
                        'whichFunctionIsCreateExcel' => $whichFunctionIsCreateExcel
                    ]);
                } catch (Throwable $th) {
                    throw $th;
                }
            } catch (Throwable $th) {
                throw $th;
            }
        }

        public function downloadChildModuleExcelSheet(Request $request) {
            try {
                $whichFunctionIsCreateExcel = "download Child Module Excel Sheet";
                $validator = $this->bulkChildModuleCreateValidation($request->all());
                if ($validator->fails()) {
                    return $validator->errors();
                }

                $subModuleName = $this->subModuleNameAndIdOnlyTrait($request);
                if (empty($subModuleName) || $subModuleName == '' || $subModuleName == null) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Parent module details not found, please check your Parent module details'
                    ], 404);
                }


                $subModuleSheet = env('FORMATTED_ROWS', 100);
                // $fileToBeName = $parentModuleName.'-'.'module-sample-'.time().'.xls';
                $fileToBeName = 'child-module-sample-' . time() . '.xls';
                $diskToStore = env("MEDIA_DISK", 'public');
                $storagePath = 'Module/Child/Sample/' . $fileToBeName;
                $createBy = $this->currentUserDetailsTrait();
                $adminNameAndId = Admin::where('id', $createBy)->pluck('name')->first();
                $adminNameAndIdArray = array('Super Admin', 'Admin', 'E-comm', $adminNameAndId);
                $insideSheetValidation = [
                    'Child module name is required, please enter child module name (e.g User Audit)',
                    'who is create child module, please select child module creater name',
                    'Parent module name is required, please select valid parent module name',
                    'Child module color code, please enter color code  (e.g #fffff or red/blue/..)',
                    'Child module icon is required, please enter module icon',
                    'Child module route is required, please must be enter child module route (e.g admin/dashboard or admin.dashboard)',
                    'Child module route type is required, please must be enter child module route type (e.g url or route)',
                    'Child module order is required, please must be enter child module order (e.g 1 or 2 or any numeric value)'
                ];
                try {
                    $columns = [
                        'Child Module Name',
                        'Child Module Created By',
                        'Sub Module Name',
                        'Child Module Color Code',
                        'Child Module Icon',
                        'Child Module Route',
                        'Child Module Route Type',
                        'Child Module Order'
                    ];

                    $dropdown = [
                        'sub_module_created_index' => 1,
                        'sub_module_created_option' => $adminNameAndIdArray,
                        'parent_module_index' => 2,
                        'parent_module_option' => $subModuleName,
                    ];
                    Excel::store(new ChildModuleExport($columns, $subModuleSheet, $insideSheetValidation, $dropdown), $storagePath, $diskToStore, \Maatwebsite\Excel\Excel::XLSX);;
                    $excelDownload = Storage::disk($diskToStore)->url($storagePath);
                    $excelDownload = asset('storage/' . $storagePath);

                    return redirect()->json([
                        'status' => 'success',
                        'message' => 'Excel generated successfully.',
                        'subModuleName' => $subModuleName,
                        'excelDownload' => $excelDownload,
                        'redirectUrl' => url('admin/all/sample/download/link').'?whichFunctionIsCreateExcel='.$whichFunctionIsCreateExcel,
                        'whichFunctionIsCreateExcel' => $whichFunctionIsCreateExcel
                    ]);
                } catch (Throwable $th) {
                    throw $th;
                }
            } catch (Throwable $th) {
                throw $th;
            }
        }

        public function uploadSubModuleExcelSheet(Request $request) {
            try {
                $validator = $this->bulkChildModuleCreateValidation($request->all());
                if ($validator->fails()) {
                    return $validator->errors();
                }
                $isSheet = 0;
                $error = 0;
            } catch (Throwable $th) {
                throw $th;
            }
        }
    // Bulk Module/Sub Module/ Child Module end ---


    // Module/Sub Module/ Child Module Mapping start
        public function listModuleMapping() {
            
        }

        public function createModuleMapping(Request $request) {
            try{
                $data = $this->adminHeading();
                $module = $this->moduleListTrait();
                $subModule = $this->subModuleListTrait();
                $childModule = $this->childModuleListTrait();
                dd($module);
                return view('admin.auth.create-module', [
                    'data' => $data,
                    'module' => $module,
                    'subModule' => $subModule,
                    'childModule' => $childModule,
                ]);
            } catch(ValidationException $th) {
                throw $th;
                Log::info(['error'=>$th->getMessage()]);
            }
        }
    // Module/Sub Module/ Child Module Mapping end

    // public function spotifyApis() {
    //     $dbConfigFile = include('DatabaseConnection.php');
    //     $connectionFromDatabase = new mysqli($dbConfigFile['servername'], $dbConfigFile['username'], $dbConfigFile['password'], $dbConfigFile['dbname']);
    //     $spotifyData = "SELECT * FROM `tbl_spotify_result` WHERE cs_req_id=10 AND is_active=0";
    //     $spotifyDataConnect = $connectionFromDatabase->query($spotifyData);
    //     if($spotifyDataConnect->num_rows > 0) {
    //         while($spotifyDataConnectResultRow = $spotifyDataConnect->fetch_assoc()) {
    //             $spotifyResJsonData = $spotifyDataConnectResultRow['cs_req_id'];
    //             $spotifyResJsonData = json_decode($spotifyDataConnectResultRow['res_json'], true);
    //             if(!empty($spotifyResJsonData)) {
    //                 foreach($spotifyResJsonData['dimensions'] as $dimension) {
    //                     // dd($dimension);
    //                     if($dimension['dimension'] == 'genre') {
    //                         foreach($dimension['insights'] as $genreData){
    //                             // dd("genreData", $genreData);
    //                         }

    //                     } else {
                            
    //                     }

    //                     if($dimension['dimension'] == 'days_of_week') {
    //                         foreach($dimension['insights'] as $daysOfWeekData){
    //                             // dd("daysOfWeekData", $daysOfWeekData);
    //                         }

    //                     } else {
                            
    //                     }

    //                     if($dimension['dimension'] == 'city') {
    //                         foreach($dimension['insights'] as $CitiesData){
    //                             // dd("CitiesData", $CitiesData);
    //                         }

    //                     } else {
    //                         // throw "";
    //                     }
    //                 }

    //             } else {
    //                 throw "Spotify result json data is empty";
    //             }
    //             dd($spotifyResJsonData);

    //         }
    //     }
    // }
}
