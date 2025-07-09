<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController
{
       public function CreateCustomer(Request $request){
        $user_id = $request->header('id');

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers,email',
            'mobile' => 'required',
        ]);

        Customer::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
            'user_id' => $user_id
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Customer created successfully'
        ]);

    }//end method

       public function CustomerList(Request $request){
        $user_id = $request->header('id');
        $customers = Customer::where('user_id', $user_id)->get();
        return $customers;
    }//end method

        public function CustomerById(Request $request){
        $user_id = $request->header('id');
        $customer =Customer::where('id', $request->id)->where('user_id', $user_id)->first();
        return $customer;
    }//end method

        public function CustomerUpdate(Request $request){
        $user_id = $request->header('id');
        $id = $request->input('id');
        Customer::where('id', $id)->where('user_id', $user_id)->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Customer Updaetd successfully'
        ]);

    }//end method


         public function CustomerDelete(Request $request,$id){
        $user_id = $request->header('id');
        Customer::where('user_id', $user_id)->where('id', $id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Customer Deleted successfully'
        ]);

    }//end method
}
