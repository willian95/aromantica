 <!-----top perfumes---->
 <section id="top" class="">
     <div class="title__general">
         <h2>Top perfumes</h2>
     </div>
     <div class="">
         <div class="container">
             <div class="main-top__content">
                 <div class="main">
                     <!---mini cards ---->
                     <div class="slider slider-nav">
                         <!---mini cards imagen ---->
                         @foreach(App\TopProduct::with('productTypeSize', 'productTypeSize.product', 'productTypeSize.type', 'productTypeSize.size')->has("productTypeSize")->has("productTypeSize.product")->has("productTypeSize.type")->has("productTypeSize.size")->get() as $topProduct)
                         <div>
                             <div class="main-top__img">
                                 <img src="{{ env('CMS_URL').'/images/products/'.$topProduct->productTypeSize->product->image }}">
                             </div>
                         </div>
                         @endforeach
                         <!---mini cards imagen ---->


                     </div>
                     <!---mini cards ---->

                     <!---cards detalle---->
                     <div class="slider slider-for">
                         @foreach(App\TopProduct::with('productTypeSize', 'productTypeSize.product', 'productTypeSize.type', 'productTypeSize.size')->has("productTypeSize")->has("productTypeSize.product")->has("productTypeSize.type")->has("productTypeSize.size")->get() as $topProduct)
                         <div>
                             <div class="main-top__container">
                                 <div class="main-top__item">
                                     <div class="main-top__text">
                                         <div class="main-top__title">
                                             <p>{{ $topProduct->productTypeSize->product->name }} </p>
                                         </div>

                                         <div class="main-top__description">
                                             <p>{{ $topProduct->productTypeSize->product->description }}</p>
                                         </div>
                                         <div class="present">
                                             <p>Presentación:</p>
                                             <div class="presentaciones d-flex">

                                                 
                                                 <p>{{ $topProduct->productTypeSize->type->name }} -
                                                     {{ $topProduct->productTypeSize->size->name }}oz</p>

                                                 
                                             </div>
                                         </div>
                                         <div class="main-top__price">
                                             <p>
                                                @if($topProduct->productTypeSize->discountPercentage == 0)
                                                    <span> ${{ number_format($topProduct->productTypeSize->price, 0, ",", ".") }}</span>
                                                @else
                                                    <span> ${{ number_format($topProduct->productTypeSize->price - (($topProduct->productTypeSize->discountPercentage/100)*$topProduct->productTypeSize->price), 0, ",", ".") }}</span>
                                                    <strike>${{ number_format($topProduct->productTypeSize->price, 0, ",", ".") }}</strike>
                                                @endif
                                                   
                                             </p>
                                         </div>

                                         <div class="barra">
                                             <!--<p> Vendidos:<span> 12</span></p>-->
                                             <p>Disponible:
                                                 <span>{{ $topProduct->productTypeSize->stock }}</span>
                                             </p>
                                         </div>
                                         <div class="progress">
                                             <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="10"></div>
                                         </div>
                                         <div class="float-left main-top__btn">
                                             <a class="btn-custom" href="{{ url('/tienda/producto/'.$topProduct->productTypeSize->id) }}">
                                                Ordene ya >
                                                {{ $topProduct->productTypeSize->discountPercentage }}

                                             </a>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="main-top__item">
                                     <div class="main-top__img top2">
                                         <img src="{{ env('CMS_URL').'/images/products/'.$topProduct->productTypeSize->product->image }}">
                                     </div>
                                 </div>
                             </div>

                         </div>
                         @endforeach
                         

                     </div>
                     <!---cards detalle---->
                 </div>
             </div>
         </div>
     </div>
 </section>