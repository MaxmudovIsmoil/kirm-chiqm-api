<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyRequest;
use App\Services\CurrencyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function __construct(
        public CurrencyService $service
    ) {}


    public function index(): JsonResponse
    {
        return response()->success($this->service->list());
    }

    public function store(CurrencyRequest $request): JsonResponse
    {
        $result = $this->service->create($request->validated());

        return response()->success($result);
    }

    public function update(CurrencyRequest $request, int $id)
    {
//        return response()->json($request->validated());
        $result = $this->service->update($request->validated(), $id);

        return response()->success($result);
    }

    public function destroy(int $id)
    {
        $result = $this->service->delete($id);

        return response()->success($result);
    }
}
