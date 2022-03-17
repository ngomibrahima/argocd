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
                                <h3 style="color: #9c182f">Liste des types de declaration</h3>

                            </div>

                            <div class="card-body pt-5">
                                <div class="p-2">
                                    <div class="col-md-6">
                                        <div class="m-3">
                                            <button  class="btn  waves-effect waves-light" style="background-color: #9c182f; color: white" data-toggle="modal" data-target="#addNature" ><i class="mdi mdi-plus mr-2"></i> Ajouter</button>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="addNature" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form action="{{route('natures.store')}}" method="post" autocomplete="off">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Ajout de Type de declaration</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="row">
                                                            <div class="form-group col-md-4">
                                                                <label for="nom">Nom :</label>
                                                                <input class="form-control @error('nom') is-invalid @enderror" type="text" id="nom" name="nom" >
                                                                @error('nom')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group col-md-4">
                                                                <label for="seuil">Seuil :</label>
                                                                <input class="form-control @error('seuil') is-invalid @enderror" type="text" id="seuil" name="seuil" >
                                                                @error('seuil')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>


                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                        <button type="submit" class="btn btn-primary">Ajouter</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>

                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nom</th>
                                            <th scope="col">Seuil</th>
                                            <th scope="col">Action</th>

                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($natures as $value)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$value->nom}}</td>
                                                <td>{{$value->seuil}} FCFA</td>

                                                <td style="width: 20%">
                                                    <a class="px-2 text-secondary" data-toggle="modal" data-placement="top" title="Editer"  data-target="#modal{{$value->slug}}"><i class="fas fa-pencil-alt font-size-18"></i></a>
                                                    <a href="#" class="px-2 text-secondary" data-toggle="tooltip" data-placement="top" title="Supprimer"><i class="fas fa-trash-alt font-size-18" style="color: darkred"></i></a>

                                                </td>

                                            </tr>

                                            <!-- Modal -->
                                            <div class="modal fade" id="modal{{$value->slug}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <form action="{{route('natures.update', [$value->slug])}}" method="post" autocomplete="off">
                                                        @csrf

                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">Prestataire {{$value->nom}}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <div class="row">
                                                                    <div class="form-group col-md-4">
                                                                        <label for="nom">Nom :</label>
                                                                        <input class="form-control @error('nom') is-invalid @enderror" type="text" id="nom" name="nom" value="{{$value->nom}}">
                                                                        @error('nom')
                                                                        <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label for="seuil">Seuil :</label>
                                                                        <input class="form-control @error('seuil') is-invalid @enderror" type="text" id="seuil" name="seuil" value="{{$value->seuil}}">
                                                                        @error('seuil')
                                                                        <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                        @enderror
                                                                    </div>


                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                                <button type="submit" class="btn btn-primary">Modifier</button>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>



                                        @endforeach


                                        </tbody>

                                    </table>
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
                .create( document.querySelector( '#description' ) )
                .then( editor => {
                    console.log( editor );
                } )
                .catch( error => {
                    console.error( error );
                } );
        </script>

@endsection
