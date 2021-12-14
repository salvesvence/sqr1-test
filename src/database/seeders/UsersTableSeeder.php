<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Src\Domain\Role\Types\RoleEnum;
use Illuminate\Support\Facades\Hash;
use Src\Support\Traits\Seeders\Truncateable;

class UsersTableSeeder extends Seeder
{
    use Truncateable;

    /**
     * @var array
     */
    protected $toTruncate = ['users'];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate();

        $adminRole = Role::where('name', RoleEnum::admin())->firstOrFail();

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@webmaster.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('W3bm@st3r2021'),
        ]);

        $user->assignRole($adminRole);
    }
}
