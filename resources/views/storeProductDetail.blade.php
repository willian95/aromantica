@extends("layouts.index")

@section("content")

<section class="container p-50" id="dev-area">
    <div class="main main-details__product">
        <div class="grid__detail row">
            <div class="col-md-6">
                <div class="video" >
                    <video loop style="width: 100%;" id="productVideo" autoplay="true" muted="muted" v-if="video != null || video != ''">
                        <source :src="'{{ env('CMS_URL') }}'+'/videos/'+ video" type="video/mp4">
                    </video>
                </div>
                <div class="row">
                    <div class="col-md-3">

                    </div>
                    <div class="col-md-8">

                    </div>
                </div>


                <div class="slider slider-for__details">
                    <div>
                        <img :src="'{{ env('CMS_URL') }}'+'/images/products/'+image" alt="">
                    </div>

                </div>


            </div>
            <div class="col-md-6">

                <div class="slider_details--text">
                    <div class="">
                        <div class="main-top__item">
                            <div class="main-top__text">
                                <div class="main-top__title d-flex justify-content-between mb-4">
                                    <p>@{{ title }}</p>
                                    <img class="logo-product" :src="'{{ env('CMS_URL') }}'+'/images/brands/'+brandImage" alt="">
                                </div>
                                <div class="main-top__price justify-content-between">
                                    <p>$ @{{ parseFloat(price).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</p>


                                    <div class="cantidad_btn">


                                        <button class="btn btn-success" @click="substractAmount()">-</button>
                                        @{{ amount }}
                                        <button class="btn btn-success" @click="addAmount()">+</button>
                                    </div>


                                </div>
                                <div class="barra mb-3">
                                    <p class="details__txt">Tamaño : @{{ size }} oz / @{{ sizeMl }} ml</p>
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

                                {{--<p>Presentaciones</p>
                      <div class="presentaciones">
                    <div>
                        <button class="btn btn-primary optiones" v-for="type in types" @click="selectType(type)" style="margin-right: 5px;">
                          
                          @{{ type.name }}</button>
                            </div>--}}
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
            title: '{!! $product->product->name !!}',
            category: '{!! $product->product->category->name !!}',
            brand: '{!! $product->product->brand->name !!}',
            image: '{!! $product->product->image !!}',
            brandImage: '{!! $product->product->brand->image !!}',
            video: '{!! $product->product->video !!}',
            description: '{!! $product->product->description !!}',
            size: '{!! $product->size->name !!}',
            sizeMl: '{!! $product->size->ml !!}',
            type: '{!! $product->type->name !!}',
            stock: "{{ $product->stock }}",
            price: "{{ $product->price }}",
            productTypeSizeId: "{{ $product->id }}",
            amount: 0
        }
    },
    methods: {

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
                            productTypeSizeId: this.productTypeSizeId,
                            amount: this.amount
                        })
                        .then(res => {

                            if (res.data.success == true) {
                                this.cartInfo()
                                alertify.success(res.data.msg)
                                this.amount = 0;
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

                if (data.productTypeSizeId == this.productTypeSizeId) {
                    data.amount = data.amount + this.amount
                    exists = true
                }

            })

            if (exists == false) {
                cart.push({
                    productTypeSizeId: this.productTypeSizeId,
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

                            localStorage.setItem("executeCartPreview", "1")

                        }

                    })

            } else {

                localStorage.setItem("executeCartPreview", "1")
            }

        }


    },
    mounted() {

        this.cartInfo()


    }

})
</script>

@endpush