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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('nik', 20)->nullable()->after('email');
            $table->string('kk_number', 20)->nullable()->after('nik');
            $table->string('npwp_number', 30)->nullable()->after('kk_number');
            $table->string('ktp_file')->nullable()->after('npwp_number');
            $table->string('kk_file')->nullable()->after('ktp_file');
            $table->string('salary_slip_file')->nullable()->after('kk_file');
            $table->string('npwp_file')->nullable()->after('salary_slip_file');
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->enum('payment_type', ['cash', 'credit'])->default('cash')->after('sale_price');
            $table->decimal('dp_amount', 15, 2)->nullable()->after('payment_type');
            $table->integer('tenor_months')->nullable()->after('dp_amount');
            $table->decimal('interest_rate_per_year', 5, 2)->nullable()->after('tenor_months');
            $table->decimal('total_interest', 15, 2)->nullable()->after('interest_rate_per_year');
            $table->decimal('monthly_installment', 15, 2)->nullable()->after('total_interest');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'nik',
                'kk_number',
                'npwp_number',
                'ktp_file',
                'kk_file',
                'salary_slip_file',
                'npwp_file',
            ]);
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn([
                'payment_type',
                'dp_amount',
                'tenor_months',
                'interest_rate_per_year',
                'total_interest',
                'monthly_installment',
            ]);
        });
    }
};
