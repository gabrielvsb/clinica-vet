<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleColumnUsersTable extends Migration
{
    public function up(): void
    {
        Schema::table('users', function($table) {
            $table->string('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function($table) {
            $table->dropColumn('role');
        });
    }
}
