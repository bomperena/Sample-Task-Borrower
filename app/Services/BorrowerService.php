<?php

namespace App\Services;


use App\Models\Borrower;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;


class BorrowerService
{
    /**
     * Create a borrower record.
     * Returns the created Borrower model.
     */
    public function create(array $data): Borrower
    {
        // Wrap in transaction in case more related operations are added later.
        return DB::transaction(function () use ($data) {
            // ensure default status is set if not provided
            if (empty($data['status'])) {
                $data['status'] = 'inactive';
            }


            return Borrower::create($data);
        });
    }


    /**
     * Get all borrowers (simple list). You can add pagination here if needed.
     */
    public function getAll()
    {
        return Borrower::orderBy('created_at', 'desc')->get();
    }


    /**     
     * Retrieve a borrower by ID or throw ModelNotFoundException.
     * if the record does not exist it returns null. PHP 8+ doesn’t allow null unless you explicitly declare it.
     */
    public function getById(int $id): ?Borrower
    {
        return Borrower::find($id);
    }
}
