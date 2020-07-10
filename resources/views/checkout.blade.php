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
                        <label class="total">Total: $ @{{ parseInt(total).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</label>
                    </div>

                    <form id="frm_botonePayco" name="frm_botonePayco" method="post" action="https://secure.payco.co/checkout.php" target="_blank" v-if="total > 0 && name != '' && email != '' && identification != '' && address != '' && phone != ''">
                        <input name="p_cust_id_cliente" type="hidden" value="82433">
                        <input name="p_key" type="hidden" value="1d321ba074d13cb580da34031bc7192331a73fed">
                        <input name="p_id_invoice" id="p_id_invoice" type="hidden" v-model="billingNumber">
                        <input name="p_description" type="hidden" value="Compra Aromantica">
                        <input name="p_currency_code" type="hidden" value="COP">
                        <input name="p_amount" id="p_amount" type="hidden" v-model="total">
                        <input name="p_tax" id="p_tax" type="hidden" value="0">
                        <input name="p_amount_base" id="p_amount_base" type="hidden" value="0">
                        <input name="p_test_request" type="hidden" value="TRUE">
                        <input name="p_email" type="hidden" value="rodriguezwillian95@gmail.com">
                        <input name="p_url_response" type="hidden" value="http://localhost:8000/checkout/response">
                        <input name="p_url_confirmation" type="hidden" value="http://localhost:8000/checkout/confirmation">
                        <input name="p_confirm_method" type="hidden" value="POST">
                        <input name="p_signature" type="hidden" id="signature" v-model="signatureHash"/>
                        <input name="p_billing_document" type="hidden" id="p_billing_document" v-model="identification" />
                        <input name="p_billing_name" type="hidden" id="p_billing_name" v-model="name" />
                        <!--<input name="p_billing_lastname" type="hidden" id="p_billing_lastname" value="" />-->
                        <input name="p_billing_address" type="hidden" id="p_billing_address" v-model="address" />
                        <input name="p_billing_country" type="hidden" id="p_billing_country" value="CO" />
                        <input name="p_billing_email" type="hidden" id="p_billing_email" v-model="email" />
                        <input name="p_billing_phone" type="hidden" id="p_billing_phone" v-model="phone" />
                        <input name="p_billing_cellphone" type="hidden" id="p_billing_cellphone" v-model="phone" />
                        <input type="image" @click="storeGuestUser()" id="imagen" src="https://369969691f476073508a-60bf0867add971908d4f26a64519c2aa.ssl.cf5.rackcdn.com/btns/btn1.png" />
                    </form>

                    <div v-if="total <= 0">
                        <p>Debe agregar productos al carrito</p>
                    </div>

                    <div v-if="name == '' || email == '' || identification == '' || address == '' || phone == ''">
                        <p>Debe iniciar sesión o llenar todos los campos del formulario</p>
                    </div>
    
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
                    authCheck:"{{Auth::check()}}",
                    total:0,
                    signatureHash:"",
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
                            
                            $("#p_amount_base").val(this.total)
                            $("#p_amount").val(this.total)
                            this.signature()

                        }

                    })

                },
                signature(){

                    axios.post("{{ url('checkout/signature') }}", {total: this.total}).then(res => {

                        console.log(res)
                        //$("#signature").val(res.data.hash)
                        this.billingNumber = res.data.billingNumber
                        this.signatureHash = res.data.hash
                        //$("#p_id_invoice").val(res.data.billingNumber)

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

                            $("#p_amount_base").val(this.total)
                            $("#p_amount").val(this.total)
                            this.signature()
                            if(this.authCheck != ''){
                                this.fetch()
                            }

                        }else{
                            alert(res.data.msg)
                        }

                    })

                },
                storeGuestUser(){

                    let user = {name: this.name, email: this.email, identification: this.identification, address: this.address, phone: this.phone}
                    window.localStorage.setItem("guestUserAromantica", JSON.stringify(user))

                }


            },
            mounted(){
                this.guestFetch()
                //this.storeSessionProducts()

                this.readonly = "{{ Auth::check() }}"
                if(this.readonly == ""){
                    this.readonly = false
                }

            }

        })

    </script>

@endpush