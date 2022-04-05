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
                                                        <label for="montant">Montant (FCFA) *</label>
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
                                                        <h4>Implications :</h4>
                                                        <div data-repeater-item class="inner m-3 p-2 ">
                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <label for="structure">Structure :</label>
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
                                                    <input data-repeater-create type="button" class="btn inner" style="background-color: #EABE8F; color: white" value="Ajouter Implication" />
                                                </div>



                                                <div class="mt-3">
                                                    <button class="btn btn-lg waves-effect waves-light float-right" id="submit" style="background-color: #9c182f; color: white" type="submit">Enregistrer</button>
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
                document.getElementById('submit').disabled = true;
            }
        </script>

    @endsection
