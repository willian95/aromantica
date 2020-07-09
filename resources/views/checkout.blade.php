@extends("layouts.index")

@section("content")

    <div class="container" id="dev-area">
        <div class="row">
            <div class="col-12">
                <div class="title__general text-left">
                    <h2>Checkout</h2>
                  </div>
               
            </div>
          <div class="col-md-6">
            <div class="">
                <div class="form-group">
                    <label for="name"><i class="fa fa-user icon_form"></i></i> Nombre</label>
                    <input type="text" class="form-control" v-model="name" id="name" :readonly="readonly">
                </div>
            </div>
            <div class="">

                <div class="form-group">
                    <label for="email"><i class="fa fa-envelope icon_form"></i>Email</label>
                    <input type="text" class="form-control" v-model="email" id="email" :readonly="readonly">
                </div>

            </div>
            <div class="">

                <div class="form-group">
                    <label for="phone"><i class="fa fa-phone icon_form"></i>Teléfono</label>
                    <input type="text" class="form-control" v-model="phone" id="phone">
                </div>

            </div>
            <div class="">

                <div class="form-group">
                    <label for="identification"><i class="fa fa-id-card icon_form"></i>Cédula</label>
                    <input type="text" class="form-control" v-model="identification" id="identification">
                </div>

            </div>
            <div class="">

                <div class="form-group">
                    <label for="dirección"><i class="fa fa-globe icon_form"></i>Dirección</label>
                    <input type="text" class="form-control" v-model="address" id="dirección">
                </div>

            </div>
           
          </div>
            <div class="col-md-6">
                <div class="card-pay text-center">

                    <div class="form-group">
                        <label class="total">Total: @{{ total }}</label>
                    </div>
    
            
    
                <!--<button class="btn btn-custom " @click="payment()">Pagar</button>-->
                <form>
                    <script
                        src="https://checkout.epayco.co/checkout.js"
                        class="epayco-button"
                        data-epayco-key="1d321ba074d13cb580da34031bc7192331a73fed"
                        data-epayco-amount="50000"
                        data-epayco-name="Vestido Mujer Primavera"
                        data-epayco-description="Vestido Mujer Primavera"
                        data-epayco-currency="cop"
                        data-epayco-country="co"
                        data-epayco-test="true"
                        data-epayco-external="false"
                        data-epayco-response="https://ejemplo.com/respuesta.html"
                        data-epayco-confirmation="https://ejemplo.com/confirmacion">
                    </script>
                </form>
            </div>
            </div>


        </div>
    </div>

@endsection

@push("scripts")

    <script type="text/javascript" src="https://checkout.epayco.co/checkout.js">   </script>

    <script>
    
        const devArea = new Vue({
            el: '#dev-area',
            data(){
                return{
                    name:"{{ Auth::check() ? Auth::user()->name : '' }}",
                    email:"{{ Auth::check() ? Auth::user()->email : '' }}",
                    identification:"{{ Auth::check() ? Auth::user()->identification : '' }}",
                    address:"{{ Auth::check() ? Auth::user()->address : '' }}",
                    phone:"{{ Auth::check() ? Auth::user()->phone : '' }}",
                    readonly:"false",
                    total:0,
                    nameProduts:"",
                    billingNumber:""
                }
            },
            methods:{
                
                fetch(){

                    axios.get("{{ url('/cart/fetch') }}")
                    .then(res => {

                        if(res.data.success == true){

                            res.data.products.forEach((data, index) => {

                                this.total = this.total + (data.amount * data.product_type_size.price)

                            })

                        }

                    })

                },
                guestFetch(){

                    let cart = []
                    if(window.localStorage.getItem('cartAromantica') != null){
                        cart =JSON.parse(window.localStorage.getItem('cartAromantica'))
                    }

                    axios.post("{{ url('/cart/guest/fetch') }}", {cart: cart}).then(res => {

                        if(res.data.success == true){

                            res.data.guestProducts.forEach((data, index) => {

                                this.total = this.total + (parseFloat(data.product.price) * parseInt(data.amount))

                            })

                        }else{
                            alert(res.data.msg)
                        }

                    })

                },
                payment(){

                    var handler = ePayco.checkout.configure({
                        key: '1d321ba074d13cb580da34031bc7192331a73fed',
                        test: true
                    })

                    axios.get("{{ url('/checkout/billing') }}").then(res => {

                        

                    })

                    var data={
                        //Parametros compra (obligatorio)
                        name: "Vestido Mujer Primavera",
                        description: "Vestido Mujer Primavera",
                        invoice: "1234",
                        currency: "cop",
                        amount: this.total,
                        tax_base: "0",
                        tax: "0",
                        country: "co",
                        lang: "es",

                        //Onpage="false" - Standard="true"
                        external: "true",


                        //Atributos opcionales
                        confirmation: "http://secure2.payco.co/prueba_curl.php",
                        response: "http://secure2.payco.co/prueba_curl.php",

                        //Atributos cliente
                        name_billing: this.name,
                        address_billing: this.address,
                        type_doc_billing: "cc",
                        mobilephone_billing: this.phone,
                        number_doc_billing: ""

                        //atributo deshabilitación metodo de pago
                        methodsDisable: ["TDC", "PSE","SP","CASH","DP"]

                    }


                }

            },
            mounted(){

                this.fetch()
                this.guestFetch()

                this.readonly = "{{ Auth::check() }}"
                if(this.readonly == ""){
                    this.readonly = false
                }

            }

        })

    </script>

@endpush