@extends("layouts.index")

@section("content")

    <div class="container" id="dev-area">
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products">
                            <td>@{{ product.product_type_size.product.name }} - @{{ product.product_type_size.type.name }} - @{{ product.product_type_size.size.name }} Oz</td>
                            <td>@{{ product.amount }}</td>
                            <td>$ @{{ parseFloat(product.product_type_size.price) * parseInt(product.amount) }}</td>
                            <td><button class="btn btn-danger">delete</button></td>
                        </tr>
                    </tbody>
                </table>
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
                    authCheck:"{{ \Auth::check() }}",
                    products:""
                }
            },
            methods:{
                
                fetch(){

                    axios.get("{{ url('/cart/fetch') }}")
                    .then(res => {

                        if(res.data.success == true){
                           
                            this.products = res.data.products

                        }

                    })

                },
                erase(id){

                    axios.post("{{ url('/cart/delete') }}", {id:id})
                    .then(res => {

                        if(res.data.success == true){
                            
                            this.fetch()

                        }

                    })

                }

            },
            mounted(){

                if(this.authCheck){
                    this.fetch()
                }

            }

        })

    </script>

@endpush