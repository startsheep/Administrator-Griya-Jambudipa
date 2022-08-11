<?php


namespace Database\Seeders\Traits;


use Illuminate\Support\Facades\DB;

trait DisableForeignKey
{
    protected function disableForeignKeys()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
    }

    protected function enableForeignKeys()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
