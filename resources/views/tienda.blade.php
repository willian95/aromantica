 @extends("layouts.index")

 @section("content")
 <div class="container p-50" id="store-area">
     <div class="row" v-cloak>
         <div class="col-md-3">
             <div class="controls">
                 <div class="">
                     <div class="border p-4 rounded mb-4">
                         <h3 class="mb-3 h6 text-uppercase text-black d-block">
                             Categorias
                         </h3>
                         <ul class="list-unstyled mb-0">
                             <li class="mb-1">
                                 <div class="form-check d-flex filter" data-filter=".category-1">
                                     <input type="checkbox" v-model="selectedAllCategories" class="form-check-input"
                                         id="todascategorias" @click="selectAllCategories()">
                                     <label class="form-check-label" for="exampleCheck1"><span>Todas
                                             ({{ App\ProductTypeSize::count() }})</span></label>
                                 </div>
                             </li>

                             <li class="mb-1" v-for="category in categories">

                                 <div class="form-check d-flex filter" data-filter=".category-1">
                                     <input type="checkbox" :value="category.id" class="form-check-input"
                                         :id="'category-id'+category.id" v-model="selectedCategories"
                                         @click="checkCategory()">
                                     <label class="form-check-label"
                                         :for="'category-id'+category.id"><span>@{{ category.name }} -
                                             (@{{ category.productsAmount }})</span></label>
                                 </div>
                             </li>

                         </ul>
                     </div>
                 </div>

                 <!--marcas--->
                 <div class="">
                     <div class="border p-4 rounded mb-4">
                         <h3 class="mb-3 h6 text-uppercase text-black d-block">
                             Marcas
                         </h3>
                         <ul class="list-unstyled mb-0">
                             <li class="mb-1">
                                 <div class="form-check d-flex filter" data-filter="all">
                                     <input type="checkbox" v-model="selectedAllBrands" class="form-check-input"
                                         id="exampleCheck1" @click="selectAllBrands()">
                                     <label class="form-check-label" for="exampleCheck1"><span>Todas</span></label>

                                 </div>
                             </li>
                             <li class="mb-1" v-for="brand in brands">
                                 <div class="form-check d-flex filter" data-filter=".category-1">
                                     <input type="checkbox" :value="brand.id" class="form-check-input"
                                         :id="'brand-id'+brand.id" v-model="selectedBrands" @click="checkBrand()">
                                     <label class="form-check-label"
                                         :for="'brand-id'+brand.id"><span>@{{ brand.name }}</span></label>

                                 </div>


                             </li>

                         </ul>
                     </div>
                 </div>

                 <div>
                     <div class="container-range">
                         <div class="box-minmax">
                             <div class="range-slider">
                                 <div class="d-flex price-range">
                                     <p>Precio: 0$ - </p>
                                     <span id="rs-bullet" class="">@{{ range }}</span>
                                     <span>$</span>
                                 </div>
                                 <input id="rs-range-line" class="rs-range" type="range" v-model="range" min="0"
                                     :max="maxPrice" step="1000" @change="fetch()">
                             </div>
                         </div>

                     </div>
                 </div>
             </div>
         </div>

         <div class="col-md-9">
             <br>
             <div id="product-grid" class="product-grid">
                 <div class="main-products__item col-xs-6 fadeInDown animated" v-for="product in products">
                     <div class="main-products__box">
                         <!--<div class="views">
                                <span data-toggle="modal" data-target="#producto_modal"><i
                                        class="flaticon-view"></i></span>
                                <span href="#"><i class="flaticon-shopping-cart"></i></span>
                            </div>-->
                         <div class="main-products__img">
                             <img :src="'{{ env('CMS_URL') }}'+'/images/products/'+product.product.image" />
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
                                     <span>$
                                         @{{ parseFloat(product.price).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</span>
                                 </div>
                             </div>
                         </a>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <div class="row" v-cloak>
         <div class="col-12">
             <nav aria-label="Page navigation example">
                 <ul class="pagination">
                     <li class="page-item" v-for="index in pages"><a class="page-link" href="#"
                             @click="fetch(index)">@{{ index }}</a></li>
                 </ul>
             </nav>
         </div>
     </div>
 </div>


 @endsection

 @push("scripts")

 <script>
const devArea = new Vue({
    el: '#store-area',
    data() {
        return {
            selectedAllBrands: false,
            selectedAllCategories: false,
            selectedBrands: [],
            selectedCategories: [],
            categories: [],
            brands: [],
            page: 1,
            pages: 0,
            products: [],
            range: 0,
            maxPrice: 0,
            minPrice: 0
        }
    },
    methods: {


        fetchCategories() {

            axios.get("{{ url('/tienda/fetch/categories') }}").then(res => {

                if (res.data.success == true) {

                    this.categories = res.data.categories

                }

            })

        },
        fetchBrands() {

            axios.get("{{ url('/tienda/fetch/brands') }}").then(res => {

                if (res.data.success == true) {

                    this.brands = res.data.brands

                }

            })

        },
        selectAllBrands() {

            if (this.brands.length == this.selectedBrands.length) {

                this.selectedBrands = []

            } else {

                this.selectedBrands = []
                this.brands.forEach((data, index) => {

                    this.selectedBrands.push(data.id)

                })

            }

            this.fetch()

        },
        fetch(page = 1) {

            setTimeout(() => {

                this.page = page
                $(".main-products__item").removeClass("fadeInDown animated")

                axios.post("{{ url('/tienda/fetch') }}", {
                    categories: this.selectedCategories,
                    brands: this.selectedBrands,
                    price: this.range,
                    page: this.page
                }).then(res => {

                    if (res.data.success == true) {
                        $(".main-products__item").addClass("fadeInDown animated")
                        this.products = res.data.products
                        this.maxPrice = res.data.maxPrice
                        this.pages = Math.ceil(res.data.productsCount / 20)

                    }

                })

            }, 100)

        },
        selectAllCategories() {

            if (this.selectedCategories.length == this.categories.length) {

                this.selectedCategories = []

            } else {

                this.selectedCategories = []
                this.categories.forEach((data, index) => {

                    this.selectedCategories.push(data.id)

                })

            }

            this.fetch()

        },
        checkCategory() {

            setTimeout(() => {

                if (this.selectedAllCategories == true) {
                    this.selectedAllCategories = false
                }

                if (this.selectedCategories.length == this.categories.length) {
                    this.selectedAllCategories = true
                }

                this.fetch()

            }, 100);

        },
        checkBrand() {

            setTimeout(() => {

                if (this.selectedAllBrands == true) {
                    this.selectedAllBrands = false
                }

                if (this.selectedAllBrands.length == this.brands.length) {
                    this.selectedAllBrands = true
                }

                this.fetch()

            }, 100);

        }

    },
    mounted() {

        this.fetchCategories()
        this.fetchBrands()
        this.fetch()

    }

})
 </script>

 @endpush