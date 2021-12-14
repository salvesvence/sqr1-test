<?php

namespace Src\Support\Traits\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

trait Truncateable
{
    /**
     * Truncate the current table.
     */
    protected function truncate()
    {
        if (env('DB_CONNECTION') !== 'sqlite') {

            Model::unguard();

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            foreach($this->toTruncate as $table) {
                DB::table($table)->truncate();
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            Model::reguard();
        }
    }
}
