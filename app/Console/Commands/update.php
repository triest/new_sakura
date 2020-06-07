<?php

namespace App\Console\Commands;

use App\Models\Admin\Permission;
use Illuminate\Console\Command;

class update extends Command
{

    protected $signature = 'app:update';
    protected $description = 'Обновляет permissions';

    /**
     * @return mixed
     */
    public function handle()
    {
        \DB::table('permissions')->truncate();
        foreach (config('app_permissions') as $row) {
            \DB::table('permissions')->insert($row);
        }
    }
}
