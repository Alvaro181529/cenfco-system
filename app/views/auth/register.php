<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CENEFCO</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="/assets/Diseño_sin_título_13.png" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body style="background-color:#c4971d;">
    <section>
        <div class="container py-5">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img1.webp"
                                    alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form method="POST" action="/register"> 
                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Inicia sesion con tu cuenta</h5>

                                        <div class="row">
                                            <div data-mdb-input-init class="form-outline mb-4 col">
                                                <label class="form-label text-muted" for="form2Example17">Nombre Completo</label>
                                                <input type="text" id="username" name="username" class="form-control form-control-lg " />
                                            </div>

                                            <div data-mdb-input-init class="form-outline mb-4 col">
                                                <label class="form-label text-muted" for="form2Example17">Correo</label>
                                                <input type="email" id="correo" name="correo" class="form-control form-control-lg " />
                                            </div>
                                        </div>
                                        <div class="row ">
                                            <div data-mdb-input-init class="form-outline mb-4 col">
                                                <label class="form-label text-muted" for="form2Example27">Contraseña</label>
                                                <input type="password" id="form2Example27" name="password" class="form-control form-control-lg " />
                                            </div>
                                            <div data-mdb-input-init class="form-outline mb-4 col">
                                                <label class="form-label text-muted" for="form2Example27">Confirmar contraseña</label>
                                                <input type="password" id="form2Example27" name="passwordConfirmed" class="form-control form-control-lg " />
                                            </div>
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-block" type="submit">Registrar cuenta</button>
                                        </div>

                                        <p class="mb-5 pb-lg-2" style="color: #393f81;"><a href="/login"
                                                style="color: #393f81;">Tengo cuenta</a></p>
                                        <a href="#!" class="small text-muted">Terms of use.</a>
                                        <a href="#!" class="small text-muted">Privacy policy</a>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>