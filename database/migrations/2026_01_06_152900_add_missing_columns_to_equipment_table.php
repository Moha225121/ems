<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            if (!Schema::hasColumn('equipment', 'name')) {
                $table->string('name')->after('id');
            }
            if (!Schema::hasColumn('equipment', 'type')) {
                $table->string('type')->nullable()->after('name');
            }
            if (!Schema::hasColumn('equipment', 'status')) {
                $table->enum('status', ['available','reserved','checked_out'])
                      ->default('available')
                      ->after('type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            if (Schema::hasColumn('equipment', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('equipment', 'type')) {
                $table->dropColumn('type');
            }
            if (Schema::hasColumn('equipment', 'name')) {
                $table->dropColumn('name');
            }
        });
    }
};
