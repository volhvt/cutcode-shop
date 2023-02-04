<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('brands', static function (Blueprint $table) {
            $table->id();
            $table->string('slug')
                ->unique();
            $table->string('title');
            $table->string('thumbnail')
                ->nullable()
                ->default(null);
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        if (!app()->isProduction()) {
            Schema::dropIfExists('brands');
        }
    }
};
