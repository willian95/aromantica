@extends("layouts.index")

@section("content")

    <div class="" id="dev-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>@{{ payment.status }}</h3>
                </div>
                <div class="col-12">
                    <p>Total: @{{ payment.total }}</p>
                    <p>Referencia ePayco: @{{ payment.epayco_reference }}</p>
                    <p>Referencia de comercio: @{{ payment.order_id }}</p>
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
                            //localStorage.removeItem("cartAromantica")
                            //localStorage.removeItem("guestUserAromantica")
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