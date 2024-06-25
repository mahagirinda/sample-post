<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/**
 * @property mixed $user_id
 * @property mixed $comment
 * @property mixed $created_at
 */
class CommentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => User::find($this->user_id)->name,
            'comment' => $this->comment,
            'created_at' => Carbon::parse($this->created_at)->format('d F Y - H:i'),
        ];
    }
}
