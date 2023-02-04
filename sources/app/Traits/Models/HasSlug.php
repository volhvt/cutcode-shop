<?php
declare(strict_types=1);


namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    protected string $slugSeparator = '-';

    protected string $slugFieldName = 'slug';

    protected string $slugAbleFieldName = 'title';

    /**
     * @return void
     */
    protected static function bootHasSlug(): void
    {
        static::creating(static function (Model $item) {
            $item->{$item->slugField()} = $item->{$item->slugField()} ?? $item->generateSlug();
        });
    }

    /**
     * @return string
     */
    public function generateSlug(): string
    {
        $slug = Str::slug($this->{$this->slugAbleField()}, $this->slugSeparator);
        $sameSlugCount = static::query()
            ->where($this->slugField(), 'RLIKE', $slug . '-?[0-9]?$')->count();
        return  $slug
            . (
                $sameSlugCount > 0
                    ? ($this->slugSeparator . $sameSlugCount)
                    : ''
            );
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
