<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Car;
use App\Models\bayar;
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

    public function bayarStore(Request $request, $slug)
    {
        // Ambil data mobil berdasarkan slug
        $car = Car::where('slug', $slug)->first();

        // Validasi input dari request
        $validatedData = $request->validate([
            'mobil' => 'required',
            'harga' => 'required',
            'nama' => 'required',
            'nomor' => 'required',
            'hari' => 'required',
        ]);

        // Validasi input dari request
        $hargaTotal = $validatedData['harga'] * $validatedData['hari'];

        // Tambahkan harga_total ke dalam data yang akan disimpan
        $validatedData['harga_total'] = $hargaTotal;

        // Generate ID unik
        $validatedData['orders_id'] = uniqid();

        // Simpan data pembayaran ke database
        $bayars = Bayar::create($validatedData);

        // Buat parameter transaksi untuk Doku
        $orderDetails = [
            'order' => [
                'invoice_number' => $bayars->orders_id,
                'amount' => $bayars->harga_total,
                'currency' => 'IDR',
                'line_items' => [
                    [
                        'name' => $bayars->mobil,
                        'quantity' => $bayars->hari,
                        'price' => $bayars->harga,
                    ],
                ],
                'callback_url' =>  route('homepage'),
                'callback_url_cancel' =>  route('homepage'),
                'callback_url_result' => "http://rentalin.great-site.net/invoice/{$bayars->orders_id}",
            ],
            'payment' => [
                'payment_due_date' => 60,
            ],
            'customer' => [
                'name' => $bayars->nama,
                'phone' => $bayars->nomor,
            ],
        ];
    
        // Parameter untuk autentikasi
        $clientID = config('doku.client_id');
        $secretKey = config('doku.secret_key');
        $environmentURL = config('doku.environment_url');

        $uniqueID = (string)\Illuminate\Support\Str::uuid()->toString();
        $timeNow = gmdate('Y-m-d\TH:i:s\Z');
        $requestTarget = "/checkout/v1/payment";
    
        // Membuat digest (hash SHA-256) dari detail pesanan
        $digest = base64_encode(hash('sha256', json_encode($orderDetails), true));

        // Membuat body digest untuk menghasilkan signature HMAC
        $digestBody = "Client-Id:{$clientID}\n" .
            "Request-Id:{$uniqueID}\n" .
            "Request-Timestamp:{$timeNow}\n" .
            "Request-Target:{$requestTarget}\n" .
            "Digest:{$digest}";
        
        // Membuat signature HMAC menggunakan secret key
        $signature = "HMACSHA256=" . base64_encode(hash_hmac('sha256', $digestBody, $secretKey, true));
    
        // Menyusun header untuk ke Doku 
        $headers = [
            "Content-Type: application/json",
            "Client-Id: {$clientID}",
            "Request-Id: {$uniqueID}",
            "Request-Timestamp: {$timeNow}",
            "Signature: {$signature}",
        ];
    
        // Menyiapkan body request yang berisi detail pesanan dalam format JSON
        $body = json_encode($orderDetails);

        // Mengirimkan request POST ke Doku API menggunakan cURL
        $ch = curl_init($environmentURL); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    
        $response = curl_exec($ch);  // Menjalankan request
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch); 
    
        // Menangani response dari API Doku
        if ($httpCode != 200) {
            throw new \Exception("Error: {$response}");
        } else {
            $result = json_decode($response, true); // Mengdecode response JSON menjadi array
    
            // Memeriksa apakah URL pembayaran ada di response
            if (isset($result['response']['payment']['url'])) {
                $paymentUrl = $result['response']['payment']['url'];
            } else {
                throw new \Exception('Payment URL not found in response.');
            }

            // Mengembalikan tampilan dengan data pembayaran dan URL pembayaran untuk melanjutkan pembayaran
            return view('frontend.sewa', compact('result', 'bayars', 'paymentUrl'));
        }
    }

    
    public function invoice($orders_id){
        $bayars = Bayar::find($orders_id);
        return view('frontend.invoice', compact('bayars'));
     }

}