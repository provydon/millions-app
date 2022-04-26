<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "author"=> $this->user->username,
            "image"=> $this->image_url,
            "description"=> $this->description,
            "total_likes"=> $this->likes->count(),
            "last_5_likes"=> Like::collection($this->likes->take(-5)),
            "date"=> Carbon::parse($this->created_at)->toDateTimeString(),
            "created_at"=> Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
