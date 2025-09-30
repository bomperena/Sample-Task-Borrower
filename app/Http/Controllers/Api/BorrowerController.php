<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBorrowerRequest;
use App\Services\BorrowerService;
use Illuminate\Http\JsonResponse;

class BorrowerController extends Controller
{
    protected BorrowerService $service;

    public function __construct(BorrowerService $service)
    {
        $this->service = $service;
    }

    /**
     * GET /api/borrowers
     */
    public function index(): JsonResponse
    {
        $borrowers = $this->service->getAll();
        return response()->json(['data' => $borrowers], 200);
    }

    /**
     * POST /api/borrowers
     */
    public function store(StoreBorrowerRequest $request): JsonResponse
    {
        $borrower = $this->service->create($request->validated());
        return response()->json(['data' => $borrower], 201);
    }

    /**
     * GET /api/borrowers/{id}
     * Returns 404 automatically if not found (via Handler)
     */
    public function show(int $id): JsonResponse
    {
        $borrower = $this->service->getById($id);
        return response()->json(['data' => $borrower], 200);
    }
}
