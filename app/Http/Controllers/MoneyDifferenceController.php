<?php

namespace App\Http\Controllers;

use App\Http\Requests\DebtorDetailRequest;
use App\Services\DebtorDetailService;
use Illuminate\Http\JsonResponse;

class MoneyDifferenceController extends Controller
{
    public function __construct(
        public DebtorDetailService $service
    ) {}


    public function index(int $debtor_id): JsonResponse
    {
        return response()->success($this->service->list($debtor_id));
    }

    public function store(DebtorDetailRequest $request): JsonResponse
    {
        $result = $this->service->create($request->validated());

        return response()->success($result);
    }

    public function update(DebtorDetailRequest $request, int $id)
    {
        $result = $this->service->update($request->validated(), $id);

        return response()->success($result);
    }

    public function destroy(int $id)
    {
        $result = $this->service->delete($id);

        return response()->success($result);
    }

}
