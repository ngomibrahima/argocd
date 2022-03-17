@extends('layouts.master-without-nav')

@section('title') Erreur @endsection

@section('body')

    <body>
    @endsection

    @section('content')

        <div class="home-btn d-none d-sm-block">
            <a href="index" class="text-dark"><i class="fas fa-home h2"></i></a>
        </div>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">

                            <div class="card-body">

                                <div class="text-center p-3">

                                    <div class="img">
                                        <img src="{{asset('images/error-img.png')}}" class="img-fluid" alt="">
                                    </div>

                                    <h4 class="mb-4 mt-5">{{$message}}</h4>
                                    <p class="mb-4 w-75 mx-auto">Veuillez contacter le Centre de Service Informatique par mail (csi@seter.sn) ou par telephone au 76 600 28 64 et les notifier le code erreur cité ci dessus.</p>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
@endsection
