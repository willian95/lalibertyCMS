<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        if(Role::where("id", 1)->count() == 0){

            $role = new Role;
            $role->name = "admin";
            $role->save();

        }

    }
}
