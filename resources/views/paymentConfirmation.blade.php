@extends("layouts.index")

@section("content")

<div class="p-50" id="dev-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 v-if="payment.status == 'aprobado'" class="text-center" style="margin-top: 20px;">Muchas gracias! Tu
                    pago ha sido aprobado! Revisa tu email para seguir el proceso de tu compra!
                </h3>
                <div v-else class="text-center" style="margin-top: 20px;">
                    <h3>@{{ payment.status }}</h3>
                    <p class="text-center" v-if="loading != ''">
                        <button class="btn btn-primary" @click="closeWindow()">Aceptar</button>
                    </p>
                </div>

            </div>
            <div class="col-12" v-if="payment.status == 'aprobado'">
                <p><strong>Total:</strong> $
                    @{{ parseFloat(payment.total).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</p>
                <p><strong>Referencia ePayco:</strong> @{{ payment.epayco_reference }}</p>
                <p><strong>Referencia de comercio:</strong> @{{ payment.order_id }}</p>
                <p><a :href="payment.tracking_url" target="_blank">Seguimiento: @{{ payment.tracking }}</a></p>
                <p class="text-center">
                    <button class="btn btn-primary" @click="closeWindow()">Aceptar</button>
                </p>
            </div>

            <div class="col-12">
                <h2 class="text-center" v-if="loading == ''">Cargando resultados</h2>
            </div>

        </div>
    </div>
</div>

@endsection

@push("scripts")

<script>
const devArea = new Vue({
    el: '#dev-area',
    data() {
        return {
            refPayco: "{{ $ref }}",
            payment: "",
            loading: ""
        }
    },
    methods: {

        storePayment() {

            let guestUser = JSON.parse(window.localStorage.getItem("guestUserAromantica"))
            let service = JSON.parse(window.localStorage.getItem("service"))
            let shippingData = JSON.parse(window.localStorage.getItem("shipping_data"))

            axios.post("{{ url('checkout/confirm/payment') }}", {
                guestCart: JSON.parse(window.localStorage.getItem('cartAromantica')),
                refPayco: this.refPayco,
                guestUser: guestUser,
                service: service,
                shippingData: shippingData
            }).then(res => {
                this.loading = "done"
                if (res.data.success == true) {
                    this.payment = res.data.payment
                    localStorage.setItem("paymentStatusAromantica", "aprobado")
                    localStorage.removeItem("cartAromantica")
                    localStorage.removeItem("guestUserAromantica")
                    $("#cart-notification").html("0")

                } else {
                    alertify.error(res.data.msg)
                    localStorage.setItem("paymentStatusAromantica", "rechazado")
                }
            })

        },
        closeWindow() {
            window.close()
        }


    },
    mounted() {

        this.storePayment()

    }

})
</script>

@endpush