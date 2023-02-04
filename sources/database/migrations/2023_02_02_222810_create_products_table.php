<?php
declare(strict_types=1);

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {

        Schema::create('products', static function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('price')
                ->comment('цена в копейках');
            $table->foreignIdFor(Brand::class)
                ->nullable()->default(null)
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('slug')
                ->unique();
            $table->string('title');
            $table->string('thumbnail')
                ->nullable()->default(null);
            $table->timestampsTz();
        });

        Schema::create('category_product', static function (Blueprint $table) {
            //$table->id();
            $table->foreignIdFor(Product::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignIdFor(Category::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->unique(['product_id', 'category_id'], null, 'btree');
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
            Schema::dropIfExists('category_product');
            Schema::dropIfExists('products');
        }
    }
};
