<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('part_links', function (Blueprint $table) {
            $table->timestamp('approved_at')->nullable()->index()->after('shop_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('part_links', function (Blueprint $table) {
            $table->dropIndex(['approved_at']);
            $table->dropColumn('approved_at');
        });
    }
};
