<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('position_id')->constrained();
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->timestamps();

            $table->string('name');
            $table->string('date_of_employment');
            $table->string('phone_number')->unique();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->decimal('salary', 10, 2);
            $table->string('photo')->nullable();
            $table->integer('level')->default(1);

            $table->unsignedBigInteger('admin_created_id')->nullable();
            $table->unsignedBigInteger('admin_updated_id')->nullable();

            $table->foreign('supervisor_id')->references('id')->on('employees')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
