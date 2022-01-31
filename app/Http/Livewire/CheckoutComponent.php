<?php

namespace App\Http\Livewire;

use Cart;
use Exception;
use App\Models\Order;
use App\Mail\OrderMail;
use Livewire\Component;
use App\Models\Delivery;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Cartalyst\Stripe\Stripe;
use KingFlamez\Rave\Facades\Rave as Flutterwave;

class CheckoutComponent extends Component
{
    public $deliver_to_different;

    public $firstname;
    public $lastname;
    public $email;
    public $mobile;
    public $line1;
    public $city;
    public $province;
    public $country;
    public $address;

    public $d_firstname;
    public $d_lastname;
    public $d_email;
    public $d_mobile;
    public $d_line1;
    public $d_city;
    public $d_province;
    public $d_country;
    public $d_address;

    public $paymentmode;
    public $thankyou;

    public $card_no;
    public $exp_month;
    public $exp_year;
    public $cvc;


    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
            'address' => 'required',
            'paymentmode' => 'required'
        ]);

        if($this->deliver_to_different)
        {
            $this->validateOnly($fields,[
                'd_firstname' => 'required',
                'd_lastname' => 'required',
                'd_email' => 'required|email',
                'd_mobile' => 'required|numeric',
                'd_city' => 'required',
                'd_province' => 'required',
                'd_country' => 'required',
                'd_address' => 'required'
            ]);
        }

        if($this->paymentmode == 'card')
        {
            $this->validateOnly($fields,[
                'card_no' => 'required|numeric',
                'exp_month' => 'required|numeric',
                'exp_year' => 'required|numeric',
                'cvc' => 'required|numeric'
            ]);
        }
    }

    public function placeOrder()
    {
        $this->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
            'address' => 'required',
            'paymentmode' => 'required'
        ]);

        if($this->paymentmode == 'card')
        {
            $this->validate([
                'card_no' => 'required|numeric',
                'exp_month' => 'required|numeric',
                'exp_year' => 'required|numeric',
                'cvc' => 'required|numeric'
            ]);
        }

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->subtotal = session()->get('checkout')['subtotal'];
        $order->discount = session()->get('checkout')['discount'];
        $order->tax = session()->get('checkout')['tax'];
        $order->total = session()->get('checkout')['total'];
         $order->firstname = $this->firstname;
         $order->lastname = $this->lastname;
         $order->email = $this->email;
         $order->mobile = $this->mobile;
         $order->line1 = $this->line1;
         $order->city = $this->city;
         $order->province = $this->province;
         $order->country = $this->country;
         $order->address = $this->address;
         $order->status = 'ordered';
         $order->is_delivering_different = $this->deliver_to_different ? 1:0;
         $order->save();

         foreach(Cart::instance('cart')->content() as $item){
             $orderItem = new OrderItem();
             $orderItem->product_id = $item->id;
             $orderItem->order_id = $order->id;
             $orderItem->price = $item->price;
             $orderItem->quantity = $item->qty;
             $orderItem->save();

         }

         if($this->deliver_to_different)
         {
            $this->validate([
                'd_firstname' => 'required',
                'd_lastname' => 'required',
                'd_email' => 'required|email',
                'd_mobile' => 'required|numeric',
                'd_city' => 'required',
                'd_province' => 'required',
                'd_country' => 'required',
                'd_address' => 'required'
            ]);

            $delivery = new Delivery();
            $delivery->order_id = $order->id;
            $delivery->firstname = $this->firstname;
            $delivery->lastname = $this->lastname;
            $delivery->email = $this->email;
            $delivery->mobile = $this->mobile;
            $delivery->line1 = $this->line1;
            $delivery->city = $this->city;
            $delivery->province = $this->province;
            $delivery->country = $this->country;
            $delivery->address = $this->address;
            $delivery->save();
         }

         if($this->paymentmode == 'cod')
         {
             $this->makeTransaction($order->id,'pending');
             $this->resetCart();
         }

         else if($this->paymentmode == 'card')
         {
             $stripe = Stripe::make(env('STRIPE_KEY'));

             try {
                 $token = $stripe->tokens()->create([
                     'card' => [
                         'number' => $this->card_no,
                         'exp_month' => $this->exp_month,
                         'exp_year' => $this->exp_year,
                         'cvc' => $this->cvc
                     ]
                 ]);

                 if(!isset($token['id']))
                 {
                     session()->flash('stripe_error','The stripe token was not generated correctly!');
                     $this->thankyou = 0;
                 }

                 $customer = $stripe->customers()->create([
                     'name' => $this->firstname. '' . $this->lastname,
                     'email' => $this->email,
                     'phone' => $this->mobile,
                     'address' => [
                         'line1' => $this->line1,
                         'postal_code' => $this->address,
                         'city' => $this->city,
                         'state' => $this->province,
                         'country' => $this->country
                     ],
                     'shipping'=> [
                        'name' => $this->firstname. '' . $this->lastname,
                        'address' => [
                            'line1' => $this->line1,
                            'postal_code' => $this->address,
                            'city' => $this->city,
                            'state' => $this->province,
                            'country' => $this->country
                        ],
                    ],
                    'source' => $token['id']
                 ]);

                 $charge = $stripe->charges()->create([
                     'customer' => $customer['id'],
                     'currency' => 'USD',
                     'amount' => session()->get('checkout')['total'],
                     'description' => 'Payment for order no'. $order->id
                 ]);

                 if($charge['status'] == 'succeeded')
                 {
                     $this->makeTransaction($order->id,'approved');
                     $this->resetCart();
                 }
                 else
                 {
                     session()->flash('stripe_error','Error in Transaction!');
                     $this->thankyou = 0;
                 }
             }

             catch(Exception $e){
                 session()->flash('stripe_error',$e->getMessage());
                 $this->thankyou = 0;
             }


         }

         else if($this->paymentmode == 'paypal')
        {


                //This generates a payment reference
                $reference = Flutterwave::generateReference();

                // Enter the details of the payment
                $data = [
                    'payment_options' => 'card,banktransfer',
                    'amount' => session()->get('checkout')['total'],
                    'email' => $this->email,
                    'tx_ref' => $reference,
                    'currency' => "USD",
                    'redirect_url' => route('callback'),
                    'customer' => [
                        'email' => $this->email,
                        "phone_number" => $this->mobile,
                        "name" => $this->firstname. '' . $this->lastname,
                    ],

                    "customizations" => [
                        "title" => 'Movie Ticket',
                        "description" => 'Payment for order no'. $order->id
                    ]
                ];

                $payment = Flutterwave::initializePayment($data);


                if ($payment['status'] !== 'success') {
                    $this->makeTransaction($order->id,'approved');
                    $this->callback();
                    $this->resetCart();
                }

                return redirect($payment['data']['link']);

            /**
             * Obtain Rave callback information
             * @return void
             */

        }

        else if($this->paymentmode == 'momo')
        {


            $tx_ref = Flutterwave::generateReference();
            $order_id = Flutterwave::generateReference('momo');

            $data = [
                'amount' => session()->get('checkout')['total'],
                'email' => $this->email,
                'redirect_url' => route('callback'),
                'phone_number' => $this->mobile,
                'tx_ref' => $tx_ref,
                'order_id' => $order_id
            ];

            $charge = Flutterwave::payments()->momoUG($data);

            if ($charge['status'] === 'success') {
                # code...
                // Redirect to the charge url
                return redirect($charge['data']['redirect']);
            }



        }

         $this->sendOrderConfirmationMail($order);

    }

    public function callback()
    {

        $status = request()->status;

        //if payment is successful
        if ($status ==  'successful') {

        $transactionID = Flutterwave::getTransactionIDFromCallback();
        $data = Flutterwave::verifyTransaction($transactionID);

        dd($data);
        }
        elseif ($status ==  'cancelled'){
            //Put desired action/code after transaction has been cancelled here
        }
        else{
            //Put desired action/code after transaction has failed here
        }
        // Get the transaction from your DB using the transaction reference (txref)
        // Check if you have previously given value for the transaction. If you have, redirect to your successpage else, continue
        // Confirm that the currency on your db transaction is equal to the returned currency
        // Confirm that the db transaction amount is equal to the returned amount
        // Update the db transaction record (including parameters that didn't exist before the transaction is completed. for audit purpose)
        // Give value for the transaction
        // Update the transaction to note that you have given value for the transaction
        // You can also redirect to your success page from here

    }


    Public function resetCart()
    {
        $this->thankyou = 1;
         Cart::instance('cart')->destroy();
         session()->forget('checkout');

    }

    public function makeTransaction($order_id,$status)
    {
        $transaction = new Transaction();
        $transaction->user_id =  Auth::user()->id;
        $transaction->order_id = $order_id;
        $transaction->mode = $this->paymentmode;
        $transaction->status = $status;
        $transaction->save();
    }

    public function sendOrderConfirmationMail($order)
    {
        Mail::to($order->email)->send(new OrderMail($order));
    }

    public function verifyForCheckout()
    {
        if(!Auth::check()){
            return redirect()->route('login');
        }
        else if($this->thankyou){
            return redirect()->route('thankyou');
        }
        else if(!session()->get('checkout')){
            return redirect()->route('product.cart');
        }
    }

    public function render()
    {
        $this->verifyForCheckout();
        return view('livewire.checkout-component')->layout("layouts.base");
    }
}
