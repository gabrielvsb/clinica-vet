<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRacaColumnPetsTable extends Migration
{
    public function up(): void
    {
        Schema::table('pets', function($table) {
            $table->string('raca');
        });
    }

    public function down(): void
    {
        Schema::table('pets', function($table) {
            $table->dropColumn('raca');
        });
    }
}
