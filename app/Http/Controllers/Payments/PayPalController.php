<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Throwable;
use PayPalHttp\HttpException;


class PayPalController extends Controller
{
    //
    public function create(Order $order)
    {

        //اذا الاوردر مدفوع قبل هيك طبعا مابنفع يدفع تاني فحعملو انو ايرور
        if ($order->payment_status !== 'paid') {
            //return $order->payments;
            abort(404);
        }

        /**
         *  @var \PayPalCheckoutSdk\Core\PayPalHttpClient;
         */
        $client = app('paypal.client');

        //احنا بنرسل المعلومات بالاول للباي بالي واللي هيا  تجهيز الريكوسيت 
        // ثم الباي بال بعطينا رابط الابروف بنبعتو للكلينت عشان يدفع عن طريقه
        //ثم احنا بنعمل من عنا كابتشر عن طريق رابط من الباي بال ايضا


        //1-تجهيز الريكويست
        // Construct a request object and set desired parameters
        // Here, OrdersCreateRequest() creates a POST request to /v2/checkout/orders
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE", //كابتشر معناها تأكيد الدفع من قبل الموقع
            "purchase_units" => [[
                "reference_id" => $order->number, //order number
                "amount" => [
                    "value" => $order->total,
                    "currency_code" => "LIS"
                ]
            ]],
            "application_context" => [ //بعد مايرجع الباي بال وين يرجع انا بعمل الراوت
                "cancel_url" => url(route('paypal.cancel', $order->id)), // url عشان اتاكد انو باعت الرابط كامل مع اسم الدومين 
                "return_url" => url(route('paypal.return', $order->id)),
            ]
        ];

        //طلب الريكويست
        try {

            // Call API with your client and get a response for your call
            //تنفيذ الريكويست
            $response = $client->execute($request);

            // If call returns body in response, you can get the deserialized version from the result attribute of the response

            //حيرجع ريسبونس 
            //المهم هل العملية نجحت او لا ورابط اعادة التوجيه لليوزر
            // print_r($response);
            //dd($response);  //د30-44
            //away -> ابعتلك لرابط خارجي بدي ابعتو على رابط الدفع
            //هنا بحكي اذا معلومات الطلب صحيحة وفشي اخطاء حول المستخدم على صفحة الدفع
            if ($response->statusCode == 201) {
                foreach ($response->result->links as $link) {
                    if ($link->rel == 'approve') {
                        return redirect()->away($link->href);
                    }
                }
            }
        } catch (HttpException $ex) {  //اذا فيه خطا بطبع اشي معين
            $order->payment_status = 'failed';
            $order->save();
            return redirect('/')->with('error', 'Payment failed!');

            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }


    // هنا بعد مابعتنا اليوزر على صفحة الابروف وعمل دفع رح نبعتو على صفحة ثانية بعد الدفع
    //اللي هيا الريتين اللي عملناها في الراوت
    //بخزن الاي دي اللي من الباي بال 
    //وبعمل كابتشر من الموقع عشان ااكد انو خلاص هادا الاردر اندفع
    //بالنسبة للبراميتر اي اشي بدي اجيبو من السيرفس كونتينر بتكون في الاول بعدين اللي من المودل

    public function callback(Request $request, Order $order)
    {
        //اذا الاوردر مدفوع قبل هيك طبعا مش رح اكمل البروسيس 
        //اذا مدفوع قبل هيك يعني المفروض معملو كابتشر من قبل
        if ($order->payment_status !== 'paid') {
            abort(404);
        }

        //افجص هل اجاني توكن او لا 
        //عشان لو شخص بطلت الرابط بشكل مباشر بدون توكن
        $token = $request->query('token');
        if (!$token) {
            abort(404);
        }




        /**
         *  @var \PayPalCheckoutSdk\Core\PayPalHttpClient;
         */
        $client = app('paypal.client');

        // Here, OrdersCaptureRequest() creates a POST request to /v2/checkout/orders
        // $response->result->id gives the orderId of the order created above
        //$request = new OrdersCaptureRequest("APPROVED-ORDER-ID");
        $request = new OrdersCaptureRequest($token); //هنا رح نبعتلو التوكن لانو رح نعمل كابتشر عليه

        $request->prefer('return=representation');
        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($request);

                        //dd($response); د 21-1

            if ($response->statusCode == 201 && $response->result->status == 'COMPLETED') {
                $order->payment_status = 'paid';
                $order->save();
                $order->payments()->create([
                    'amount' => $response->result->purchase_units[0],
                    'payload' =>$response->result, // هنا الارفل رح يحول معلومات الدفع كلها الى جيسون
                    'method' => 'paypal',
                ]);
            }

            return redirect('/')->with('success', 'Payment completes!');
            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            //print_r($response);

        } catch (HttpException $ex) {
            $order->payment_status = 'failed';
            $order->save();

            return redirect('/')->with('error', 'Payment failed!');

            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }


    public function cancel(Order $order)
    {


        $order->payment_status = 'failed';
        $order->save();
        return redirect('/')->with('error', 'Payment failed!');
    }
}



//انتبه في دقيقة 23-1 
//فيه تغير في الشيك اوت بدل صفحة الهوم على صفحى البايمنت
//تجربة  36-1