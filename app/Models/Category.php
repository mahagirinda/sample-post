<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $category)
 * @method static orderBy(string $field, string $direction)
 * @method static where(string $string, String $id)
 * @method static paginate(int $int)
 * @method static withCount(string $string)
 * @method static find(mixed $categoryId)
 * @property mixed|string|null $name
 * @property mixed|string|null $detail
 * @property mixed|bool $status
 * @property mixed $id
 */
class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'detail',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'status' => 'boolean',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
