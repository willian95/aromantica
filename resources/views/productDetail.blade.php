@extends("layouts.index")

@section("content")

<!--- <div class="container" id="dev-area">
        <div class="row">
            <div class="col-lg-4">
                <h3 class="text-center">@{{ title }}</h3>
                <h4 class="text-center">@{{ brand }}</h4>

                <button class="btn btn-primary" v-for="type in types" @click="selectType(type)" style="margin-right: 5px;">@{{ type.name }}</button>

                <button class="btn btn-success" v-for="size in sizes" @click="selectSize(size)"  style="margin-right: 5px; margin-top: 5px;">@{{ size.name }} Oz - @{{ size.ml }} ml</button>

            </div>
            <div class="col-lg-4">
                Precio: @{{ price }}
                Cantidad: @{{ amount }}
                <button class="btn btn-success" @click="addAmount()">+</button>
                <button class="btn btn-success" @click="substractAmount()">-</button>

                <p class="text-center" style="margin-top: 10px;" v-if="this.type != '' && this.size != ''">
                    <button class="btn btn-success" @click="addToCart()">Agregar al carrito</button>
                </p>

            </div>  
        </div>
    </div>--->
<section class="container p-50" id="dev-area">
    <div class="main main-details__product" v-cloak>
        <div class="grid__detail row">
            <div class="col-md-6">
                <!--<div class="video">-->
                    <video loop style="width: 100%;" id="productVideo" autoplay="true"
                        muted="muted" v-if="video != null && video != ''">
                        <source src="'{{ env('CMS_URL') }}'+/videos/'+video }}" type="video/mp4">
                    </video>

                <!--</div>-->
                <div class="row">
                    <div class="col-md-3">

                    </div>
                    <div class="col-md-8">

                    </div>
                </div>


                <!--<div class="slider slider-for__details">-->
                    <div>
                        <img style="width: 80%" :src="'{{ env('CMS_URL') }}'+'/images/products/'+image" alt="">
                    </div>
                    <!--<div>
                <img src="assets/img/productos/perfume1.png" alt="">
              </div>-->
                <!--</div>-->
                <!---mini---->
                <!--<div class="slider slider-nav__details">
              <div>
                <img src="assets/img/productos/perfume1.png" alt="">
              </div>
              <div>
                <img src="assets/img/productos/perfume1.png" alt="">
              </div>
            </div>-->

            </div>
            <div class="col-md-6">

                <div class="slider_details--text">
                    <div class="">
                        <div class="main-top__item">
                            <div class="main-top__text">
                                <div class="main-top__title">
                                    <p>@{{ title }}</p>
                                    <img class="logo-product" :src="'{{ env('CMS_URL') }}'+'/images/brands/'+brandImage" alt="">
                                </div>
                                <div class="main-top__price justify-content-between">
                                   <div class="precio_content">
                                    <p v-if="discount == 0">$ @{{ parseFloat(price).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</p>

                        
                                        
                                    <p v-if="discount > 0">$ @{{ parseFloat(price - ((discount/100)*price)).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</p>
                                    <strike v-if="discount > 0">$ @{{ parseFloat(price).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</strike>
          
                                   </div>


                                    <div class="cantidad_btn">

                                        <button class="btn btn-success" @click="substractAmount()">-</button>
                                        @{{ amount }}
                                        <button class="btn btn-success" @click="addAmount()">+</button>
                                    </div>


                                </div>
                                <div class="barra mb-3">
                                    <p class="details__txt">Tamaño : @{{ size.name }} oz / @{{ size.ml }} ml</p>
                                    <div>
                                        <p>Cantidades disponibles: <span>@{{ stock }}</span></p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 25%"
                                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="10"></div>
                                        </div>
                                    </div>
                                </div>



                                <div class="main-top__description">
                                    <p>@{{ description }}</p>
                                </div>

                                <p>Presentaciones</p>
                      <div class="presentaciones">
                    <div>
                        <button class="btn btn-primary optiones" v-for="type in types" @click="selectType(type)" style="margin-right: 5px;">
                          
                          @{{ type.name }}</button>
                    </div>


                                <div class="ml-2 mt-3">

                                    <div class="control-group">

                                        <label class="control control--radio" v-for="(size, index) in sizes"
                                            @click="selectSize(size)">@{{ size.name }} Oz - @{{ size.ml }} ml
                                            <input type="radio" name="radio" v-if="index == 0" checked />
                                            <input type="radio" name="radio" v-else />
                                            <div class="control__indicator"></div>
                                        </label>
                                        


                                    </div>

                                    
                                </div>



                                

                            </div>

                            <div class="float-left main-top__btn " v-if="stock > 0">
                                <a style="color:#fff" class="btn-custom mr-4" @click="addToCart()">
                                    Añadir >
                                </a>
                            </div>
                            <div v-else>
                                <p>Producto sin stock</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>


    </div>
</section>


@endsection

@push("scripts")

<script>
const devArea = new Vue({
    el: '#dev-area',
    data() {
        return {
            authCheck: "{{ Auth::check() }}",
            title: "{{ addslashes($product->name) }}",
            category: "{{ $product->category->name }}",
            brand: "{{ $product->brand->name }}",
            brandImage: "{{ $product->brand->image }}",
            image: "{{ $product->image }}",
            description: "{{ $product->description }}",
            productTypeSizes: JSON.parse('{!! json_encode($product->productTypeSizes) !!}'),
            discount:0,
            types: [],
            sizes: [],
            type: "",
            size: "",
            productTypeSize: "",
            amount: 0,
            stock: 0,
            price: 0
        }
    },
    methods: {

        selectType(type) {
            this.type = type

            this.sizes = []
            this.size = ""
            this.productTypeSizes.forEach((data, index) => {

                if (data.type_id == type.id) {
                    this.sizes.push(data.size)
                }

            })
            this.selectSize(this.sizes[0])

        },
        selectSize(size) {

            this.amount = 0;
            this.size = size
            this.discount = 0

            if (this.type != "" && this.size != "") {

                this.productTypeSizes.forEach((data, index) => {

                    if (data.type_id == this.type.id && data.size_id == this.size.id) {

                        this.productTypeSize = data
                        this.price = data.price
                        this.discount = data.discount
                        this.stock = data.stock

                    }

                })

            }

        },
        addAmount() {

            if (this.amount + 1 <= this.stock) {
                this.amount++
            }

        },
        substractAmount() {

            if (this.amount - 1 > 0) {
                this.amount--
            }

        },
        addToCart() {

            if (this.amount > 0) {

                if (this.authCheck == "1") {

                    axios.post("{{ url('/cart/store') }}", {
                            productTypeSizeId: this.productTypeSize.id,
                            amount: this.amount
                        })
                        .then(res => {

                            if (res.data.success == true) {
                                this.cartInfo()
                                alertify.success(res.data.msg)
                                this.amount = 0;
                                this.type = ""
                                this.size = ""
                                this.productTypeSize = ""
                            } else {
                                alertify.error(res.data.msg)
                            }

                        })

                } else {
                    this.guestCart()
                }

            } else {

                alertify.error("Debes seleccionar una cantidad")

            }

        },
        guestCart() {

            var total = 0
            let cart = []
            if (window.localStorage.getItem('cartAromantica') != null) {
                cart = JSON.parse(window.localStorage.getItem('cartAromantica'))
            }

            var exists = false

            cart.forEach((data, index) => {

                if (data.productTypeSizeId == this.productTypeSize.id) {
                    data.amount = data.amount + this.amount
                    exists = true
                }

            })

            if (exists == false) {
                cart.push({
                    productTypeSizeId: this.productTypeSize.id,
                    amount: this.amount
                })
            }

            cart.forEach((data, index) => {

                total = data.amount + total

            })

            

            window.localStorage.setItem("cartAromantica", JSON.stringify(cart))

            this.amount = 0
            this.cartInfo()
            alertify.success("Producto añadido al carrito")


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

            let cartTotal = totalGuest + totalCheck
            $("#cart-notification").html(cartTotal + "")

            if (this.authCheck == "1") {

                axios.get("{{ url('/cart/fetch') }}")
                    .then(res => {

                        if (res.data.success == true) {

                            this.products = res.data.products

                            this.products.forEach((data, index) => {

                                totalCheck = totalCheck + data.amount

                            })

                            console.log(totalGuest, totalCheck)
                            let cartTotal = totalGuest + totalCheck
                            $("#cart-notification").html(cartTotal + "")

                        }

                    })

            }

        }


    },
    mounted() {

        this.productTypeSizes.forEach((data, index) => {
            var typeExists = false
            this.types.forEach((type, index) => {

                if (type.id == data.type.id) {
                    typeExists = true
                }

            })

            if (typeExists == false) {
                this.types.push(data.type)
            }

            if (index == 0) {
                this.type = this.types[0]
                this.selectType(this.type)
                this.selectSize(this.sizes[0])
            }


        })

        this.cartInfo()




    }

})
</script>


@endpush