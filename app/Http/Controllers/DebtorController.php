<?php

namespace App\Http\Controllers;

use App\Dto\Debtor\CreateDebtorDto;
use App\Http\Requests\CreateDebtorRequest;
use App\Http\Requests\UpdateDebtorRequest;
use App\Models\Debtor;
use App\Services\DebtorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DebtorController extends Controller
{
    public function __construct(
        public DebtorService $service
    ) {}


    public function index()
    {
        return response()->success($this->service->list());
    }

    public function store(CreateDebtorRequest $request): JsonResponse
    {

        $result = $this->service->create(new CreateDebtorDto(
            name: $request->name,
            phone: $request->phone,
            status: $request->status,
        ));

        return response()->success($result);
    }

    public function update(UpdateDebtorRequest $request)
    {
        $result = $this->service->update(new CreateDebtorDto(
            name: $request->name,
            phone: $request->phone,
            status: $request->status,
        ), $request->id);

        return response()->success($result);
    }

    public function destroy(int $id)
    {

        $result = $this->service->delete($id);

        return response()->success($result);
    }

}
