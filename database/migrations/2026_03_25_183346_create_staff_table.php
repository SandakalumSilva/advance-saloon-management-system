<?php

use App\Models\Branch;
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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->unique()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Branch::class)->constrained()->cascadeOnDelete();
            $table->string('phone')->nullable();
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->date('join_date')->nullable();
            $table->decimal('basic_salary', 12, 2)->nullable();
            $table->string('photo')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
