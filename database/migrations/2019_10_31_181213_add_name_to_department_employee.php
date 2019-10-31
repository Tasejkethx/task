<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameToDepartmentEmployee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('department_employee', function (Blueprint $table) {
            $table->string('department_name');
            $table->foreign('department_name')->references('name')->on('departments')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('department_employee', function (Blueprint $table) {
            $table->dropForeign('department_employee_department_name_foreign');
            $table->dropColumn('department_name');
        });
    }
}
