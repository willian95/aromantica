@extends("layouts.index")

@section("content")

<div class="container p-50" id="dev-area">
    <div class="row">
        <div class="title__general text-justify d-flex justify-content-between" style="    width: 100%;">
            <h2>Mis compras</h2>

            <div class="row">
                <div class="col-12 over_table">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item" v-if="page > 1">
                                <a class="page-link" href="#" aria-label="Previous" @click="fetch(page - 1)">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item" v-for="index in pages" v-if="index >= page - 3 &&  index < page + 3">
                                <a class="page-link" href="#" @click="fetch(index)">@{{ index }}</a></li>
                            <li class="page-item" v-if="page < pages">
                                <a class="page-link" href="#" aria-label="Next" @click="fetch(page + 1)">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-12">

            <table class="table  table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Tracking</th>

                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="shopping in shoppings">
                        <td>@{{ shopping.order_id }}</td>
                        <td>@{{ shopping.created_at.toString().substr(0, 10) }}</td>
                        <td><a :href="shopping.tracking_url" target="_blank">@{{ shopping.tracking }}</a></td>
                        <td>$ @{{ parseInt(shopping.total).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</td>
                        <td>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#shoppingModal" @click="show(shopping)">Ver</button>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

    </div>


    <!-- Modal-->
    <div class="modal fade" id="shoppingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Información</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body informacion" v-if="shopping != ''">
                    <div>
                        <div class="row">
                            <div class="col-md-6">
                                <label><strong>Cliente</strong></label>
                                <p>@{{ shopping.user.name }}</p>
                            </div>
                            <div class="col-md-6">
                                <label><strong>Email</strong></label>
                                <p>@{{ shopping.user.email }}</p>
                            </div>
                            <div class="col-md-6">
                                <label><strong>Costo productos</strong></label>
                                <p>$ @{{ parseInt(shopping.total_products).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label><strong>Costo envío</strong></label>
                                <p>$ @{{ parseInt(shopping.shipping_cost).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label><strong>Total</strong></label>
                                <p>$ @{{ parseInt(shopping.total).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</p>
                            </div>
                            <div class="col-md-6">
                                <label><strong>Tracking</strong></label>
                                <p>@{{ shopping.tracking }}</p>
                            </div>
                            <div class="col-md-6">
                                <label><strong>Status tracking</strong></label>
                                <p>@{{ shopping.status_shipping }}</p>
                            </div>
                            <div class="col-md-6">
                                <label><strong>Dirección</strong></label>
                                <p>@{{ shopping.address }}</p>
                            </div>
                            <div class="col-md-12">
                                <h3 class="text-center">Productos</h3>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered table-checkable">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                            <th>Tipo</th>
                                            <th>Tamaño</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(shoppingPurchase, index) in shopping.product_purchases">
                                            <td>@{{ shoppingPurchase.product_type_size.product.brand.name }} -
                                                @{{ shoppingPurchase.product_type_size.product.name }}</td>
                                            <td>$
                                                @{{ parseInt(shoppingPurchase.price).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}
                                            </td>
                                            <td>@{{ shoppingPurchase.product_type_size.type.name }}</td>
                                            <td>@{{ shoppingPurchase.product_type_size.size.name }} Oz</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                </div>
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
                shoppings: [],
                shopping: "",
                page: 1,
                pages: 0
            }
        },
        methods: {

            fetch(page = 1) {

                this.page = page

                axios.get("{{ url('/shopping/fetch/') }}" + "/" + page)
                    .then(res => {

                        this.shoppings = res.data.shoppings
                        this.pages = Math.ceil(res.data.shoppingsCount / 20)

                    })

            },
            show(shopping) {

                this.shopping = shopping

            }

        },
        mounted() {

            this.fetch()

        }

    })
</script>

@endpush