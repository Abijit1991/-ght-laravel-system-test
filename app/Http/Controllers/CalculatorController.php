<?php

namespace App\Http\Controllers;

use App\Calculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CalculatorController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth:api');
    }

    /*
        method to add the input values
    */
    public function add(Request $request) {
        $validation_report = $this->validateRequest($request);

        if($validation_report['validation_status'] == 'failed') {
            return response()->json([
                $this->displayValidateFailResponse($validation_report['error_report'])
            ], 404);
        }
        else {
            $calculator = new Calculator($request->a, $request->b);
            $output = $calculator->add();

            return response()->json([
                $this->displayValidateSuccessResponse($output)
            ], 200);
        }
    }

    /*
        method to subtract the input values
    */
    public function sub(Request $request) {
        $validation_report = $this->validateRequest($request);

        if($validation_report['validation_status'] == 'failed') {
            return response()->json([
                $this->displayValidateFailResponse($validation_report['error_report'])
            ], 404);
        }
        else {
            $validation_report = $this->customSubtractValidate($request);

            if($validation_report['validation_status'] == 'failed') {
                return response()->json([
                    $this->displayValidateFailResponse($validation_report['error_report'])
                ], 404);
            }
            else {
                $calculator = new Calculator($request->a, $request->b);
                $output = $calculator->sub();

                return response()->json([
                    $this->displayValidateSuccessResponse($output)
                ], 200);
            }
        }
    }

    /*
        method to divide the input values
    */
    public function div(Request $request) {
        $validation_report = $this->validateRequest($request);

        if($validation_report['validation_status'] == 'failed') {
            return response()->json([
                $this->displayValidateFailResponse($validation_report['error_report'])
            ], 404);
        }
        else {
            $validation_report = $this->customDivisiontValidate($request);

            if($validation_report['validation_status'] == 'failed') {
                return response()->json([
                    $this->displayValidateFailResponse($validation_report['error_report'])
                ], 404);
            }
            else {
                $calculator = new Calculator($request->a, $request->b);
                $output = $calculator->div();

                return response()->json([
                    $this->displayValidateSuccessResponse($output)
                ], 200);
                }
        }
    }

    /*
        method to multiple the input values
    */
    public function mul(Request $request) {
        $validation_report = $this->validateRequest($request);

        if($validation_report['validation_status'] == 'failed') {
            return response()->json([
                $this->displayValidateFailResponse($validation_report['error_report'])
            ], 404);
        }
        else {
            $calculator = new Calculator($request->a, $request->b);
            $output = $calculator->mul();

            return response()->json([
                $this->displayValidateSuccessResponse($output)
            ], 200);
        }
    }

    /*
        method to validate Request values
    */
    public function validateRequest(Request $request) {
        $validation_report = [];

        $validator = Validator ::make($request->all(), [
            'a' => 'required | integer',
            'b' => 'required | integer',
        ]);

        if($validator->fails()) {
            $validation_report = [
                "validation_status" => "failed",
                "error_report" => $validator->errors()
            ];
        }
        else {
            $validation_report = [
                "validation_status" => "passed",
                "error_report" => null
            ];
        }

        return $validation_report;
    }

    /*
        method to display Fail Response
    */
    public function displayValidateFailResponse($error_report) {
        $fail_response = [
            'output_status' => 'error',
            'error_report' => $error_report,
            'output' => 'Error Occured!!!. Your Request could not be proceseed right now'
        ];

        return $fail_response;
    }

    /*
        method to display Success Response
    */
    public function displayValidateSuccessResponse($output) {
        $success_response = [
            'output_status' => 'success',
            'error_report' => null,
            'output' => $output
        ];

        return $success_response;
    }

    /*
        method to check whether the input value 'a' is greater than the input value 'b'

        if input'a' > input 'b', then ok
        else display error message
    */
    public function customSubtractValidate(Request $request) {
        $validation_report = [];

        if($request->a < $request->b) {
            $validation_report = [
                "validation_status" => "failed",
                "error_report" => [
                    "a" => "Input 'a' cannot be lesser than Input 'b'"
                ],
            ];
        }
        else {
            $validation_report = [
                "validation_status" => "passed",
                "error_report" => null
            ];
        }

        return $validation_report;
    }

    /*
        method to check whether the input value 'b' (denominator) is equal to 'zero'

        if input'a' > input 'b', then ok
        else display error message
    */
    public function customDivisiontValidate(Request $request) {
        $validation_report = [];

        if($request->b == 0) {
            $validation_report = [
                "validation_status" => "failed",
                "error_report" => [
                    "b" => "Mathematical Error: The denominator - Input 'b' cannot be zero"
                ],
            ];
        }
        else {
            $validation_report = [
                "validation_status" => "passed",
                "error_report" => null
            ];
        }

        return $validation_report;
    }
}
