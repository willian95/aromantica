@extends("layouts.index")

@section("content")

<section class="container p-50" id="dev-area">
    <div class="car">
        <div class="card-body">
            <div class="title__general title__general2 fadeInUp wow animated title__general_flex">
                <p class="m-0">Perfil</p>

                <div class=" form-group  text-center">
                    <button class="btn btn-primary btn-custom " @click="update()">Editar</button>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Nombre</label>
                        <input placeholder="pedro perez" type="text" v-model="name" autocomplete="off"
                            class="form-control" id="email" aria-describedby="emailHelp">
                        <i class="fa fa-user icon_form"></i>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input placeholder="pedroperez@gmail.com" type="email" autocomplete="off" class="form-control"
                            id="text" aria-describedby="emailHelp" v-model="email" :readonly="true">
                        <i class="fa fa-envelope icon_form"></i>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address">Dirección</label>

                        <input placeholder="Dirección" type="text" class="form-control  " id="address"
                            v-model="address">
                        <i class="fa fa-globe icon_form"></i>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Teléfono</label>

                        <input placeholder="+1234567" type="text" class="form-control  " id="telephone"
                            v-model="telephone" @keypress="isNumber($event)">
                        <i class="fa fa-phone icon_form"></i>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="identification">Identificación</label>

                        <input placeholder="Dirección" type="text" class="form-control  " id="identification"
                            v-model="identification" @keypress="isNumber($event)">
                        <i class="fa fa-globe icon_form"></i>
                    </div>
                </div>
            </div>


        </div>
    </div>

</section>

@endsection

@push("scripts")

<script>
const devArea = new Vue({
    el: '#dev-area',
    data() {
        return {
            name: "{{ Auth::user()->name }}",
            email: "{{ Auth::user()->email }}",
            address: "{{ Auth::user()->address }}",
            telephone: "{{ Auth::user()->phone }}",
            identification: "{{ Auth::user()->identification }}"
        }
    },
    methods: {

        update() {

            axios.post("{{ url('/profile/update') }}", {
                    name: this.name,
                    address: this.address,
                    phone: this.telephone,
                    identification: this.identification
                })
                .then(res => {

                    if (res.data.success == true) {
                        alert(res.data.msg)
                    } else {
                        alert(res.data.msg)
                    }

                })
                .catch(err => {
                    $.each(err.response.data.errors, function(key, value) {
                        alert(value)
                        //alertify.error(value);
                        //alertify.alert('Basic: true').set('basic', true); 
                    });
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


    },
    mounted() {

    }

})
</script>

@endpush