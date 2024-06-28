<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property mixed $id
 * @property mixed $user_id
 * @property mixed $draft
 * @property mixed $title
 * @property mixed $image
 * @property mixed $category_id
 * @property mixed $contents
 * @property mixed $visit_counts
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $comments
 */
class PostListResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => User::find($this->user_id)->name,
            'image' => config('app.url') . "/storage/image/post/" . $this->image,
            'category' => Category::find($this->category_id)->name,
            'content_preview' => Str::limit($this->contents),
            'visit_counts' => $this->visit_counts,
            'comment_counts' => $this->comments->count(),
            'created_at' => Carbon::parse($this->created_at)->format('d F Y - H:i'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d F Y - H:i'),
        ];
    }
}
