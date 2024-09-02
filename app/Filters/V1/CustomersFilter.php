<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class CustomersFilter extends ApiFilter
{
    // allowed parameters to accept from user and is assigned to it's allowed comparison 
    // whitelisting the allowed params
    protected $allowedParms = [
        // 'id' => ['eq', 'gt', 'lt'],
        'name' => ['eq'],
        'type' => ['eq'],
        'email' => ['eq'],
        'address' => ['eq'],
        'city' => ['eq'],
        'state' => ['eq'],
        'postalCode' => ['eq', 'gt', 'lt'],
    ];

    // transform user input format to its column name
    protected $columnMap = [
        'postalCode' => 'postal_code'
    ];

    // transform operators from strings to its signs
    protected $operatorMap = [
        'eq' => '=',
        'gt' => '>',
        'gte' => '>=',
        'lt' => '<',
        'lte' => '<=',
    ];
}
