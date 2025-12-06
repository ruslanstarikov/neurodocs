<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('domain_knowledge_source', function (Blueprint $table) {
            $table->id();
            $table->foreignId('domain_id')->constrained('domains')->onDelete('cascade');
            $table->foreignId('knowledge_source_id')->constrained('knowledge_sources')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['domain_id', 'knowledge_source_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domain_knowledge_source');
    }
};
