<?php

namespace App\Http\Controllers;

use App\Cart;
use App\OrderedProducts;
use App\Payment;
use App\Product;
use App\UsersModel;
use Illuminate\Http\Request;
use URL;
use Redirect;
use Input;
use Validator;
use App\Order;
use App\Package;
use App\PricingTable;
use App\Settings;
use Config;
use Session;

use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Stripe\Error\Card;

class StripeController extends Controller
{

    public function __construct()
    {
        //Set Spripe Keys
        $stripe = Settings::findOrFail(1);
  		Config::set('services.stripe.key', $stripe->stripe_key);
  		Config::set('services.stripe.secret', $stripe->stripe_secret);
    }


    public function store(Request $request){

        $payment = new Payment;
        $settings = Settings::findOrFail(1);
        $user = UsersModel::findOrFail($request->userid);

        $paymentold = Payment::where('user_id',$request->userid)
            ->where('payment_status',"Pending")
            ->where('featured',$request->featured);
        $paymentold->delete();

        $success_url = action('PaymentController@payreturn');

        $item_name = 'Premium Profile';
        $item_number = str_random(2).time();
        $item_amount = $settings->normal_price;
        $feature_price = $settings->feature_price;

        if($user->status == '1'){
            $item_amount = 0.00;
        }

        if($request->featured == 'yes'){
            $item_amount = $item_amount + $feature_price;
        }

		$validator = Validator::make($request->all(),[
						'card' => 'required',
						'cvv' => 'required',
						'month' => 'required',
						'year' => 'required',
					]);

		if ($validator->passes()) {

	     	$stripe = Stripe::make(Config::get('services.stripe.secret'));
	     	try{
	     		$token = $stripe->tokens()->create([
	     			'card' =>[
	     					'number' => $request->card,
	     					'exp_month' => $request->month,
	     					'exp_year' => $request->year,
	     					'cvc' => $request->cvv,
	     				],
	     			]);
	     		if (!isset($token['id'])) {
	     			return back()->with('error','Token Problem With Your Token.');
	     		}

	     		$charge = $stripe->charges()->create([
	     			'card' => $token['id'],
	     			'currency' => 'USD',
	     			'amount' => $item_amount,
	     			'description' => $item_name,
	     			]);

	     		//dd($charge);

	     		if ($charge['status'] == 'succeeded') {

                    $payment['featured'] = $request->featured;
                    $payment['user_id'] = $request->userid;
                    $payment['paid_amount'] = $item_amount;
                    $payment['txnid'] = $charge['balance_transaction'];
                    $payment['charge_id'] = $charge['id'];
                    $payment['method'] = "Stripe";
                    $payment['payment_status'] = "Completed";
                    $payment['payment_id'] = $item_number;
                    $payment['process_time'] = date('Y-m-d H:i:s');
                    $payment->save();

                    $profileupdate = UsersModel::findOrFail($request->userid);
                    $status['status'] = 1;
                    $status['featured'] = 0;
                    if ($request->featured == "yes"){
                        $status['featured'] = 1;
                    }
                    $profileupdate->update($status);


	     			return redirect($success_url);
	     		}
	     		
	     	}catch (Exception $e){
	     		return back()->with('error', $e->getMessage());
	     	}catch (\Cartalyst\Stripe\Exception\CardErrorException $e){
	     		return back()->with('error', $e->getMessage());
	     	}catch (\Cartalyst\Stripe\Exception\MissingParameterException $e){
	     		return back()->with('error', $e->getMessage());
	     	}
		}
		return back()->with('error', 'Please Enter Valid Credit Card Informations.');
	}
}
