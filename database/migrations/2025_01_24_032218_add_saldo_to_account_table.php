<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->decimal('saldo', 15, 2)->default(0)->after('password');  // Ganti 'column_name' dengan kolom setelahnya
        });
    }
    
    
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('account', function (Blueprint $table) {
            $table->dropColumn('saldo');
        });
    }
    
};
