  <!-----products---->
  
  <!--<div class="container" id="dev-area">
    <div class="row">
        <div class="col-lg-3 col-md-4" v-for="perfume in perfumes">
            <div class="card" style="width: 100%;">
                <img :src="'{{ env('CMS_URL') }}'+'/images/products/'+perfume.image" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">@{{ perfume.name }}</h5>
                    <p class="card-text"><strong>Marca: </strong> @{{ perfume.brand.name }}</p>
                    <a :href="'{{ url('/product/') }}'+'/'+perfume.slug" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
</div>-->

  <section class="container" >
    <div class="title__general">
      <h2>Fragancias recomendadas</h2>
    </div>

    <div class="main-productos__content " id="dev-area">
      <div class="main-products__item" v-for="perfume in perfumes">
        <div class="main-products__box" >
          <div class="views">
            <span data-toggle="modal" data-target="#producto_modal"><i class="flaticon-view"></i></span>
            <span href=""><i class="flaticon-shopping-cart"></i></span>
          </div>
          <div class="main-products__img">
            <img :src="'{{ env('CMS_URL') }}'+'/images/products/'+perfume.image" class="card-img-top" alt="...">
          </div>
          <a :href="'{{ url('/product/') }}'+'/'+perfume.slug" >
            <div class="main-products__text">
              <div class="main-products__title_cat">
                <p> @{{ perfume.brand.name }}</p>
              </div>
              <div class="main-products__title">
                <p>@{{ perfume.name }} </p>
              </div>
              <div class="main-products__details">
                <span>$85,000</span>
              </div>
              <div class="presentaciones presentaciones_card ">

                <p>50ml</p>
                <p>100ml</p>
                <p>150ml</p>
               </div>
            </div>
          </a>
        </div>

      </div>
    <!---  <div class="main-products__item">

        <div class="main-products__box">
          <div class="views">
            <span data-toggle="modal" data-target="#producto_modal"><i class="flaticon-view"></i></span>
            <span href=""><i class="flaticon-shopping-cart"></i></span>
          </div>
          <div class="main-products__img">
            <img src="assets/img/productos/perfume1.png">
          </div>
          <a href="detalle-producto.html">
            <div class="main-products__text">
              <div class="main-products__title_cat">
                <p>categoria</p>
              </div>
              <div class="main-products__title">
                <p>CH MEN PRIVÉ </p>
              </div>
              <div class="main-products__details">
                <span>$85,000</span>
              </div>
            </div>
          </a>
        </div>

      </div>
      <div class="main-products__item">

        <div class="main-products__box">
          <div class="views">
            <span data-toggle="modal" data-target="#producto_modal"><i class="flaticon-view"></i></span>
            <span href=""><i class="flaticon-shopping-cart"></i></span>
          </div>
          <div class="main-products__img">
            <img src="assets/img/productos/perfume1.png">
          </div>
          <a href="detalle-producto.html">
            <div class="main-products__text">
              <div class="main-products__title_cat">
                <p>categoria</p>
              </div>
              <div class="main-products__title">
                <p>CH MEN PRIVÉ </p>
              </div>
              <div class="main-products__details">
                <span>$85,000</span>
              </div>
            </div>
          </a>
        </div>

      </div>
      <div class="main-products__item">

        <div class="main-products__box">
          <div class="views">
            <span data-toggle="modal" data-target="#producto_modal"><i class="flaticon-view"></i></span>
            <span href=""><i class="flaticon-shopping-cart"></i></span>
          </div>
          <div class="main-products__img">
            <img src="assets/img/productos/perfume1.png">
          </div>
          <a href="detalle-producto.html">
            <div class="main-products__text">
              <div class="main-products__title_cat">
                <p>categoria</p>
              </div>
              <div class="main-products__title">
                <p>CH MEN PRIVÉ </p>
              </div>
              <div class="main-products__details">
                <span>$85,000</span>
              </div>
            </div>
          </a>
        </div>

      </div>-->

    </div>



  </section>


  