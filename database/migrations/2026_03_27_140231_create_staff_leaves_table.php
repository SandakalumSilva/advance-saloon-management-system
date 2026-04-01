<?php

use App\Models\Staff;
use App\Models\User;
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
        Schema::create('staff_leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->date('leave_date');
            $table->string('leave_type')->default('off_day'); 
            $table->string('duration')->default('full_day'); 
            $table->text('reason')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->unique(['user_id', 'leave_date'], 'staff_leave_unique_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_leaves');
    }
};
