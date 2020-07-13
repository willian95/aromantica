@extends("layouts.index")

@section("content")

    <div class="" id="dev-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 v-if="payment.status == 'aprobado'" class="text-center" style="margin-top: 20px;">Muchas gracias! Tu pago ha sido aprobado! Revisa tu email para seguir el proceso de tu compra!</h3>
                    <h3 v-else class="text-center" style="margin-top: 20px;">@{{ payment.status }}</h3>
                </div>
                <div class="col-12">
                    <p><strong>Total:</strong> $ @{{ parseFloat(payment.total).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</p>
                    <p><strong>Referencia ePayco:</strong> @{{ payment.epayco_reference }}</p>
                    <p><strong>Referencia de comercio:</strong> @{{ payment.order_id }}</p>
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
                    refPayco:"{{ $ref }}",
                    payment:""
                }
            },
            methods:{
                
                storePayment(){

                    let guestUser = JSON.parse(window.localStorage.getItem("guestUserAromantica"))

                    axios.post("{{ url('checkout/confirm/payment') }}", {guestCart: JSON.parse(window.localStorage.getItem('cartAromantica')), refPayco: this.refPayco, guestUser: guestUser}).then(res => {
                        if(res.data.success == true){
                            this.payment = res.data.payment
                            localStorage.removeItem("cartAromantica")
                            localStorage.removeItem("guestUserAromantica")
                            $("#cart-notification").html("0")
                        }else{
                            alert(res.data.msg)
                        }
                    })

                }
                

            },
            mounted(){

                this.storePayment()

            }

        })
    </script>

@endpush