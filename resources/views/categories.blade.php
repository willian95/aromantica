@extends("layouts.index")

@section("content")

<div id="dev-area">

    <div class="main-banner main-banner-categorias p-50   pb-5">
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
    </div>

    <section class="container mt-2">

        <div class="main-productos__conten categorias_grid">

            <div class="main-products__item" v-for="product in products">

                <div class="main-products__box">
                    <div class="views">
                        <span data-toggle="modal" data-target="#producto_modal"><i class="flaticon-view"></i></span>
                        <!--<span href=""><i class="flaticon-shopping-cart"></i></span>-->
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
                                <p>@{{ product.product.name }} </p>
                            </div>
                            <div class="main-products__title">
                                <p>@{{ product.type.name }} - @{{ product.size.name }}Oz </p>
                            </div>
                            <div class="main-products__details">
                                <span>$
                                    @{{ parseFloat(product.price).toString().replace().replace(/\B(?=(\d{3})+\b)/g, ".") }}</span>
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
    data() {
        return {
            categoryName: "{{ $category->name }}",
            image: "{{ $category->image }}",
            id: "{{ $category->id }}",
            products: [],
            page: 1,
            pages: 0
        }
    },
    methods: {


        fetch(page = 1) {

            this.page = page

            axios.get("{{ url('/') }}" + "/category/products/" + this.page + "/category/" + this.id).then(
            res => {

                if (res.data.success == true) {

                    this.products = res.data.products
                    this.pages = Math.ceil(res.data.productsCount / 20)

                }

            })

        }

    },
    mounted() {

        this.fetch()

    }

})
</script>

@endpush