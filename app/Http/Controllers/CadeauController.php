<?php

namespace App\Http\Controllers;

use App\Exports\DeclarationExport;
use App\Mail\AdminNotification;
use App\Mail\NotifyDeclarant;
use App\Mail\NotifyResHie;
use App\Models\Cadeau;
use App\Models\Implication;
use App\Models\Nature;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;


class CadeauController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $declarations = Cadeau::all();
        return view('cadeau.index', compact('declarations'));
    }



    /**
     * Mes Declarations
     */
    public function mesDeclarations(){
        $declarations = Cadeau::where(['user_id' => Auth::user()->id])->get();
        return view('cadeau.mes-declarations', compact('declarations'));
    }



    /**
     * User Declarations
     */
    public function userDeclarations()
    {
        $declarations = Cadeau::where(['user_id' => Auth::user()->id])->get();
        return view('cadeau.user-declarations', compact('declarations'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function store(Request $request)
    {
        $request->validate([
           'declaration.*.direction' => 'required',
           'declaration.*.nature' => 'required',
           'declaration.*.sens' => 'required',
           'declaration.*.date' => 'required|date',
           'declaration.*.contexte' => 'required|max:100',
           'declaration.*.montant' => 'required|integer',
           'declaration.*.resHierarchique' => 'required',
           'declaration.*.description' => 'required',
           'declaration.*.implications.*.structure' => 'required',
           'declaration.*.implications.*.prenom' => 'required',
           'declaration.*.implications.*.nom' => 'required',

        ]);

        $outerGroup = $request->declaration[0];
        $nature = Nature::where(['slug' => $outerGroup['nature']])->firstOrFail();
        $cadeau = new Cadeau();
        $cadeau->nature_id = $nature->id;
        $cadeau->user_id = Auth::user()->id;
        $cadeau->montant = $outerGroup['montant'];
        $cadeau->direction = $outerGroup['direction'];
        $cadeau->sens = $outerGroup['sens'];
        $cadeau->contexte = $outerGroup['contexte'];

        if ($outerGroup['resHierarchique'] != 0){
            try {
                $client  = new Client();
                $url = "http://5.189.156.127:8015/apirest.php/User/".$outerGroup['resHierarchique'];

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
                $supHierarchique = $userGlpi->realname.' '.$userGlpi->firstname;

            }catch (\Exception $exception){
                $message = "Error Code 100-04";
                return view('page-erreur', compact('message'));
            }

        }else {
            $supHierarchique = "Aucun";
        }



        $cadeau->sup_hierarchique = $supHierarchique;
        $cadeau->date = $outerGroup['date'];
        $cadeau->description = $outerGroup['description'];
        $cadeau->statut = "EN-COURS";


        $cadeau->save();



        if (array_key_exists('implications', $outerGroup)){
            $innerGroup = $outerGroup['implications'];
            foreach ($innerGroup as $value){
                if ($value['structure'] != null && $value['prenom'] != null && $value['nom']){
                    $implication = new Implication();
                    $implication->cadeau_id = $cadeau->id;
                    $implication->structure = $value['structure'];
                    $implication->prenom = $value['prenom'];
                    $implication->nom = $value['nom'];
                    $implication->save();
                }
            }
        }



        if ($outerGroup['resHierarchique'] != 0){
            $emailList = Session::get('emailList')[0];
            $userEmail = $emailList->firstWhere('id', '=',$outerGroup['resHierarchique']);

            Mail::to($userEmail->email)->send(new NotifyResHie($cadeau));

        }


        $admins = User::where(['type' => "ADMIN"])->get();
        if (count($admins) != 0){
            $errors = [];
            foreach ($admins as $admin){
                try {
                    Mail::to($admin->email)->send(new AdminNotification($admin->name, $cadeau));
                }catch (\Exception $exception){
                    array_push($errors, $exception);
                }
            }
        }


        return redirect()->route('auth.starter')->with('success', "Votre déclaration de cadeau ou d'invitation a été enregistrée avec succès");

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $declaration = Cadeau::findOrFail($id);

        $adminApprouv = "";
        if ($declaration->statut != "EN-COURS" && $declaration->admin_modif_statut != null){
            $adminApprouv = User::findOrFail($declaration->admin_modif_statut)->name;
        }

        $year = Carbon::createFromFormat('Y-m-d', $declaration->date)->format('Y');
        $startDate = Carbon::createFromFormat('d-m-Y', '01-01-'.$year)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d-m-Y', '31-12-'.$year)->format('Y-m-d');
        $decYear = Cadeau::where(['user_id' => $declaration->user_id, 'statut' => "APPROUVE", 'nature_id' => $declaration->nature_id])
                        ->whereBetween('date', [$startDate, $endDate])->get();
        $montant = 0;
        foreach ($decYear as $item){
            $montant = $montant + $item->montant;

        }

        return view('cadeau.show', compact('declaration', 'adminApprouv', 'montant', 'decYear'));


    }

    /**
     * Export
     */
    public function export(Request $request){

        $request->validate([
            'debut' => "required",
            'fin' => "required",
        ]);
        $declas = Cadeau::whereBetween('date', [$request->debut, $request->fin])->get();
        if (count($declas) != 0){
            return Excel::download(new DeclarationExport($request->debut, $request->fin), 'declaration-cadeaux-invitations.xlsx');

        }else {
            return redirect()->route('cadeau.index')->with('error', "Aucune declaration à exporter");

        }


    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $declaration = Cadeau::findOrFail($id);
        $declaration->statut = $request->statut;
        $declaration->motif_accept_rejet = $request->motif;
        $declaration->admin_modif_statut = Auth::user()->id;
        $declaration->save();


        try {
            if ($declaration->statut == "APPROUVE"){
                $reponse = "approuvée";
            }else {
                $reponse = "refusée";
            }

            $admin = Auth::user()->name;
            Mail::to($declaration->user->email)->send(new NotifyDeclarant($declaration, $reponse, $admin));

        }catch (\Exception $exception){
            $message = "Error Code 100-05";
            return view('page-erreur', compact('message'));
        }

        return redirect()->route('cadeau.index')->with('success', "Reponse enregistrée avec succès");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
