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
        Schema::table('roadmaps_materials', function (Blueprint $table) {
            $table->dropForeign(['roadmap_id']);
            $table->dropForeign(['material_id']);
        });
        Schema::drop('roadmaps_materials');
        Schema::table('course_materials', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropForeign(['material_id']);
        });
        Schema::drop('course_materials');
        Schema::drop('materials');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
