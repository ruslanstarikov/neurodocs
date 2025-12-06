<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('knowledge_entities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('knowledge_source_id')->constrained('knowledge_sources')->onDelete('cascade');
            $table->foreignId('entity_type_id')->constrained('knowledge_entity_types')->onDelete('restrict');

            $table->string('name', 255);
            $table->string('external_id', 512)->nullable();

            // Layer 1 - Schema / structural facts
            $table->json('raw_definition')->nullable();

            // Layer 2 - Usage evidence
            $table->json('usage_evidence')->nullable();

            // Layer 3 - Semantic understanding
            $table->string('semantic_label', 255)->nullable();
            $table->text('semantic_summary')->nullable();
            $table->json('semantic_meta')->nullable();

            // Layer timestamps
            $table->timestamp('last_schema_at')->nullable();
            $table->timestamp('last_usage_analysis_at')->nullable();
            $table->timestamp('last_semantic_update_at')->nullable();

            $table->timestamps();

            // Index for faster lookups
            $table->index(['knowledge_source_id', 'entity_type_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('knowledge_entities');
    }
};
