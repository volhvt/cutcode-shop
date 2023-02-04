<?php
declare(strict_types=1);

namespace App\Models;

use App\Traits\Models\HasUniqueSlug;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property int $brand_id
 * @property int $price
 * @property string $title
 * @property string $slug
 * @property string|null $thumbnail
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Brand $brand
 * @property Category[] $categories
 *
 */
class Product extends Model
{
    use HasFactory, HasUniqueSlug;
    protected $fillable = ['brand_id', 'price', 'title', 'slug', 'thumbnail'];

    protected $dates = ['created_at', 'updated_at'];

    /**
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
