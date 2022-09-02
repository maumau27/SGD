<html>
    <head>
        <title>@yield('title')</title>
        <link rel="icon" href="<?= asset('img/favicon.png') ?>" type="image" sizes="16x16">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">

        <?= '<link rel="stylesheet" href="'.asset('css/base.css').'">'; ?>

    </head>

    <body>
        @section('navbar')

        <nav class="navbar navbar-expand navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="<?= asset('img/logo_di.png') ?>" alt="" width="30" height="24">
                    @yield('title')
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php 
                    foreach($itensMenu as $key => $menu):
                        if($menu["SubMenu"]): ?>
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{$key}}
                                </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php foreach($menu["Itens"] as $item): ?>
                                <li><a class="dropdown-item" href="<?= url($item['Controller'] ."/" . $item['Action']) ?>">{{ $item["Nome"] }}</a></li>
                            <?php endforeach; ?>
                            </ul>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="<?= url($menu['Controller'] ."/" . $menu['Action']) ?>">{{ $menu["Nome"] }}</a>
                            </li>
                        <?php endif;
                    endforeach;?>
                    </ul>

                    <div class="d-flex">
                        <span class="navbar-text"> @yield('usuario', auth()->user()->Nome ?? '') </span>
                        <button type="button" class="btn btn-danger ms-2" onClick="location.href='<?= url('/logout'); ?>'">Logout</button>
                    </div>
                </div>
            </div>
        </nav>


       <!-- Toasts -->
       <div aria-live="polite" aria-atomic="true" style="position: relative;">
            <!-- Position it -->
            <div class="toast-container position-fixed bottom-0 end-0 p-2" style="z-index: 11">
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

        <div class="container-fluid">
            @yield('content')
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
        
        <?= '<script src="'.asset('js/base.js').'"></script>'; ?>
       
        @yield('script')
        
        <script>

        function newToast(mensagem) {
            toast = 
            '<div class="toast new-toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">' +
            '<div class="toast-header bg-primary text-white">' +
                '<img src=<?= asset("img/favicon.png") ?> class="rounded mr-2">' +
                '<strong class="me-auto">@yield('title')</strong>' +
                '<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>' +
            '</div>' +
            '<div class="toast-body">' + 
                mensagem +
            '</div>' +
            '</div>';

            elem = $('.toast-container').append(toast);
            $('.new-toast').toast('show');
            $('.new-toast').removeClass('new-toast');

        }    

        $(document).ready(function(){
            $('.selectpicker').selectpicker();
        });

        </script>

    </body>
</html>