<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint ) {
            ->id();
            ->string('title');
            ->text('content');
            ->string('slug')->unique();
            ->enum('status', ['draft', 'published'])->default('draft');
            ->timestamp('published_at')->nullable();
            ->foreignId('user_id')->constrained();
            ->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
