<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DebtorDetailResource extends JsonResource
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
            "debtor_id" => $this->debtor_id,
            "debtor" => $this->debtor->name,
            "money" => $this->phone,
            "status" => $this->status,
            "expression_history" => $this->expression_history,
            "currency" => $this->currency->currency,
            "date" => $this->date,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
