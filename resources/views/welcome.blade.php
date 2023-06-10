@extends('app')

@section('content')

<div>
    <section class="food_section mb-4">
        <div class="container">

            <div class="row">
                <div class="col-sm-12 col-lg-8">
                    <div class="title title-center">
                        <h2>Our Menu</h2>
                    </div>

                    <ul class="filters_menu" id="filters-menu-container">
                        <!-- <li class="active mx-2" onclick="filter('Main Dish')">Main Dishes</li>
                <li class="mx-2" onclick="filter('Side Dish')">Side Dishes</li>
                <li class="mx-2" onclick="filter('Dessert')">Desserts</li> -->
                    </ul>

                    <!-- <div class="filters-content">
                <div class="row grid" id='foods-container'>

                    <div class="col-sm-6 col-lg-4">
                        <div class="box">
                            <div>
                                <div class="img-box">
                                    <img src="images/f1.png" alt="">
                                </div>
                                <div class="detail-box">
                                    <h5>Tasty Burger</h5>
                                    <p>
                                        Veniam debitis quaerat officiis quasi cupiditate quo, quisquam velit, magnam voluptatem repellendus sed eaque
                                    </p>
                                    <div class="options">
                                        <h6>$14</h6>
                                        <a href=""></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div> -->

                    <div class="filters-content">
                        <div class="row grid" id="card-container">
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="title title-center">
                        <h2>Your Order</h2>
                    </div>

                    <div class="order-content">
                        <table class="table table-dark table-sm" id="order-table">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Food</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <h2 class="text-light title-center mt-3">Total <span id="total-amount">0</span> /=</h2>

                    <form data-action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data" id="saveOrderForm">
                        @csrf
                        <div class="btn-martha">
                            <button type="submit">Save Order</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </section>
</div>
@stop