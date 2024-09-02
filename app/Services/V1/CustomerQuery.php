<?php

namespace App\Services\V1;

use Illuminate\Http\Request;

class CustomerQuery
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

    // transform the query to eloquent query that
    public function transform(Request $request) {
        // the arr that is going to be passed to elquent query 
        $eloQuery = [];
        foreach($this->allowedParms as $parm => $operators){
            // parameter
            //if user query has any of our allowedParms save it query and skip to return if none
            $userQuery = $request->query($parm);
            if(!isset($userQuery)){
                continue;
            }
            // columnMap (parm  <--> column)
            // check if user is filtering on a column camelCase format to mapt it to its real column name
            $column = $this->columnMap[$parm] ?? $parm;

            // looping through allowed operators for that specific parm + operator mapping
            foreach($operators as $operator){

                // checking if the user provided operator is allowed for this field
                if(isset($userQuery[$operator])){

                    // here we add a complete filter component --> [ [], [], [], ... ] --> to accept more than one filter component
                    // we also have to map that operator to what a sql query would understand =,>,<,>=,... 
                    $eloQuery[] = [$column, $this->operatorMap[$operator], $userQuery[$operator]];
                }
            }
        }

dd($request->query(), $eloQuery);


        return $eloQuery;
    }
}
