@extends("layouts.index")

@section("content")

    <div id="dev-area">

        <!--<div class="main-banner main-banner-categorias   pb-5">
            <div class="main-banner__conten">
                <div class="main-banner__item--categoria">
                    <div class="main-banner__text">
                        <div class="main-banner__title animated fadeIn wow container">

                            <p class="titulo">@{{ categoryName }}</p>
                        </div>
                    </div>
                    <div class="main-banner__img">
                        <div class="massk"></div>
                        <img :src="'{{ env('CMS_URL') }}'+'/images/categories/'+image">
                    </div>
                </div>
            </div>
        </div>-->

        <section class="container mt-2">

            <div class="main-productos__conten categorias_grid">

                <div v-if="loading == true">
                    Buscando productos
                </div>

                <div v-if="loading == false && products.length == 0">
                    Producto no encontrado
                </div>

                <div class="main-products__item" v-for="product in products">

                    <div class="main-products__box">
                        <div class="views">
                            <span data-toggle="modal" data-target="#producto_modal"><i class="flaticon-view"></i></span>
                            <span href=""><i class="flaticon-shopping-cart"></i></span>
                        </div>
                        <div class="main-products__img">
                            <img :src="'{{ env('CMS_URL') }}'+'/images/products/'+product.product.image">
                        </div>
                        <a :href="'{{ url('/') }}'+'/tienda/producto/'+product.id">
                            <div class="main-products__text">
                                <div class="main-products__title_cat">
                                    <p>@{{ product.product.brand.name }}</p>
                                </div>
                        
                                <div class="main-products__title">
                                    <p>@{{ product.product.name }}</p>
                                </div>
                                <div class="main-products__details">
                                    <p>@{{ product.type.name }} - @{{ product.size.name }}Oz</p>
                                </div>
                                <div class="main-products__details">
                                    <span>$ @{{ product.price }}</span>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </section>

    </div>


@endsection

@push("scripts")

<script>

        const devArea = new Vue({
            el: '#dev-area',
            data(){
                return{
                    loading:false,
                    type:"",
                    size:"",
                    products:[],
                    page:1,
                    pages:0
                }
            },
            methods:{
                
                
                search(page = 1){

                    this.page=  page
                    this.loading = true

                    axios.post("{{ url('/search') }}", {searchText: this.searchText, size: this.size, type: this.type}).then(res =>{
                        
                        this.loading = false
                        //if(res.data.success == true){

                            this.products = res.data.products
                            this.pages = Math.ceil(res.data.productsCount / 20)

                        //}

                    })

                }

            },
            mounted(){

                if(localStorage.getItem("searchAromantica") != null){
                    this.searchText = localStorage.getItem("searchAromantica")
                    this.size = localStorage.getItem("sizeAromantica")
                    this.type = localStorage.getItem("typeAromantica")
                    this.search()
                }

            }

        })

    </script>

@endpush