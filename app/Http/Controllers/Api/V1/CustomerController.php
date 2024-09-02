<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Filters\V1\CustomersFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Resources\V1\CustomerResource;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\V1\CustomerCollection;
use Illuminate\Support\Facades\Redis;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->query());
        $filter      = new CustomersFilter();
        $filterItems = $filter->transform($request);  // [['column', 'operator', 'value']]   --> [ [],[],[] ]  --> accept multiple filters

        // check if includeInvoices is in user query
        $includeInvoices = $request->query('includeInvoices');

        // if Customer::where( [] ) has an empty array --> then it will just act as its not here
        $customers = Customer::where($filterItems);

        // if with invoices then get append invoices
        if ($includeInvoices) {
            $customers = $customers->with('invoices');
        }

        return new CustomerCollection($customers->paginate()->appends($request->query()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $customer = new CustomerResource($customer);

        // check if includeInvoices is in user query
        $includeInvoices = request()->query('includeInvoices');

        if($includeInvoices){
            $customer = $customer->loadMissing('invoices');
        }

        return $customer;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
