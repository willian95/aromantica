 @extends("layouts.index")

 @section("content")
 <div class="container">
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
                                     <span class="text-black ml-auto">(2,220)</span></a>
                             </li>
                             <li class="mb-1">
                                 <a class="d-flex filter" data-filter=".category-1"><span>Caballeros</span>
                                     <span class="text-black ml-auto">(2,220)</span></a>
                             </li>
                             <li class="mb-1 ">
                                 <a class="d-flex filter" data-filter=".category-4"><span>Damas</span>
                                     <span class="text-black ml-auto">(2,550)</span></a>
                             </li>
                             <li class="mb-1">
                                 <a class="d-flex filter" data-filter=".category-2"><span>Niños</span>
                                     <span class="text-black ml-auto">(2,124)</span></a>
                             </li>
                         </ul>
                     </div>
                 </div>
                 <div class="">
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
                 </div>

                 <div>
                     <div class="container-range">

                         <div class="range-slider">
                             <span id="rs-bullet" class="rs-label">0</span>
                             <input id="rs-range-line" class="rs-range" type="range" value="0" min="0" max="200">

                         </div>

                         <div class="box-minmax">
                             <span>0</span><span>200</span>
                         </div>

                     </div>
                 </div>
             </div>
         </div>

         <div class="col-md-9">
             <br>
             <div id="product-grid" class="product-grid">
                 <div class="main-products__item mix category-1  col-xs-6 boats ">
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



 <script>

 </script>