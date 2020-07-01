
  <section class="container" >
    <div class="title__general">
      <h2>Fragancias recomendadas</h2>
    </div>

    <div class="main-productos__content ">
      @foreach(App\Product::inRandomOrder()->take(12)->has("brand")->has("productTypeSizes")->with("brand", "productTypeSizes", "productTypeSizes.size", "productTypeSizes.type")->get() as $product)
      <div class="main-products__item">
        <div class="main-products__box" >
          <!--<div class="views">
            <span data-toggle="modal" data-target="#producto_modal"><i class="flaticon-view"></i></span>
            <span href=""><i class="flaticon-shopping-cart"></i></span>
          </div>--> 
        <a href="{{ url('/product/'.$product->slug) }}" >
          <div class="main-products__img">
            <img src="{{ env('CMS_URL').'/images/products/'.$product->image }}" class="card-img-top" alt="...">
          </div>
       
            <div class="main-products__text">
              <div class="main-products__title_cat">
                <p> {{ $product->brand->name }}</p>
              </div>
              <div class="main-products__title">
                <p>{{ $product->name }} </p>
              </div>
              <!--<div class="main-products__details">
                <span>$85,000</span>
              </div>-->
              <div class="presentaciones presentaciones_card ">
             
                @foreach(App\ProductTypeSize::where("product_id", $product->id)->groupBy("type_id")->get() as $productTypeSize)

                <p>{{ $productTypeSize->type->name }}</p>

                @endforeach
               </div>
            </div>
          </a>
        </div>
   
      </div>
      @endforeach

    </div>



  </section>


  