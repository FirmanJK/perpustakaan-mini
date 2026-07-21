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
        Schema::create('trs_loans', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi', 20)->unique();
            $table->date('tgl_pinjam');
            $table->date('tgl_kembali');
            $table->date('tgl_dikembalikan')->nullable();
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('book_id');
            $table->enum('status', ['Dipinjam', 'Dikembalikan'])->default('Dipinjam');
            $table->text('catatan')->nullable();
            $table->enum('isactive', ['0', '1'])->default('1');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->string('user_create')->nullable();
            $table->string('user_update')->nullable();

            // Foreign keys
            $table->foreign('member_id')->references('id')->on('mst_members')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('mst_books')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trs_loans');
    }
};
