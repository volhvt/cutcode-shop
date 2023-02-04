<?php
declare(strict_types=1);

namespace App\Models;

use App\Traits\Models\HasUniqueSlug;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $thumbnail
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Product[] $products
 */
class Brand extends Model
{
    use HasFactory, HasUniqueSlug;

    protected $fillable = ['title', 'slug', 'thumbnail'];

    protected $dates = ['created_at', 'updated_at'];

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
