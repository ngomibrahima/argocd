
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Déclaration de Cadeaux et Invitations</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>


<!-- end row -->

<div class="row justify-content-center">
    <div class="col-lg-9">

        <div class="col-xl-6">
            <div class="card pricing-box text-center">
                <div class="card-body p-4">
                    <div>

                        <div class="mt-3">
                            <h2 class="mb-1">Déclaration de Cadeaux et Invitations</h2>
                        </div>

                        <div class="py-3">
                            <i class="fas fa-user fa-3x"></i>
                        </div>
                    </div>


                    <p>Bonjour {{$admin}}. Une déclaration faite par l'agent {{$cadeau->user->name}} est en attente d'approbation. Veuillez vous connecter sur la plateforme DIC pour soumettre une réponse. </p>

                    <ul class="list-unstyled plan-features mt-3">
                        <li>Numero Declaration: <span class="text-primary font-weight-semibold"><b>{{$cadeau->id}}</b></span></li>
                        <li>Date: <span class="text-primary font-weight-semibold"><b>{{$cadeau->date}}</b></span></li>
                        <li>Nature: <span class="text-primary font-weight-semibold"><b>{{$cadeau->nature->nom}}</b></span></li>
                        <li>Sens: <span class="text-primary font-weight-semibold"><b>{{$cadeau->sens}}</b></span></li>
                        <li>Contexte: <span class="text-primary font-weight-semibold"><b>{{$cadeau->contexte}}</b></span></li>
                        <li>Montant Estimatif: <span class="text-primary font-weight-semibold"><b>{{$cadeau->montant}} FCFA</b></span></li>
                        <li>Responsable Hierarchique: <span class="text-primary font-weight-semibold"><b>{{$cadeau->sup_hierarchique}}</b></span></li>
                        <li>Description: <span class="text-primary font-weight-semibold">{!! $cadeau->description !!}</span></li>

                    </ul>

                    <br>
                    <br>

                    @if(count($cadeau->implications) != 0)
                        <h4>Provenance</h4>
                        @foreach($cadeau->implications as $value)
                            <ul class="list-unstyled plan-features mt-3">
                                <li>Structure: <span class="text-primary font-weight-semibold"><b>{{$value->structure}}</b></span></li>
                                <li>Nom: <span class="text-primary font-weight-semibold"><b>{{$value->nom}} {{$value->prenom}}</b></span></li>
                            </ul>
                        @endforeach
                    @endif

                    <p>Cordialement</p>


                </div>
            </div>
        </div>




        <!-- end row -->
    </div>
</div>
<!-- end row -->

</body>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</html>




