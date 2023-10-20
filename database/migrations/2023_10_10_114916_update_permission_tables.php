<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $teams = config('permission.teams');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }
        if ($teams && empty($columnNames['team_foreign_key'] ?? null)) {
            throw new \Exception('Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        // Add fields to the permissions table
        Schema::table($tableNames['permissions'], function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->integer('module_id');
            $table->boolean('is_active')->default(1);
            $table->softDeletes();
        });

        // Add fields to the roles table
        Schema::table($tableNames['roles'], function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(1);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableNames = config('permission.table_names');

        // Remove fields from the permissions table
        Schema::table($tableNames['permissions'], function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('module_id');
            $table->dropColumn('is_active');
            $table->dropColumn('deleted_at');
        });

        // Remove fields from the roles table
        Schema::table($tableNames['roles'], function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('is_active');
            $table->dropColumn('deleted_at');
        });
    }
};
