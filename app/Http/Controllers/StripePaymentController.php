<?php
    
namespace App\Http\Controllers;
     
use Illuminate\Http\Request;
use Session;
use Stripe;
     
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }
    
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $customer = Stripe\Customer::create(array(

            "address" => [

                    "line1" => "Virani Chowk",

                    "postal_code" => "360001",

                    "city" => "Rajkot",

                    "state" => "GJ",

                    "country" => "IN",

                ],

            "email" => "hossain@gmail.com",

            "name" => "Hossain Jamal",

            "source" => $request->stripeToken

         ));
  
        Stripe\PaymentIntent::create([
            'amount' => 1000 * 10,
            'currency' => 'inr',
            'payment_method_types' => ['card'],
            'metadata' => [
              'order_id' => '12345',
            ],
            "customer" => $customer->id,

            "description" => "Test payment from itsolutionstuff.com.",

            "shipping" => [

              "name" => "Jon Due",

              "address" => [

                "line1" => "510 Townsend St",

                "postal_code" => "98140",

                "city" => "Fardabad",

                "state" => "CA",

                "country" => "US",

              ],

            ]
          ]);

  

    Session::flash('success', 'Payment successful!');

           

    return back();
    }
}