<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

        <title>Hello, world!</title>
    </head>
    <body>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">

                    @if(\Auth::guest())
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#registerModal">Register</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Login</a>
                        </li>
                    @else

                        <li class="nav-item">
                            <a class="nav-link" href="#">{{ \Auth::user()->name }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/shopping/index') }}">Compras</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/logout') }}">Cerrar sesión</a>
                        </li>

                    @endif

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/cart/index') }}">Carrito</a>
                    </li>
                
                
                </ul>
            </div>
        </nav>

        @yield("content")


        <!-- Modal -->
        <div id="authModal">

            <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Registro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" v-model="name" id="name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" v-model="email" id="email">
                        </div>
                        <div class="form-group">
                            <label for="identification">Cédula</label>
                            <input type="text" class="form-control" v-model="identification" id="identification">
                        </div>
                        <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input type="text" class="form-control" v-model="phone" id="phone">
                        </div>
                        <div class="form-group">
                            <label for="address">Dirección</label>
                            <textarea class="form-control" rows="5" v-model="address"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="password">Clave</label>
                            <input type="password" class="form-control" v-model="password">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Clave</label>
                            <input type="password" class="form-control" v-model="password_confirmation">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="register()">Registrarse</button>
                    </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="emailLogin">Email</label>
                            <input type="text" class="form-control" v-model="emailLogin" id="emailLogin">
                        </div>
                        
                        <div class="form-group">
                            <label for="passwordLogin">Clave</label>
                            <input type="password" class="form-control" v-model="passwordLogin">
                        </div>

                        <a href="{{ url('/google/redirect') }}" class="btn btn-primary">Login With Google</a>
                        <a href="{{ url('/facebook/redirect') }}" class="btn btn-primary">Login With Facebook</a>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="login()">Login</button>
                    </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <script src="{{ asset('/js/app.js') }}"></script>

        <script>
        const navbar = new Vue({
            el: '#authModal',
            data(){
                return{
                    name:"",
                    email:"",
                    password:"",
                    password_confirmation:"",
                    phone:"",
                    identification:"",
                    address:"",
                    emailLogin:"",
                    passwordLogin:""
                }
            },
            methods:{
                
                register(){

                    axios.post("{{ url('/register') }}", {name: this.name, email:this.email, password: this.password, password_confirmation: this.password_confirmation, phone: this.phone, identification: this.identification, address: this.address}).then(res => {

                        if(res.data.success == true){
                            alert(res.data.msg)
                            this.name = ""
                            this.email = ""
                            this.password = ""
                            this.password_confirmation = ""
                            this.phone = ""
                            this.identification = ""
                            this.address = ""
                        }else{
                            alert(res.data.msg)
                        }

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value) {
                            alert(value)
                            //alertify.error(value);
                            //alertify.alert('Basic: true').set('basic', true); 
                        });
                    })

                },
                login(){

                    axios.post("{{ url('/login') }}", {email: this.emailLogin, password: this.passwordLogin})
                    .then(res => {

                        if(res.data.success == true){
                            alert(res.data.msg)
                            window.location.href="{{ url('/') }}"
                        }else{
                            alert(res.data.msg)
                        }

                    })

                }

            }

        })
    </script>

    @stack("scripts")

    </body>
</html>