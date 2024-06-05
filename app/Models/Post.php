<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Used Property
 * @property mixed $id
 * @property mixed $title
 * @property mixed image
 * @property mixed category
 * @property mixed content
 *
 * Used Method
 * @method static where(string $string, $id)
 */
class Post extends Model
{
    use HasFactory;

    protected $table = 'post';

    protected $fillable = ['title', 'image', 'category', 'content'];
}
