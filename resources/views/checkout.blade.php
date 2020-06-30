@extends("layouts.index")

@section("content")

    <div class="container" id="dev-area">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center">Checkout</h3>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" v-model="name" id="name" :readonly="readonly">
                </div>
            </div>
            <div class="col-md-6">

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" v-model="email" id="email" :readonly="readonly">
                </div>

            </div>
            <div class="col-md-6">

                <div class="form-group">
                    <label for="phone">Teléfono</label>
                    <input type="text" class="form-control" v-model="phone" id="phone">
                </div>

            </div>
            <div class="col-md-6">

                <div class="form-group">
                    <label for="identification">Cédula</label>
                    <input type="text" class="form-control" v-model="identification" id="identification">
                </div>

            </div>
            <div class="col-md-6">

                <div class="form-group">
                    <label for="dirección">Dirección</label>
                    <input type="text" class="form-control" v-model="address" id="dirección">
                </div>

            </div>
            <div class="col-md-6">

                <div class="form-group">
                    <label>Total: @{{ total }}</label>
                </div>

            </div>

            <div class="col-md-12">
                <button class="btn btn-success" @click="payment()">Pagar</button>
            </div>


        </div>
    </div>

@endsection

@push("scripts")

    <script>

        const devArea = new Vue({
            el: '#dev-area',
            data(){
                return{
                    name:"{{ Auth::check() ? Auth::user()->name : '' }}",
                    email:"{{ Auth::check() ? Auth::user()->email : '' }}",
                    identification:"{{ Auth::check() ? Auth::user()->identification : '' }}",
                    address:"{{ Auth::check() ? Auth::user()->address : '' }}",
                    phone:"{{ Auth::check() ? Auth::user()->phone : '' }}",
                    readonly:"{!! Auth::check() ? true : false !!}",
                    total:0
                }
            },
            methods:{
                
                fetch(){

                    axios.get("{{ url('/cart/fetch') }}")
                    .then(res => {

                        if(res.data.success == true){

                            res.data.products.forEach((data, index) => {

                                this.total = this.total + (data.amount * data.product_type_size.price)

                            })

                        }

                    })

                },
                guestFetch(){

                    let cart = []
                    if(window.localStorage.getItem('cartAromantica') != null){
                        cart =JSON.parse(window.localStorage.getItem('cartAromantica'))
                    }

                    axios.post("{{ url('/cart/guest/fetch') }}", {cart: cart}).then(res => {

                        if(res.data.success == true){

                            res.data.guestProducts.forEach((data, index) => {

                                this.total = this.total + (parseFloat(data.product.price) * parseInt(data.amount))

                            })

                        }else{
                            alert(res.data.msg)
                        }

                    })

                },
                payment(){



                }

            },
            mounted(){

                this.fetch()
                this.guestFetch()

            }

        })

    </script>

@endpush