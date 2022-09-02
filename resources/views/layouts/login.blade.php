<html>
    <head>
        <title>@yield('title')</title>
        <link rel="icon" href="<?= asset('img/favicon.png') ?>" type="image" sizes="16x16">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <?= '<link rel="stylesheet" href="'.asset('css/base.css').'">'; ?>

    </head>

    <style>
        body {
            background-image: url("{{asset("img/logo_di.png")}}");
            background-repeat: no-repeat;
            background-position: center ;
            background-color: black;
        }        
    </style>

    <body>
        @section('navbar')
        
       <!-- Toasts -->
       <div aria-live="polite" aria-atomic="true" style="position: relative;">
            <!-- Position it -->
            <div class='toast-container' style="position: absolute; top:0; right: 0;">
                <!-- Menssagens -->
                <?php 
                    //Check where are the messages
                    $Mensagens = isset($MensagensToast) ? $MensagensToast : session()->get('MensagensToast');
                    //Check for null values
                    if($Mensagens != null): $delay = 3000;
                    foreach($Mensagens as $Mensagem):
                ?>

                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="<?= $delay ?>">
                    <div class="toast-header bg-primary text-white">
                    <img src="<?= asset('img/favicon.png') ?>" class="rounded mr-2">
                        <strong class="me-auto">@yield('title')</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        <?= $Mensagem ?>
                    </div>
                </div>

                <?php $delay += 500; endforeach; endif; ?>
                
                <!-- Errors -->
                <?php 
                    //Check for erros
                    if ($errors->any()): $delay = 3000;
                    foreach($errors->all() as $error):
                ?>
                
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="<?= $delay ?>">
                    <div class="toast-header  bg-danger text-white">
                    <img src="<?= asset('img/favicon.png') ?>" class="rounded mr-2">
                        <strong class="me-auto">@yield('title') :: Error</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        <?= $error ?>
                    </div>
                </div>

                <?php $delay += 500; endforeach; endif; ?>
            </div>
        </div>
        
        @show

        <div class="container">
            @yield('content')
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

        <?= '<script src="'.asset('js/base.js').'"></script>'; ?>
       
        @yield('script')
        
        <script>

        </script>

    </body>
</html>