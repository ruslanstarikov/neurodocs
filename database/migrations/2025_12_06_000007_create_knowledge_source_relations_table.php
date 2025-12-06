<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('knowledge_source_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_knowledge_source_id')->constrained('knowledge_sources')->onDelete('cascade');
            $table->foreignId('to_knowledge_source_id')->constrained('knowledge_sources')->onDelete('cascade');
            $table->foreignId('relation_type_id')->constrained('knowledge_source_relation_types')->onDelete('restrict');
            $table->timestamps();

            // Prevent duplicate edges of the same type between the same pair
            $table->unique(['from_knowledge_source_id', 'to_knowledge_source_id', 'relation_type_id'], 'ks_relations_unique');

            // Additional indexes for query performance
            $table->index('from_knowledge_source_id');
            $table->index('to_knowledge_source_id');
            $table->index('relation_type_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('knowledge_source_relations');
    }
};
