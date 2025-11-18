<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'image' => $this->image,
            'created_by' => $this->createdBy ? $this->createdBy->name : null,
            'files' => FileResource::collection($this->whenLoaded('files')),
            'comments' => CommentResource::collection($this->whenLoaded('commentable')),
            'views' => ViewResource::collection($this->whenLoaded('views')),
            'created_at' => $this->created_at,
        ];
    }
}
