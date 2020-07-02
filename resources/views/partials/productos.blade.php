
  <section class="container" >
    <div class="title__general">
      <h2>Fragancias recomendadas</h2>
    </div>

    <div class="main-productos__content ">
      @foreach(App\Product::take(12)->has("brand")->has("productTypeSizes")->with("brand", "productTypeSizes", "productTypeSizes.size", "productTypeSizes.type")->get() as $product)
      <div class="main-products__item">
        <div class="main-products__box" >
          <div class="views">
            <span data-toggle="modal" data-target="#producto_modal-{{ $loop->index + 1 }}"><i class="flaticon-view"></i></span>
            <!--<span href=""><i class="flaticon-shopping-cart"></i></span>-->
          </div>
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
              <div class=" presentaciones_card d-flex">
             
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

    @foreach(App\Product::take(12)->has("brand")->has("productTypeSizes")->with("brand", "productTypeSizes", "productTypeSizes.size", "productTypeSizes.type")->get() as $product)

      <!-- modal producto views -->
    <div class="modal fade" id="producto_modal-{{ $loop->index + 1 }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-body">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>

              <div class="content_modal">
                <div class="content_modal-item">
                  <p class="titulo">{{ $product->name }}</p>
                  <span>{{ $product->description }}</span>


                  <div class="main-top__price">
                    <p><span>$ {{ App\ProductTypeSize::where("product_id", $product->id)->first()->price }}</span> </p>

                  </div>


                </div>
                <div class="content_modal-item center">
                  <img src="{{ env('CMS_URL').'/images/products/'.$product->image }}" alt="">
                </div>


              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="barra">
                    <!--<p> Vendidos:<span> 12</span></p>-->
                    <p>Disponible: <span>{{ App\ProductTypeSize::where("product_id", $product->id)->first()->stock }}</span></p>
                  </div>
                  <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                      aria-valuemax="10"></div>
                  </div>
                </div>
                <div class="col-md-6 text-center">
                  <div class=" main-top__btn ">
                    <a class="btn-custom" href="{{ url('/product/'.$product->slug) }}">
                      Ordene ya >
                    </a>
                  </div>
                </div>



              </div>

            </div>
          </div>
        </div>
      </div>

    @endforeach
    



  </section>


  