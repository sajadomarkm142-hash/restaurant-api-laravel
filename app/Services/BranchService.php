<?php

namespace App\Services;

use App\Models\Branch;
use App\Repositories\BranchRepository;

class BranchService
{
    public function __construct(protected BranchRepository $repository) {}

    public function list()
    {
        return $this->repository->all();
    }

    public function create(array $data): Branch
    {
        return $this->repository->create($data);
    }

    public function update(Branch $branch, array $data): Branch
    {
        return $this->repository->update($branch, $data);
    }
}
