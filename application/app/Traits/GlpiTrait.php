<?php

namespace App\Traits;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

trait GlpiTrait
{
    /**
     * Get all users
     */
    public function getAllUsers(){
        if (Session::has('users')){
            $users = Session::get('users')[0];

        } else {
            try {
                $client  = new Client();
                $url = "http://5.189.156.127:8015/apirest.php/User";

                $params = [
                    "app_token" => "LoOZbYrfBt5dqi7eBZyPMjCLO3ye1i4zZEQGhSDe",
                    "session_token" => Session::get('session_token'),
                    "range" => "0-20000"
                ];

                $headers = [
                    "Content-Type" => "application/json",

                ];

                $response = $client->request("GET", $url, [
                    'query' => $params,
                    'headers' => $headers,
                    'verify' => false,
                ]);

                $users = json_decode($response->getBody());
                Session::push('users', $users);

            }catch (\Exception $exception){
                $message = "Error Code Trait-01";
                return view('erreur.page-500', compact('message'));
            }
        }

        return $users;
    }
}
