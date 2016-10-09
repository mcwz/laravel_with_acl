<?php
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EntrustSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating roles to users (Many-to-Many)
        Schema::create('role_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'role_id']);
        });

        // Create table for storing permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });

        $this->setupFoundorAndBaseRolsPermission();
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('permission_role');
        Schema::drop('permissions');
        Schema::drop('role_user');
        Schema::drop('roles');
    }


    /**
     *
     */
    private function setupFoundorAndBaseRolsPermission()
    {
        // Create Roles
        $founder = new Role;
        $founder->name = 'Founder';
        $founder->save();
        $admin = new Role;
        $admin->name = 'Admin';
        $admin->save();
        // Create User
        $user = new User;
        $user->name = 'admin';
        //$user->display_name = 'Admin';
        $user->email = 'admin@local.com';
        $user->password = bcrypt('admin');
        //$user->password_confirmation = 'admin';
        //$user->confirmation_code = md5(uniqid(mt_rand(), true));
        //$user->confirmed = true;
        if(! $user->save()) {
            Log::info('Unable to create user '.$user->name, (array)$user->errors());
        } else {
            Log::info('Created user "'.$user->name.'" <'.$user->email.'>');
        }
        // Attach Roles to user
        $user->roles()->attach( $founder->id );
        // Create Permissions
        $manageContent = new Permission;
        $manageContent->name = 'manage_contents';
        $manageContent->display_name = 'Manage Content';
        $manageContent->save();
        $manageUsers = new Permission;
        $manageUsers->name = 'manage_users';
        $manageUsers->display_name = 'Manage Users';
        $manageUsers->save();
        // Assign Permission to Role
        $founder->perms()->sync([$manageContent->id,$manageUsers->id]);
        $admin->perms()->sync([$manageContent->id]);
    }
}
