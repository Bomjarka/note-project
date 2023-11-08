<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Role::create(['name' => 'admin']);

        User::factory(1)->create([
            'name' => Role::ROLE_ADMIN,
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ])->first()->assignRole(Role::ROLE_ADMIN);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Role::whereName('admin')->first()->delete();

        User::whereName(Role::ROLE_ADMIN)
            ->whereEmail('admin@gmail.com')
            ->first()
            ->delete();
    }
};
