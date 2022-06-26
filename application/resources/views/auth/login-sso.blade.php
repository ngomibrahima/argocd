@extends('layouts.master-without-nav')

@section('title') Login  @endsection

@section('body')

    <body>
    @endsection

    @section('content')


        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-login text-center">
                                <div class="bg-login-overlay"></div>
                                <div class="position-relative">
                                    <h5 class="text-white font-size-20">Bonjour</h5>
                                    <p class="text-white-50 mb-0">Déclaration Cadeaux et Invitations - SETER</p>
                                    <a href="#" class="logo logo-admin mt-4">
                                        <img src="{{asset('images/logo2.svg')}}" alt="" height="20">
                                    </a>
                                </div>
                            </div>
                            <div class="card-body pt-5">
                                <div class="p-2">
                                    <div class="mt-3">
                                        <a class="btn btn-block waves-effect waves-light" style="background-color: #9c182f; color: white" href="{{route('auth.login-sso')}}" id="submit">Se Connecter</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="mt-5 text-center">

                            <p>© 2022 Déclaration Cadeaux et Invitations V0 - SETER Crafted with <i class="mdi mdi-heart text-danger"></i> by DSI</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script')
        <script>
            function disableButton(){
                document.getElementById('submit').disabled = true;
            }
        </script>
@endsection
