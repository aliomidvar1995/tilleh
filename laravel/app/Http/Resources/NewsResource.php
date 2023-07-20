<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class NewsResource extends JsonResource
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
            'image' => url('storage/'.$this->image),
            // 'image' => Storage::disk('s3')->url($this->image),
            'title' => $this->title,
            'content' => $this->content,
            'likes' => $this->likes,
            'dislikes' => $this->dislikes
        ];
    }
}
