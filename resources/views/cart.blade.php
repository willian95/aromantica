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
                                            <td class="text-center">Producto</td>
                                            <td class="text-center">Precio</td>
                                            <td class="text-center">Cantidad</td>
                                            <td class="text-center">Total</td>
                                            <td class="text-center">Acciones</td>
    
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
                                            <td class="text-center">
                                                <span>$ @{{ parseFloat(product.product_type_size.price) * parseInt(product.amount) }}</span>
    
                                            </td>
                                            <td class="text-center">@{{ product.amount }}</td>
                                            <td></td>
                                            <td class="text-center"><div class="btn "><p class="delete" href="#" @click="erase(product.id)"><span>x</span></p></div></td>
                                      
    
    
                                        </tr>
                                        <tr v-for="(product, index) in guestProducts">
                                            <td class="text-center w-150">@{{ product.product.product.name }} - @{{ product.product.type.name }} - @{{ product.product.size.name }} Oz</td>
                                            <td class="text-center">@{{ product.amount }}</td>
                                            <td class="text-center">$ @{{ parseFloat(product.product.price) }}</td>
                                            <td class="text-center">$ @{{ parseFloat(product.product.price) * parseInt(product.amount) }}</td>
                                            <td class="text-center"><div class="btn "><p class="delete" href="#" @click="guestDelete(index)"><span>x</span></p></div></td>
                                        </tr>

                                    </tbody>
                                </table>
    
                            </div>
                            <div class="col-md-4">
                                <div class="pedido">
    
                                    <h5>Total de tu compra</h5>
                            
                                    <p class="space">Total: <span>$@{{ total }}</span> </p>
                                    <p class="space">Subtotal: <span>$@{{ total }}</span> </p>
    
                                 <div class="text-center">
                                    <a href="{{ url('/checkout') }}"><button class="btn-custom">Finalizar compra ></button></a>
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
                            <th>Sub-total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products">
                            <td>@{{ product.product_type_size.product.name }} - @{{ product.product_type_size.type.name }} - @{{ product.product_type_size.size.name }} Oz</td>
                            <td>@{{ product.amount }}</td>
                            <td>@{{ parseFloat(product.product_type_size.price) }}</td>
                            <td>$ @{{ parseFloat(product.product_type_size.price) * parseInt(product.amount) }}</td>
                            <td><button class="btn btn-danger" @click="erase(product.id)">delete</button></td>
                        </tr>
                        <tr v-for="(product, index) in guestProducts">
                            <td>@{{ product.product.product.name }} - @{{ product.product.type.name }} - @{{ product.product.size.name }} Oz</td>
                            <td>@{{ product.amount }}</td>
                            <td>$ @{{ parseFloat(product.product.price) }}</td>
                            <td>$ @{{ parseFloat(product.product.price) * parseInt(product.amount) }}</td>
                            <td><button class="btn btn-danger" @click="guestDelete(index)">delete</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>-->
        </div>
       <!-- <div class="row">
            <div class="col-12">
                <h3>Total: @{{ total }}</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="{{ url('/checkout') }}" class="btn btn-success">Pagar</a>
            </div>
        </div>--->
    </div>

@endsection

@push("scripts")

    <script>
        
        const devArea = new Vue({
            el: '#dev-area',
            data(){
                return{
                    authCheck:"{{ \Auth::check() }}",
                    guestProducts:"",
                    products:"",
                    total:0
                }
            },
            methods:{
                
                fetch(){

                    axios.get("{{ url('/cart/fetch') }}")
                    .then(res => {

                        if(res.data.success == true){
                            
                            
                            this.products = res.data.products

                            this.products.forEach((data, index) => {

                                this.total = this.total + (data.amount * data.product_type_size.price)

                            })

                        }

                    })

                },
                erase(id){
                    
                    axios.post("{{ url('/cart/delete') }}", {id:id})
                    .then(res => {

                        if(res.data.success == true){
                            
                            this.total = 0
                            this.fetch()
                            this.guestFetch()

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
                            console.log("test-guestProducts", res.data.guestProducts)
                            this.guestProducts = res.data.guestProducts

                            this.guestProducts.forEach((data, index) => {

                                this.total = this.total + (parseFloat(data.product.price) * parseInt(data.amount))

                            })

                        }else{
                            alert(res.data.msg)
                        }

                    })

                },
                guestDelete(cartIndex){

                    if(window.localStorage.getItem('cartAromantica') != null){
                        cart =JSON.parse(window.localStorage.getItem('cartAromantica'))
                    }



                    cart.forEach((data, index)=>{
                        console.log("test-index", index)
                        if(index == cartIndex){
                            cart.splice(index, 1)
                        }
                    })

                    window.localStorage.setItem("cartAromantica", JSON.stringify(cart))
                    this.total = 0
                    this.guestFetch()
                    if(this.authCheck){
                        this.fetch()
                    }

                }

            },
            mounted(){

                if(this.authCheck){
                    this.fetch()
                }

                this.guestFetch()

            }

        })

    </script>

@endpush