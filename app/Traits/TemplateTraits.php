<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Throwable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;


trait TemplateTraits {

    public function adminHeading () {
        return "Admin | Sub Module Dashboard";
    }
    
    public function adminGroceryHeading () {
        return "Admin | Grocery";
    }

    public function generateMigrationSchema($fields) {
        try{
            $schema = "\$table->id();\n";
            foreach ($fields as $field) {
                $name = $field['name'];
                $type = $field['type'];
                $length = $field['length'] ?? null;
                $notNull = isset($field['not_null']) ? true : false;
                $unsigned = $field['unsigned'] ?? null;
                $comment = $field['comment'] ?? null;
                $default = $field['default'] ?? null;

                $column = match($type) {
                    'bigint' => "\$table->bigInteger('$name', $length)",
                    'tinyint' => "\$table->tinyInteger('$name', $length)",
                    'string' => "\$table->string('$name', $length)",
                    'integer' => "\$table->integer('$name', $length)",
                    'double' => "\$table->double('$name')",
                    'text' => "\$table->text('$name')",
                    'boolean' => "\$table->boolean('$name')",
                    'datetime' => "\$table->dateTime('$name')",
                    'float' => "\$table->float('$name')",
                    'json' => "\$table->json('$name')",
                    'enum' => "\$table->enum('$name', $length)",
                    default => null
                };

                if ($column === null) {
                    throw new \Exception("Unsupported field type: $type");
                }

                if ($unsigned) {
                    $column .= "->unsigned()";
                }

                if ($notNull) {
                    $column .= "->nullable(false)";
                } else {
                    $column .= "->nullable()";
                }
                
                if ($comment !== null) {
                    $column .= "->comment('$comment')";
                }

                if ($default) {
                    $column .= is_string($default) ? "->default('$default')" : "->default($default)";
                } 

                $schema .= $column . ";\n";
            }
            $schema .= "\$table->softDeletes();";
            return $schema;

        } catch(Throwable $th) {
            return Log::info([$th->getMessage()]);
        }
    }

    public function generateModel($tableName) {
        try{
            // $modelName = ucfirst(Str::camel(Str::singular($tableName)));
            // $filePath = app_path("Models/Admin/{$modelName}");
            // Artisan::call('make:model', [
            //         'name'=>$modelName,
            //         'path'=> $filePath
            //     ]
            // );
            $modelName = ucfirst(Str::camel(Str::singular($tableName)));
            $filePath = app_path("Models/Admin/{$modelName}.php");
            
            // Check if the directory exists, if not, create it
            if (!File::exists(dirname($filePath))) {
                File::makeDirectory(dirname($filePath), 0755, true);
            }
            $modelTemplate = <<<EOT
                            <?php
                            namespace App\Models\Admin;
                            use Illuminate\Database\Eloquent\Model;
                            use Illuminate\Database\Eloquent\SoftDeletes;
                            use Illuminate\Database\Eloquent\Factories\HasFactory;

                            class {$modelName} extends Model {
                                use HasFactory, SoftDeletes;

                                protected \$table = '{$tableName}';
                                
                                protected \$fillable = [];
                            }
                            EOT;

            File::put($filePath, $modelTemplate);
            return "Model created at: {$filePath}";

        } catch(Throwable $th) {
            return $th->getTraceAsString();
        }
    }

