<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Throwable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Exports\AdminEmployeeOnboardingExport;
use Illuminate\Support\Facades\{DB, Log, Auth, Hash, Validator};
use App\Traits\{ValidationTraits, QueryTraits, UserActivityLogTraits};
use App\Models\Admin\{Admin, AdminSalary, AdminBankDetails, AdminDepartmentMaster, AdminExperience, UserActivityLog};

class AdminController extends Controller {
    use QueryTraits, ValidationTraits, UserActivityLogTraits;
    // settings employee profile related
    public function profile(Request $request) {
        try{
            $admin = $this->editAdminProfileTraist($request->id);
            if($admin['dob'] && $admin['doj']) {
                $dob = Carbon::createFromFormat('Y-m-d', $admin['dob'])->format('d-m-Y');
                $doj = Carbon::createFromFormat('Y-m-d', $admin['doj'])->format('d-m-Y');
            }
            return view('admin.auth.profile', ["admin" => $admin, 'dob' => $dob, 'doj' => $doj]);

        } catch(Throwable $th) {

        }
    }

    public function editProfile(Request $request) {
        try{
            $admin = $this->editAdminProfileTraist($request->id);

            $department = $this->getAllDepartmentDetails();

            $designation = $this->getAllDesignationDetails();

            $role = $this->getAllRoleDetails();
            
            if($admin) {
                return view('admin.auth.update-profile', [
                    'admin' => $admin,
                    'role' => $role,
                    'department' => $department,
                    'designation' => $designation
                ]);

            } else {
                return back();
            }

        } catch(Throwable $th) {
            return Log::info([$th->getMessage(), $th->getTraceAsString()]);

        }
    }

    public function updateProfile(Request $request) {
        try{
            $validated = $this->profileValidation($request->all(), $request->id);

            if($validated->fails()) {
                return back()->withErrors($validated)->withInput();
            }
            $admin = $this->updateEmployeeProfileTraits($request->id);
            
            if($admin) {
                $admin->is_active = 1;
                $admin->is_verified = 1;
                $admin->login_status = 1;
                $admin->deleted_at = null;
                $admin->created_at = Carbon::now();
                $admin->updated_at = Carbon::now();
                $admin->dob = $request->dob ?? $admin->dob;
                $admin->doj = $request->doj ?? $admin->doj;
                $admin->name = $request->name ?? $admin->name;
                $admin->code = $request->code ?? $admin->code;
                $admin->email = $request->emaill ?? $admin->email;
                $admin->contact = $request->contact ?? $admin->contact;
                $admin->role_id = $request->role_id ?? $admin->role_id;
                $admin->password = $request->password ?? $admin->password;
                $admin->username = $request->username ?? $admin->username;
                $admin->department_id = $request->department_id ?? $admin->department_id;
                $admin->designation_id = $request->designation_id ?? $admin->designation_id;
                $admin->save();
                return redirect('admin/profile')->with('success', "$admin->username : your profile updated successfully.");
            }
            return back()->with('error', 'something went wrong, please check manually.');
        
        } catch(Throwable $th) {
            Log::info([$th->getMessage(), $th->getTraceAsString()]);
            return back()->withErrors(['error' => $th->getMessage()]);

        }
    }

    public function changePassword(Request $request) {
        try {
            $admin = $this->changePasswordTraits($request->id);
            return view('admin.auth.change-password', [
                'admin' => $admin
            ]);

        } catch(Throwable $th) {
            Log::error($th->getMessage(), $th->getTraceAsString());

        }
    }

