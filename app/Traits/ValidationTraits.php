<?php

namespace App\Traits;

use Throwable;
use Illuminate\Support\Facades\{Log, Validator};

trait ValidationTraits {
    public function adminRegistrationValidation($data) {
        try{
            $rules = [
                'department_id'  => 'required|integer|exists:admin_department_masters,id',
                'designation_id'  => 'required|integer|exists:admin_designation_masters,id',
                'role_id'  => 'required|integer|exists:admin_roles,id',
                'code' => 'required|string|unique:admins,code',
                'pancard_document' => 'required|file',
                'adhaar_document' => 'required|file',
                'self_image' => 'required|file',
                'email' => 'required|email|unique:admins,email',
                'name' => 'required|string',
                'phone' => 'string|min:10|max:13',
                'bank_name' => 'required|regex:/^[A-Z]{1,}[a-zA-Z. ]{0,}/',
                'branch_name' => 'required|regex:/^[A-Z]{1,}[a-zA-Z. ]{3,}/',
                'account_holder' => 'required|regex:/^[A-Z]{1,}[a-zA-Z. ]{3,}/',
                'account_number' => 'required|regex:/^[0-9]{8,20}/',
                'ifsc_code' => 'required|regex:/([A-Za-z0]{4})(0\d{6})$/',
                'bank_destination' => 'string',
                'nominee_name' => 'string|regex:/^[A-Z]{1,}[a-zA-Z. ]{3,}/',

                'house_rent_allowance' => 'required|regex:/^[0-9]{2,20}[.]{0,2}/',
                'travelling_allowance' => 'regex:/^[0-9]{2,20}[.]{0,2}/',
                'tax_deducted_at_source' => 'regex:/^[0-9]{2,20}[.]{0,2}/',
                'basic_pay' => 'regex:/^[0-9]{2,20}[.]{0,2}/',
                'bonus' => 'regex:/^[0-9]{2,20}[.]{0,2}/',
                'gross_salary' => 'regex:/^[0-9]{2,20}[.]{0,2}/',
                'base_salary' => 'regex:/^[0-9]{2,20}[.]{0,2}/',
                'net_salary' => 'required|regex:/^[0-9]{2,20}[.]{0,2}/',
                'medical' => 'regex:/^[0-9]{2,20}[.]{0,2}/',
                'annual' => 'regex:/^[0-9]{2,20}[.]{0,2}/',
                'monthly' => 'regex:/^[0-9]{2,20}[.]{0,2}/',
                'bonus_date' => 'date',
                'start_from' => 'date',
                'end_to' => 'date',
                'applicable_from' => 'required|date',
                'applicable_to' => 'required|date|after:applicable_from',

            ];

            $message = [
                'code.required' => 'The : employee code is required',
                'code.string' => 'The  : valid employee code is required, employee code should be string type !',
                'code.unique' => 'The : employee code already exists, please try again',
                'email.required' => 'The : email is required',
                'email.email' => 'The  : valid email is required, email should be email type !',
                'email.unique' => 'The : email already exists, please try again',
                'name.required' => 'The : name field is required', 
                'name.string' => 'The : name field must be alpha character',
                'phone.string' => 'The : phone is string type',
                'phone.min' => 'The : phone is atleast 10 digit', 
                'phone.max' => 'The : phone is maximum 13 digit', 
                'self_image.required' => 'The : employee image is required',
                'self_image.file' => 'The  : please provide valid employee image document !',
                // 'self_image.mimes' => 'The : employee image extension must be png/pdf/jpg/jpeg/svg/bmp/webp',
                'adhaar_document.required' => 'The : employee adhaar document is required',
                'adhaar_document.file' => 'The  : please provide valid employee adhaar document !',
                'pancard_document.required' => 'The : employee pancard document is required',
                'pancard_document.file' => 'The  : please provide valid employee pancard document !',
                
                'house_rent_allowance.required' => 'House rent allowance required.',
                'house_rent_allowance.regex' => 'House rent allowance invalid.',
                'travelling_allowance.regex' => 'Travelling allowance decimel.',
                'tax_deducted_at_source.regex' => 'Tax deducted source decimel.',
                'basic_pay.regex' => 'Basic pay is decimel.',
                'gross_salary.regex' => 'Gross salary pay is decimel.',
                'base_salary.regex' => 'base salary pay is decimel.',
                'bonus.regex' => 'Bonus is decimel.',
                'net_salary.regex' => 'Net salary pay is decimel.',
                'medical.regex' => 'medical is decimel.',
                'annual.regex' => 'annual salary is decimel.',
                'monthly.regex' => 'monthly salary is decimel.',
                'applicable_from.required' => 'Applicable from is required.',
                'applicable_from.date' => 'Applicable from is invalid date.',
                'applicable_to.required' => 'Applicable to is required.',
                'applicable_to.date' => 'Applicable to is invalid date.',
                'applicable_to.after' => 'Applicable to date is after appicable from date.',
            
                'bank_name.required' => 'Bank name is required.',
                'bank_name.invalid' => 'Bank name is invalid.',
                'branch_name.required' => 'Branch name is required.',
                'branch_name.invalid' => 'Branch name is invalid.',
                'account_holder.required' => 'Account holder name is required.',
                'account_holder.invalid' => 'Account holder name is invalid.',
                'account_number.required' => 'Account number is required.',
                'account_number.invalid' => 'Account number is invalid please use (eg 01242546879).',
                'ifsc_code.required' => 'IFSC code is required.',
                'ifsc_code.invalid' => 'IFSC code is invalid.',
                'nominee_name.invalid' => 'nominee name is invalid.',
            ];

            return Validator::make($data, $rules, $message);

        } catch(Throwable $th) {
            errorLog("---------------------------------");
            errorLog($th->getMessage());
            errorLog("---------------------------------");
            errorLog($th->getLine());
        
        }
    }

