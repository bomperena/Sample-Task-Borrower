<?php

namespace App\Services;

use App\Models\Borrower;
use Illuminate\Support\Facades\DB;

class BorrowerService
{
    /**
     * Create a borrower record.
     */
    public function create(array $data): Borrower
    {
        return DB::transaction(function () use ($data) {
            if (empty($data['status'])) {
                $data['status'] = 'inactive';
            }

            return Borrower::create($data);
        });
    }

    /**
     * Get all borrowers.
     */
    public function getAll()
    {
        return Borrower::orderBy('created_at', 'desc')->get();
    }

    /**
     * Retrieve a borrower by ID or throw ModelNotFoundException.
     */
    public function getById(int $id): Borrower
    {
        // ✅ findOrFail ensures ModelNotFoundException is thrown
        return Borrower::findOrFail($id);
    }
}
