<?php

namespace App\Http\Resources\Util;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
{
    
    protected $message;
    protected $data;
    protected $additionalData;


    public function __construct($data = [],$additionalData = [], $message = 'success fetching data')
    {
        $this->additionalData = $additionalData;
        $this->message = $message;
        $this->data = $data;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge([
            'status' => 200,
            'data' =>  $this->data,
            'message' => $this->message
        ],$this->additionalData);
    }
}
