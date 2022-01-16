@extends("layouts.index")

@section("content")

<style>
    ::placeholder{ color:#eee}
</style>

<div style="position: fixed; top: 0; bottom: 0; left:0; right: 0; width: 100%; background: rgba(0, 0, 0, 0.6); z-index: 999999; display:none;"
    id="cover">

</div>

<div class="container p-50" id="dev-area">
    <div class="row" v-cloak>
        <div class="col-12">


        </div>
        <div class="col-md-6">
            <div class="title__general text-left">
                <h2>Checkout @if(\Auth::guest())<span style="font-weight: normal; font-size: 20px;">(como
                        invitado)</span>@endif</h2>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name"><i class="fa fa-user icon_form"></i></i> Nombre</label>
                        <input type="text" class="form-control" v-model="name" id="name" :readonly="readonly">
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="email"><i class="fa fa-envelope icon_form"></i>Email</label>
                        <input type="text" class="form-control" v-model="email" id="email" :readonly="readonly">
                    </div>

                </div>
            </div>
            <div class="">

                <div class="form-group">
                    <label for="dirección"><i class="fa fa-globe icon_form"></i>Dirección</label>
                    <input type="text" class="form-control" v-model="address" id="dirección">
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="phone"><i class="fa fa-phone icon_form"></i>Teléfono</label>
                        <input type="text" class="form-control" v-model="phone" id="phone" @keypress="isNumber($event)">
                    </div>

                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="identification"><i class="fa fa-id-card icon_form"></i>Cédula</label>
                        <input type="text" class="form-control" v-model="identification" id="identification"
                            @keypress="isNumber($event)">
                    </div>

                </div>
            </div>


        </div>

        <div class="col-md-6">
            <div class="title__general text-left ">
                <h2>Datos de envío
                </h2>
            </div>
            <div class="card-pay ">

                <div class="row">
                    <div class="col-md-6">


                        <div class="form-group">
                            <label for="state"><i class="fa fa-map icon_form"></i>Departamento</label>
                            <select class="form-control" v-model="state" id="state"
                                @change="setShippingCalculatedFalse(); getProvinces()">
                                <option v-for="state in states" :value="state.code_2_digits">@{{ state.name }}
                                </option>
                            </select>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="city"><i class="fa fa-map icon_form"></i>Ciudad</label>
                            <select class="form-control" v-model="city" id="city"
                                @keyup="setShippingCalculatedFalse()">
                                <option v-for="province in provinces" :value="province.code">@{{ province.name }}
                                </option>
                            </select>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            <label for="dirección"><i class="fa fa-map-marker icon_form"></i>Dirección de envío</label>
                            <input placeholder="Cra 12 # 34 - 56" type="text" class="form-control" v-model="street"
                                id="dirección" @keyup="setShippingCalculatedFalse()">
                        </div>

                    </div>
                    <!--<div class="col-md-6">

                        <div class="form-group">
                            <label for="postalCode"><i class="fa fa-id-card icon_form"></i>Código postal</label>
                            <input type="text" placeholder="opcional" class="form-control" v-model="postalCode" id="postalCode"
                                @keypress="isNumber($event)" @keyup="setShippingCalculatedFalse()">
                        </div>

                    </div>-->

                </div>
                <div class="">

                    <div class="form-group">
                        <label for="streetNumber">Carriers</label>
                        <select class="form-control" v-model="carrier" @change="reloadServices()" style="text-transform: capitalize;">
                            <option :value="carrier" v-for="carrier in carriers" style="text-transform: capitalize;">
                                @{{ carrier.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="mt-5" style="display: flex; justify-content: space-between;">
                    <button class=" btn-custom mb-5" @click="calculateCarrier()">Calcular envío</button>
                    <div class="form-group totaal">
                        <label class="total">Total: $
                            @{{ parseInt(total).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</label>
                    </div>


                </div>

                <div class="title__general text-left m-0">
                    <h2 v-if="availableServices.length > 0">Courier</h2>
                </div>

                <!-- <h4 class="text-center" v-if="availableServices.length > 0">Courier</h4> -->
                <div class="grid-cou">

                    <div class="card" v-for="availableService in availableServices"
                        style="margin-top: 5px; cursor:pointer" @click="setService(availableService)">
                        <div class="card-body">
                            <h4 class="text-center carrier-name" style="text-transform: capitalize;">
                                <img style="width: 50px;" :src="carrier.logo" alt="">
                                @{{ carrier.name }}</h4>
                            <p>$ @{{ parseInt(availableService.totalPrice + 1).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}
                                COP</p>
                            <small><span style="text-transform: capitalize;">@{{ availableService.service }} </span> - @{{ availableService.deliveryEstimate }}</small>
                        </div>
                    </div>
                </div>
               


                <form id="frm_botonePayco" name="frm_botonePayco" method="post"
                    action="https://secure.payco.co/checkout.php" target="print_popup"
                    v-if="total > 0 && name != '' && email != '' && identification != '' && address != '' && phone != '' && shippingCalculated == true"
                    @click="storeLocal()" onsubmit="openChildWindow()">
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
                    <input name="p_url_response" type="hidden" value="{{ url('checkout/response') }}">
                    <input name="p_url_confirmation" type="hidden" value="{{ url('checkout/confirmation') }}">
                    <input name="p_confirm_method" type="hidden" value="POST">
                    <input name="p_signature" type="hidden" id="signature" v-model="signatureHash" />
                    <input name="p_billing_document" type="hidden" id="p_billing_document" v-model="identification" />
                    <input name="p_billing_name" type="hidden" id="p_billing_name" v-model="name" />
                    <!--<input name="p_billing_lastname" type="hidden" id="p_billing_lastname" value="" />-->
                    <input name="p_billing_address" type="hidden" id="p_billing_address" v-model="address" />
                    <input name="p_billing_country" type="hidden" id="p_billing_country" value="CO" />
                    <input name="p_billing_email" type="hidden" id="p_billing_email" v-model="email" />
                    <input name="p_billing_phone" type="hidden" id="p_billing_phone" v-model="phone" />
                    <input name="p_billing_cellphone" type="hidden" id="p_billing_cellphone" v-model="phone" />
                    <p class="text-center">
                    <input type="image" @click="storeGuestUser()" id="imagen"
                        src="https://369969691f476073508a-60bf0867add971908d4f26a64519c2aa.ssl.cf5.rackcdn.com/btns/btn1.png" style="width: 250px; padding: 2rem;"/>
                    </p>
                </form>

                <div v-if="total <= 0">
                    <p>Debes agregar productos al carrito</p>
                </div>

                <div v-if="name == '' || email == '' || identification == '' || address == '' || phone == ''">
                    <p>Debes iniciar sesión o llenar todos los campos del formulario</p>
                </div>

            </div>
        </div>


    </div>

</div>

@endsection

@push("scripts")

<script type="text/javascript" src="https://checkout.epayco.co/checkout.js"> </script>

<script>
const devArea = new Vue({
    el: '#dev-area',
    data() {
        return {
            name: "{{ Auth::check() ? Auth::user()->name : '' }}",
            email: "{{ Auth::check() ? Auth::user()->email : '' }}",
            identification: "{{ Auth::check() ? Auth::user()->identification : '' }}",
            address: "{{ Auth::check() ? Auth::user()->address : '' }}",
            street: "",
            phone: "{{ Auth::check() ? Auth::user()->phone : '' }}",
            readonly: "false",
            shippingCalculated: false,
            states: "",
            state: "CN",
            city: "",
            postalCode: "",
            streetNumber: "49B-20",
            authCheck: "{{Auth::check()}}",
            basePrice: 0,
            total: 0,
            signatureHash: "",
            nameProduts: "",
            billingNumber: "",
            availableServices: [],
            choosenService: "",
            packages: [],
            carriers: [],
            provinces:[],
            carrier: ""
        }
    },
    methods: {
        fetch() {
            axios.get("{{ url('/cart/fetch') }}")
                .then(res => {
                    if (res.data.success == true) {
                        res.data.products.forEach((data, index) => {
                            
                                this.total = this.total + (data.amount * data.price)
                          
                            
                            let weight = 0
                            if (parseInt(data.amount) > 1) {
                                weight = parseFloat(data.amount/2)
                            } else {
                                weight = 0.5
                            }
                            this.packages.push({
                                "content": data.product_type_size.product.name,
                                "amount": data.amount,
                                type: "box",
                                "dimensions": {
                                    "length": 4,
                                    "width": 8,
                                    "height": 13
                                },
                                "weight": weight,
                                "insurance": 0,
                                "declaredValue": (parseFloat(data.price) *
                                    parseInt(data.amount)),
                                "weightUnit": "KG",
                                "lengthUnit": "CM"
                            })
                        })
                        this.baseTotal = this.total
                        this.cartInfo()
                    }
                })
        },
        isNumber: function(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                evt.preventDefault();;
            } else {
                return true;
            }
        },
        signature() {
            axios.post("{{ url('checkout/signature') }}", {
                total: this.total
            }).then(res => {
                console.log(res)
                this.shippingCalculated = true
                //$("#signature").val(res.data.hash)
                this.billingNumber = res.data.billingNumber
                this.signatureHash = res.data.hash
                //$("#p_id_invoice").val(res.data.billingNumber)
            })
        },
        updateCartAmount(product_type_size_id, amount) {

            axios.post("{{ url('/cart/amount/update') }}", {
                productTypeSizeId: product_type_size_id,
                amount: amount
            })
            .then(res => {


            })

        },
        checkAuthCartAmounts(){

            axios.get("{{ url('/cart/fetch') }}")
                .then(res => {

                if (res.data.success == true) {


                    this.products = res.data.products

                    this.products.forEach((data, index) => {

                    
                        if(data.product_type_size.stock < data.amount){
                            
                            this.updateCartAmount(this.products[index].product_type_size.id, this.products[index].product_type_size.stock)
                            //this.cartInfo()
                        }

                    })

                    window.setTimeout(() => {
                        this.fetch()
                    }, 300)
                    

                }

            })

        },
        cartInfo() {
            var totalGuest = 0;
            var totalCheck = 0;

            let cart = []
            if (window.localStorage.getItem('cartAromantica') != null) {
                cart = JSON.parse(window.localStorage.getItem('cartAromantica'))
            }

            cart.forEach((data, index) => {
                
                totalGuest = data.amount + totalGuest

            })

            if (this.authCheck == "1") {

                axios.get("{{ url('/cart/fetch') }}")
                    .then(res => {

                        if (res.data.success == true) {

                            this.products = res.data.products

                            this.products.forEach((data, index) => {
                                
                                totalCheck = totalCheck + data.amount

                            })

                            let cartTotalCheck = totalGuest + totalCheck
                
                            $("#cart-notification").html(cartTotalCheck + "")
                            localStorage.setItem("executeCartPreview", "1")
                        }

                    })

            }else{
                localStorage.setItem("executeCartPreview", "1")
            }

            let cartTotal = totalGuest + totalCheck
            $("#cart-notification").html(cartTotal + "")
        },
        checkGuestCartAmounts(){

            let cart = []
            if (window.localStorage.getItem('cartAromantica') != null) {
                cart = JSON.parse(window.localStorage.getItem('cartAromantica'))
            }

            axios.post("{{ url('/cart/guest/fetch') }}", {
                cart: cart
            }).then(res => {

                this.guestProducts = res.data.guestProducts

                this.guestProducts.forEach((data, index) => {
                    if(data.product.stock < data.amount){
                        isAmountChanged = true
                        if (window.localStorage.getItem('cartAromantica') != null) {
                            cart = JSON.parse(window.localStorage.getItem('cartAromantica'))
                        }

                        cart.forEach((prod) => {

                            if (prod.productTypeSizeId == this.guestProducts[index].product.id) {
                                prod.amount = data.product.stock
                                exists = true
                            }

                        })

                        window.localStorage.setItem("cartAromantica", JSON.stringify(cart))

                    }
                })

                this.guestFetch()

            })  

        },
        guestFetch() {
            let cart = []
            let packages = []
            if (window.localStorage.getItem('cartAromantica') != null) {
                cart = JSON.parse(window.localStorage.getItem('cartAromantica'))
            }
            axios.post("{{ url('/cart/guest/fetch') }}", {
                cart: cart
            }).then(res => {
                if (res.data.success == true) {
                    res.data.guestProducts.forEach((data, index) => {
                        if(data.product.discount_percentage == 0){
                            this.total = this.total + (parseFloat(data.product.price) * parseInt(data.amount))
                        }else{
                            this.total = this.total + (parseInt(data.amount) * (parseFloat(data.product.price) - (parseFloat(data.product.price) * (parseFloat(data.product.discount_percentage)/100))))
                        }
                        let weight = 0
                        if (parseInt(data.amount) > 1) {
                            weight = parseFloat(data.amount/2)
                        } else {
                            weight = 0.5
                        }
                        this.packages.push({
                            "content": data.product.product.name,
                            "amount": data.amount,
                            "type": "box",
                            "dimensions": {
                                "length": 4,
                                "width": 8,
                                "height": 13
                            },
                            "weight": weight,
                            "insurance": 0,
                            "declaredValue": (parseFloat(data.product.price) * parseInt(
                                data.amount)),
                            "weightUnit": "KG",
                            "lengthUnit": "CM"
                        })
                    })
                    this.baseTotal = this.total
                    //$("#p_amount_base").val(this.total)
                    //$("#p_amount").val(this.total)
                    //alert("entre 1")
                    
                    if (this.authCheck != '') {
                        this.checkAuthCartAmounts()
                    }else{
                        this.cartInfo()
                    }
                } else {
                    alertify.error(res.data.msg)
                }
            })
        },
        storeGuestUser() {
            let user = {
                name: this.name,
                email: this.email,
                identification: this.identification,
                address: this.street,
                phone: this.phone
            }
            window.localStorage.setItem("guestUserAromantica", JSON.stringify(user))
        },
        calculateCarrier() {
            if(this.city != "" && this.state != "" && this.street){
                let zipcode = "110111"
                if(this.postalCode == ''){
                    zipcpde = this.postalCode
                }
                var data = {
                    "origin": {
                        "name": "Aromantica",
                        "company": "Aromantica",
                        "email": "ventas@aromantica.co",
                        "phone": "3165726092‬",
                        "street": "carrera 60 #5A - 27 Barrio Galan Puente Aranda",
                        "number": "",
                        "district": "Cundinamarca",
                        "city": "11001000",
                        "state": "CN",
                        "country": "CO",
                        "postalCode": "900864948-9",
                        "reference": ""
                    },
                    "destination": {
                        "name": this.name,
                        "company": this.name,
                        "email": this.email,
                        "phone": this.phone,
                        "street": this.street,
                        "number": "",
                        "district": "",
                        "city": this.city,
                        "state": this.state,
                        "country": "CO",
                        "postalCode": this.city,
                        "reference": ""
                    },
                    "packages": this.packages,
                    "shipment": {
                        "carrier": this.carrier.name,
                        "type": 1
                    }
                }
                vm = this
                $.ajax({
                    type: "POST",
                    //url: "https://api-test.envia.com/ship/rate",
                    url: "https://api.envia.com/ship/rate",
                    data: JSON.stringify(data),
                    dataType: "json",
                    /*headers: {
                        'Authorization': 'Bearer 2acacff444ddd328fb8b7e64c94671740218643867cb7d69489d33ca77147c0d'
                    },*/
                    headers: {
                        'Authorization': 'Bearer 5e0ad0d945ccc05a410561f389dd2e4c035c84ad7d4269b13fd6d54d0b8e6d8c'
                    },
                    crossDomain: true,
                    success: function(result) {
                        // process result
                        if (result.meta == "error") {
                            alertify.error(result.error.message)
                        } else {
                            vm.availableServices = result.data
                        }
                    },
                    error: function(e) {
                        // log error in browser
                        console.log(e.message);
                    }
                });
            }else{  
                alertify.error("Debe completar los campos para el envío")
            }
            
        },
        setShippingCalculatedFalse() {
            this.shippingCalculated = false
            this.availableServices = []
            this.choosenService = ""
        },
        setService(service) {
            this.choosenService = service
            this.total = this.baseTotal + parseInt(service.totalPrice)+1
            this.signature()
        },
        reloadServices() {
            this.availableServices = []
        },
        getCarriers() {
            vm = this
            $.ajax({
                type: "GET",
                url: "https://queries.envia.com/carrier?country_code=CO",
                success: function(result) {
                    // process result
                    vm.carriers = result.data
                },
                error: function(e) {
                    // log error in browser
                    console.log(e.message);
                }
            });
        },
        getStates() {
            vm = this
            $.ajax({
                type: "GET",
                url: "https://queries.envia.com/state?country_code=CO",
                success: function(result) {
                    // process result
                    vm.states = result.data
                },
                error: function(e) {
                    // log error in browser
                    console.log(e.message);
                }
            });
        },
        getProvinces() {
            vm = this
            $.ajax({
                type: "GET",
                url: "https://queries.envia.com/provinces/"+this.state,
                success: function(result) {
                    // process result
                    vm.provinces = result.data
                },
                error: function(e) {
                    // log error in browser
                    console.log(e.message);
                }
            });
        },
        storeLocal() {
            let zipcode = "110111"
            if(this.postalCode == ''){
                zipcpde = this.postalCode
            }
            var data = {
                "origin": {
                    "name": "Aromantica",
                    "company": "Aromantica",
                    "email": "ventas@aromantica.co",
                    "phone": "3165726092‬",
                    "street": "carrera 60 #5A - 27 Barrio Galan Puente Aranda",
                    "number": "",
                    "district": "Cundinamarca",
                    "city": "11001000",
                    "state": "CN",
                    "country": "CO",
                    "postalCode": "900864948-9",
                    "reference": ""
                },
                "destination": {
                    "name": this.name,
                    "company": this.name,
                    "email": this.email,
                    "phone": this.phone,
                    "street": this.street,
                    "number": this.street,
                    "district": this.city,
                    "city": this.city,
                    "state": this.state,
                    "country": "CO",
                    "postalCode": this.city,
                    "reference": ""
                },
                "packages": this.packages,
                "shipment": {
                    "carrier": this.carrier.name,
                    "service": this.choosenService.service,
                    "type": 1
                },
                "settings": {
                    "printFormat": "PDF",
                    "printSize": "STOCK_4X6"
                }
            }
            window.localStorage.setItem("shipping_data", JSON.stringify(data))
        }
    },
    mounted() {
        this.checkGuestCartAmounts()
        //this.guestFetch()
        this.getStates()
        this.getCarriers()
        this.getProvinces()
        //this.getLabels()
        //this.storeSessionProducts()
        this.readonly = "{{ Auth::check() }}"
        if (this.readonly == "") {
            this.readonly = false
        }
    }
})
</script>

<script>
var childWin = null
function openChildWindow() {
    childWin = window.open('about:blank', 'print_popup', 'width=600,height=600');
    $("#cover").css("display", "block")
}
function checkWindow() {
    if (childWin && childWin.closed) {
        window.clearInterval(intervalID);
        $("#cover").css("display", "none")
        if (localStorage.getItem("paymentStatusAromantica") == 'aprobado') {
            localStorage.removeItem("paymentStatusAromantica")
            window.location.href = "{{ url('/') }}"
        } else if (localStorage.getItem("paymentStatusAromantica") == 'rechazado') {
            window.location.reload()
        }
    }
}
var intervalID = window.setInterval(checkWindow, 500);
</script>

@endpush