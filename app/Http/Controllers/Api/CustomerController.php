<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(protected CustomerService $customerService) {}

    public function index()
    {
        return CustomerResource::collection($this->customerService->list());
    }

    public function store(StoreCustomerRequest $request)
    {
        $customer = $this->customerService->create($request->validated());

        return new CustomerResource($customer->load('addresses'));
    }

    public function show(string $id)
    {
        return new CustomerResource(\App\Models\Customer::with('addresses')->findOrFail($id));
    }

    public function update(Request $request, string $id)
    {
        $customer = \App\Models\Customer::findOrFail($id);
        $customer = $this->customerService->update($customer, $request->all());

        return new CustomerResource($customer->load('addresses'));
    }

    public function destroy(string $id)
    {
        \App\Models\Customer::destroy($id);

        return response()->json(['message' => 'Customer deleted successfully']);
    }
}
