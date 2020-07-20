 @extends("layouts.index")

 @section("content")
 <div class="container mt-5" id="store-area">
     <div class="row">
         <div class="col-md-3">
             <div class="controls">
                 <div class="">
                     <div class="border p-4 rounded mb-4">
                         <h3 class="mb-3 h6 text-uppercase text-black d-block">
                             Categorias
                         </h3>
                         <ul class="list-unstyled mb-0">
                            <li class="mb-1">
                                <a class="d-flex filter" data-filter="all"><span>Todas</span>
                                <span class="text-black ml-auto">{{ App\Product::count() }}</span></a>
                            </li>
                            <li class="mb-1" v-for="category in categories">
                                <a class="d-flex filter" data-filter=".category-1"><span>@{{ category.name }}</span>
                                <span class="text-black ml-auto">(@{{ category.productsAmount }})</span></a>
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
                                     <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                     <label class="form-check-label" for="exampleCheck1"><span>Todas</span></label>

                                 </div>
                             </li>
                             <li class="mb-1">
                                 <div class="form-check d-flex filter" data-filter=".category-1">
                                     <input type="checkbox" class="form-check-input" id="exampleCheck2">
                                     <label class="form-check-label" for="exampleCheck2"><span>Carolina</span></label>

                                 </div>


                             </li>
                             <li class="mb-1 ">
                                 <div class="form-check d-flex filter" data-filter=".category-4">
                                     <input type="checkbox" class="form-check-input" id="exampleCheck3">
                                     <label class="form-check-label" for="exampleCheck3"><span>Hugo</span></label>

                                 </div>

                             </li>


                             <li class="mb-1">
                                 <div class="form-check d-flex filter" data-filter=".category-2">
                                     <input type="checkbox" class="form-check-input" id="exampleCheck4">
                                     <label class="form-check-label" for="exampleCheck4"><span>Lady</span></label>

                                 </div>

                             </li>
                         </ul>
                     </div>
                 </div>



                 <!---  <div class="">
                     Marca
                     <br>
                     <div id="filters_and_sorters">
                         <select id="area_filter">
                             <option value="all" selected="selected">area</option>
                             <option value=".boats">boats</option>
                             <option value=".cars">cars</option>
                             <option value=".bikes">bikes</option>
                             <option value=".hedgehogs">hedgehogs</option>
                             <option value=".cakes">cakes</option>
                         </select>

                     </div>
                 </div>--->
                 <!---rango--->
                 <div>
                     <div class="container-range">
                         <div class="box-minmax">
                             <div class="range-slider">
                                 <div class="d-flex price-range">
                                     <p>Precio: 0$ - </p>
                                     <span id="rs-bullet" class=""> 20</span>
                                     <span>$</span>
                                 </div>
                                 <input id="rs-range-line" class="rs-range" type="range" value="1" min="0" max="200">
                             </div>
                         </div>
                         <a href="" class="btn-custom btn-filtro ">Filtrar</a>
                     </div>
                 </div>
             </div>
         </div>

         <div class="col-md-9">
             <br>
             <div id="product-grid" class="product-grid">
                 <div class="main-products__item mix category-4  col-xs-6 boats ">
                     <div class="main-products__box">
                         <div class="views">
                             <span data-toggle="modal" data-target="#producto_modal"><i
                                     class="flaticon-view"></i></span>
                             <span href=""><i class="flaticon-shopping-cart"></i></span>
                         </div>
                         <div class="main-products__img">
                             <img src="assets/img/productos/perfume1.png" />
                         </div>
                         <a href="detalle-producto.html">
                             <div class="main-products__text">
                                 <div class="main-products__title_cat">
                                     <p>categoria</p>
                                 </div>
                                 <div class="main-products__title">
                                     <p>CH MEN PRIVÉ</p>
                                 </div>
                                 <div class="main-products__details">
                                     <span>$85,000</span>
                                 </div>
                             </div>
                         </a>
                     </div>
                 </div>
                 <div class="main-products__item mix category-1  col-xs-6 cars">
                     <div class="main-products__box">
                         <div class="views">
                             <span data-toggle="modal" data-target="#producto_modal"><i
                                     class="flaticon-view"></i></span>
                             <span href=""><i class="flaticon-shopping-cart"></i></span>
                         </div>
                         <div class="main-products__img">
                             <img src="assets/img/productos/perfume1.png" />
                         </div>
                         <a href="detalle-producto.html">
                             <div class="main-products__text">
                                 <div class="main-products__title_cat">
                                     <p>categoria</p>
                                 </div>
                                 <div class="main-products__title">
                                     <p>CH MEN PRIVÉ</p>
                                 </div>
                                 <div class="main-products__details">
                                     <span>$85,000</span>
                                 </div>
                             </div>
                         </a>
                     </div>
                 </div>

                 <div class="main-products__item mix category-1  col-xs-6 cars">
                     <div class="main-products__box">
                         <div class="views">
                             <span data-toggle="modal" data-target="#producto_modal"><i
                                     class="flaticon-view"></i></span>
                             <span href=""><i class="flaticon-shopping-cart"></i></span>
                         </div>
                         <div class="main-products__img">
                             <img src="assets/img/productos/perfume1.png" />
                         </div>
                         <a href="detalle-producto.html">
                             <div class="main-products__text">
                                 <div class="main-products__title_cat">
                                     <p>categoria</p>
                                 </div>
                                 <div class="main-products__title">
                                     <p>CH MEN PRIVÉ</p>
                                 </div>
                                 <div class="main-products__details">
                                     <span>$85,000</span>
                                 </div>
                             </div>
                         </a>
                     </div>
                 </div>
                 <div class="main-products__item mix category-2  col-xs-6 cars">
                     <div class="main-products__box">
                         <div class="views">
                             <span data-toggle="modal" data-target="#producto_modal"><i
                                     class="flaticon-view"></i></span>
                             <span href=""><i class="flaticon-shopping-cart"></i></span>
                         </div>
                         <div class="main-products__img">
                             <img src="assets/img/productos/perfume1.png" />
                         </div>
                         <a href="detalle-producto.html">
                             <div class="main-products__text">
                                 <div class="main-products__title_cat">
                                     <p>categoria</p>
                                 </div>
                                 <div class="main-products__title">
                                     <p>CH MEN PRIVÉ</p>
                                 </div>
                                 <div class="main-products__details">
                                     <span>$85,000</span>
                                 </div>
                             </div>
                         </a>
                     </div>
                 </div>
                 <div class="main-products__item mix category-2  col-xs-6 cakes">
                     <div class="main-products__box">
                         <div class="views">
                             <span data-toggle="modal" data-target="#producto_modal"><i
                                     class="flaticon-view"></i></span>
                             <span href=""><i class="flaticon-shopping-cart"></i></span>
                         </div>
                         <div class="main-products__img">
                             <img src="assets/img/productos/perfume1.png" />
                         </div>
                         <a href="detalle-producto.html">
                             <div class="main-products__text">
                                 <div class="main-products__title_cat">
                                     <p>categoria</p>
                                 </div>
                                 <div class="main-products__title">
                                     <p>CH MEN PRIVÉ</p>
                                 </div>
                                 <div class="main-products__details">
                                     <span>$85,000</span>
                                 </div>
                             </div>
                         </a>
                     </div>
                 </div>




             </div>
         </div>
     </div>
 </div>


 @endsection

 @push("scripts")

<script>

        const devArea = new Vue({
            el: '#store-area',
            data(){
                return{
                    categories:[]
                }
            },
            methods:{
                
                
                fetchCategories(){

                    axios.get("{{ url('/tienda/fetch/categories') }}").then(res =>{

                        if(res.data.success == true){

                            this.categories = res.data.categories

                        }

                    })

                }

            },
            mounted(){

                this.fetchCategories()

            }

        })

    </script>

@endpush