@extends("layouts.index")

@section("content")

<div class="p-50" id="dev-area">
    <section class="container" v-cloak>
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
                                        @if(\Auth::check())
                                            <td class="text-center">Descuento</td>
                                        @endif
                                        <td class="text-center">Eliminar</td>

                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <tr v-for="(product, index) in products">
                                        <td class="text-center w-150 text-center">
                                            <img :src="'{{ env('CMS_URL') }}'+'/images/products/'+product.product_type_size.product.image"
                                                alt="" style="width: 100%">
                                            @{{ product.product_type_size.product.name }} -
                                            @{{ product.product_type_size.type.name }} -
                                            @{{ product.product_type_size.size.name }} Oz
                                            
                                        </td>

                                        <!--- <td class="text-center w-150">
                                                <img src="assets/img/productos/perfume1.png" alt="">
                                                <p>CH MEN PRIVÉ</p>
                                            </td>-->
                                        <td class="text-center">
                                            <div>
                                                <span>$ @{{ parseInt(product.price).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</span>
    
                                            </div>
                                        </td>
                                        <td class="text-center ">
                                            <div style="    text-align: center;
                                                display: flex;
                                                justify-content: center;">
                                                <div class="cantidad_btn" style="width: 55%;">
                                                    <button class="btn btn-success p-0 "
                                                        @click="substractAmountProduct(product, index)">-</button>
                                                    @{{ product.amount }} <button class="btn btn-success p-0"
                                                        @click="addAmountProduct(product, index)">+</button>
                                        </td>

                                            </div>
                                        </div>

                                        <td class="text-center">$
                                            @{{ parseInt(parseFloat(product.price) * parseInt(product.amount)).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Código de descuento" :id="'cart-discount'+index">
                                            </div>
                                            <button class="btn btn-primary" @click="setCodeSingleProduct(product.product_type_size, index, false)">Aplicar</button>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn ">
                                                <p class="delete" href="#" @click="erase(product.id)"><span>x</span></p>
                                            </div>
                                        </td>



                                    </tr>
                    <tr v-for="(product, index) in guestProducts">
                        <td class="text-center w-150"><img
                                :src="'{{ env('CMS_URL') }}'+'/images/products/'+product.product.product.image" alt=""
                                style="width: 100%">@{{ product.product.product.name }} -
                            @{{ product.product.type.name }} - @{{ product.product.size.name }} Oz</td>
                        <td class="text-center">$ @{{ parseInt(product.product.price).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</td>
                        <td class="text-center">
                            <div style="    text-align: center;
                                                display: flex;
                                                justify-content: center;">

                                <div class=" cantidad_btn" style="width: 55%;">
                                    <button class="btn btn-success p-0"
                                        @click="substractAmountGuestProduct(index)">-</button> @{{ product.amount }}
                                    <button class="btn btn-success p-0" @click="addAmountGuestProduct(index)">+</button>
                                </div>
                        </td>
                </div>



                <td class="text-center">$
                    @{{ parseInt(parseFloat(product.product.price) * parseInt(product.amount)).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}
                </td>
                @if(\Auth::check())
                    <td>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Código de descuento" :id="'cart-discount-guest'+index">
                        </div>
                        <button class="btn btn-primary" @click="setCodeSingleProduct(product.product_type_size, index, true)">Aplicar</button>
                    </td>
                @endif
                <td class="text-center">
                    <div class="btn ">
                        <p class="delete" href="#" @click="guestDelete(index)"><span>x</span></p>
                    </div>
                </td>
                </tr>

                </tbody>
                </table>

            </div>
            <div class="col-md-4">
                <div class="pedido">

                    <h5>Total de tu compra</h5>

                    <p class="space">Total:
                        <span>$@{{ parseInt(total).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</span> </p>
                    <!--<p class="space">Subtotal: <span>$@{{ parseInt(total).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</span> </p>-->

                    <div class="text-center">
                        <a href="{{ url('/checkout') }}"><button class="btn-custom">Finalizar compra ></button></a>
                    </div>

                </div>

                @if(\Auth::check())
                    <div class="row">
                        <div class="col-12">
                            <div class="pedido">

                                <h5>Descuento</h5>

                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Código de descuento" id="fullcart">
                                </div>

                                <div class="text-center">
                                    <button @click="fullCartDiscount()" class="btn-custom">Aplicar descuento ></button>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif

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
    data() {
        return {
            authCheck: "{{ \Auth::check() }}",
            guestProducts: "",
            products: "",
            total: 0
        }
    },
    methods: {

        setCodeSingleProduct(productTypeSizeId, index, isGuest){

            let code = ""
            if(isGuest){

                code = $("#cart-discount-guest"+index).val()
                $("#cart-discount-guest"+index).val("")

            }else{

                code = $("#cart-discount"+index).val()
                $("#cart-discount"+index).val("")

            }

            axios.post("{{ url('/cart/single-product/discount') }}", {"productTypeSizeId": productTypeSizeId, "coupon": code})
            .then(res => {

                if(res.data.success == true){

                    swal({
                        text:res.data.msg,
                        icon:"success"
                    }).then(ans =>{
                        this.fetch()
                    })

                   
                }else{

                    swal({
                        text:res.data.msg,
                        icon:"error"
                    })

                }

            }).catch(err => {
                $.each(err.response.data.errors, function(key, value) {
                    alertify.error(value[0])
                    //alertify.error(value);
                    //alertify.alert('Basic: true').set('basic', true); 
                });
            })

        },
        fullCartDiscount(){
            let code = $("#fullcart").val()
            axios.post("{{ url('/cart/full-cart/discount') }}", {"coupon": code})
            .then(res => {

                if(res.data.success == true){

                    swal({
                        text:res.data.msg,
                        icon:"success"
                    }).then(ans =>{
                        this.fetch()
                        $("#fullcart").val("")
                    })


                }else{

                    swal({
                        text:res.data.msg,
                        icon:"error"
                    })

                }

            }).catch(err => {
                $.each(err.response.data.errors, function(key, value) {
                    alertify.error(value[0])
                });
            })

        },

        addAmountProduct(product, index) {

            if (this.products[index].amount + 1 <= this.products[index].product_type_size.stock) {
                this.products[index].amount++
                this.updateCartAmount(this.products[index].product_type_size.id, this.products[index].amount)
                this.cartInfo()
            }

        },
        substractAmountProduct(product, index) {
            if (this.products[index].amount - 1 > 0) {
                this.products[index].amount--
                this.updateCartAmount(this.products[index].product_type_size.id, this.products[index].amount)
                this.cartInfo()
            }
        },
        addAmountGuestProduct(index) {
            if (this.guestProducts[index].amount + 1 <= this.guestProducts[index].product.stock) {

                this.guestProducts[index].amount++

                if (window.localStorage.getItem('cartAromantica') != null) {
                    cart = JSON.parse(window.localStorage.getItem('cartAromantica'))
                }

                cart.forEach((data) => {

                    if (data.productTypeSizeId == this.guestProducts[index].product.id) {
                        data.amount = this.guestProducts[index].amount
                        exists = true
                    }

                })

                window.localStorage.setItem("cartAromantica", JSON.stringify(cart))

                this.total = 0
                this.fetch()
                this.guestFetch()
                this.cartInfo()
            }

        },
        substractAmountGuestProduct(index) {
            if (this.guestProducts[index].amount - 1 > 0) {

                this.guestProducts[index].amount--

                if (window.localStorage.getItem('cartAromantica') != null) {
                    cart = JSON.parse(window.localStorage.getItem('cartAromantica'))
                }

                cart.forEach((data) => {

                    if (data.productTypeSizeId == this.guestProducts[index].product.id) {
                        data.amount = this.guestProducts[index].amount
                        exists = true
                    }

                })

                window.localStorage.setItem("cartAromantica", JSON.stringify(cart))

                this.total = 0
                this.fetch()
                this.guestFetch()
                this.cartInfo()
            }
        },
        fetch() {
            this.total = 0
            axios.get("{{ url('/cart/fetch') }}")
                .then(res => {

                    if (res.data.success == true) {


                        this.products = res.data.products

                        this.products.forEach((data, index) => {


                       
                            this.total = this.total + (data.amount * data.price)
                            
                            

                        })

                        this.cartInfo()

                    }

                })

        },
        cartInfo() {
            var totalGuest = 0;
            var totalCheck = 0;

            let cart = []
            if (window.localStorage.getItem('cartAromantica') != null) {
                cart = JSON.parse(window.localStorage.getItem('cartAromantica'))
            }

            cart.forEach((data, index) => {

                totalGuest = data.amount + totalGuest

            })

            if (this.authCheck == "1") {

                axios.get("{{ url('/cart/fetch') }}")
                    .then(res => {

                        if (res.data.success == true) {

                            this.products = res.data.products

                            this.products.forEach((data, index) => {

                                totalCheck = totalCheck + data.amount

                            })

                            let cartTotalCheck = totalGuest + totalCheck
                
                            $("#cart-notification").html(cartTotalCheck + "")
                            localStorage.setItem("executeCartPreview", "1")
                        }

                    })

            }else{
                localStorage.setItem("executeCartPreview", "1")
            }

            let cartTotal = totalGuest + totalCheck
            $("#cart-notification").html(cartTotal + "")
        },
        updateCartAmount(product_type_size_id, amount) {

            axios.post("{{ url('/cart/amount/update') }}", {
                productTypeSizeId: product_type_size_id,
                amount: amount
            })
            .then(res => {

                this.total = 0
                this.fetch()
                this.guestFetch()
                this.cartInfo()

            })

        },
        erase(id) {

            axios.post("{{ url('/cart/delete') }}", {
                    id: id
                })
                .then(res => {

                    if (res.data.success == true) {

                        this.total = 0
                        this.fetch()
                        this.guestFetch()
                        this.cartInfo()

                    }

                })

        },
        checkAuthCartAmounts(){

            axios.get("{{ url('/cart/fetch') }}")
                .then(res => {

                if (res.data.success == true) {


                    this.products = res.data.products

                    this.products.forEach((data, index) => {

                      
                        if(data.product_type_size.stock < data.amount){
                            console.log("entre", data)
                            this.updateCartAmount(this.products[index].product_type_size.id, this.products[index].product_type_size.stock)
                            //this.cartInfo()
                        }

                    })

                    window.setTimeout(() => {
                        this.fetch()
                    }, 300)
                    

                }

            })

        },
        checkGuestCartAmounts(){

            let cart = []
            if (window.localStorage.getItem('cartAromantica') != null) {
                cart = JSON.parse(window.localStorage.getItem('cartAromantica'))
            }

            axios.post("{{ url('/cart/guest/fetch') }}", {
                cart: cart
            }).then(res => {

                this.guestProducts = res.data.guestProducts

                this.guestProducts.forEach((data, index) => {
                    if(data.product.stock < data.amount){
                        isAmountChanged = true
                        if (window.localStorage.getItem('cartAromantica') != null) {
                            cart = JSON.parse(window.localStorage.getItem('cartAromantica'))
                        }

                        cart.forEach((prod) => {

                            if (prod.productTypeSizeId == this.guestProducts[index].product.id) {
                                prod.amount = data.product.stock
                                exists = true
                            }

                        })

                        window.localStorage.setItem("cartAromantica", JSON.stringify(cart))

                    }
                })

                this.guestFetch()

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

                    //console.log("test-guestProducts", res.data.guestProducts)
                    this.guestProducts = res.data.guestProducts

                    this.guestProducts.forEach((data, index) => {

                        

                        if(data.product.discount_percentage == 0){
                            this.total = this.total + (parseFloat(data.product.price) * parseInt(
                            data.amount))
                        }
                        else{
                            this.total = this.total + (data.amount * (data.product.price - ((data.product.discount_percentage/100)*data.price)))
                        }

                    })

                    this.cartInfo()

                } else {
                    alertify.error(res.data.msg)
                }

            })

        },
        guestDelete(cartIndex) {

            if (window.localStorage.getItem('cartAromantica') != null) {
                cart = JSON.parse(window.localStorage.getItem('cartAromantica'))
            }



            cart.forEach((data, index) => {
                console.log("test-index", index)
                if (index == cartIndex) {
                    cart.splice(index, 1)
                }
            })

            window.localStorage.setItem("cartAromantica", JSON.stringify(cart))
            this.total = 0
            this.guestFetch()
            if (this.authCheck) {
                this.fetch()
            }

            this.cartInfo()

        }

    },
    mounted() {

        if (this.authCheck) {
            this.checkAuthCartAmounts()
            //this.fetch()
        }

        //this.guestFetch()
        this.checkGuestCartAmounts()
        //this.cartInfo()

    }

})
</script>

@endpush