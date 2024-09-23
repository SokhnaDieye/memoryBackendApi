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
        Schema::table('payments', function (Blueprint $table) {
            $table->decimal('total_amount_due', 15, 2)->after('amount_received')->nullable(); // Montant total dû
            $table->string('payment_status')->default('En attente')->after('payment_date')->nullable(); // Statut du paiement
            $table->date('due_date')->after('payment_status')->nullable()->nullable(); // Date d'échéance
            $table->boolean('reminder_sent')->default(false)->after('due_date')->nullable(); // Indicateur de relance
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('total_amount_due');
            $table->dropColumn('payment_status');
            $table->dropColumn('due_date');
            $table->dropColumn('reminder_sent');
        });
    }
};
