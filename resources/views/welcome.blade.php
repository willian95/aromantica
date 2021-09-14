@extends("layouts.index")

@section("content")

    @include('partials.banner')
    @include('partials.categories')
    @include('partials.top')
    @include('partials.productos')


@endsection

   <!-- Modal -->
        <div class="modal fade newletter" id="new" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content">
                    <div class="modal-body bg-new" style="background-image: url('assets/img/newletter.jpg');">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="newl-content">
                            <!---<span>Regala personalidad</span>-->
                            <h2>Suscríbete a nuestro <br> newsletter </h2>
                            <form @submit.prevent="store()">
                                <div class="grid-new">
                                    <div class="">
                                        <div class="form-group"><label for="emailLogin">Correo electrónico</label> <input type="text" autocomplete="off" placeholder="Email" class="form-control" v-model="email"> <i class="fa fa-envelope icon_form"></i></div>
                                    </div>
                                    <div class="">

                                        <button class="btn btn-custom">SUSCRIBIR</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
