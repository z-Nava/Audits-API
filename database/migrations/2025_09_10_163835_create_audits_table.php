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
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->cascadeOnDelete();
            $table->foreignId('technician_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('supervisor_id')->constrained('users')->cascadeOnDelete();

            // capturado en formulario; válida contra tabla employees
            $table->string('employee_number');

            $table->string('audit_code')->unique(); // AUD-YYYY-NNNNN
            $table->foreignId('line_id')->constrained('production_lines')->cascadeOnDelete();
            $table->enum('shift', ['A','B','C'])->index();

            $table->enum('status', ['draft','in_progress','submitted','reviewed','closed'])
                  ->default('draft')->index();

            $table->text('summary')->nullable();
            $table->enum('overall_result', ['PASS','FAIL','NA'])->nullable()->index();

            $table->dateTime('started_at')->nullable()->index();
            $table->dateTime('ended_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};
