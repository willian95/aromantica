@extends("layouts.index")

@section("content")

    @include('partials.banner')
    @include('partials.categories')

    <div class="container" id="dev-area">
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
    </div>

@endsection

@push("scripts")

    <script>

        const devArea = new Vue({
            el: '#dev-area',
            data(){
                return{
                    perfumes:[]
                }
            },
            methods:{
                
                fetch(){

                    axios.get("{{ url('/home/fetch') }}").then(res => {

                        if(res.data.success == true){
                            
                            this.perfumes = res.data.products
                        }

                    })

                }

            },
            mounted(){

                this.fetch()

            }

        })
    
    </script>

@endpush