    public function generateController($tableName) {
        try{
            // ye code tab ke liye hai jab default location par model create karna ho
            // $controllerName = ucfirst(Str::camel(Str::singular($tableName))) . 'Controller';
            // Artisan::call('make:controller', [
            //     'name' => $controllerName,
            //     'path'=> $filePath,
            //     '--resource' => true
            // ]);

            $userType = [1,2,3];
            
            if ($userType[0] == 1) { // For Admin
                // ye jab hamko kudh se defined karna ho ki kaha par controller create karna hai 
                $controllerName = ucfirst(Str::camel(Str::singular($tableName))) . 'Controller';
                $filePath = app_path("Http/Controllers/Admin/{$controllerName}.php");
                if (!File::exists(dirname($filePath))) {
                    File::makeDirectory(dirname($filePath), 0755, true);
                }

            } elseif($userType[0] == 2) { // Vendor
                $controllerName = ucfirst(Str::camel(Str::singular($tableName))) . 'Controller';
                $filePath = app_path("Http/Controllers/Vendor/{$controllerName}.php");
                if (!File::exists(dirname($filePath))) {
                    File::makeDirectory(dirname($filePath), 0755, true);
                }

            } else { // User
                $controllerName = ucfirst(Str::camel(Str::singular($tableName))) . 'Controller';
                $filePath = app_path("Http/Controllers/User/{$controllerName}.php");
                if (!File::exists(dirname($filePath))) {
                    File::makeDirectory(dirname($filePath), 0755, true);
                }
            }
            
            // Check if the directory exists, if not, create it
            if (!File::exists(dirname($filePath))) {
                File::makeDirectory(dirname($filePath), 0755, true);
            }

            $controllerTemplate = <<<EOT
                                <?php

                                namespace App\Http\Controllers\Admin;

                                use Exception;
                                use Throwable;
                                use Illuminate\Http\Request;
                                use Illuminate\Support\Facades\DB;
                                use Illuminate\Support\Facades\Log;
                                use App\Models\Admin;

                                class {$controllerName} extends Controller {
                                    public function index() {
                                        try{


                                        } catch(Throwable \$t) {
                                            return Log::info([\$t->getMessage(), \$t->getTraceAsString()]);
                                        }
                                    }

                                    public function create() {
                                        try{

                                        
                                        } catch(Throwable \$t) {
                                            return Log::info([\$t->getMessage(), \$t->getTraceAsString()]);
                                        }
                                    }

                                    public function store(Request \$request) {
                                        try{

                                        
                                        } catch(Throwable \$t) {
                                            return Log::info([\$t->getMessage(), \$t->getTraceAsString()]);
                                        }
                                    }

                                    public function show(\$id) {
                                        try{

                                        
                                        } catch(Throwable \$t) {
                                            return Log::info([\$t->getMessage(), \$t->getTraceAsString()]);
                                        }
                                    }

                                    public function edit(\$id) {
                                        try{

                                        
                                        } catch(Throwable \$t) {
                                            return Log::info([\$t->getMessage(), \$t->getTraceAsString()]);
                                        }
                                    }

                                    public function update(Request \$request, \$id) {
                                        try{

                                        
                                        } catch(Throwable \$t) {
                                            return Log::info([\$t->getMessage(), \$t->getTraceAsString()]);
                                        }
                                    }

                                    public function destroy(\$id) {
                                        try{

                                        
                                        } catch(Throwable \$t) {
                                            return Log::info([\$t->getMessage(), \$t->getTraceAsString()]);
                                        }
                                    }
                                }   
                                EOT;

            File::put($filePath, $controllerTemplate);

            return "Controller created at: {$filePath}";

        } catch(Throwable $th) {
            return $th->getTraceAsString();
        }
    }




    // old code with migration create
    // public function generateModel($tableName) {
        //     try {
        //         $modelName = ucfirst(Str::camel($tableName));
        //         $modelTemplate = <<<EOT
        //         <?php
        //         namespace App\Models\Admin;

        //         use Illuminate\Database\Eloquent\Model;
        //         use Illuminate\Database\Eloquent\Factories\HasFactory;
            
        //         class {$modelName} extends Model {
        //             use HasFactory;

        //             protected \$table = '{$tableName}';

        //             protected \$fillable = [];
        //         }
        //         EOT;
            
        //         $modelPath = app_path("Models/Admin/{$modelName}.php");
        //         File::put($modelPath, $modelTemplate);

        //     } catch(Throwable $t) {
        //         return $t->getMessage();
        //     }
    // }

    // public function generateController($tableName) {
        //     try {
        //         $controllerName = ucfirst(Str::camel($tableName));
        //         $setName = $controllerName."Controller";
        //         $controllerTemplate = <<<EOT
        //                             <?php

        //                             namespace App\Http\Controllers\Admin;

        //                             use Exception;
        //                             use Throwable;
        //                             use Illuminate\Http\Request;
        //                             use Illuminate\Support\Facades\DB;
        //                             use Illuminate\Support\Facades\Log;
        //                             use App\Http\Controllers\Controller;
        //                             class {$setName} extends Controller {
        //                                 public function index() {
        //                                     try{


        //                                     } catch(Throwable \$t) {
        //                                         return Log::info([\$t->getMessage(), \$t->getTraceAsString()]);
        //                                     }
        //                                 }

        //                                 public function create() {
        //                                     try{

                                            
        //                                     } catch(Throwable \$t) {
        //                                         return Log::info([\$t->getMessage(), \$t->getTraceAsString()]);
        //                                     }
        //                                 }

