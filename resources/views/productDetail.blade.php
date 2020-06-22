@extends("layouts.index")

@section("content")

    <div class="container" id="dev-area">
        <div class="row">
            <div class="col-lg-4">
                <h3 class="text-center">@{{ title }}</h3>
                <h4 class="text-center">@{{ brand }}</h4>

                <button class="btn btn-primary" v-for="type in types" @click="selectType(type)" style="margin-right: 5px;">@{{ type.name }}</button>

                <button class="btn btn-success" v-for="size in sizes" @click="selectSize(size)"  style="margin-right: 5px; margin-top: 5px;">@{{ size.name }} Oz - @{{ size.ml }} ml</button>

            </div>
            <div class="col-lg-4">
                Precio: @{{ price }}
                Cantidad: @{{ amount }}
                <button class="btn btn-success" @click="addAmount()">+</button>
                <button class="btn btn-success" @click="substractAmount()">-</button>

                <p class="text-center" style="margin-top: 10px;" v-if="this.type != '' && this.size != ''">
                    <button class="btn btn-success" @click="addToCart()">Agregar al carrito</button>
                </p>

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
                    authCheck:"{{ Auth::check() }}",
                    title:"{{ $product->name }}",
                    category:"{{ $product->category->name }}",
                    brand:"{{ $product->brand->name }}",
                    productTypeSizes:JSON.parse('{!! json_encode($product->productTypeSizes) !!}'),
                    types:[],
                    sizes:[],
                    type:"",
                    size:"",
                    productTypeSize:"",
                    amount:0,
                    stock:0,
                    price:0
                }
            },
            methods:{
                
                selectType(type){
                    this.type = type

                    this.sizes = []
                    this.productTypeSizes.forEach((data, index) => {

                        if(data.type == type){
                            this.sizes.push(data.size)
                        }

                    })

                },
                selectSize(size){   

                    this.amount = 0;
                    this.size = size

                    if(this.type != "" && this.size != ""){

                        this.productTypeSizes.forEach((data, index) => {

                            if(data.type == this.type && data.size == this.size){
                                
                                this.productTypeSize = data
                                this.price = data.price
                                this.stock = data.stock

                            }   

                        })

                    }

                },
                addAmount(){

                    if(this.amount + 1 <= this.stock){
                        this.amount++
                    }

                },
                substractAmount(){

                    if(this.amount - 1 > 0){
                        this.amount--
                    }

                },
                addToCart(){

                    if(this.amount > 0){

                        if(this.authCheck == true){
                            
                            axios.post("{{ url('/cart/store') }}", {productTypeSizeId: this.productTypeSize.id, amount: this.amount})
                            .then(res => {

                                if(res.data.success == true){
                                    alert(res.data.msg)
                                    this.amount = 0;
                                    this.type = ""
                                    this.size = ""
                                    this.productTypeSize = ""
                                }else{
                                    alert(res.data.msg)
                                }

                            })

                        }

                    }else{

                        alert("Debe seleccionar una cantidad")

                    }

                }


            },
            mounted(){

                this.productTypeSizes.forEach((data, index) => {

                    this.types.push(data.type)
                    

                })


            }

        })

    </script>

@endpush