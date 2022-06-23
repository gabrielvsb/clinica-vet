<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAtivoColumnHorariosDisponiveisTable extends Migration
{
    public function up(): void
    {
        Schema::table('horarios_disponiveis', function($table) {
            $table->boolean('ativo')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('horarios_disponiveis', function($table) {
            $table->dropColumn('ativo');
        });
    }
}