        //                                 public function store(Request \$request) {
        //                                     try{

                                            
        //                                     } catch(Throwable \$t) {
        //                                         return Log::info([\$t->getMessage(), \$t->getTraceAsString()]);
        //                                     }
        //                                 }

        //                                 public function show(\$id) {
        //                                     try{

                                            
        //                                     } catch(Throwable \$t) {
        //                                         return Log::info([\$t->getMessage(), \$t->getTraceAsString()]);
        //                                     }
        //                                 }

        //                                 public function edit(\$id) {
        //                                     try{

                                            
        //                                     } catch(Throwable \$t) {
        //                                         return Log::info([\$t->getMessage(), \$t->getTraceAsString()]);
        //                                     }
    //}

    // public function update(Request \$request, \$id) {
        //    try{

                                            
        //                                     } catch(Throwable \$t) {
        //                                         return Log::info([\$t->getMessage(), \$t->getTraceAsString()]);
        //                                     }
        //                                 }

        //                                 public function destroy(\$id) {
        //                                     try{

                                            
        //                                     } catch(Throwable \$t) {
        //                                         return Log::info([\$t->getMessage(), \$t->getTraceAsString()]);
        //                                     }
        //                                 }
        //                             }   
        //                             EOT;

        //         $filePath = app_path("Http/Controllers/Admin/{$setName}.php");
        //         File::put($filePath, $controllerTemplate);

        //     } catch(Exception $e) {
        //         return Log::info([$e->getMessage()]);

        //     }
    // }

    // public function saveTable(Request $request) {
        //     try {
        //         $request->validate([
        //             'table_name' => 'required|string',
        //             'fields' => 'required|array',
        //             'fields.*.name' => 'required|string',
        //             'fields.*.type' => 'required|string',
        //             'fields.*.length' => 'nullable|string',
        //             'fields.*.not_null' => 'nullable|string',
        //             'fields.*.null' => 'nullable|string',
        //             'fields.*.unsigned' => 'nullable|string',
        //             'fields.*.index' => 'nullable|string',
        //             'fields.*.default' => 'nullable|string',
        //         ]);
            
        //         $tableName = $request->input('table_name');
                
        //         if (Schema::hasTable($tableName)) {
        //             return response()->json(['error' => 'Table already exists.'], 400);
        //         }

        //         $fields = $request->input('fields');
            
        //         Schema::create($tableName, function (Blueprint $table) use ($fields) {
        //             $table->id();
        //             foreach ($fields as $field) {
        //                 $name = $field['name'];
        //                 $type = $field['type'];
        //                 $length = $field['length'] ?? null;
        //                 $notNull = isset($field['not_null']) ? true : false;
        //                 $unsigned = isset($field['unsigned']);
        //                 $default = $field['default'] ?? Null;
        //                 $Comments = $field['comment'] ?? Null;
            
        //                 $column = match($type) {
        //                     'bigint' => $table->bigInteger($name),
        //                     'tinyint' => $table->tinyInteger($name),
        //                     'string' => $table->string($name, $length ?? 255),
        //                     'integer' => $table->integer($name),
        //                     'double' => $table->double($name),
        //                     'text' => $table->text($name),
        //                     'boolean' => $table->boolean($name),
        //                     'datetime' => $table->dateTime($name),
        //                     'float' => $table->float($name),
        //                     'json' => $table->json($name),
        //                     default => null
        //                 };
            
        //                 if ($unsigned && in_array($type, ['bigint', 'tinyInteger', 'integer', 'double', 'float'])) {
        //                     $column->unsigned();
        //                 }
            
        //                 if ($notNull) {
        //                     $column->nullable(false);
        //                 } else {
        //                     $column->nullable();
        //                 }
            
        //                 if ($default !== null) {
        //                     $column->default($default);
        //                 }

        //                 if($Comments !==null) {
        //                     $column->comment($Comments);
        //                 } 
        //             }
            
        //             $table->softDeletes();
        //             $table->timestamps();
        //         });
                
        //         $this->generateModel($tableName);
        //         $this->generateController($tableName);
        //         return redirect('admin/database/table-list')->with('success', 'table created successfully !!');

        //     } catch(Throwable $t) {
        //         return Log::info([$t->getMessage(), $t->getTraceAsString()]);
        //     }
    // }
}




	