    public function authValidation($data) {
        try{
            $rules = [
                'email' => 'required|email|exists:admins,email',
                'password' => 'required',
            ];

            $message = [
                'email.required' => 'The : email is required',
                'email.email' => 'The  : valid email is required, email should be email type !',
                'email.exists' => 'The : email does not exists, please check and try again',
                'password.required' => 'The : email is required',
            ];

            return Validator::make($data, $rules, $message);

        } catch(Throwable $th) {
            errorLog("---------------------------------");
            errorLog($th->getMessage());
            errorLog("---------------------------------");
            errorLog($th->getLine());
        }
    }

    public function profileValidation($data, $id) {
        try {
            $rules = [
                'username' => 'string|max:255',
                'email' => ['email', 'max:255', Rule::unique('admins')->ignore($id)],
                'designation_id' => 'exists:designations,id',
                'department_id' => 'exists:departments,id',
                'role_id' => 'exists:roles,id',
                'code' => 'string|max:100',
                'contact' => 'string|max:15',
                'dob' => 'date',
                'doj' => 'date',
                // 'gender' => 'in:1,2,3',
                'name' => 'string|max:255',
            ];

            $message = [
                'username.string' => 'The username field must be string type.',
                'username.max' => 'Please username is upto 255 character.',
                'email.email' => 'Please provide a valid email address.',
                'email.max' => 'Please email is upto 255 character.',
                'department_id.exists' => 'The selected department is invalid.',
                'designation_id.exists' => 'The selected designation is invalid.',
                'role_id.exists' => 'The selected role is invalid.',
                'code.string' => 'The employee code field must be string type.',
                'code.max' => 'The employee code is upto 100 character.',
                'contact.string' => 'Contact number field must be string type.',
                'dob.date' => 'Date of birth is invalid date type.',
                'doj.date' => 'Date of joining is invalid date type.',
                // 'gender.in' => 'Please select a valid gender.',
                'name.string' => 'The name field must be string type.',
            ];

            return Validator::make($data, $rules, $message);

        } catch(Throwable $th) {
            errorLog("---------------------------------");
            errorLog($th->getMessage());
            errorLog("---------------------------------");
            errorLog($th->getLine());
        }
    }

    public function changePasswordValidation($data) {
        try{
            $rules = [
                'current_password' => 'required|string|min:8',
                'new_password' => 'required|string|min:8|confirmed',
            ];

            $message = [
                'current_password.required' => 'The : current password is required .',
                'current_password.string' => 'The : current password is string type.',
                'current_password.min' => 'The : current password must be minimum 8 character .',
                'new_password.required' => 'The : new password is required .',
                'new_password.string' => 'The : new password is string type.',
                'new_password.min' => 'The : new password must be minimum 8 character .',
            ];

            return Validator::make($data, $rules, $message);

        } catch(Throwable $th) {
            errorLog("---------------------------------");
            errorLog($th->getMessage());
            errorLog("---------------------------------");
            errorLog($th->getLine());
        }
    }

    public function moduleValidation($data) {
        try{
            $rules = [
                'name' => 'required|string',
                'icon' => 'required|string',
                'route' => 'required|string',
                'order' => 'numeric',
            ];

            $message = [
                'name.required' => 'The : module name field is required .',
                'name.string' => 'The : module name field is string type.',
                'icon.required' => 'The : module icon field is required .',
                'icon.string' => 'The : module icon field is string type.',
                'route.required' => 'The : module route field is required .',
                'route.string' => 'The : module route field is string type.',
                'order.numeric' => 'The : module name field is numeric type.',
            ];

            return Validator::make($data, $rules, $message);

        } catch(Throwable $th) {
            errorLog("---------------------------------");
            errorLog($th->getMessage());
            errorLog("---------------------------------");
            errorLog($th->getLine());
        }
    }

    public function moduleUpdateValidation($data) {
        try{
            $rules = [
                'name' => 'string',
                'icon' => 'string',
                'route' => 'string',
                'order' => 'numeric',
            ];

            $message = [
                'name.string' => 'The : module name field is string type.',
                'icon.string' => 'The : module icon field is string type.',
                'route.string' => 'The : module route field is string type.',
                'order.numeric' => 'The : module name field is numeric type.',
            ];

            return Validator::make($data, $rules, $message);

        } catch(Throwable $th) {
            errorLog("---------------------------------");
            errorLog($th->getMessage());
            errorLog("---------------------------------");
            errorLog($th->getLine());
        }
    }

