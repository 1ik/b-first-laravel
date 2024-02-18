<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'meta'       => json_decode($this->meta),
            'content'    => $this->content,
            'authors'    => AuthorResource::collection($this->whenLoaded('authors')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'tags'       => TagResource::collection($this->whenLoaded('tags')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
