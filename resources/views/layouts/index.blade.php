<!doctype html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ url('/assets/img/iso_f.png') }}" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!--  <link rel="icon" type="image/jpg" href="assets/img/logo-blanco.png" style="width: 30px; height: 30px;">-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel='stylesheet'>
    <link href="{{ asset('assets/css/slick.css') }}" rel='stylesheet'>
    <link href="{{ asset('assets/css/slick-theme.css') }}" rel='stylesheet'>
    <link href="{{ asset('assets/css/font-awesome.css') }}" rel='stylesheet'>
    <link href="{{ asset('assets/css/animate.css') }}" rel='stylesheet'>
    <link href="{{ asset('assets/css/main.css') }}" rel='stylesheet'>
    <link href="{{ asset('assets/css/login.css') }}" rel='stylesheet'>
    <link href="{{ asset('assets/css/responsive.css') }}" rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link href="{{ asset('alertify/css/alertify.css') }}" rel='stylesheet'>
    <link href="{{ asset('alertify/css/themes/bootstrap.css') }}" rel='stylesheet'>
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <script src="{{ asset('pwa.js') }}"></script>

    <title>Aromantica </title>

    @laravelPWA
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9GR52EFB78"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-9GR52EFB78');
    </script>
</head>

<body>
    <a class="ws" target="_blank" href="https://api.whatsapp.com/send?phone=+573003707531&text=%C2%A1Hola!%20,%20Quiero%20m%C3%A1s%20informaci%C3%B3n."> <img src="{{ asset('assets/img/whatsapp.png') }}" alt=""> </a>
    <div class="elipse">
        <img class="logo-f" src="{{ asset('assets/img/logo.png') }}" alt="">
    </div>
    <!---   <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>--->
    @if(strpos(url()->current() ,url('/checkout/response')) < -1) <nav @if(url()->current() == url('/front-test'))
        class='navbar navbar-expand-md navbar-fixed-js container-fluid m-0 p-0 '
        @else class='navbar navbar-expand-md navbar-fixed-js pepe container-fluid' @endif id="navbarSupportedContent">
        <div class='container-fluid nav-grid'>
            <a class='' href="{{ url('/') }}">
                <img alt='' class="img-logo" src="{{ asset('assets/img/logo.png') }}">
            </a>
            <div class="search">
                <div id="search">
                    <form>
                        <input v-model="searchText" class="form-control" type="text" placeholder="Buscar..." autocomplete="off" @keyup="search()">
                    </form>

                    <div class="list_search">
                        <!--por nomnbre-->
                        <ul class="name_list">

                            <li v-for="producttitle in productTitles">
                                <a href="#" @click="setText(producttitle.name)">
                                    <p>
                                        <img style="width: 90px;" :src="'{{ env('CMS_URL') }}'+'/images/brands/'+producttitle.brand.image">
                                    </p>
                                    @{{ producttitle.name }}
                                    <p>
                                        <img style="width: 90px;" :src="'{{ env('CMS_URL') }}'+'/images/products/'+producttitle.image">
                                    </p>
                                </a>
                            </li>

                            <li v-for="brandtitle in brandTitles"><a href="#" @click="setText(brandtitle.name)">@{{ brandtitle.name }}
                                    <p>
                                        <img style="width: 90px;" :src="'{{ env('CMS_URL') }}'+'/images/brands/'+brandtitle.image">
                                    </p>
                                </a>
                            </li>

                        </ul>

                        <!--presentaciones-->
                        <div class="bg-search">
                            <span>Presentaciones</span>
                            <ul class="name_list name_list2 name_list3">

                                @foreach(App\Type::all() as $type)

                                <li @click="selectType('{{ $type }}')">
                                    {{ $type->name }}
                                    <label class="control control--radio">
                                        <input type="radio" name="type" />
                                        <div class="control__indicator"></div>
                                    </label>
                                </li>

                                @endforeach

                            </ul>



                            <!--caracteristicas--->
                            <div class="bg-search bg-search-scroll">
                                <span>Tamaños</span>
                                <ul class="name_list name_list2">

                                    @foreach(App\Size::all() as $size)

                                    <li @click="selectSize('{{ $size }}')">
                                        {{ $size->name }}oz / {{ $size->ml }}ml
                                        <label class="control control--radio">
                                            <input type="radio" name="size" />
                                            <div class="control__indicator"></div>
                                        </label>
                                    </li>

                                    @endforeach

                                </ul>

                            </div>

                            <div class="text-center">
                                <a href="#" type="button" class="btn-custom btn-custom-1" @click="lookFor()">Buscar</a>
                            </div>
                        </div>
                        <!--caracteristicas-->

                    </div>
                </div>
            </div>

            <button class='navbar-toggler p-2 border-0 hamburger hamburger--elastic d-none-lg' data-toggle='offcanvas' type='button'>
                <span class='hamburger-box'>
                    <span class='hamburger-inner'></span>
                </span>
            </button>
            <div class='offcanvas-collapse fil ml-auto' id='navbarNav'>
                <ul class="navbar-nav nav-2">
                    <div class="iconos-social">

                        <li><a href="https://wa.me/573003707533" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i> </a></li>
                        <li><a href="https://www.facebook.com/Aromantica-Perfumeria-100208405251210/?ti=as" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i> </a></li>
                        <li><a href="https://instagram.com/aromanticaperfumeria?igshid=4i52vlzcp5jz" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i> </a></li>
                    </div>
                    <li><a href="mailto:ventas@aromatica"><i class="fa fa-envelope-o" aria-hidden="true"></i>
                            ventas@aromantica.co</a></li>
                    <li><a href="tel:+573003707533"><i class="fa fa-phone" aria-hidden="true"></i>

                            +57 3003707533</a></li>
                </ul>
                <ul class='navbar-nav'>
                    <!-- <li class='nav-item active'>
                        <a class='nav-link active nav-link-black ' href='{{ url('/front-test') }}'>Inicio</a>
                    </li> -->
                    <li class='nav-item mr-3'>
                        <a class='nav-link nav-link-black ' href='{{ url('/tienda') }}'>Tienda</a>
                    </li>

                    <li class='nav-item dropdown dowms mr-3'>
                        <a href='#' aria-expanded='false' aria-haspopup='true' class='nav-link dropdown-toggle nav-link-black ' data-toggle='dropdown'>
                            Categorías
                        </a>
                        <div aria-labelledby='dropdownMenuButton' class='dropdown-menu overdro'>
                            <div class='content-drop'>
                                <a class='dropdown-item' href='#'>
                                    @foreach(App\Category::all() as $category)
                                    <a href="{{ url('/category/'.$category->slug) }}" class='nav-link  nav-link '>
                                        {{ $category->name }}
                                    </a>
                                    @endforeach
                                </a>
                            </div>
                        </div>
                    </li>


                    <!-----   @foreach(App\Category::all() as $category)

                    <li class='nav-item down-md'>
                        <a href="{{ url('/category/'.$category->slug) }}" class='nav-link  nav-link '>
                            {{ $category->name }}
                        </a>

                    </li>

                    @endforeach---->

                    <!--menu tablet--->
                    <li class='nav-item dropdown down-md-v mr-3'>
                        <a href='#' aria-expanded='false' aria-haspopup='true' class='nav-link dropdown-toggle  ' data-toggle='dropdown'>
                            Categorias
                        </a>
                        <div aria-labelledby='dropdownMenuButton' class='dropdown-menu'>
                            <div class='content-drop'>
                                <a class='dropdown-item' href='#'>
                                    <p> Damas</p>
                                </a>
                                <a class='dropdown-item' href='#'>
                                    <p> Caballeros</p>
                                </a>
                                <a class='dropdown-item' href='#'>
                                    <p> Ninos</p>
                                </a>
                            </div>
                        </div>

                    </li>

                    <!--menu tablet--->
                    @if(\Auth::guest())
                    <li class="nav-item mr-3">
                        <a id="openRegisterModal" style="border: 1px solid white;
                          border-radius: 10px;" class="nav-link p-0 " href="#" data-toggle="modal" data-target="#registerModal">Regístrate</a>
                    </li>


                    <!--- <li class="nav-item">
                          <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Login</a>
                      </li>--->
                    @else



                    @endif

                    <!--- <li class="nav-item position-relative mr-3">
                        <span class="add_btn" id="cart-notification"></span>
                        <a class="nav-link" href="{{ url('/cart/index') }}"><i class="flaticon-shopping-cart"></i></a>
                    </li>--->


                    <li>
                        <div class="dropdown" id="cartPreview">
                            <button class="btn btn-default dropdown-toggle d-flex p-0 " type="button" data-toggle="dropdown" data-hover="dropdown">
                                <span class="add_btn" id="cart-notification"></span>
                                <a class="nav-link" href="{{ url('/cart/index') }}"><i class="flaticon-shopping-cart"></i></a>
                            </button>
                            <ul class="dropdown-menu carrito-nav">

                                <li v-for="product in products">
                                    <div>
                                        <img :src="'{{ env('CMS_URL') }}'+'/images/products/'+product.product_type_size.product.image" alt="">
                                    </div>

                                    <div>
                                        <p>@{{ product.product_type_size.product.name }}</p>
                                        <p>@{{ product.amount }} x
                                            <span v-if="product.product_type_size.discount_percentage == 0">$@{{ parseInt(product.product_type_size.price).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</span>
                                            <span v-else>$@{{ parseInt(product.product_type_size.price - (product.product_type_size.price * (product.product_type_size.discount_percentage/100))).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</span>
                                        </p>
                                    </div>
                                </li>
                                <li v-for="product in guestProducts">
                                    <div>
                                        <img :src="'{{ env('CMS_URL') }}'+'/images/products/'+product.product.product.image" alt="">
                                    </div>

                                    <div>
                                        <p>@{{ product.product.product.name }}</p>
                                        <p>@{{ product.amount }} x
                                            <span v-if="product.product.discount_percentage == 0">$@{{ parseInt(product.product.price).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</span>
                                            <span v-else>$@{{ parseInt(product.product.price - (product.product.price * (product.product.discount_percentage/100))).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</span>
                                        </p>
                                    </div>
                                </li>
                                <div class="sub">
                                    <span>Subtotal:
                                        $@{{ parseInt(total).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</span>
                                    <ul>
                                        <li><a class="btn-custom sub-h" href="{{ url('/cart/index') }}">Ver carrito</a></li>
                                        <li><a class="btn-custom sub-h btn-w" href="{{ url('/checkout') }}">Finalizar
                                                compra</a></li>
                                    </ul>
                                </div>
                            </ul>


                        </div>

                    </li>

                    @if(\Auth::guest())

                    <li class="nav-item">
                        <a id="openLoginModal" class="nav-link p-0 mr-5" href="#" data-toggle="modal" data-target="#loginModal"><i class="flaticon-user"></i></a>
                    </li>
                    @else <li class='nav-item dropdown dowms succss'>
                        <a href='#' aria-expanded='false' aria-haspopup='true' style="text-transform: capitalize;" class='nav-link dropdown-toggle border-blue ' data-toggle='dropdown'>
                            <i class="flaticon-user"></i>

                            @if(strpos(\Auth::user()->name, " ") > 0)
                            {{ substr(\Auth::user()->name, 0, strpos(\Auth::user()->name, " ")) }} {{ substr(\Auth::user()->name, strpos(\Auth::user()->name, " "), 2) }}.
                            @else
                            {{ \Auth::user()->name }}
                            @endif


                        </a>

                        <div aria-labelledby='dropdownMenuButton' class='dropdown-menu'>
                            <div class='content-drop'>
                                <a class='dropdown-item nav-link-black' href='#'>
                                    <a class="nav-link nav-link-black" href="{{ url('/profile') }}">Perfil</a>
                                    <a class="nav-link nav-link-black" href="{{ url('/shopping/index') }}">Compras</a>

                                    <a class="nav-link nav-link-black" href="{{ url('/logout') }}">Cerrar sesión</a>
                                </a>
                            </div>
                        </div>
                    </li>

                    <!-- <li class="nav-item">
                      <a class="nav-link" href="#">{{ \Auth::user()->name }}</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="{{ url('/shopping/index') }}">Compras</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="{{ url('/logout') }}">Cerrar sesión</a>
                  </li>--->

                    @endif

                    <!-- <li class='nav-item'>
                        <a class='nav-link' data-toggle="modal" data-target="#login"><i class="flaticon-user"></i></a>
                      </li>-->
                </ul>


            </div>
        </div>
        </nav>
        @endif

        </nav>

        @yield("content")


        <!-- Modal -->
        <div id="authModal">
            <div class="modal fade" id="registerModal" id="registro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg modal_w">
                    <div class="modal-content login">
                        <div class="modal-body">
                            <button id="registerModalClose" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                            <div class="main-login main-registro">
                                <div class="main-login__item">
                                    <div class="card">
                                        <div class="title__general title__general2 fadeInUp wow animated">
                                            <p class="m-0 ml-3">Registro</p>
                                        </div>
                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Nombre y apellido</label>
                                                        <input type="text" class="form-control" v-model="name" id="name" placeholder="Pedro perez" autocomplete="off">
                                                        <i class="fa fa-user icon_form"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="email">Correo electrónico</label>
                                                        <input type="text" class="form-control" v-model="email" id="email" placeholder="pedroperez@gmail.com" autocomplete="off">
                                                        <i class="fa fa-envelope icon_form"></i>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">

                                                    <div class="form-group">
                                                        <label for="identification">Cédula</label>

                                                        <input type="text" class="form-control" v-model="identification" id="identification" @keypress="isNumber($event)" style="padding-left: 35px;">
                                                        <i class="fa fa-id-card icon_form"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">

                                                    <div class="form-group">
                                                        <label for="phone">Teléfono</label>
                                                        <input type="text" class="form-control" v-model="phone" id="phone" @keypress="isNumber($event)">
                                                        <i class="fa fa-phone icon_form"></i>
                                                    </div>

                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="address">Dirección</label>
                                                        <textarea class="form-control" rows="1" v-model="address"></textarea>
                                                        <i class="fa fa-globe icon_form"></i>
                                                    </div>

                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Contraseña</label>

                                                        <input placeholder="Contraseña" type="password" class="form-control  " id="password" v-model="password">
                                                        <i class="fa fa-lock icon_form"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">

                                                    <div class="form-group">
                                                        <label for="password_confirmation">Confirmar Contraseña</label>
                                                        <input type="password" class="form-control" v-model="password_confirmation" placeholder="Contraseña">

                                                        <i class="fa fa-lock icon_form"></i>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class=" form-group mt-4 text-center">
                                                <button class="btn btn-primary btn-custom " @click="register()">Regístrarse
                                                </button>

                                            </div>

                                            <div class="text-center">
                                                <p class="inicia">ó regístrate facil </p>
                                                {{--<a class="btn-login btn-login2 mr-2" href="{{ url('/facebook/redirect') }}">
                                                <i class="fa fa-facebook"></i> Facebook</a>--}}
                                                <a class="btn-login goo" href="{{ url('/google/redirect') }}"> <i class="fa fa-google"></i> Google</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" main-login__item bg-login">


                                    <div class="text-center">
                                        <p>¿Ya tienes cuenta?</p>
                                        <a class="txt facil" href="#" @click="openLoginModal()">Inicia sesión</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>



            <!-- modal login -->
            <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content login">
                        <div class="modal-body">
                            <button id="loginModalClose" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                            <div class="main-login">
                                <div class="main-login__item">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="title__general title__general2 fadeInUp wow animated">
                                                <p class="m-0">Inicio de sesión</p>
                                            </div>

                                            <div class="form-group">
                                                <label for="emailLogin">Correo electrónico</label>
                                                <input type="text" class="form-control" v-model="emailLogin" id="emailLogin" autocomplete="off" placeholder="pedroperez@gmail.com">

                                                <i class="fa fa-envelope icon_form"></i>
                                            </div>
                                            <div class="form-group">
                                                <label for="passwordLogin">Contraseña</label>
                                                <input type="password" class="form-control" v-model="passwordLogin" placeholder="Contraseña">

                                                <i class="fa fa-lock icon_form"></i>
                                            </div>
                                            <div class="form-group  text-lg-right">
                                                <a href="{{ url('/forgot-password') }}" class="texto">¿Has olvidado tu
                                                    contraseña?</a>
                                            </div>
                                            <div class=" form-group mt-4 text-center">
                                                <button class="btn btn-primary btn-custom " @click="login()">Ingresar</button>

                                            </div>
                                            <div class="text-center">
                                                <p class="inicia">ó inicia sesión con:</p>
                                                {{--<a class="btn-login btn-login2 mr-2" href="{{ url('/facebook/redirect') }}">
                                                <i class="fa fa-facebook"></i> Facebook</a>--}}
                                                <a class="btn-login goo" href="{{ url('/google/redirect') }}"> <i class="fa fa-google"></i> Google</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" main-login__item bg-login">
                                    <!-- <div class="mb-5 text-center">
                                    <p>¡Registrate facíl!</p>

                                </div>-->

                                    <div class="text-center">
                                        <a class="txt facil" href="#" @click="openRegisterModal()">¡Regístrate
                                            facíl!</a>
                                        <p class="mt-3">¿Aún no tienes cuenta?</p>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <footer class="container-fluid">
            <div class="main-footer">
                <div class="main-footer__item">
                    <a href="{{ url('/') }}">
                        <img class="logo_footer" src="{{ asset('assets/img/logo.png') }}" alt="">
                    </a>
                </div>
                <div class="main-footer__item">
                    <p class="ml-4 mb-2">Categorias</p>
                    <ul class='grid_footer'>
                        @foreach(App\Category::all() as $category)

                        <li class='nav-item down-md'>
                            <a href="{{ url('/category/'.$category->slug) }}" class='nav-link  nav-link '>
                                {{ $category->name }}
                            </a>

                        </li>

                        @endforeach
                        <!-- <li class='nav-item' style='color: #000 !important'>
                            <a style='color: #000 !important' href="{{ url('/cart/index') }}">Carrito</a>
                        </li>-->
                    </ul>
                </div>
                <div class="main-footer__item">
                    <p class="ml-4 mb-2">Empresa</p>
                    <ul class='grid_foote'>


                        <li class='nav-item'>
                            <a class='terminos' data-toggle="modal" data-target="#terminos">Términos y
                                condiciones</a>
                        </li>

                        <li style="list-style: none; margin-left: -20px;">
                            <div class="">
                                <img style="    width: 30%;" src="{{ asset('assets/img/logo-envia.png') }}">

                            </div>
                            <img style="    width: 80%;" src="{{ asset('assets/img/logo-pay.png') }}" alt="">
                        </li>

                    </ul>
                </div>
            </div>

            <div>
                <p class="copy mt-2 mb-2">Aromantica - Copyright 2020©
                    <a class='terminos'>Desarrollado por Ass (Apps, Services & Solutions)</a>
                </p>
            </div>
        </footer>

        <!-- modal terminos-->
        <div class="modal fade terminos-modal" id="terminos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        <div class="content_modal">
                            <strong class="mb-4">TÉRMINOS Y CONDICIONES - POLÍTICA DE
                                PRIVACIDAD</strong>
                            La presente Política de Privacidad establece los términos en que
                            Aromantica - Tavanca S.A.S. usa y protege la información que es
                            proporcionada por sus usuarios al momento de utilizar su sitio
                            web. Esta compañía está comprometida con la seguridad de los
                            datos de sus usuarios. Cuando le pedimos llenar los campos de
                            información personal con la cual usted pueda ser identificado, lo
                            hacemos asegurando que sólo se empleará de acuerdo con los
                            términos de este documento. Sin embargo esta Política de
                            Privacidad puede cambiar con el tiempo o ser actualizada por lo
                            que le recomendamos y enfatizamos revisar continuamente esta
                            página para asegurarse que está de acuerdo con dichos
                            cambios.
                            <strong class="mb-4 mt-4"> Información que es recogida</strong>
                            Nuestro sitio web podrá recoger información personal por
                            ejemplo: Nombre, información de contacto como su dirección de
                            correo electrónica e información demográfica. Así mismo cuando
                            sea necesario podrá ser requerida información específica para
                            procesar algún pedido o realizar una entrega o facturación.
                            <strong class="mb-4 mt-4"> Uso de la información recogida</strong>
                            Nuestro sitio web emplea la información con el fin de
                            proporcionar el mejor servicio posible, particularmente para
                            mantener un registro de usuarios, de pedidos en caso que
                            aplique, y mejorar nuestros productos y servicios. Es posible que
                            sean enviados correos electrónicos periódicamente a través de
                            nuestro sitio con ofertas especiales, nuevos productos y otra
                            información publicitaria que consideremos relevante para usted o
                            que pueda brindarle algún beneficio, estos correos electrónicosserán enviados a la dirección que usted proporcione y podrán ser
                            cancelados en cualquier momento.
                            Aromantica - Tavanca S.A.S. está altamente comprometido para
                            cumplir con el compromiso de mantener su información segura.
                            Usamos los sistemas más avanzados y los actualizamos
                            constantemente para asegurarnos que no exista ningún acceso
                            no autorizado.
                            <strong class="mb-4 mt-4"> Cookies (solo si aplica)</strong>
                            Una cookie se refiere a un fichero que es enviado con la finalidad
                            de solicitar permiso para almacenarse en su ordenador, al
                            aceptar dicho fichero se crea y la cookie sirve entonces para
                            tener información respecto al tráfico web, y también facilita las
                            futuras recurrente. Otra función que tienen las cookies es que con
                            ellas las web pueden reconocerte individualmente y por tanto
                            brindarte el mejor servicio personalizado de su web.
                            Nuestro sitio web emplea las cookies para poder identificar las
                            páginas que son visitadas y su frecuencia. Esta información es
                            empleada únicamente para análisis estadístico y después la
                            información se elimina de forma permanente. Usted puede
                            eliminar las cookies en cualquier momento desde su ordenador.
                            Sin embargo las cookies ayudan a proporcionar un mejor servicio
                            de los sitios web, estás no dan acceso a información de su
                            ordenador ni de usted, a menos de que usted así lo quiera y la
                            proporcione directamente. Usted puede aceptar o negar el uso de
                            cookies, sin embargo la mayoría de navegadores aceptan
                            cookies automáticamente pues sirve para tener un mejor servicio
                            web. También usted puede cambiar la configuración de su
                            ordenador
                            para declinar las cookies. Si se declinan es posible que no pueda
                            utilizar algunos de nuestros servicios.
                            <strong class="mb-4 mt-4"> Enlaces a Terceros</strong>
                            Este sitio web pudiera contener en laces a otros sitios que
                            pudieran ser de su interés. Una vez que usted de clic en estos
                            enlaces y abandone nuestra página, ya no tenemos control sobre
                            al sitio al que es redirigido y por lo tanto no somos responsables
                            de los términos o privacidad ni de la protección de sus datos en
                            esos otros sitios terceros. Dichos sitios están sujetos a sus
                            propias políticas de privacidad por lo cual es recomendable que
                            los consulte para confirmar que usted está de acuerdo con estas.
                            En este caso, los terceros como envia.com y ePayco tiene sus
                            propias políticas y garantizan todo lo relacionado a servicios de
                            shipping y pagos seguros.
                            <strong class="mb-4 mt-4"> Control de su información personal</strong>
                            En cualquier momento usted puede restringir la recopilación o el
                            uso de la información personal que es proporcionada a nuestro
                            sitio web. Cada vez que se le solicite rellenar un formulario, como
                            el de alta de usuario, puede marcar o desmarcar la opción de
                            recibir información por correo electrónico. En caso de que haya
                            marcado la opción de recibir nuestro boletín o publicidad usted
                            puede cancelarla en cualquier momento.
                            Para hacer efectivo estos cambios, por favor envíenos un email a
                            ventas@aromantica.co
                            Esta compañía no venderá, cederá ni distribuirá la información
                            personal que es recopilada sin su consentimiento, salvo que sea
                            requerido por un juez con un orden judicial.
                            Aromantica - Tavanca S.A.S. Se reserva el derecho de cambiar
                            los términos y demás puntos del presente documento en
                            cualquier momento.

                            <div class="mb-4 mt-4">
                                <strong>
                                    PROMOCIONES DE PERFUMERÍA
                                </strong><br>
                                Las promociones que se ofrezcan en nuestro sitio web NO son necesariamente las mismas que se ofrezcan en tiendas físicas, venta telefónica, catálogos u otros, a menos que se señale expresamente en este sitio o en la publicidad de cada promoción.
                                Además de los Términos y Condiciones generales, cuando<strong><strong> Aromantica – Tavanca S.A.S.</strong></strong> realice promociones en vallas publicitarias, redes sociales u otros medios publicitarios, aplican adicionalmente los siguientes Términos y Condiciones específicos:
                                <br> • Cuando se ofrezcan descuentos, se señalará en la publicidad, el porcentaje o valor del descuento, el canal de venta por el cual se puede obtener, así como la suma mínima de compra para adquirir ese descuento y y las fechas válidas.
                                <br> • Las promociones no son acumulables
                                <br> • La promoción sólo podrá ser usado una vez por cada cliente.
                                <br> • Al hacer una compra durante una promoción vigente, se entiende que el consumidor ha aceptado íntegramente los Términos y Condiciones generales y específicos de <strong>Aromantica – Tavanca S.A.S.</strong>

                                <br><br>
                                <strong> DESPACHO DE LOS PRODUCTOS</strong><br>
                                Los productos adquiridos a través de nuestro sitio web serán despachados y entregados de acuerdo a las opciones elegidas por el usuario. <strong> Envía.com logistics</strong> es la plataforma de envíos integrada con la cual trabajamos conjuntamente para ofrecer el mejor servicio. Sin embargo, para la recolección y entrega de los envíos se aplicarán estrictamente los términos y condiciones de servicios de las agencias de mensajería y paquetería (transportistas) que el usuario haya elegido durante el proceso de compra. De modo que<strong><strong> Aromantica – Tavanca S.A.S.</strong></strong> queda exento de cualquier anomalía presentada en los servicios del transportista.
                                La información del lugar de envío es de exclusiva responsabilidad del usuario. Los plazos elegidos para el despacho y entrega, se cuentan desde que se haya validado la orden de compra y el medio de pago utilizado, y se consideraran días hábiles para el cumplimiento de dicho plazo. El usuario antes de finalizar su compra podrá hacer seguimiento a la entrega estimada de su producto. <br><br>
                                <strong><strong> Aromantica – Tavanca S.A.S.</strong></strong> comunicará por e-mail a los usuarios los datos para que se pueda realizar el seguimiento del estado del envío por Internet. Si el usuario o la persona autorizada para recibir, se encontrara ausente cuando se le visita y se le notifica vía telefónica para dejar el pedido y nadie lo recibe en el lugar de residencia, con previo aviso de nuestra plataforma de envíos, se efectuará la entrega en la puerta del domicilio o en su caso en la agencia de paquetería más cercana al domicilio del destino con su respectiva notificación. Con el fin de facilitar el seguimiento de los pedidos realizados por los usuarios en nuestro sitio web,<strong><strong> Aromantica – Tavanca S.A.S.</strong></strong> podrá enviar información vía mensajes de texto (SMS y/o MMS) o vía «WhatsApp» acerca de la entrega y estado de los pedidos realizados en el sitio web.

                                <br><br>
                                <strong> POLÍTICA DE CAMBIOS, DEVOLUCIONES Y GARANTÍA DE PERFUMERÍA</strong><br>
                                <strong>
                                    1. GARANTÍA DE PRODUCTOS DE PERFUMERÍA:
                                </strong>
                                <strong> Aromantica – Tavanca S.A.S.</strong> ofrece garantía sobre los productos vendidos en nuestra tienda que no cumplan con las condiciones de calidad ofrecidas por el fabricante. En consecuencia, el cliente tendrá derecho a solicitar garantía sobre fragancias en los siguientes casos:
                                <br> • Alteraciones en el color de la fragancia
                                <br> • Fragancia vacía
                                <br> • Filtración
                                <br> • Oxidación
                                <br> • Daño Válvula Dosificadora
                                <br> • Presencia de alguna partícula de impureza en su contenido u hongos.
                                <br><br>
                                El cliente deberá devolver el producto que fue adquirido, en su empaque original en buen estado y sin uso adicional al primero, informando los defectos que presenta. El cliente deberá o acreditar que el producto fue adquirido en las tiendas<strong> Aromantica – Tavanca S.A.S.</strong> El término de la garantía sobre los productos de perfumería es de TREINTA (30) días hábiles contados a partir de la fecha de compra. No será procedente la solicitud de efectividad de la garantía en caso en que el daño en el producto sea consecuencia del uso indebido del mismo, por el hecho de un tercero ajeno a<strong> Aromantica – Tavanca S.A.S.</strong> o al fabricante, así como en los demás casos previstos en la ley. Toda solicitud de garantía deberá ser presentada dentro del término de vigencia y cumpliendo con las condiciones aquí establecidas y serán analizadas y evaluadas por el área de servicio al cliente y el consultor de la marca según el caso quienes determinarán si se accede o no a la garantía para lo cual contarán con un plazo no mayor a 15 días hábiles. En caso de improcedencia de la garantía se informará al consumidor los motivos de la decisión. El plazo para la entrega del producto de reemplazo será de 10 días hábiles dependiendo de la disponibilidad de inventario en la tienda. De ser necesario<strong> Aromantica – Tavanca S.A.S.</strong> podrá informarle al consumidor si requiere un plazo adicional. La entrega del producto de reemplazo se realizará previo aviso y acuerdo de<strong> Aromantica – Tavanca S.A.S.</strong> con el cliente y según se determine. <br><br>
                                <strong>Reclamación de garantía por efectos de fijación:</strong> los productos de uso personal como perfumería, no tienen la misma fijación en la piel en todas las personas, ya que, por efectos únicos del comportamiento corporal, la reacción de durabilidad es diferente. La fijación del producto depende entre otras del tipo de piel, las condiciones climáticas, el nivel de PH, los medicamentos que se estén consumiendo, cambios hormonales o de alimentación. Por lo anterior, no procede reclamación alguna de garantía por efectos de fijación del producto. <br><br>

                                <strong>
                                    2. CAMBIOS NO RELACIONADOS CON LA GARANTÍA
                                </strong> <br>
                                Por aspectos no relacionados con la garantía del producto, Aromantica – Tavanca S.A.S podrá, bajo su propia voluntad, criterio y decisión, aceptar el cambio del producto para lo cual se deberán tener en cuenta las siguientes condiciones:
                                <br> • El producto debe estar en las condiciones que se recibió, con su empaque original, con las etiquetas, sellos de seguridad, y contar con todas sus partes y/o accesorios. No podrá presentar abolladuras, rayones, roturas, manchas, fallas de funcionamiento diferentes a defectos de producto o de fabricación. Si tiene celofán debe estar en perfecto estado, apto para su posterior venta
                                <br> • No se aceptan solicitudes de reembolso de dinero
                                <br> • Los productos que presenten daño por mala manipulación del cliente no tendrán cambio
                                <br> • No se realizan cambios de fragancias por gusto del cliente, o por fijación del mismo
                                <br> • No se aceptan cambios de productos en promoción y/o estuchería (con excepción de reclamaciones por garantía). El cliente deberá devolver todos los productos contenidos en la oferta, involucrando obsequios y miniaturas, en caso que se hubieran entregado al momento de la venta
                                <br> • En caso de aceptarse el cambio, el cliente tendrá derecho a uno de iguales características y de igual valor. En caso de solicitar un producto de mayor valor, deberá cancelar la diferencia entre el precio cancelado y el precio de venta del nuevo producto
                                <br> • Las solicitudes de cambio deberán presentarse como plazo máximo dentro de los 5 días posteriores a la venta y en cualquier caso están sometidos a la decisión discrecional del personal de<strong> Aromantica – Tavanca S.A.S.</strong>

                                <br><br>
                                <strong> 3. DERECHO DE RETRACTO PARA COMPRAS POR INTERNET </strong> <br>
                                En aplicación del artículo 47 de la ley 1480 de 2011, los consumidores que adquieran cualquier producto a través de nuestra página web https://aromantica.co tienen derecho al retracto, dentro de los CINCO (5) días hábiles siguientes a la fecha de recibo del producto. Para ejercer el derecho de retracto, el cliente podrá solicitar en el término previamente indicado, su solicitud de devolución del dinero, mediante envío por correo electrónico a la dirección ventas@aromantica.co info@elmejorperfume.com, un escrito con el asunto “DERECHO DE RETRACTO” identificando en el cuerpo del correo, sus datos, el producto adquirido, la fecha de su recepción.
                                El dinero será reembolsado en un plazo no mayor a TREINTA (30) días calendario desde la fecha en que se presentó la solicitud. La devolución del dinero se realizará de la siguiente manera: En caso de compras realizadas con tarjeta de crédito o en caso de pagos por medio de PSE se realizará el reembolso a la misma tarjeta de crédito o débito con la que se realizó la compra. El cliente deberá devolver a<strong> Aromantica – Tavanca S.A.S.</strong> el producto adquirido el cual debe estar en las mismas condiciones en que lo recibió, esto es, en perfecto estado, con su empaque completo con todos sus sellos, celofán en estado original y sin uso o rupturas. El producto deberá ser enviado por el cliente a las oficinas de<strong> Aromantica – Tavanca S.A.S.</strong> para lo cual se indicará la dirección correspondiente. Los costos del transporte para la entrega del producto correrán a cargo del consumidor.









                            </div>






















                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade newletter" id="new" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content">
                    <div class="modal-body bg-new" style="background-image: url('assets/img/newletter.jpg');">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                        <div class="newl-content">
                            <!---<span>Regala personalidad</span>-->
                            <h2>Suscríbete a nuestro <br> newsletter </h2>
                            <form @submit.prevent="store()">
                                <div class="grid-new">
                                    <div class="">
                                        <div class="form-group"><label for="emailLogin">Correo electrónico</label> <input type="text" autocomplete="off" placeholder="Email" class="form-control" v-model="email"> <i class="fa fa-envelope icon_form"></i></div>
                                    </div>
                                    <div class="">

                                        <button class="btn btn-custom">SUSCRIBIR</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
        </script>
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/slick.min.js') }}"></script>
        <script src="{{ asset('assets/js/setting-slick.js') }}"></script>
        <script src="{{ asset('assets/js/wow.min.js') }}"></script>
        <script src="{{ asset('assets/js/wow-settings.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <script src="{{ asset('/js/app.js') }}"></script>
        <script src="{{ asset('alertify/alertify.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/jquery.mixitup/latest/jquery.mixitup.min.js?v=2.1.2"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script>
            $(document).ready(function($) {
                $(".newletter").modal("show");
            });
        </script>
        <script>
            alertify.set('notifier', 'position', 'top-right');
        </script>

        <script>
            const cartPreview = new Vue({
                el: "#cartPreview",
                data() {
                    return {
                        authCheck: "{{ Auth::check() }}",
                        products: [],
                        guestProducts: [],
                        total: 0
                    }
                },
                methods: {
                    cartFetch() {

                        axios.get("{{ url('/cart/fetch') }}")
                            .then(res => {

                                if (res.data.success == true) {


                                    this.products = res.data.products
                                    this.total = 0;
                                    this.products.forEach((data, index) => {

                                        this.total = this.total + (data.amount * data.price)


                                    })

                                }

                            })

                    },
                    guestFetch() {

                        let cart = []
                        if (window.localStorage.getItem('cartAromantica') != null) {
                            cart = JSON.parse(window.localStorage.getItem('cartAromantica'))
                        }

                        axios.post("{{ url('/cart/guest/fetch') }}", {
                            cart: cart
                        }).then(res => {

                            if (res.data.success == true) {
                                this.guestProducts = res.data.guestProducts

                                this.guestProducts.forEach((data, index) => {

                                    this.total = this.total + (parseInt(data.product.price) * parseInt(data.amount))



                                })

                            } else {
                                //alertify.error(res.data.msg)
                            }

                        })

                    }
                },
                mounted() {

                    if (this.authCheck == "1") {
                        this.cartFetch()
                    }

                    this.guestFetch()

                    window.setInterval(() => {

                        if (window.localStorage.getItem("executeCartPreview") == "1") {
                            this.total = 0;
                            if (this.authCheck == "1") {
                                this.cartFetch()
                            }

                            this.guestFetch()

                            window.localStorage.removeItem("executeCartPreview")
                        }

                    }, 1000)

                }

            })

            const newsLetter = new Vue({
                el: "#new",
                data() {
                    return {
                        email:""
                    }
                },
                methods: {
                    store(){

                        axios.post("{{ url('/newsletter') }}", {
                                email: this.email,
                            }).then(res => {

                                if (res.data.success == true) {
                                    swal({
                                        title: "Excelente!",
                                        text: res.data.msg,
                                        icon: "success"
                                    });
                    
                                    this.email = ""
                                    $(".newletter").modal("hide");
    
                                } else {
                                    alertify.error(res.data.msg)
                                }

                            })
                            .catch(err => {
                                $.each(err.response.data.errors, function(key, value) {
                                    alertify.error(value[0])
                                });
                            })

                    }
                },

            })


            const navbar = new Vue({
                el: '#authModal',
                data() {
                    return {
                        name: "",
                        email: "",
                        password: "",
                        password_confirmation: "",
                        phone: "",
                        identification: "",
                        address: "",
                        emailLogin: "",
                        passwordLogin: "",
                        products: [],
                        guesProducts: [],
                        authCheck: "{{ Auth::check() }}",
                        total: 0,
                        url: "{{ url('/') }}"
                    }
                },
                methods: {

                    isNumber: function(evt) {
                        evt = (evt) ? evt : window.event;
                        var charCode = (evt.which) ? evt.which : evt.keyCode;
                        if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                            evt.preventDefault();;
                        } else {
                            return true;
                        }
                    },
                    register() {

                        axios.post("{{ url('/register') }}", {
                                name: this.name,
                                email: this.email,
                                password: this.password,
                                password_confirmation: this.password_confirmation,
                                phone: this.phone,
                                identification: this.identification,
                                address: this.address
                            }).then(res => {

                                if (res.data.success == true) {
                                    swal({
                                        title: "Excelente!",
                                        text: res.data.msg,
                                        icon: "success"
                                    });
                                    this.name = ""
                                    this.email = ""
                                    this.password = ""
                                    this.password_confirmation = ""
                                    this.phone = ""
                                    this.identification = ""
                                    this.address = ""
                                } else {
                                    alertify.error(res.data.msg)
                                }

                            })
                            .catch(err => {
                                $.each(err.response.data.errors, function(key, value) {
                                    alertify.error(value[0])
                                    //alertify.error(value);
                                    //alertify.alert('Basic: true').set('basic', true);
                                });
                            })

                    },
                    openRegisterModal() {

                        $("#loginModalClose").click();
                        $('body').removeClass('modal-open');
                        $('body').css('padding-right', '0px');
                        $('.modal-backdrop').remove();

                        $("#openRegisterModal").click()

                    },
                    openLoginModal() {

                        $("#registerModalClose").click();
                        $('body').removeClass('modal-open');
                        $('body').css('padding-right', '0px');
                        $('.modal-backdrop').remove();

                        $("#openLoginModal").click()

                    },
                    login() {

                        axios.post("{{ url('/login') }}", {
                                email: this.emailLogin,
                                password: this.passwordLogin
                            })
                            .then(res => {

                                if (res.data.success == true) {

                                    swal({
                                        title: "Excelente!",
                                        text: res.data.msg,
                                        icon: "success"
                                    }).then(() => {
                                        window.location.href = "{{ url('/') }}"
                                    });
                                    this.cartInfo()


                                } else {
                                    alertify.error(res.data.msg)
                                }
                            })


                    },
                    async cartInfo() {
                        var totalGuest = 0;
                        var totalCheck = 0;

                        let cart = []
                        if (window.localStorage.getItem('cartAromantica') != null) {
                            cart = JSON.parse(window.localStorage.getItem('cartAromantica'))
                        }

                        cart.forEach((data, index) => {

                            totalGuest = data.amount + totalGuest

                        })

                        let cartTotal = totalGuest + totalCheck
                        $("#cart-notification").html(cartTotal + "")

                        if (this.authCheck == "1") {

                            

                            let cart = []
                            if (window.localStorage.getItem('cartAromantica') != null) {
                                cart = JSON.parse(window.localStorage.getItem('cartAromantica'))
                            }

                            var _this = this
                            for(var i = 0; i< cart.length; i++){

                                await _this.addToCart(cart[i].productTypeSizeId, cart[i].amount)

                            }
                            
                            window.localStorage.removeItem("cartAromantica")

                            axios.get("{{ url('/cart/fetch') }}")
                            .then(res => {

                                if (res.data.success == true) {

                                    this.products = res.data.products

                                    this.products.forEach((data, index) => {

                                        totalCheck = totalCheck + data.amount

                                    })

                                    let cartTotalCheck = totalGuest + totalCheck
                                    
                                    $("#cart-notification").html(cartTotalCheck + "")

                                }

                            })

                        }


                    },
                    async addToCart(productTypeSizeId, amount) {


                        if (this.authCheck == "1") {

                            let res = await axios.post("{{ url('/cart/store') }}", {
                                    productTypeSizeId: productTypeSizeId,
                                    amount: amount
                                })

                        }



                    },

                },
                
                mounted() {

                    this.cartInfo()

                }

            })

            const search = new Vue({
                el: '#search',
                data() {
                    return {
                        type: "",
                        size: "",
                        searchText: "",
                        brandTitles: [],
                        productTitles: [],
                    }
                },
                methods: {

                    selectType(type) {

                        this.type = JSON.parse(type)
                    },
                    selectSize(size) {
                        this.size = JSON.parse(size)
                    },
                    setText(string) {

                        this.searchText = string
                        this.search()
                        this.lookFor()

                    },
                    lookFor() {
                        if (this.searchText != "" || this.type != "" || this.size != "") {
                            localStorage.setItem("searchAromantica", this.searchText)
                            //if (this.type != "") {
                            if (this.type != "") {
                                localStorage.setItem("typeAromantica", this.type.id)
                            } else {
                                localStorage.setItem("typeAromantica", "")
                            }

                            //}
                            if (this.size != "") {
                                localStorage.setItem("sizeAromantica", this.size.id)
                            } else {
                                localStorage.setItem("sizeAromantica", "")
                            }
                            window.location.href = "{{ url('/search') }}"
                        }
                    },
                    search() {

                        if (this.searchText != "") {
                            axios.post("{{ url('/words') }}", {
                                search: this.searchText
                            }).then(res => {

                                if (res.data.success == true) {

                                    this.brandTitles = res.data.brandTitles
                                    this.productTitles = res.data.productTitles

                                }

                            })
                        }

                    }

                },
                mounted() {

                    if ("{{ url()->current() }}" == "{{ url('/search') }}")
                        this.searchText = localStorage.getItem("searchAromantica")

                }

            })
        </script>

        @stack("scripts")

</body>

</html>