    public function subModuleCreateValidation($data) {
        try{
            $rules = [
                'icon' => 'string',
                'color_code' => 'string',
                'name' => 'required|string',
                'route' => 'required|string',
                'query' => 'required|string',
                'order' => 'required|numeric',
                'route_type' => 'required|string',
                // 'sub_module_id' => 'required|numeric|exists:admin_module,id',
                'module_id' => 'required',
            ];

            $message = [
                'module_id.required' => 'The: module id field is required.',
                // 'module_id.numeric' => 'The: module id is invalid.',
                // 'module_id.exists' => 'The: module id does not exist.',
                'name.required' => 'The: module name field is required.',
                'name.string' => 'The: module name field is string type, please use alphabate.',
                'route.required' => 'The: module route field is required.',
                'route.string' => 'The: module route field is string type, please use alphabate.',
                'route_type.required' => 'The: module route type field is required.',
                'route_type.string' => 'The: module route type field is string type',
                'query.required' => 'The: module query field is required.',
                'query.string' => 'The: module query field is string type.',
                'order.required' => 'The: module order field is required.',
                'order.numeric' => 'The: module order field is numeric type.',
                'icon.string' => 'The: module icon field is string type.',
                'color_code.string' => 'The: module color code field is string type.',
            ];

            return Validator::make($data, $rules, $message);

        } catch(Throwable $th) {
            errorLog("---------------------------------");
            errorLog($th->getMessage());
            errorLog("---------------------------------");
            errorLog($th->getLine());
            return response()->json([
                'error' => $th->getTraceAsString(),
            ]);
        }
    }

    public function bulkSubModuleCreateValidation($data) {
        try {
            $rules = [
                // 'module_id' =>'required|integer|exists:admin_module,id',
                'module_id' =>'nullable',
            ];

            $message = [
                'module_id.required' => 'The: Module id must be required, please set module id',
                'module_id.integer' => 'The: Module id must be integer type, please check your provided module id',
                'module_id.exists' => 'The: Module id does not exists, please check module id',
            ];
            return Validator::make($data, $rules, $message);

        } catch(Throwable $th) {
            errorLog("---------------------------------");
            errorLog($th->getMessage());
            errorLog("---------------------------------");
            errorLog($th->getLine());
            return ['error' => $th->getMessage(), $th->getLine()];
        }
    }

    public function childModuleCreateValidation($data) {
        try{
            $rules = [
                'icon' => 'string',
                'color_code' => 'string',
                'name' => 'required|string',
                'route' => 'required|string',
                'query' => 'required|string',
                'order' => 'required|numeric',
                'route_type' => 'required|string',
                // 'sub_module_id' => 'required|numeric|exists:admin_sub_module,id',
                'sub_module_id' => 'required',
            ];

            $message = [
                'sub_module_id.required' => 'The: module id field is required.',
                // 'sub_module_id.numeric' => 'The: module id is invalid.',
                // 'sub_module_id.exists' => 'The: module id does not exist.',
                'name.required' => 'The: module name field is required.',
                'name.string' => 'The: module name field is string type, please use alphabate.',
                'route.required' => 'The: module route field is required.',
                'route.string' => 'The: module route field is string type, please use alphabate.',
                'route_type.required' => 'The: module route type field is required.',
                'route_type.string' => 'The: module route type field is string type',
                'query.required' => 'The: module query field is required.',
                'query.string' => 'The: module query field is string type.',
                'order.required' => 'The: module order field is required.',
                'order.numeric' => 'The: module order field is numeric type.',
                'icon.string' => 'The: module icon field is string type.',
                'color_code.string' => 'The: module color code field is string type.',
            ];

            return Validator::make($data, $rules, $message);

        } catch(Throwable $th) {
            errorLog("---------------------------------");
            errorLog($th->getMessage());
            errorLog("---------------------------------");
            errorLog($th->getLine());
            return response()->json([
                'error' => $th->getTraceAsString(),
            ]);
        }
    }

    public function bulkChildModuleCreateValidation($data) {
        try{
            $rules = [
                // 'sub_module_id' => 'required|numeric|exists:admin_sub_module,id',
                'sub_module_id' => 'nullable',
            ];

            $message = [
                // 'sub_module_id.required' => 'The: module id field is required.',
                // 'sub_module_id.numeric' => 'The: module id is invalid.',
                // 'sub_module_id.exists' => 'The: module id does not exist.',
                'sub_module_id.nullable' => 'The: module id field is required.',
            ];

            return Validator::make($data, $rules, $message);

        } catch(Throwable $th) {
            errorLog("---------------------------------");
            errorLog($th->getMessage());
            errorLog("---------------------------------");
            errorLog($th->getLine());
            return response()->json([
                'error' => $th->getTraceAsString(),
            ]);
        }
    }

}
