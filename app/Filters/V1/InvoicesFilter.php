<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class InvoicesFilter extends ApiFilter
{
    protected $allowedParms = [
        'customerId' => ['eq'],
        'amount' => ['eq', 'gt', 'lt', 'gte', 'lte'],
        'status' => ['eq', 'ne'],
        'billedDate' => ['eq', 'gt', 'lt', 'gte', 'lte'],
        'paidDate' => ['eq', 'gt', 'lt', 'gte', 'lte'],
    ];

    // transform user input format to its column name
    protected $columnMap = [
        'customerId' => 'customer_id',
        'billedDate' => 'billed_date',
        'paidDate' => 'paied_date',
    ];

    // transform operators from strings to its signs
    protected $operatorMap = [
        'eq' => '=',
        'gt' => '>',
        'gte' => '>=',
        'lt' => '<',
        'lte' => '<=',
        'ne' => '!=',
    ];

}
