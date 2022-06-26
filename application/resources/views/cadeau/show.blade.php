@extends('layouts.master-without-nav')

@section('title') Nature @endsection

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
                                <h3 style="color: #9c182f">Déclaration Numero: {{$declaration->id}}</h3>

                            </div>

                            <div class="card-body pt-3">
                                <div class="media-body align-self-center">

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="mt-3">
                                                <p class="text-muted mb-2">Nature</p>
                                                <h5 class="font-size-16 mb-0">{{ $declaration->nature->nom }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mt-3">
                                                <p class="text-muted mb-2"> Sens</p>
                                                <h5 class="font-size-16 mb-0">{{ $declaration->sens }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mt-3">
                                                <p class="text-muted mb-2"> Déclarant</p>
                                                <h5 class="font-size-16 mb-0">{{ $declaration->user->name }}</h5>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="mt-3">
                                                <p class="text-muted mb-2">Direction</p>
                                                <h5 class="font-size-16 mb-0">{{ $declaration->direction }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mt-3">
                                                <p class="text-muted mb-2"> Contexte</p>
                                                <h5 class="font-size-16 mb-0">{{ $declaration->contexte }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mt-3">
                                                <p class="text-muted mb-2"> Superieur Hierarchique</p>
                                                <h5 class="font-size-16 mb-0">{{ $declaration->sup_hierarchique }}</h5>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="mt-3">
                                                <p class="text-muted mb-2">Statut</p>
                                                <h5 class="font-size-16 mb-0">{{ $declaration->statut }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mt-3">
                                                <p class="text-muted mb-2"> Date</p>
                                                <h5 class="font-size-16 mb-0">{{ $declaration->date }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mt-3">
                                                <p class="text-muted mb-2"> Montant</p>
                                                <h5 class="font-size-16 mb-0">{{ $declaration->montant }} FCFA</h5>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mt-3">
                                                <p class="text-muted mb-2">Description</p>
                                                <p class="font-size-16 mb-0">{!! $declaration->description !!}</p>
                                            </div>
                                        </div>
                                    </div>

                                    @if($declaration->statut != "EN-COURS")
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="mt-3">
                                                    <p class="text-muted mb-2"> Approuvé/Rejeté par</p>
                                                    <h5 class="font-size-16 mb-0">{{ $adminApprouv }}</h5>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mt-3">
                                                    <p class="text-muted mb-2">Motif</p>
                                                    <p class="font-size-16 mb-0">{!! $declaration->motif_accept_rejet !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(\Illuminate\Support\Facades\Auth::user()->type != "USER")

                                        @if($declaration->statut == "EN-COURS")
                                            <div class="m-3 p-3 float-right">
                                                <button type="button" data-toggle="modal" data-target="#approuver" class="btn btn-primary">Répondre</button>
                                            </div>
                                            <div class="modal fade" id="approuver" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                    <form action="{{route('cadeau.update', [$declaration->id])}}" method="post" autocomplete="off" onsubmit="disableButton()">
                                                        @csrf
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">Etes vous sur de vouloir approuver cette déclaration ?</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <h4>Déclarations antérieures de l'agent</h4>
                                                                <ul>
                                                                    @foreach($decYear as $item)
                                                                        <li>Numero Reservation: {{$item->id}} -- Date: {{$item->date}} -- Montant: {{$item->montant}} FCFA</li>
                                                                    @endforeach
                                                                </ul>
                                                                <h4>Total: {{$montant}} FCFA</h4>
                                                                <br>
                                                                @if($declaration->nature->seuil - $montant - $declaration->montant < 0)
                                                                    <h4 class="text-danger">Seuil: {{$declaration->nature->seuil - $montant - $declaration->montant}} FCFA</h4>
                                                                @else
                                                                    <h4 class="text-success">Seuil: {{$declaration->nature->seuil - $montant - $declaration->montant}} FCFA</h4>
                                                                @endif

                                                                <div class="m-3">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="statut">Statut :</label>
                                                                        <select class="form-control" name="statut" id="statut">
                                                                            <option value="APPROUVE">Approuvée</option>
                                                                            <option value="REFUSE">Refusée</option>

                                                                        </select>
                                                                        @error('statut')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group ">
                                                                        <label for="motif">Motif</label>
                                                                        <textarea name="motif" id="motif" class="form-control ckeditor " placeholder="Ecrire ici..." >
                                                                        {{old('motif')}}
                                                                    </textarea>
                                                                        @error('motif')
                                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>





                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                                <button type="submit" id="submit" class="btn btn-primary">Confirmer</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>



                                        @endif
                                    @endif


                                </div>

                            </div>
                        </div>
                        <div class="mt-5 text-center">

                            <p>© 2022 Declaration Cadeaux et invitations V0 - SETER Crafted with <i class="mdi mdi-heart text-danger"></i> by DSI</p>
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
                .create( document.querySelector( '#motif' ) )
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
