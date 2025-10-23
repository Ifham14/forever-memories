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
        Schema::create('notebooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->date('date');
            $table->longText('story')->nullable();
            $table->text('processional')->nullable();
            $table->text('life_reflection')->nullable();
            $table->text('song_selection')->nullable();
            $table->text('life_scriptures')->nullable();
            $table->text('prayer')->nullable();
            $table->text('resolution')->nullable();
            $table->text('acknowledgment')->nullable();
            $table->text('expression')->nullable();
            $table->text('invitation_of_discipleship')->nullable();
            $table->text('recessional')->nullable();
            $table->text('honorary_pallbearers')->nullable();
            $table->text('grateful_hearts')->nullable();
            $table->text('interment')->nullable();
            $table->text('final_arrangement_entrusted_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notebooks');
    }
};
