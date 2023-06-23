<?php

namespace App\Http\Resources\Features;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class EntityResource extends JsonResource
{
    protected $data;

    function __construct(Collection $data)
    {
        $this->data = $data;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "message"=>"success","data" =>$this->data,"success"=>true,
        ];
    }
}
