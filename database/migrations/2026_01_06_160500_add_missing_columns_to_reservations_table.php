<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            if (!Schema::hasColumn('reservations', 'equipment_id')) {
                $table->foreignId('equipment_id')->nullable()->constrained('equipment')->cascadeOnDelete();
            }
            if (!Schema::hasColumn('reservations', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            }
            if (!Schema::hasColumn('reservations', 'date')) {
                $table->date('date')->nullable();
            }
            if (!Schema::hasColumn('reservations', 'time')) {
                $table->time('time')->nullable();
            }
            if (!Schema::hasColumn('reservations', 'note')) {
                $table->text('note')->nullable();
            }
            if (!Schema::hasColumn('reservations', 'status')) {
                $table->enum('status', ['active','cancelled'])->default('active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            if (Schema::hasColumn('reservations', 'equipment_id')) {
                $table->dropConstrainedForeignId('equipment_id');
            }
            if (Schema::hasColumn('reservations', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
            if (Schema::hasColumn('reservations', 'date')) {
                $table->dropColumn('date');
            }
            if (Schema::hasColumn('reservations', 'time')) {
                $table->dropColumn('time');
            }
            if (Schema::hasColumn('reservations', 'note')) {
                $table->dropColumn('note');
            }
            if (Schema::hasColumn('reservations', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
