<?php

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //Roles Table
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label')->nullable();
            $table->timestamps();
        });

        //Permissions Table
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label')->nullable();
            $table->timestamps();
        });

        //Permission role PIVOT Relationship
        Schema::create('permission_role', function (Blueprint $table) {
            $table->foreignIdFor(Permission::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(Role::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->primary(['permission_id', 'role_id']);
        });

        //Role user PIVOT Relationship
        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignIdFor(Role::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->primary(['role_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('role_user');
    }
};
