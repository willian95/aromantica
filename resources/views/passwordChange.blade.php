@extends("layouts.index")

@section("content")

<div class="container p-50" id="dev-area">
    <div class="row" v-cloak>
        <div class="col-12">
            <div class="form-group">
                <label for="">Nueva contraseña</label>
                <input type="text" class="form-control" v-model="password">
            </div>
            <div class="form-group">
                <label for="">Repetir contraseña</label>
                <input type="text" class="form-control" v-model="password_confirmation">
            </div>
            <p class="text-center">
                <button class="btn btn-success" @click="update()">Actualizar</button>
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
            authCheck: "{{ \Auth::check() }}",
            password: "",
            password_confirmation: "",
            userId: "{{ $user->id }}"
        }
    },
    methods: {

        update() {

            axios.post("{{ url('/password/update') }}", {
                    id: this.userId,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                })
                .then(res => {

                    if (res.data.success == true) {

                        alertify.success(res.data.msg)
                        window.location.href = "{{ url('/') }}"

                    } else {

                        alertify.error(res.data.msg)

                    }

                })
                .catch(err => {
                    $.each(err.response.data.errors, function(key, value) {
                        alertify.error(value[0])
                    });
                })

        }

    },
    mounted() {



    }

})
</script>

@endpush