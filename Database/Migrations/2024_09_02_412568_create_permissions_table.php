<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('account.table_names');
        if (empty($tableNames) || !is_array($tableNames)) {
            throw new \Exception('Error: Module config.php file not found or table_names not set. Please check the file and set table_names manually.');
        }
        
        /**
         * Group Model Table
         */
        Schema::create($tableNames['table_name_groups'], function (Blueprint $table) {
            $table->string('id', 25 )->unique();
            $table->string('name', 45);
            $table->text('permissions');
            $table->timestamps();
            $table->primary('id');
        });
        
        /**
         * GroupUser Model Table
         */
        Schema::create($tableNames['table_name_group_user'], function (Blueprint $table) use( $tableNames ) {
            $table->increments('id');
            $table->integer('user_id', false, true);
            $table->string('group_id', 25);
            $table->timestamps();
            
            $table->foreign('user_id', 'fk_group_user_user_id')
            ->references('id')
            ->on($tableNames['table_name_users'])
            ->onUpdate('cascade')
            ->onDelete('cascade');
            
            $table->foreign('group_id', 'fk_group_user_group_id')
            ->references('id')
            ->on($tableNames['table_name_groups'])
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
        
        /**
         * UserPermission Model Table
         */
        Schema::create($tableNames['table_name_user_permission'], function (Blueprint $table) use( $tableNames ) {
            $table->increments('id');
            $table->integer('user_id', false, true);
            $table->text('permissions');
            $table->timestamps();
            $table->foreign('user_id', 'acl_user_permission_user_id')
            ->references('id')
            ->on($tableNames['table_name_users'])
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('account.table_names');
        if (empty($tableNames)) {
            throw new \Exception('Error: Module config.php file not found or table_names not set. Please check the file and set table_names manually.');
        }
        
        Schema::dropIfExists($tableNames['table_name_user_permission']);
        Schema::dropIfExists($tableNames['table_name_group_user']);
        Schema::dropIfExists($tableNames['table_name_groups']);
    }
}
