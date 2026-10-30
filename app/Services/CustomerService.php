<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\CustomerRepository;

class CustomerService
{
    public function __construct(protected CustomerRepository $repository) {}

    public function list()
    {
        return $this->repository->listWithAddresses();
    }

    public function create(array $data): Customer
    {
        return $this->repository->create($data);
    }

    public function update(Customer $customer, array $data): Customer
    {
        return $this->repository->update($customer, $data);
    }
}
