<?php

namespace App\Http\Resources;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

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
            "money" => $this->money,
            "status" => $this->status,
            "expression_history" => $this->expression_history,
            "currency_convert" => $this->currency_convert,
            "currency_id" => $this->currency_id,
            "date" => $this->date,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
