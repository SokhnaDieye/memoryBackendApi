<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row border rounded-5 p-3 bg-white shadow box-area">
        <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #4f84b5;">
            <div class="featured-image mb-3">
                <img src="img1.png" class="img-fluid" style="width: 250px;">
            </div>
            <p class="text-white fs-2 " style="font-family: 'Courier New' , Courier, monospace; font-weight: 600;text-align: center">Bienvenue dans Factur<span style="color: blue">ix </span></p>
            <small class="text-white text-wrap text-center" style="width: 17rem;font-family: 'Courier New', Courier, monospace;">Votre satisfaction notre objectif </small>
        </div>

        <div class="col-md-6 right-box">
            <div class="row align-items-center">
                <div class="header-text mb-4">
                    <h2>Bonjour à nouveau</h2>
                    <p>Nous sommes heureux de vous retrouver.</p>
                </div>
                <div class="input-group mb-3">
                    <input name="nom" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Nom">
                </div>
                <div class="input-group mb-3">
                    <input name="email" type="email" class="form-control form-control-lg bg-light fs-6" placeholder="Addresse email">
                </div>
                <div class="input-group mb-3">
                    <input name="password" type="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password">
                </div>
                <div class="input-group mb-1">
                    <input name="password_confirmation" type="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password Confirmation">
                </div>

                <div class="input-group mb-5 d-flex justify-content-between">
                    <div class="forgot offset-3">
                        <small><a href="#">Mot de passe oublier?</a></small>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <button class="btn btn-lg btn-primary w-100 fs-6">Se connecter</button>
                </div>
                <div class="row">
                    <small>Vous n'avez pas de compte ? <a href="#">S'inscrire</a></small>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
