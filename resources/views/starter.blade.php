@extends('layouts.master-without-nav')

@section('title') Accueil @endsection

@section('body')

    <body>
    @endsection

    @section('content')
        <link href="{{ URL::asset('/css/app.min.css')}}" id="app-light" rel="stylesheet" type="text/css" />

        <link href="{{URL::asset('libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">
        <link href="{{URL::asset('libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
        <link href="{{URL::asset('libs/bootstrap-touchspin/bootstrap-touchspin.min.css')}}" rel="stylesheet" />



        <div class="home-btn d-none d-sm-block">
            <a href="{{route('auth.starter')}}" class="text-dark"><i class="fas fa-home h2"></i></a>
            <a href="{{route('cadeau.mesDeclarations')}}" class="px-2 text-primary" data-toggle="tooltip" data-placement="top" title="Mes Declarations">
                <i class="fas fa-clipboard-list fa-2x"></i></a>
            @if(\Illuminate\Support\Facades\Auth::user()->type == "ADMIN" || \Illuminate\Support\Facades\Auth::user()->type == "SUPER-ADMIN")
                <a href="{{route('cadeau.index')}}" class="px-2 text-primary" data-toggle="tooltip" data-placement="top" title="Declarations">
                    <i class="fas fa-cogs fa-2x"></i></a>
                <a href="{{route('natures.index')}}" class="px-2 text-primary" data-toggle="tooltip" data-placement="top" title="Nature">
                    <i class="fas fa-cog fa-2x"></i></a>
            @endif

            @if(\Illuminate\Support\Facades\Auth::user()->type == "SUPER-ADMIN")
                <a href="{{route('auth.users-list')}}" class="px-2 text-primary" data-toggle="tooltip" data-placement="top" title="Utilisateurs">
                    <i class="fas fa-users fa-2x"></i></a>
            @endif

            <a href="{{route('auth.logout')}}" class="px-2 text-dark" data-toggle="tooltip" data-placement="top" title="Déconnection">
                <i class="fas fa-sign-out-alt fa-2x"></i></a>
        </div>

        <div class="account-pages my-5 pt-sm-5">
            <div class="text-center ">
                <a href="{{route('auth.starter')}}" class="mb-3 d-block auth-logo">
                    <img src="{{ URL::asset('images/logoseter.png')}}" alt="" height="60" class="logo logo-dark">
                    <img src="{{ URL::asset('images/logoseter.png')}}" alt="" height="60" class="logo logo-light">
                </a>
            </div>
            <div class="container">

                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-10 col-xl-10">
                        <div class="card overflow-hidden">
                            <div class="text-center mt-2">
                                <h3 style="color: #9c182f">Déclaration des invitations et cadeaux</h3>
                                <p class="text-muted">Veuillez remplir les champs</p>
                            </div>

                            <div class="card-body pt-5">
                                <div class="p-2">
                                    <form class="outer-repeater" method="POST" action="{{route('cadeau.store')}}" onsubmit="disableButton()">
                                        @csrf

                                        <div data-repeater-list="declaration" class="outer">
                                            <div data-repeater-item class="outer">
                                                <div class="row">
                                                    <div class="form-group col-md-4">
                                                        <label for="direction">Direction *</label>
                                                        <select class="form-control select2 @error('declaration.*.direction') is-invalid @enderror" name="direction" id="direction">
                                                            <option value="DAF">DAF</option>
                                                            <option value="DG">DG</option>
                                                            <option value="DQHSE">DQHSE</option>
                                                            <option value="DEX">DEX</option>
                                                            <option value="DRH">DRH</option>
                                                            <option value="DSI">DSI</option>
                                                            <option value="DJUR">DJUR</option>
                                                            <option value="DMSV">DMSV</option>
                                                            <option value="DMMR">DMMR</option>
                                                            <option value="DMISB">DMISB</option>
                                                            <option value="DSUR">DSUR</option>
                                                        </select>
                                                        @error('declaration.*.direction')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="nature">Nature *</label>
                                                        <select class="form-control select2 @error('declaration.*.nature') is-invalid @enderror" name="nature" id="nature">
                                                            @foreach($natures as $value)
                                                                <option value="{{$value->slug}}">{{$value->nom}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('declaration.*.nature')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="sens">Sens *</label>
                                                        <select class="form-control select2 @error('declaration.*.sens') is-invalid @enderror" name="sens" id="sens">
                                                            <option value="RECUS">RECUS</option>
                                                            <option value="OFFERT">OFFERT</option>
                                                        </select>
                                                        @error('declaration.*.sens')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label for="date">Date *</label>
                                                        <input type="date" class="form-control @error('declaration.*.date') is-invalid @enderror" id="date" name="date" value="{{old('date')}}" >
                                                        @error('declaration.*.date')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="contexte">Contexte *</label>
                                                        <input type="text" class="form-control @error('declaration.*.contexte') is-invalid @enderror" id="contexte" name="contexte" value="{{ old('contexte') }}" >
                                                        @error('declaration.*.contexte')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label for="montant">Montant Estimatif (FCFA) *</label>
                                                        <input type="text" class="form-control @error('declaration.*.montant') is-invalid @enderror" id="montant" name="montant" >
                                                        @error('declaration.*.montant')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="resHierarchique">Responsable Hierarchique *</label>
                                                        <select class="form-control select2 @error('declaration.*.resHierarchique') is-invalid @enderror" name="resHierarchique" id="resHierarchique">
                                                            <option value="0">Aucun</option>
                                                            @foreach($users as $user)
                                                                <option value="{{$user->id}}">{{$user->realname}} {{$user->firstname}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('declaration.*.resHierarchique')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group ">
                                                    <label for="description">Description *</label>
                                                    <textarea name="description" id="description" class="form-control @error('declaration.*.description') is-invalid @enderror ckeditor " placeholder="Ecrire ici..." >
                                                        {{old('texte')}}
                                                    </textarea>
                                                    @error('declaration.*.description')
                                                    <div class="alert alert-danger">Champ Obligatoire</div>
                                                    @enderror
                                                </div>


                                                <div class="inner-repeater m-2 p-2">
                                                    <div data-repeater-list="implications" class="inner form-group">
                                                        <h4>Provenance :</h4>
                                                        <div data-repeater-item class="inner m-3 p-2 ">
                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <label for="structure">Structure de Provenance :</label>
                                                                    <input class="form-control @error('declaration.*.implications.*.structure') is-invalid @enderror" type="text" id="structure" name="structure" value="{{old('structure')}}">
                                                                    @error('declaration.*.implications.*.structure')
                                                                    <span class="invalid-feedback" role="alert">
                                                                    <strong>Champ Obligatoire</strong>
                                                                </span>
                                                                    @enderror
                                                                </div>


                                                            </div>

                                                            <div class="row">
                                                                <div class="form-group col-md-4">
                                                                    <label for="prenom">Prenom :</label>
                                                                    <input class="form-control @error('declaration.*.implications.*.prenom') is-invalid @enderror" type="text" id="prenom" name="prenom" value="{{old('prenom')}}">
                                                                    @error('declaration.*.implications.*.prenom')
                                                                    <span class="invalid-feedback" role="alert">
                                                                    <strong>Champ Obligatoire</strong>
                                                                </span>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="nom">Nom :</label>
                                                                    <input class="form-control @error('declaration.*.implications.*.nom') is-invalid @enderror" type="text" id="nom" name="nom" value="{{old('nom')}}">
                                                                    @error('declaration.*.implications.*.nom')
                                                                    <span class="invalid-feedback" role="alert">
                                                                    <strong>Champ Obligatoire</strong>
                                                                </span>
                                                                    @enderror
                                                                </div>


                                                            </div>



                                                            <div class="col-md-2 col-4">
                                                                <input data-repeater-delete type="button" class="btn btn-block inner" style="color: white; background-color: #6C4B26" value="Supprimer" />
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <input data-repeater-create type="button" class="btn inner" style="background-color: #EABE8F; color: white" value="Ajouter" />
                                                </div>



                                                <div class="mt-3">
                                                    <button class="btn btn-lg waves-effect waves-light float-right" style="background-color: #9c182f; color: white" data-toggle="modal" data-target="#exampleModalScrollable" type="button">Enregistrer</button>
                                                </div>

                                                <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">Déclaration d'invitations et de cadeaux </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <p><strong>Cher(ère) collaborateur(rice), vous souhaitez déclarer la réception d’un cadeau ou d’une invitation ? Vous êtes bien au bon endroit. Merci d’avoir choisi la voie de la transparence.</strong></p>

                                                                <p>Mais avant de lancer la procédure de déclaration, les informations ci-après vous seront utiles. </p>

                                                                <p>A titre de rappel, concernant la Politique cadeaux et invitations, merci de noter que <strong>le principe est la déclaration et non l’interdiction.</strong></p>

                                                                <p>Donc, quel que soit le cadeau ou l’invitation reçu, en nature ou en numéraire (même par voie de paiement électronique notamment par WAVE, WARI, ORANGE MONEY, FREE MONEY etc…), le collaborateur est soumis à une obligation de déclaration pour validation via cette plateforme DIC.</p>

                                                                <p><strong>La réponse</strong> de la Direction Juridique et Conformité à la déclaration va intervenir dans les 24 heures après réception de la demande d’approbation.</p>

                                                                <h3>1.	Seuil</h3>

                                                                <p>Le seuil du montant annuel des libéralités est fixé par collaborateur comme suit :</p>

                                                                <ul>
                                                                    <li>Pour les cadeaux :     44.900 Fr CFA</li>
                                                                    <li>Pour les invitations : 80. 000 Fr CFA  </li>
                                                                </ul>

                                                                <h3>2.	Nombre de cadeaux et Invitations </h3>

                                                                <p>Il est possible de recevoir plusieurs cadeaux et invitations, à condition que le montant ne dépasse pas le seuil annuel arrêté. Par conséquent, un ou plusieurs cadeaux peuvent faire l’objet d’une seule déclaration.</p>

                                                                <p>Tous les cadeaux et invitations reçus d’une relation d’affaires et dont la valeur dépasse le plafond doivent être signalés au Responsable hiérarchique et à la Direction Juridique et Conformité pour validation /approbation.</p>

                                                                <p>Le collaborateur souhaitant exceptionnellement recevoir un cadeau ou une invitation au-delà du montant autorisé, doit d’abord obtenir l’autorisation de sa hiérarchie et l’avis favorable de la Direction Juridique et Conformité. </p>

                                                                <h3>3.	Les Interdictions</h3>

                                                                <p>Sont interdits, quel que soit le montant, les cadeaux et invitations :</p>
                                                                <ul>
                                                                    <li>Sous forme de dons en espèces, monnaies électroniques (Orange money, wave…) prêts, titres de placement ; </li>
                                                                    <li>Sous forme de prestations gratuites ou inférieures au prix du marché ; </li>
                                                                    <li>Demandés, offerts ou reçus à domicile, en contrepartie d'un avantage ; </li>
                                                                    <li>Reçus ou offerts dans une période de procédure d’attribution de marché ;</li>
                                                                    <li>A caractère illégal, de nature sexuelle, contraire à la dignité humaine ;</li>
                                                                    <li>Son conformes aux lois et règlementations ;</li>
                                                                    <li>En remerciement de services rendus ou d’avantages en nature. </li>
                                                                </ul>

                                                                <p><strong>Vous pouvez dès à présent procéder à la déclaration du cadeau/invitation reçu. </strong></p>

                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="customCheck2" name="accept" onchange="document.getElementById('confirmer').disabled = !this.checked;">
                                                                    <label class="custom-control-label" for="customCheck2">j'ai lu et j'accepte les termes et conditions</label>
                                                                </div>

                                                                <br>

                                                                <h3><strong>LA DIRECTION JURIDIQUE ET CONFORMITE</strong></h3>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                                <button type="submit" class="btn " style="background-color: #9c182f; color: white" id="confirmer" disabled>Confirmer</button>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>

                                            </div>
                                        </div>

                                    </form>
                                </div>

                            </div>
                        </div>
                        <div class="mt-5 text-center">

                            <p>© 2022 Declaration des invitations et cadeaux V0 - SETER Crafted with <i class="mdi mdi-heart text-danger"></i> by DSI</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
@endsection

    @section('script')

        <script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>
        <script src="{{URL::asset('/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{URL::asset('/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js')}}"></script>
        <script src="{{URL::asset('/libs/bootstrap-touchspin/bootstrap-touchspin.min.js')}}"></script>
        <script src="{{URL::asset('/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>

        <!-- form advanced init -->
        <script src="{{URL::asset('/js/pages/form-advanced.init.js')}}"></script>
        <!-- form repeater js -->
        <script src="{{URL::asset('/libs/jquery-repeater/jquery-repeater.min.js')}}"></script>
        <!-- form repeater init -->
        <script src="{{URL::asset('/js/pages/form-repeater.init.js')}}"></script>

        <script src="https://cdn.ckeditor.com/ckeditor5/33.0.0/classic/ckeditor.js"></script>
        <script type="text/javascript">
            ClassicEditor
                .create( document.querySelector( '#description' ) )
                .then( editor => {
                    console.log( editor );
                } )
                .catch( error => {
                    console.error( error );
                } );
        </script>

        <script>
            function disableButton(){
                document.getElementById('confirmer').disabled = true;
            }
        </script>

    @endsection
