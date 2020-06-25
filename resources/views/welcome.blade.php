@extends("layouts.index")

@section("content")

    @include('partials.banner')
    @include('partials.categories')
    @include('partials.top')
    @include('partials.productos')



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