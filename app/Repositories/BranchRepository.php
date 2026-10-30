<?php

namespace App\Repositories;

use App\Models\Branch;

class BranchRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Branch());
    }

    public function listWithUsers()
    {
        return Branch::with('users')->get();
    }
}
