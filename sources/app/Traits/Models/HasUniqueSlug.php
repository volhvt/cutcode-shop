<?php
declare(strict_types=1);


namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasUniqueSlug
{
    protected string $slugSeparator = '-';

    protected string $slugFieldName = 'slug';

    protected string $slugAbleFieldName = 'title';

    /**
     * @return void
     */
    protected static function bootHasUniqueSlug(): void
    {
        static::creating([self::class, 'prepareSlag']);
        static::updating([self::class, 'prepareSlag']);
    }

    /**
     * @param Model $item
     * @return void
     */
    protected static function prepareSlag(Model $item): void
    {
        $item->{$item->slugField()} = $item->{$item->slugField()} ?? $item->generateSlug();
    }

    /**
     * @return string
     */
    public function generateSlug(): string
    {
        $baseSlug = Str::slug($this->{$this->slugAbleField()}, $this->slugSeparator);
        $query = static::withoutGlobalScopes();
        if ($this->exists) {
            $query->where($this->getKeyName(), '!=', $this->getKey());
        }

        $slugCounter = 0;
        do {
            $slug = $baseSlug . ($slugCounter > 0 ? ($this->slugSeparator . $slugCounter) : '');
            $sameProduct = (clone($query))->where($this->slugField(), $slug)->first();
            $slugCounter++;
        } while ($sameProduct);

        return $slug;
    }

    /**
     * @return string
     */
    protected function slugField(): string
    {
        return $this->slugFieldName;
    }

    /**
     * @return string
     */
    protected function slugAbleField(): string
    {
        return $this->slugAbleFieldName;
    }
}
