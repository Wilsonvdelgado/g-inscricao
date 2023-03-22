<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class InseertAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('users')->insert(
            [
                'name' => "Administrador",
                'email' => "admin@admin.com",
                'password' =>  Hash::make("1234")
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $admin =  User::where([
            ['email', "=", "admin@admin.com"],
            ['name', "=", "Administrador"]
        ])->first();

        if ($admin != null) {
            User::destroy($admin->id);
        }
    }
}
