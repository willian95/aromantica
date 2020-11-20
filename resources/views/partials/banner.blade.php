    <section id="banner" class="banner-bg p-0 m-0 position-relative">
        <div class="main-banner__content">
            
            <div class="main-banner__content_item">
                <div class="overlay">
                    <div class="banner-title text-center ">
                        <p>{{ App\Banner::find(1)->small_text }}</p>
                        <h1>{{ App\Banner::find(1)->big_text }}</h1>
                    </div>
                    <div class="main-banner__img">
                      @if(App\Banner::find(1)->type == "image")
                        <img src="{{ env('CMS_URL').'/images/banners/'.App\Banner::find(1)->image }}">
                        <div class="mask"></div>
                      @elseif(App\Banner::find(1)->type == "video")
                        <video playsinline  loop style="width: 100%;" autoplay="true" muted="muted">
                          <source src="{{ env('CMS_URL').'/images/banners/'.App\Banner::find(1)->image }}" type="video/mp4">
                        </video>
                      @endif
                    </div>
                </div>

            </div>

            <div class="main-banner__content_item">
                <div class="overlay">
                    <div class="banner-title text-center ">
                        <p>{{ App\Banner::find(1)->small_text }}</p>
                        <h1>{{ App\Banner::find(1)->big_text }}</h1>
                    </div>
                    <div class="main-banner__img">
                      @if(App\Banner::find(1)->type == "image")
                        <img src="{{ env('CMS_URL').'/images/banners/'.App\Banner::find(1)->image }}">
                        <div class="mask"></div>
                      @elseif(App\Banner::find(1)->type == "video")
                        <video loop style="width: 100%;" autoplay="true" muted="muted">
                          <source src="{{ env('CMS_URL').'/images/banners/'.App\Banner::find(1)->image }}" type="video/mp4">
                        </video>
                      @endif
                    </div>
                </div>

            </div>

        </div>

    </section>


    