@extends("layouts.index")

@section("content")

<div class="container fleex p-50" id="dev-area">
    <div class="title__general text-center  justify-content-between" style="    width: 100%;">
        <h2>Recuperar mi contraseña</h2>
    </div>

    <div class="row" v-cloak>
        <div class="col-12">

            <div class="form-group mb-4" style="    width: 320px;">

                <label for="">Correo electrónico</label>
                <input type="text" class="form-control" v-model="email">

            </div>

            <p class="text-center">
                <button class="btn  btn-custom " @click="forgot()">Recuperar</button>
            </p>

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
            email: ""
        }
    },
    methods: {

        forgot() {

            if (this.email != "") {

                axios.post("{{ url('/forgot-password') }}", {
                        email: this.email
                    })
                    .then(res => {

                        if (res.data.success == true) {
                            alertify.success(res.data.msg)
                            this.email = ""
                        } else {
                            alertify.error(res.data.msg)
                        }

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value) {
                            alertify.error(value[0])
                        });
                    })

            } else {

                alertify.error("Email es requerido")

            }

        }


    },
    mounted() {

    }

})
</script>

@endpush