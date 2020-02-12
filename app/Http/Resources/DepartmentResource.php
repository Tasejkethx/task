<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class DepartmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'amount' => $this->employees_count,
            'max_salary' => $this->max_salary,
        ];
    }
}
