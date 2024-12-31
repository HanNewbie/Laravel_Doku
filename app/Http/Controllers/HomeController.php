<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Car;
use App\Models\bayar;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Str;


class HomeController extends Controller
{
   

    public function index(){
        
        $cars = Car::latest()->get();
        return view('frontend.homepage', compact('cars'));
    }

    public function contact(){
        return view('frontend.contact');
    }

    public function contactStore(Request $request){
       $data = $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'pesan' => 'required'  
       ]);

       Message::create($data);

       return redirect()->back()->with([
        'message' => 'Pesan anda berhasil dikirim',
        'alert-type' => 'Sukses'
       ]);
    }

    public function detail(Car $car){

        return view('frontend.detail', compact('car'));
    }

    public function bayar(Car $car){

        return view('frontend.bayar', compact('car'));
    }


    private $clientID = 'BRN-0238-1735638119953';
    private $secretKey = 'SK-I84fz79o7gd30nFb0kMN';
    private $environmentURL = "https://api-sandbox.doku.com/checkout/v1/payment";

    public function __construct($clientID = 'BRN-0238-1735638119953', $secretKey = 'SK-I84fz79o7gd30nFb0kMN', $environmentURL = "https://api-sandbox.doku.com/checkout/v1/payment")
    {
        $this->clientID = $clientID;
        $this->secretKey = $secretKey;
        $this->environmentURL = $environmentURL;
    }

    public function bayarStore(Request $request, $slug)
    {
        // Fetch car details by slug
        $car = Car::where('slug', $slug)->first();

        // Validate request data
        $validatedData = $request->validate([
            'mobil' => 'required',
            'harga' => 'required',
            'nama' => 'required',
            'nomor' => 'required',
            'hari' => 'required',
            'status' => 'Unpaid',
        ]);

        // Calculate total price based on rental days
        $hargaTotal = $validatedData['harga'] * $validatedData['hari'];

        // Add total price and generate unique order ID
        $validatedData['harga_total'] = $hargaTotal;
        $validatedData['orders_id'] = uniqid();

        // Save payment details to the database
        $bayars = Bayar::create($validatedData);

        // Construct order details for Doku
        $orderDetails = [
            'order' => [
                'invoice_number' => $bayars->orders_id,
                'amount' => $bayars->harga_total,
                'currency' => 'IDR',
                'callback_url' =>  route('homepage'),
                'callback_url_cancel' =>  route('homepage'),
                'callback_url_result' => route('invoice', ['orders_id' => $bayars->orders_id])
            ],
            'payment' => [
                'payment_due_date' => 60 * 3,
            ],
            'customer' => [
                'id' => $bayars->nama,
                'name' => $bayars->nama,
                'country' => 'ID',
                'phone' => $bayars->nomor,
            ],
            'item_details' => [
                [
                    'id' => $bayars->orders_id,
                    'name' => $bayars->mobil,
                    'quantity' => $bayars->hari,
                    'price' => $bayars->harga,
                ],
            ],
        ];

        // Signature and headers
        $url = $this->environmentURL;
        $uniqueID = (string)\Illuminate\Support\Str::uuid()->toString();
        $timeNow = gmdate('Y-m-d\TH:i:s\Z');
        $requestTarget = "/checkout/v1/payment";

        $digest = base64_encode(hash('sha256', json_encode($orderDetails), true));
        $digestBody = "Client-Id:{$this->clientID}\n" .
            "Request-Id:{$uniqueID}\n" .
            "Request-Timestamp:{$timeNow}\n" .
            "Request-Target:{$requestTarget}\n" .
            "Digest:{$digest}";
        $signature = "HMACSHA256=" . base64_encode(hash_hmac('sha256', $digestBody, $this->secretKey, true));

        $headers = [
            "Content-Type: application/json",
            "Client-Id: {$this->clientID}",
            "Request-Id: {$uniqueID}",
            "Request-Timestamp: {$timeNow}",
            "Signature: {$signature}",
        ];

        $body = json_encode($orderDetails);
        $ch = curl_init($this->environmentURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode != 200) {
            throw new \Exception("Error: {$response}");
        } else {
            $result = json_decode($response, true);

            if (isset($result['response']['payment']['url'])) {
                $paymentUrl = $result['response']['payment']['url']; // URL pembayaran
            } else {
                throw new \Exception('Payment URL not found in response.');
            }
            return view('frontend.sewa', compact('result', 'bayars', 'paymentUrl'));
        }
    }

    public function invoice($orders_id){
        $bayars = Bayar::find($orders_id);
        return view('frontend.invoice', compact('bayars'));
     }

}