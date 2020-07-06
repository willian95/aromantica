  <!-----cateoria---->
  <section id="categorias" class="mt-5">
    <!---  <div class="title__general">
        <h2>Categorías</h2>
      </div>--->
     

      <div class="main-categories">
        @foreach(App\Category::all() as $category)
        <div class="main-categories__item">
          <a href="{{ url('/category/'.$category->slug) }}">
            <div class="main-categories__content categories-transition"
              style="background-image: url('{{ env('CMS_URL').'/images/categories/'.$category->image }}');">
              <div class="mask_deg">
                <div class="titulo">
                  {{$category->name}}
                  <i class="fa fa-arrow"></i>
                </div>
              </div>
            </div>
          </a>
        </div>
        @endforeach
      </div>

        <!--<div class="main-categories__item">
          <a href="categorias.html">
            <div class="main-categories__content categories-transition"
              style="background-image: url('assets/img/categorias/caballero.jpg');">
              <div class="mask_deg">
                <div class="titulo">
                  Caballeros
                  <i class="fa fa-arrow"></i>
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="main-categories__item">
          <a href="categorias.html">
            <div class="main-categories__content categories-transition"
              style="background-image: url('assets/img/categorias/niños.jpg');">
              <div class="mask_deg">
                <div class="titulo">
                  Niños
                  <i class="fa fa-arrow"></i>
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="main-categories__item">
          <a href="categorias.html">
            <div class="main-categories__content categories-transition"
              style="background-image: url('assets/img/categorias/crema.jpg');">
              <div class="mask_deg">
                <div class="titulo">
                  Estuches
                  <i class="fa fa-arrow"></i>
                </div>
              </div>
            </div>
          </a>
        </div>-->
      </div>
    </section>
  