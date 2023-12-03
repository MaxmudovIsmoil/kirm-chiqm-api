<?php

namespace App\Http\Controllers;

use App\Http\Requests\DebtorDetailRequest;
use App\Services\DebtorDetailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use function Psy\debug;

class DebtorDetailController extends Controller
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
//        Log::info($request->validated());
        try {
            $result = $this->service->create($request->validated());
            return response()->success($result);
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function update(DebtorDetailRequest $request, int $id)
    {
        try {
            $result = $this->service->update($request->validated(), $id);
            return response()->success($result);
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try {
            $result = $this->service->delete($id);
            return response()->success($result);
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

}