    public function updatePassword(Request $request) {
        try {
            // ajax code 
                // if(Hash::check($request->current_password, Auth::guard('admin')->user()->password)) {
                //     if($request->new_password == $request->new_password_confirmation) {
                //         // update new password
                //         $admin = Admin::where('id', Auth::guard('admin')->user()->id);
                //         $admin->update(['password' => Hash::make($request->new_password)]);
                //         return redirect('admin/profile')->with('success', 'Password has been changed successfully.');

                //     } else{
                //         return back()->with('error', 'your new password and new password confirmation is not match, please set matching password.');
                //     }

                // } else {
                //     return back()->with('error', 'your current password is incorrect.');

                // }
            //

            $validate = $this->changePasswordValidation($request->all());
    
            if($validate->fails()) {
                return back()->withErrors($validate)->withInput();
            }
    
            $admin = $this->changePasswordTraits($request->id);
    
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors(['current_password' => 'Your current password is incorrect.']);
            }
    
            if (
                Hash::check($request->new_password, $admin->password) || 
                Hash::check($request->new_password, $admin->password_one) ||
                Hash::check($request->new_password, $admin->password_two) ||
                Hash::check($request->new_password, $admin->password_three)
            ) {
                return back()->withErrors(['new_password' => 'Please use a different password. This one matches one of your previous passwords.']);
            }
    
            if ($admin) {
                if ($admin->password_two) {
                    $admin->password_three = $admin->password_two;
                }
    
                if ($admin->password_one) {
                    $admin->password_two = $admin->password_one;
                }
    
                if ($admin->password) {
                    $admin->password_one = $admin->password;
                }
    
                $admin->default_password = $request->new_password;
                $admin->password = Hash::make($request->new_password);
                
                $admin->save();
    
                return redirect('admin/profile')->with('success', 'Password has been changed successfully.');
            }
    
        } catch (Throwable $th) {
            Log::error($th->getMessage(), $th->getTraceAsString());
            return back()->withErrors(['error' => 'Something went wrong, please try again.']);
        }
    }
    

    // Login
    public function loginForm() {
        return view('admin.auth.login');
    }

    public function login(Request $request) {
        try {
            $this->authValidation($request->all());

            $credentials = $request->only('email', 'password');

            if (Auth::guard('admin')->attempt($credentials)) {
                $adminUser = Auth::guard('admin')->user();

                $name = $adminUser->name;

                if ($adminUser->login_status !== 1) {
                    $adminUser->update(['login_status' => 1]);
                    
                }

                $userLoginDetails = new UserActivityLog();
                $userLoginDetails->user_id = Auth::guard('admin')->user()->id;
                $userLoginDetails->user_location = $this->getLocationTrait();
                $userLoginDetails->user_ipaddress = $this->getIpAddressTrait();
                $userLoginDetails->user_device_name = $this->getDeviceNameTrait();
                $userLoginDetails->user_browser_name = $this->getBrowserNameTrait();
                $userLoginDetails->user_operating_system = $this->getOpertingSystemTrait();
                if($adminUser->login_status == 1) {
                    $userLoginDetails->status = 1;
                }
                $userLoginDetails->save();

                return redirect('/admin/dashboard')->with('success', "{$name} successfully logged in");

            } else {
                return redirect()->route('admin.login')->with('error', 'Invalid credentials. Please try again.');
            
            }
        } catch (Throwable $th) {
            return redirect()->route('admin.login')->with('error', 'An error occurred. Please try again.');
        
        }
    }


    // single registration
    public function employeeOnboardingForm(Request $request) {
        try{
            $admin = $this->editAdminProfileTraist($request->id);
            $roles = $this->getAllRoleDetails();
            $departments = $this->getAllDepartmentDetails();
            $designations = $this->getAllDesignationDetails();
            if(!empty($roles) && !empty($departments) && !empty($designations)) {
                return view('admin.auth.register', [
                    'admin' => $admin,
                    'roles' => $roles,
                    'departments' => $departments,
                    'designations' => $designations,
                ]);
            }

        } catch(Throwable $th) {
            Log::error(['errors'=>$th->getMessage(), 'Line'=>$th->getTraceAsString()]);

        }
    }

    public function employeeOnboardingSubmit(Request $request) {
        try{
            $validator = $this->adminRegistrationValidation($request->all());
            if($validator->fails()) {
                return $validator->errors();
            }
            DB::beginTransaction();
            $documents = ['pancard_document', 'adhaar_document', 'self_image'];
            $admin = new Admin();
            $admin->department_id = $request->department_id; 
            $admin->designation_id = $request->designation_id; 
            $admin->role_id = $request->role_id; 
            $admin->code = $request->code; 
            $admin->email = $request->email; 
            $admin->name = $request->name;
            $admin->phone = $request->phone;
            $email = $request->email;
            $domain = explode('@', $email);
            $admin->password = Hash::make($domain[0].'@'.$request->code); 
            $admin->default_password = $domain[0].'@'.$request->code;
            $admin->password_modified_at = Carbon::now();
            $admin->created_at = Carbon::now();
            $admin->updated_at = NULL;
            $admin->created_by = Auth::guard('admin')->user()->id;
            $admin->updated_by = NULL;
            $admin->deleted_by = NULL;
            $admin->status = 1;

            foreach($documents as $file) {
                if($request->hasFile($file)) {
                    if(is_array($request->file($file))) {
                        foreach($request->file($file) as $multipleFile){
                            $extension = $multipleFile->getClientOriginalName();
                            $fileName  = time() . '_' . $extension;
                            $filePath = $multipleFile->move('documents/'.$file, $fileName);
                            $admin->$file = $fileName;
                        }
                    } else {
                        $singleFile = $request->file($file);
                        $extension = $singleFile->getClientOriginalName();
                        $fileName = time() . '_' .$extension; 
                        $filePath = $singleFile->move('documents/'.$file, $fileName);
                        $admin->$file = $fileName;
                    }
                }
            }
            $admin->save();

            if(!empty($admin->id)) {
                $bankDetails = new AdminBankDetails();
                $bankDetails->status = 1;
                $bankDetails->admin_id = $admin->id;
                $bankDetails->account_holder = $admin->name;
                $bankDetails->bank_name = $request->bank_name ?? null;
                $bankDetails->ifsc_code = $request->ifsc_code;
                $bankDetails->branch_name = $request->branch_name ?? null;
                $bankDetails->nominee_name = $request->nominee_name ?? null;
                $bankDetails->account_number = $request->account_number ?? null;
                $bankDetails->bank_destination = $request->bank_destination ?? null;
                $bankDetails->bank_opening_date = Carbon::parse($request->bank_opening_date)->format('Y-m-d') ?? null;
                $bankDetails->save();
            }

            if(!empty($admin->id)) {
                $salary = new AdminSalary();
                $salary->admin_id = $admin->id;
                $salary->admin_code = $admin->code;
                $salary->status = $request->status ?? 0;
                $salary->bonus = $request->bonus ?? null;
                $salary->annual = $request->annual ?? null;
                $salary->medical = $request->medical ?? null;
                $salary->monthly = $request->monthly ?? null;
                $salary->department_id = $admin->department_id;
                $salary->basic_pay = $request->basic_pay ?? null;
                $salary->net_salary = $request->net_salary ?? null;
                $salary->base_salary = $request->base_salary ?? null;
                $salary->gross_salary = $request->gross_salary ?? null;
                $salary->bonus_applicable = $request->bonus_applicable ?? 0;
                $salary->house_rent_allowance = $request->house_rent_allowance ?? null;
                $salary->travelling_allowance = $request->travelling_allowance ?? null;
                $salary->tax_deducted_at_source = $request->tax_deducted_at_source ?? null;
                $salary->end_to = Carbon::parse($request->end_to)->format('Y-m-d') ?? null;
                $salary->bonus_date = Carbon::parse($request->bonus_date)->format('Y-m-d') ?? null;
                $salary->start_from = Carbon::parse($request->start_from)->format('Y-m-d') ?? null;
                $salary->applicable_to = Carbon::parse($request->applicable_to)->format('Y-m-d') ?? null;
                $salary->applicable_from =  Carbon::parse($request->applicable_from)->format('Y-m-d') ?? null;
                $salary->save();
            }

            if(!empty($admin->id)) {
                $data = $request->validate([
                        'admin_id.*' => 'numeric',
                        'admin_code.*' => 'string',
                        'company.*' => 'required',
                        'role.*' => 'required',
                        'experience' => 'required',
                        'doj.*' => 'required|date',
                        'doe.*' => 'required|date',
                        'salary.*' => 'required|numeric',
                        'project_title.*' => 'required|string',
                        'description.*' => 'required|string',
                        'documents.*' => 'required|file'
                    ], [
                        'company.*.required' => 'The company field is required for all entries.',
                        'company.*.regex' => 'The company field should contain only alphabetic characters for all entries.',
                        'role.*.required' => 'The role field is required for all entries.',
                        'role.*.regex' => 'The role field should contain only alphabetic characters for all entries.',
                        'experience.required' => 'The experience field is required.',
                        'experience.string' => 'The experience field should be a string.',
                        'doj.*.required' => 'The date of joining field is required for all entries.',
                        'doj.*.date' => 'The date of joining field should be a valid date for all entries.',
                        'doe.*.required' => 'The date of end field is required for all entries.',
                        'doe.*.date' => 'The date of end field should be a valid date for all entries.',
                        'salary.*.required' => 'The salary field is required for all entries.',
                        'salary.*.numeric' => 'The salary field should be numeric for all entries.',
                        'project_title.*.required' => 'The project field is required for all entries.',
                        'project_title.*.string' => 'The project field should be a string for all entries.',
                        'description.*.required' => 'The description field is required for all entries.',
                        'description.*.string' => 'The description field should be a string for all entries.',
                        'documents.*.required' => 'The documents field is required for all entries.',
                        'documents.*.file' => 'The documents field should be a file for all entries.',
                        'documents.*.mimes' => 'The documents field should be a file of type: jpeg, jpg, png for all entries.'
                    ]
                );
                $details = [];
                foreach($data['company'] as $key => $exp) {
                    if ($request->hasFile("documents.$key")) {
                        $file = $request->file("documents.$key");
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $filePath = $file->move('documents/experience', $fileName);
                    }
                    $details[] = [
                        'admin_id' => $admin->id,
                        'admin_code' => $admin->code,
                        'company' => $data['company'][$key],
                        'role' => $data['role'][$key],
                        'experience' => $data['experience'][$key],
                        'doj' => $data['doj'][$key],
                        'doe' => $data['doe'][$key],
                        'salary' => $data['salary'][$key],
                        'project_title' => $data['project_title'][$key],
                        'description' => $data['description'][$key],
                        'documents' => $fileName,
                    ];
                }
                AdminExperience::insert($details);
            }

            DB::commit();
            return redirect('/admin/list/page')->with('message', 'employee onboarding successfully .');

        } catch(Throwable $th) {
            DB::rollback();
            Log::error(['errors' => $th->getMessage(), 'Line' => $th->getTraceAsString()]);
            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        
        }
    }

    public function logout(Request $request) {
        try{
            $admin = Auth::guard('admin')->user();
            if($admin->login_status == 1) {
                $admin->update(['login_status' => 0]);
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login')->with('success', 'logout successfully .');
            }

        } catch(Throwable $th) {

        }
        
    }


    // Bulk Admin Employee Create
    public function sampleExcelDownloandPage(Request $request) {
        try {
            $createBy = $this->editAdminProfileTraist($request->id);
            $roles = $this->getAllRoleDetails();
            $departments = $this->getAllDepartmentDetails();
            $designations = $this->getAllDesignationDetails();
            return view('admin.auth.sample-excel-page', [
                'createBy' => $createBy,
                'roles' => $roles,
                'departments' => $departments,
                'designations' => $designations,
            ]);
        } catch(Throwable $th) {
            
        }
    }

    public function bulkEmployeeOnboarding(Request $request) {
        try {
            $excelTypeUrl = "bulk Employee Onboarding";
            $validator = $this->employeeOnboardingValidation($request->all());

            if($validator->fails()) {
                return $validator->errors();
            }
            
            $departmentName = $this->getSpecificDepartmentData($request);
            $employeeOnboardSheet = env('FORMATTED_ROWS', 100);
            $fileToBeName = $departmentName.'-'.'onboarding-sample-'.time().'.xls';
            $diskToStore = env("MEDIA_DISK", 'public');
            
            $storagePath = 'Onboarding/Sample/'.$fileToBeName;
            
            $dropdownDetails = [];
            
            $department = AdminDepartmentMaster::when($request->has('department_id'), function($query) use($request) {
                $query->where('id', $request->department_id);
            })->with('employeesDepartment')->first();
            
            $createBy = $this->currentUserDetailsTrait();
            // $adminNameAndId = Admin::where('id', $createBy)->select('id','name')->first();
            $adminNameAndId = Admin::where('id', $createBy)->pluck('name')->first();
            $adminNameAndIdArray = array('Super Admin', $adminNameAndId);
            $roles = $this->getAllRoleNameOnly();
            $designations = $this->getAllDesignationNameOnly();
            $moduleAccess = $this->getAllModuleNameOnly();
            if(empty($department)) {
                return "Department details not found, please check your department details";
            }
            
            try{
                $columns = [
                    'Employee code', 
                    'Full Name', 
                    'First Name', 
                    'Last Name',
                    'Who Created Employee',
                    'Employee Role', 
                    'Employee Designation',
                    'Gross Salary',
                    'Employee Module Access',
                    'Employee Gender',
                    'Employee Location', 
                    'Employee Email', 
                    'Employee Password', 
                    'Employee Contact',
                    'Employee DOB', 
                    'Employee DOJ',
                    'Employee Address', 
                    'Previous company',
                    'Previous Role', 
                    'Previous Experience',
                    'Previous Date of joining', 
                    'Previous Date of left',
                    'Previous Salary', 
                    'Previous Project Title',
                    'Previous Description', 
                    'Previous Documents',
                    'house Rent Allowance', 
                    'Travelling Allowance', 
                    'Tax Deducted Source',
                    'Basic Pay', 
                    'Bonus', 
                    'Bonus Applicable',
                    'Salary Status', 
                    'Net salary',
                    'Applicable From', 
                    'Applicable To', 
                    'Beneficiary Name',
                    'Bank Name', 
                    'Branch Name', 
                    'Account Holder Name',
                    'Account Number', 
                    'Ifsc Code', 
                    'Bank Documents',
                ];

                $grossSalary = [
                                '12000', '15000', '20000', '22000', '25000', '28000', '35000', '38000', '40000',
                                '45000', '50000', '55000', '60000','65000', '70000', '75000', '80000',
                            ];

                $gender = ['Male', 'Female', 'Other'];

                $dropdownDetails = [
                    'who_created_employee_index' => 4,
                    'who_created_employee_option' => $adminNameAndIdArray,
                    'role_index' => 5,
                    'role_option' => $roles,
                    'designation_index' => 6,
                    'designation_option' => $designations,
                    'gross_salary_index' => 7,
                    'gross_salary_option' => $grossSalary,
                    'module_access_index' => 8,
                    'module_access_option' => $moduleAccess,
                    'gender_index' => 9,
                    'gender_option' => $gender,
                ];
                // dd( $adminNameAndId, $roles, $designations, $moduleAccess, $storagePath, $dropdownDetails);
                Excel::store(new AdminEmployeeOnboardingExport($columns, $employeeOnboardSheet, $dropdownDetails), $storagePath, $diskToStore, \Maatwebsite\Excel\Excel::XLSX);
                $excelDownload = Storage::disk($diskToStore)->url($storagePath);

                $excelDownload = asset('storage/' . $storagePath);

                return view('admin.auth.excel-link-show',[
                    'excelDownload' => $excelDownload,
                    'excelTypeUrl' => $excelTypeUrl,
                ]);

            } catch (Exception $e) {
                return $e->getMessage();
            }

        } catch(Throwable $th) {

        }
    }

    public function bulkEmployeeOnboardingUpload(Request $request) {
        try{
            $validator = $this->employeeValidation($request->all());
            if($validator->fails()) {
                return $validator->errors();
            }
            $sheetExcel = 1;
            $errorCount = 0;

        } catch(Throwable $th) {
            Log::info($th->getMessage());
        }
    }

    public function employeeOnboardingValidation($data) {
        try {
            $rules = [
                'department_id' =>'required|integer|exists:admin_department_masters,id',
            ];

            $message = [
                'department_id.required' => 'Department id must be required, please set department id',
                'department_id.integer' => 'Department id must be integer type, please check your provided department id',
                'department_id.exists' => 'Department id does not exists, please check department id',
            ];
            return Validator::make($data, $rules, $message);

        } catch(Throwable $th) {
            return ['error' => $th->getMessage(), $th->getLine()];
        }
    }
    
    public function employeeValidation($data) {
        try{
            $rules = [
                'department_id' => 'required|integer|exists:departments,id',
                // 'onboarding_sheet' =>'required|file|mimes:xls,xlx,xlsx',
                // 'type' =>'required|numeric',
            ];
    
            $message = [
                'department_id.required' => 'Department id must be required, please set department id',
                'department_id.integer' => 'Department id must be integer type, please check your provided department id',
                'department_id.exist' => 'Department id does not exists, please check department id',
                'onboarding_sheet.required' => 'Attendence sheet is required, please select valid sheet.',
                'onboarding_sheet.mimes' => 'The : Please select should be Valid Excel File.',
                // 'type.required' => 'The: Type must be required, please set type id',
            ];
    
            $validator = Validator::make($data, $rules, $message);
    
            return $validator;

        } catch(Throwable $th) {

        }
    }

}
