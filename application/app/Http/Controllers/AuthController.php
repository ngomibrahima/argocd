<?php

namespace App\Http\Controllers;

use App\Mail\SendToken;
use App\Models\Nature;
use App\Models\User;
use App\Traits\GlpiTrait;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Jumbojett\OpenIDConnectClient;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    use GlpiTrait;
    //Init Session
    public function initSession(){
        try {
            $client  = new Client();
            $url = "http://5.189.156.127:8015/apirest.php/initSession";

            $params = [
                "app_token" => "LoOZbYrfBt5dqi7eBZyPMjCLO3ye1i4zZEQGhSDe",
                "user_token" => "EgEaYBCZEv2EzdcDdBVgPbn6jVIYYapOhwXJkRXU"
            ];

            $headers = [
                "Content-Type" => "application/json",
            ];

            $response = $client->request("GET", $url, [
                'query' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            Session::put('session_token', $responseBody->session_token);

        }catch (\Exception $exception){
            $message = "Error Code 100-01";
            return view('page-erreur', compact('message'));
        }

    }



    public function getAllEmail(){

        $this->initSession();

        if (Session::has('emailList')){
            return Session::get('emailList');
            //Session::forget('emailList');

        }else {
            try {
                $headers = [
                    "Content-Type" => "application/json",
                ];

                $client2  = new Client();
                $url2 = "http://5.189.156.127:8015/apirest.php/Useremail";

                $params2 = [
                    "app_token" => "LoOZbYrfBt5dqi7eBZyPMjCLO3ye1i4zZEQGhSDe",
                    "session_token" => Session::get('session_token'),
                    "range" => "0-2000"
                ];

                $response2 = $client2->request("GET", $url2, [
                    'query' => $params2,
                    'headers' => $headers,
                    'verify' => false,
                ]);

                $usersResponse = json_decode($response2->getBody());

                $users = collect();
                foreach ($usersResponse as $value){
                    $user = (object)["id" => $value->users_id, "email" => $value->email];
                    //array_push($users, $user);
                    $users->push($user);
                }

                //Session::put('emailList', $user);
                Session::push('emailList', $users);
                return Session::get('emailList');

            }catch (\Exception $exception){
                $message = "Error Code 100-02";
                return view('erreur.page-500', compact('message'));
            }
        }

    }

    // Login Form
    public function loginForm(){
        return view('auth.login');
    }


    //Verify if email exist in glpi database
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);

        $users = $this->getAllEmail();
        //return $users[0];
        if ($users[0]->contains('email', $request->email)){

            $token = Str::random(20);
            //return $token;
            $user = $users[0]->firstWhere('email', '=',$request->email);
            //$id = $user->id;
            //$email = $user->email;
            //return $user;

            Session::push('userTryngToConnect', $user);
            Session::put('token', $token);

            //Mail::to($request->email)->send(new SendToken($token));
            //return redirect()->route('auth.verify-token-form');


            try {
                Mail::to($request->email)->send(new SendToken($token));
                return redirect()->route('auth.verify-token-form');
            }catch (\Exception $exception){
                $message = "Error Code 100-03";
                return view('page-erreur', compact('message'));
            }




        }else{
            return redirect()->route('auth.login-form')->with('error', "vous n'avez pas accès à cette application");
        }
    }

    //Verify token form
    public function verifyTokenForm(){
        if (Session::has('token')){
            return view('auth.verify-token');
        }else {
            return redirect()->route('auth.login-form')->with('error', 'Token expiré');
        }
    }

    //Verify token
    public function verifyToken(Request $request){
        if (Session::has('token') && Session::has('userTryngToConnect')){
            $token = Session::get('token');
            $userTryingToConnect = Session::get('userTryngToConnect')[0];
            Session::forget('token');
            Session::forget('userTryngToConnect');

            if ($token == $request->token){
                $userDB = User::where(['email' => $userTryingToConnect->email])->first();
                if ($userDB === null){
                    try {
                        $client  = new Client();
                        $url = "http://5.189.156.127:8015/apirest.php/User/".$userTryingToConnect->id;
                        $params = [
                            "app_token" => "LoOZbYrfBt5dqi7eBZyPMjCLO3ye1i4zZEQGhSDe",
                            "session_token" => Session::get('session_token'),
                        ];

                        $headers = [
                            "Content-Type" => "application/json",

                        ];
                        $response = $client->request("GET", $url, [
                            'query' => $params,
                            'headers' => $headers,
                            'verify' => false,
                        ]);

                        $userGlpi = json_decode($response->getBody());
                        $user = new User();
                        $user->user_glpi_id = $userTryingToConnect->id;
                        $user->email = $userTryingToConnect->email;
                        $user->name = $userGlpi->realname.' '.$userGlpi->firstname;
                        $user->password = Hash::make("DooDoug12345678");
                        $user->save();

                    }catch (\Exception $exception){
                        $message = "Error Code 100-04";
                        return view('page-erreur', compact('message'));
                    }



                }else {
                    $user = $userDB;
                }

                Auth::login($user);
                if (Auth::user()->type == "ADMIN"){
                    return redirect()->route('cadeau.index');
                }else {
                    return redirect()->route('auth.starter');
                }



            }else {
                return redirect()->route('auth.login-form')->with('error', 'Token non valide');
            }
        }else{
            return redirect()->route('auth.login-form')->with('error', 'Token expiré');
        }

    }

    // Starter
    public function starter(){
        $natures = Nature::all();
        $users = $this->getAllUsers();
        return view('starter', compact('natures', 'users'));
    }

    //user List
    public function usersList(){
        $users = User::all();
        $agents = $this->getAllUsers();
        return view('auth.users-list', compact('users', 'agents'));
    }

    //Create User
    public function createUser(Request $request){
        $check = User::where(['user_glpi_id' => $request->agent])->first();
        if ($check != null){
            $check->type = $request->type;
            $check->save();

        }else {
            $emailList = Session::get('emailList')[0];
            $userEmail = $emailList->firstWhere('id', '=',$request->agent);
            //return $userEmail->id;
            try {
                $client  = new Client();
                $url = "http://5.189.156.127:8015/apirest.php/User/".$userEmail->id;

                $params = [
                    "app_token" => "LoOZbYrfBt5dqi7eBZyPMjCLO3ye1i4zZEQGhSDe",
                    "session_token" => Session::get('session_token'),
                ];

                $headers = [
                    "Content-Type" => "application/json",

                ];
                $response = $client->request("GET", $url, [
                    'query' => $params,
                    'headers' => $headers,
                    'verify' => false,
                ]);

                $userGlpi = json_decode($response->getBody());
                //return $userGlpi;
                $user = new User();
                $user->user_glpi_id = $userEmail->id;
                $user->email = $userEmail->email;
                $user->name = $userGlpi->realname.' '.$userGlpi->firstname;
                $user->password = Hash::make("DooDoug12345678");
                $user->type = $request->type;
                $user->save();

            }catch (\Exception $exception){
                $message = "Error Code 100-04";
                return view('page-erreur', compact('message'));
            }
        }

        return redirect()->route('auth.users-list')->with('Utilisateur créé avec succès');

    }

    //Delete User
    public function deleteUser($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('auth.users-list')->with('success', "Utilisateur supprimé avec succès");
    }


    /**
     * Login SSO Form
     */
    public function loginSsoForm() {
        return view('auth.login-sso');
    }

    /**
     * Login SSO
     */
    public function loginSso(){
        $url = "https://seter.trustelem.com/app/630963";
        $clientID = "trustelem.oidc.hfqtayrt";
        $clientSecret = "ig0Sx9l4kKyi5sLobfgOWsTqx53K0oud";
        $oidc = new OpenIDConnectClient($url, $clientID, $clientSecret);

        $oidc->authenticate();

        $email = $oidc->requestUserInfo('email');

        $users = $this->getAllEmail();

        $userTC = $users[0]->firstWhere('email', '=',$email);
        $userDB = User::where(['email' => $userTC->email])->first();

        if ($userDB === null){
            try {
                $client  = new Client();
                $url = "http://5.189.156.127:8015/apirest.php/User/".$userTC->id;
                $params = [
                    "app_token" => "LoOZbYrfBt5dqi7eBZyPMjCLO3ye1i4zZEQGhSDe",
                    "session_token" => Session::get('session_token'),
                ];

                $headers = [
                    "Content-Type" => "application/json",

                ];
                $response = $client->request("GET", $url, [
                    'query' => $params,
                    'headers' => $headers,
                    'verify' => false,
                ]);

                $userGlpi = json_decode($response->getBody());
                $user = new User();
                $user->user_glpi_id = $userTC->id;
                $user->email = $userTC->email;
                $user->name = $userGlpi->realname.' '.$userGlpi->firstname;
                $user->password = Hash::make("DooDoug12345678");
                $user->save();

            }catch (\Exception $exception){
                $message = "Error Code 100-04";
                return view('page-erreur', compact('message'));
            }



        }else {
            $user = $userDB;
        }

        Auth::login($user);
        if (Auth::user()->type == "ADMIN"){
            return redirect()->route('cadeau.index');
        }else {
            return redirect()->route('auth.starter');
        }

    }

    //Logout
    public function logout(){

        Session::forget('session_token');
        Auth::logout();
        return redirect()->route('auth.login-sso-form');

    }
}
