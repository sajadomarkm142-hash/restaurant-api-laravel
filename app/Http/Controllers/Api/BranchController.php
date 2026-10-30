<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Resources\BranchResource;
use App\Services\BranchService;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function __construct(protected BranchService $branchService) {}

    public function index()
    {
        return BranchResource::collection($this->branchService->list());
    }

    public function store(StoreBranchRequest $request)
    {
        $branch = $this->branchService->create($request->validated());

        return new BranchResource($branch);
    }

    public function show(string $id)
    {
        return new BranchResource($this->branchService->list()->firstWhere('id', $id));
    }

    public function update(Request $request, string $id)
    {
        $branch = \App\Models\Branch::findOrFail($id);
        $branch = $this->branchService->update($branch, $request->all());

        return new BranchResource($branch);
    }

    public function destroy(string $id)
    {
        \App\Models\Branch::destroy($id);

        return response()->json(['message' => 'Branch deleted successfully']);
    }
}
