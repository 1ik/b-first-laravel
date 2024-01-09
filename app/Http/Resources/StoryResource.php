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
            'authors'    => AuthorResource::collection($this->authors),
            'categories' => CategoryResource::collection($this->categories),
            'tags'       => TagResource::collection($this->tags)
        ];
    }
}
