<?php

namespace App\Http\Controllers\Admin\Grocery;

use Throwable;
use App\Traits\QueryTraits;
use App\Traits\TemplateTraits;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Admin\AdminSubModule;

class GroceryDashboardController extends Controller {
    use QueryTraits;
    use TemplateTraits;
    public function grocerySubModuleDashboard() {
        try {
            $grocery = $this->adminGroceryHeading();
            $templateData = $this->grocerySubModuleListTrait();
            errorLog($templateData);
            $groceryTemplateData = [];

            foreach($templateData as $index => $template) {
                if(!empty($template->query)) {
                    $query = $template->query;
                    $result = DB::select($query);
                    $queryData = [];
                    foreach($result as $data) {
                        foreach($data as $key => $value) {
                            $queryData = $value;
                        }
                        $groceryTemplateData[$index]['query'] = $queryData;
                    }

                    $groceryTemplateData[$index] = [
                        'query' => $queryData,
                        'module_id' => $template->module_id,
                        'name' => $template->name,
                        'route' => $template->route,
                        'icon' => $template->icon,
                        'route_type' => $template->route_type,
                        'color_code' => $template->color_code,
                    ];
                }
            }

            return view('admin.grocery.grocery-sub-module',[
                'grocery' => $grocery,
                'groceryTemplateData' => $groceryTemplateData,
            ]);

        } catch(Throwable $th) {

        }
    }
}
