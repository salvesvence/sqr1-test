<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Src\Domain\Role\Types\RoleEnum;
use Src\Support\Traits\Seeders\Truncateable;

class RolesTableSeeder extends Seeder
{
    use Truncateable;

    /**
     * @var array
     */
    protected $toTruncate = [
        'roles'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate();

        Role::create(['name' => RoleEnum::admin()]);
        Role::create(['name' => RoleEnum::blogger()]);
    }
}
