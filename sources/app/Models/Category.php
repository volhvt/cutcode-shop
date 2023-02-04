<?php
declare(strict_types=1);

namespace App\Models;

use App\Traits\Models\HasSlug;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Product[] $products
 *
 */
class Category extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['title', 'slug'];

    protected $dates = ['created_at', 'updated_at'];

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
