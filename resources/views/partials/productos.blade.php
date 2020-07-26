<section class="container">
    <div class="title__general">
        <h2>Fragancias recomendadas</h2>
    </div>

    <div class="main-productos__content ">
        @foreach(App\ProductTypeSize::take(12)->has("product.brand")->with("product.brand", "product", "size", "type")->get() as $product)
        <div class="main-products__item">
            <div class="main-products__box">
                <div class="views">
                    <span data-toggle="modal"
                        onclick="setStock('{{ $product->stock }}', '{{ $product->price }}', '{{ $product->id }}')"
                        data-target="#producto_modal-{{ $loop->index + 1 }}"><i class="flaticon-view"></i></span>
                    <!--<span href=""><i class="flaticon-shopping-cart"></i></span>-->
                </div>
                <a href="{{ url('/tienda/producto/'.$product->id) }}">
                    <div class="main-products__img">
                        <img src="{{ env('CMS_URL').'/images/products/'.$product->product->image }}" class="card-img-top"
                            alt="...">
                    </div>

                    <div class="main-products__text">
                        <div class="main-products__title_cat">
                            <p> {{ $product->product->brand->name }}</p>
                        </div>
                        <div class="main-products__title">
                            <p>{{ $product->product->name }} </p>
                        </div>
                        <div class="main-products__details">
                            <p>{{ $product->type->name }} - {{ $product->size->name }}Oz</p>
                        </div>
                        <div class="main-products__details">
                            <span>$ {{ $product->price }}</span>
                        </div>
                        <!--<div class="main-products__details">
                <span>$85,000</span>
              </div>-->
                        
                    </div>
                </a>
            </div>

        </div>

        @endforeach

    </div>

    @foreach(App\ProductTypeSize::take(12)->has("product.brand")->with("product.brand", "product",
    "size", "type")->get() as $product)

    <!-- modal producto views -->
    <div class="modal fade" id="producto_modal-{{ $loop->index + 1 }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <div class="content_modal">
                        <div class="content_modal-item">
                            <p class="titulo">{{ $product->product->name }}</p>
                            <span>{{ $product->product->description }}</span>
                            <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam ea inventore maxime
                                harum odio, suscipit enim voluptate saepe incidunt veritatis sed? Deleniti pariatur
                                dignissimos ratione nisi blanditiis expedita velit assumenda!</span>


                            <div class="main-top__price">
                                <p><span>$
                                        {{ number_format($product->price, 0, ",", ".") }}</span>
                                </p>


                            </div>


                        </div>
                        <div class="content_modal-item center">
                            <img src="{{ env('CMS_URL').'/images/products/'.$product->product->image }}" alt="">
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="barra">
                                <!--<p> Vendidos:<span> 12</span></p>-->
                                <p> {{ $product->type->name }} -
                                    {{ $product->size->name }}ml
                                </p>
                                <p>Disponible:
                                    <span>{{ $product->stock }}</span>
                                </p>
                            </div>

                            <!--<div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="10"></div>
                            </div>--->


                            <div class=" main-top__btn d-flex">


                                <div class="d-flex mt-2">
                                    <button class="btn  mass mr-2" onclick="substractAmount()">-</button>
                                    <div class="amountProductModal"></div>
                                    <button class="btn  mass ml-2" onclick="addAmount()">+</button>


                                </div>
                                <button class="btn-custom custom2" onclick="addToCart()">Añadir al carrito</button>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class=" main-top__btn d-flex justify-content-center">


                                <a class="btn-custom " href="{{ url('/product/'.$product->product->slug) }}">
                                    VER MÁS >
                                </a>
                            </div>
                        </div>



                    </div>

                </div>
            </div>
        </div>
    </div>

    @endforeach

    <script>
    var productStock = 0;
    var productPrice = 0
    var productTypeSizeId = 0
    var amount = 0;
    var authCheck = "{{ \Auth::check() }}"

    function setStock(stock, price, id) {
        amount = 0
        productStock = stock
        productPrice = price
        productTypeSizeId = id
        $(".amountProductModal").html(amount)
    }

    function addAmount() {

        if (amount + 1 <= productStock) {
            amount++
            $(".amountProductModal").html(amount)
        }

    }

    function substractAmount() {

        if (amount - 1 >= 0) {
            amount--
            $(".amountProductModal").html(amount)
        }

    }

    function guestCart() {

        var total = 0
        let cart = []
        if (window.localStorage.getItem('cartAromantica') != null) {
            cart = JSON.parse(window.localStorage.getItem('cartAromantica'))
        }

        var exists = false

        cart.forEach((data, index) => {

            if (data.productTypeSizeId == productTypeSizeId) {
                data.amount = data.amount + amount
                exists = true
            }

        })

        if (exists == false) {
            cart.push({
                productTypeSizeId: productTypeSizeId,
                amount: amount
            })
        }

        cart.forEach((data, index) => {

            total = data.amount + total

        })

        window.localStorage.setItem("cartAromantica", JSON.stringify(cart))
        cartInfo()
        amount = 0
        $(".amountProductModal").html("0")
        alert("Producto añadido al carrito")
    }

    function cartInfo() {
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

        if (authCheck == "1") {

            $.get("{{ url('/cart/fetch') }}", function(res) {

                if (res.success == true) {

                    let products = res.products

                    products.forEach((data, index) => {

                        totalCheck = totalCheck + data.amount

                    })

                    console.log(totalGuest, totalCheck)
                    let cartTotal = totalGuest + totalCheck
                    $("#cart-notification").html(cartTotal + "")

                }

            })

        }

    }

    function addToCart() {

        if (amount > 0) {

            if (authCheck == "1") {

                $.post("{{ url('/cart/store') }}", {
                    productTypeSizeId: productTypeSizeId,
                    amount: amount,
                    _token: "{{ csrf_token() }}"
                }, function(data) {

                    if (data.success == true) {
                        alert(data.msg)
                        cartInfo()
                        $(".amountProductModal").html("0")
                    } else {
                        alert(data.msg)
                    }

                });

            } else {
                guestCart()
            }

        } else {

            alert("Debe seleccionar una cantidad")

        }

    }
    </script>

</section>