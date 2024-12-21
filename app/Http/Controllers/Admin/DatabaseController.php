<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use App\Traits\TemplateTraits;
use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Log, File, Schema, Artisan};

class DatabaseController extends Controller {
    use TemplateTraits;
    public function tableList() {
        try {
            $data = $this->adminHeading();
            $details = Admin::getTableName();
            return view('admin.database.table-list', [
                'details' => $details,
                'data' => $data
            ]);
        } catch (Throwable $th) {
            Log::info('database related error', [$th->getMessage()]);
        }
    }

    public function createTable() {
        $data = $this->adminHeading();
        return view('admin.database.create-table', ['data' => $data]);
    }


    public function saveTable(Request $request) {
        try {
            $request->validate([
                'table_name' => 'required|string',
                'fields' => 'required|array',
                'fields.*.name' => 'required|string',
                'fields.*.type' => 'required|string',
                'fields.*.length' => 'nullable|string',
                'fields.*.not_null' => 'nullable|string',
                'fields.*.null' => 'nullable|string',
                'fields.*.unsigned' => 'nullable|string',
                'fields.*.index' => 'nullable|string',
                'fields.*.default' => 'nullable|string',
                'fields.*.comment' => 'nullable|string',
            ]);

            $tableName = $request->input('table_name');
            $fields = $request->input('fields');
            
            if (Schema::hasTable($tableName)) {
                return response()->json(['error' => 'Table already exists.'], 400);
            }

            $migrationFileName = 'create_' . $tableName . '_table';
            
            Artisan::call('make:migration', [
                'name' => $migrationFileName,
                '--create' => $tableName
            ]);

            $migrationPath = database_path('migrations');

            $migrationFile = collect(File::allFiles($migrationPath))
            ->last(fn($file) => str_contains($file->getFilename(), $migrationFileName));
            
            if (!$migrationFile) {
                return response()->json(['error' => 'Migration file not found.'], 500);
            }


            $migrationContent = File::get($migrationFile->getPathname());
            $migrationContent = str_replace(
                '$table->id();',
                $this->generateMigrationSchema($fields),
                $migrationContent
            );
            File::put($migrationFile->getPathname(), $migrationContent);

            DB::listen(function ($query) {
                Log::info($query->sql, $query->bindings);
            });

            $relativeMigrationPath = 'database/migrations/' . $migrationFile->getFilename();

            try {
                Artisan::call("migrate", [
                    '--path'=>$relativeMigrationPath
                ]);

            } catch (\Exception $e) {
                Log::error('Migration failed: ' . $e->getMessage());
                return response()->json(['error' => 'Migration failed: ' . $e->getMessage()], 500);
            }

            $this->generateModel($tableName);
            $this->generateController($tableName);

            return redirect('admin/database/table-list')->with('success', 'Table, model, controller, and migration created successfully!');
        } catch (Throwable $th) {
            return Log::info([$th->getTraceAsString()]);
        }
    }


    // Create BREAD 
    public function createBread(Request $request) {
        try {
            $data = $this->adminHeading();
            $tableName = DB::select('show tables');
            foreach ($tableName as $name) {
                $details[] = $name->Tables_in_ecomm;
            }

            return view(
                'admin.database.bread',
                ['data' => $data]
            );
        } catch (Throwable $t) {
        }
    }

    public function saveBread(Request $request) {
        try {
            $request->validate([
                'table_name'             => 'string',
                'display_name_singulars' => 'string',
                'display_name_plurals'   => 'string',
                'model_name'             => 'string',
                'controller_name'        => 'string',
                'policy_name'            => 'string',
                'generate_permission'    => 'string',
                'server_side_pagination' => 'string',
                'order_column'           => 'string',
                'order_display_column'   => 'string',
                'order_direction'        => 'string',
            ]);

        } catch (Throwable $t) {
        }
    }
}
