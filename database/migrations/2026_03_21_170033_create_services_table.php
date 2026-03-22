<?php

use App\Models\Branch;
use App\Models\ServiceCategory;
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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Branch::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(ServiceCategory::class)->constrained()->restrictOnDelete();
            $table->string('name');
            $table->string('code')->nullable();
            $table->text('description')->nullable();
            $table->integer('duration_minutes')->default(30);
            $table->decimal('price', 10, 2);
            $table->decimal('cost', 10, 2)->nullable();

            $table->enum('commission_type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('commission_value', 10, 2)->default(10.00);

            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->unique(['branch_id', 'name']);
            $table->unique(['branch_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
