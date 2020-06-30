@extends("layouts.index")

@section("content")

    <div class="container" id="dev-area">
        <section class="container">
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="carrito">
                        <div class="title__general text-justify">
                            <h2>Mi carrito</h2>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td>Producto</td>
                                            <td>Precio</td>
                                            <td>Cantidad</td>
                                            <td>Total</td>
                                            <td>Acciones</td>
    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="product in products">
                                            <td class="text-center w-150">@{{ product.product_type_size.product.name }} - @{{ product.product_type_size.type.name }} - @{{ product.product_type_size.size.name }} Oz
                                            </td>

                                           <!--- <td class="text-center w-150">
                                                <img src="assets/img/productos/perfume1.png" alt="">
                                                <p>CH MEN PRIVÉ</p>
                                            </td>-->
                                            <td>
                                                <span>$ @{{ parseFloat(product.product_type_size.price) * parseInt(product.amount) }}</span>
    
                                            </td>
                                            <td>@{{ product.amount }}</td>
                                              <td></td>
                                            <td class="text-center"><div class="btn "><p class="delete" href=""><span>x</span></p></div></td>
                                      
    
    
                                        </tr>
                                    </tbody>
                                </table>
    
                            </div>
                            <div class="col-md-4">
                                <div class="pedido">
    
                                    <h5>Total de tu compra</h5>
                            
                                    <p class="space">Total: <span>$ 79.000</span> </p>
                                    <p class="space">Subtotal: <span>$ 79.000</span> </p>
    
                                 <div class="text-center">
                                    <a href=""><button class="btn-custom">Finalizar compra ></button></a>
                                 </div>
    
                                </div>
                            </div>
                        </div>
                    </div>
    
                </div>
    
    
            </div>
        </section>




<!--        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products">
                            <td>@{{ product.product_type_size.product.name }} - @{{ product.product_type_size.type.name }} - @{{ product.product_type_size.size.name }} Oz</td>
                            <td>@{{ product.amount }}</td>
                            <td>$ @{{ parseFloat(product.product_type_size.price) * parseInt(product.amount) }}</td>
                            <td><button class="btn btn-danger">delete</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>-->
    </div>

@endsection

@push("scripts")

    <script>
        
        const devArea = new Vue({
            el: '#dev-area',
            data(){
                return{
                    authCheck:"{{ \Auth::check() }}",
                    products:""
                }
            },
            methods:{
                
                fetch(){

                    axios.get("{{ url('/cart/fetch') }}")
                    .then(res => {

                        if(res.data.success == true){
                           
                            this.products = res.data.products

                        }

                    })

                },
                erase(id){

                    axios.post("{{ url('/cart/delete') }}", {id:id})
                    .then(res => {

                        if(res.data.success == true){
                            
                            this.fetch()

                        }

                    })

                }

            },
            mounted(){

                if(this.authCheck){
                    this.fetch()
                }

            }

        })

    </script>

@endpush