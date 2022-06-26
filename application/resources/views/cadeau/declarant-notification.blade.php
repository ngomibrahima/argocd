
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


                    <p>Bonjour {{$declaration->user->name}}. Votre declaration numéro {{$declaration->id}} vient d'etre {{$reponse}} par {{$admin}}. </p>
                    <p>Numero Déclaration: {{$declaration->id}}</p>
                    <p>Motif: {!! $declaration->motif_accept_rejet !!}</p>

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




