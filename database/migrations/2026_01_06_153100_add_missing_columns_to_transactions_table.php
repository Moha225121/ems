<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'equipment_id')) {
                $table->foreignId('equipment_id')->after('id')->constrained('equipment')->cascadeOnDelete();
            }
            if (!Schema::hasColumn('transactions', 'user_id')) {
                $table->foreignId('user_id')->after('equipment_id')->constrained('users')->cascadeOnDelete();
            }
            if (!Schema::hasColumn('transactions', 'action')) {
                $table->enum('action', ['check_out','check_in'])->after('user_id');
            }
            if (!Schema::hasColumn('transactions', 'note')) {
                $table->text('note')->nullable()->after('action');
            }
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'note')) {
                $table->dropColumn('note');
            }
            if (Schema::hasColumn('transactions', 'action')) {
                $table->dropColumn('action');
            }
            if (Schema::hasColumn('transactions', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
            if (Schema::hasColumn('transactions', 'equipment_id')) {
                $table->dropConstrainedForeignId('equipment_id');
            }
        });
    }
};
