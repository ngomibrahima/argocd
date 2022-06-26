@extends('layouts.master-without-nav')

@section('title') Utilisateurs @endsection

@section('body')

    <body>
    @endsection

    @section('content')
        <link href="{{ URL::asset('/css/app.min.css')}}" id="app-light" rel="stylesheet" type="text/css" />

        <link href="{{URL::asset('libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">
        <link href="{{URL::asset('libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
        <link href="{{URL::asset('libs/bootstrap-touchspin/bootstrap-touchspin.min.css')}}" rel="stylesheet" />

        <!-- DataTables -->
        <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />


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
                                <h3 style="color: #9c182f">Liste des utilisateurs</h3>

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
                                            <form action="{{route('auth.create-user')}}" method="post" autocomplete="off">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Ajout de Type de declaration</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">


                                                            <div class="form-group ">
                                                                <label for="nom">Agent :</label>
                                                                <select class="form-control select2" name="agent" id="agent">
                                                                    <option>Choisir ...</option>
                                                                    @foreach($agents as $user)
                                                                        <option value="{{$user->id}}">{{$user->realname}} {{$user->firstname}}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('agent')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group ">
                                                                <label for="type">Type :</label>
                                                                <select class="form-control select2" name="type" id="type">
                                                                    <option>Choisir ...</option>
                                                                    <option value="USER">USER</option>
                                                                    <option value="ADMIN">ADMIN</option>
                                                                    <option value="SUPER-ADMIN">SUPER-ADMIN</option>
                                                                </select>
                                                                @error('type')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
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
                                            <th scope="col">Type</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Action</th>

                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($users as $value)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$value->type}}</td>
                                                <td>{{$value->name}}</td>

                                                <td style="width: 10%">
                                                    <a href="{{route('auth.delete-user', [$value->id])}}" class="px-2 text-secondary" data-toggle="tooltip" data-placement="top" title="Supprimer"><i class="fas fa-trash-alt font-size-18" style="color: darkred"></i></a>

                                                </td>

                                            </tr>

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

        <!-- Required datatable js -->
        <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>
        <script src="{{ URL::asset('/libs/jszip/jszip.min.js')}}"></script>
        <script src="{{ URL::asset('/libs/pdfmake/pdfmake.min.js')}}"></script>

        <!-- Datatable init js -->
        <script src="{{ URL::asset('/js/pages/datatables.init.js')}}"></script>

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
