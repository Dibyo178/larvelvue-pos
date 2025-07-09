<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController
{
        public function InvoiceCreate(Request $request){
        // dd($request->all());
        DB::beginTransaction();
        try {
            $user_id = $request->header('id');

            $data = [
                'user_id' => $user_id,
                'customer_id' => $request->customer_id,
                'total' => $request->total,
                'vat' => $request->vat,
                'payable' => $request->payable,
                'discount' => $request->discount
            ];

            $invoice = Invoice::create($data);

            $products = $request->input('products');

            foreach($products as $product){
                $existUnit = Product::where('id', $product['id'])->first();

                if(!$existUnit){
                    return response()->json([
                        'status' => 'failed',
                        'message' => "Product with ID {$product['id']} not found"
                    ]);
                }

                if($existUnit->unit < $product['unit']){
                    return response()->json([
                        'status' => 'failed',
                        'message' => "Only {$existUnit->unit} units available in stock for product id {$product['unit']}"
                    ]);
                }
                InvoiceProduct::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $product['id'],
                    'user_id' => $user_id,
                    'qty' => $product['unit'],
                    'sale_price' => $product['price']
                ]);
                Product::where('id', $product['id'])->update([
                    'unit' => $existUnit->unit - $product['unit']
                ]);
            }//end foreach

            DB::commit();
            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Invoice created successfully'
            // ]);

            $data = ['message'=>'Invoice created successfully','status'=>true,'error'=>''];
            return redirect('/InvoiceListPage')->with($data);
        }catch(Exception $e){
            DB::rollBack();
            // return response()->json([
            //     'status' => 'failed',
            //     'message' => "Something went wrong"
            // ]);

            $data = ['message'=>'Something went wrong','status'=>false,'error'=>$e->getMessage()];
            return redirect()->back()->with($data);
        }
    }//end method
}
