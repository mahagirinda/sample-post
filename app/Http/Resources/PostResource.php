<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

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
class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request) : array
    {
        return [
            'title' => $this->title,
            'author' => User::find($this->user_id)->name,
            'image' => config('app.url') . "/storage/image/post/" . $this->image,
            'category' => Category::find($this->category_id)->name,
            'contents' => $this->contents,
            'comments' => CommentsResource::collection($this->comments),
            'created_at' => Carbon::parse($this->created_at)->format('d F Y - H:i'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d F Y - H:i'),
        ];
    }
}
