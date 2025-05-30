@extends('layouts.app')

@section('content')
<style>
    .pt-90 { padding-top: 90px !important; }
    .pr-6px { padding-right: 6px; text-transform: uppercase; }
    .my-account .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 40px;
        border-bottom: 1px solid;
        padding-bottom: 13px;
    }
    .cancel-order {
    font-size: 0.8rem;
    padding: 4px 10px;
    margin-top: 10px;
    }
    .my-account .wg-box {
        display: flex;
        flex-direction: column;
        gap: 24px;
        padding: 24px;
        border-radius: 12px;
        background: var(--White);
        box-shadow: 0px 4px 24px 2px rgba(20, 25, 38, 0.05);
    }
    .bg-success { background-color: #40c710 !important; }
    .bg-danger { background-color: #f44032 !important; }
    .bg-warning { background-color: #f5d700 !important; color: #000; }
    .table-transaction>tbody>tr:nth-of-type(odd) {
        --bs-table-accent-bg: #fff !important;
    }
    .table-transaction th, .table-transaction td {
        padding: 0.625rem 1.5rem .25rem !important;
        color: #000 !important;
    }
    .table-bordered>:not(caption)>*>* {
        border-width: inherit;
        line-height: 32px;
        font-size: 14px;
        border: 1px solid #e1e1e1;
        vertical-align: middle;
    }
    .table-striped .image {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        flex-shrink: 0;
        border-radius: 10px;
        overflow: hidden;
    }
    .table-striped td:nth-child(1) {
        min-width: 250px;
        padding-bottom: 7px;
    }
    .pname { display: flex; gap: 13px; }
</style>

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Order Detail</h2>
        <div class="row">
            <div class="col-lg-2">
                @include('user.account-nav')
            </div>

            <div class="col-lg-10">
                <!-- Order Details Box -->
                <div class="wg-box mt-5 mb-5">
                    <div class="row">
                        <div class="col-6">
                            <h5>Ordered Details</h5>
                        </div>
                        <div class="col-6 text-right">
                            <a class="btn btn-sm btn-danger" href="{{ route('user.orders')}}">Back</a>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-transaction">
                        <tr>
                            <th>Order No</th>
                            <td>{{ $order->id }}</td>
                            <th>Phone</th>
                            <td>{{ $order->phone }}</td>
                            <th>Pin/Zip Code</th>
                            <td>{{ $order->zip }}</td>
                        </tr>
                        <tr>
                            <th>Order Date</th>
                            <td>{{ $order->created_at }}</td>
                            <th>Delivered Date</th>
                            <td>{{ $order->delivered_date }}</td>
                            <th>Canceled Date</th>
                            <td>{{ $order->canceled_date }}</td>
                        </tr>
                        <tr>
                            <th>Order Status</th>
                            <td colspan="5">
                                @if($order->status == 'delivered')
                                    <span class="badge bg-success">Delivered</span>
                                @elseif($order->status == 'canceled')
                                    <span class="badge bg-danger">Canceled</span>
                                @else
                                    <span class="badge bg-warning">Ordered</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Ordered Items -->
                <div class="wg-box mt-5">

                    <h5>Ordered Items</h5>
                    <div class="table-responsive">
                        @if (Session::has('status'))
                            <p class="alert alert-success">{{ Session::get('status') }}</p>
                        @endif
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">SKU</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Brand</th>
                                    <th class="text-center">Options</th>
                                    <th class="text-center">Return Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderItems as $orderitem)
                                <tr>
                                    <td class="pname">
                                        <div class="image">
                                            <img src="{{ asset('uploads/products/thumbnails/' . $orderitem->product->image) }}" alt="">
                                        </div>
                                        <div class="name">
                                            <a href="{{ route('shop.product.details', ['product_slug' => $orderitem->product->slug]) }}" target="_blank">
                                                {{ $orderitem->product->name }}
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-center">${{ $orderitem->price }}</td>
                                    <td class="text-center">{{ $orderitem->quantity }}</td>
                                    <td class="text-center">{{ $orderitem->product->SKU }}</td>
                                    <td class="text-center">{{ $orderitem->product->category->name }}</td>
                                    <td class="text-center">{{ $orderitem->product->brand->name }}</td>
                                    <td class="text-center">{{ $orderitem->options }}</td>
                                    <td class="text-center">{{ $orderitem->rstatus == 0 ? 'No' : 'Yes' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('shop.product.details', ['product_slug' => $orderitem->product->slug]) }}" target="_blank">
                                            <div class="list-icon-function view-icon">
                                                <div class="item eye"><i class="icon-eye"></i></div>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="divider"></div>
                    <div class="wgp-pagination">
                        {{ $orderItems->links('pagination::bootstrap-5') }}
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="wg-box mt-5">
                    <h5>Shipping Address</h5>
                    <div class="my-account__address-item col-md-6">
                        <div class="my-account__address-item__detail">
                            <p>{{ $order->name }}</p>
                            <p>{{ $order->address }}</p>
                            <p>{{ $order->locality }}</p>
                            <p>{{ $order->city }}, {{ $order->country }}</p>
                            <p>{{ $order->landmark }}</p>
                            <p>{{ $order->zip }}</p>
                            <br />
                            <p>Mobile: {{ $order->phone }}</p>
                        </div>
                    </div>
                </div>

                <!-- Transaction -->
                <div class="wg-box mt-5">
                    <h5>Transactions</h5>
                    @if($transaction)
                    <table class="table table-striped table-bordered table-transaction">
                        <tr>
                            <th>Subtotal</th>
                            <td>${{ $order->subtotal }}</td>
                            <th>Tax</th>
                            <td>${{ $order->tax }}</td>
                            <th>Discount</th>
                            <td>${{ $order->discount }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>${{ $order->total }}</td>
                            <th>Payment Mode</th>
                            <td>{{ $transaction->mode }}</td>
                            <th>Status</th>
                            <td>
                                @if($transaction->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($transaction->status == 'declined')
                                    <span class="badge bg-danger">Declined</span>
                                @elseif($transaction->status == 'refunded')
                                    <span class="badge bg-secondary">Refunded</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                    @else
                    <div class="alert alert-warning">No transaction found for this order.</div>
                    @endif
                </div>
            </div>

            @if ($order->status=='ordered')
            <div class="wg-box mt-5 text-right">
                <form action="{{route('user.order.cancel')}}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="order_id" value="{{ $order->id }}" />
                    <button type="button" class="btn btn-sm btn-outline-danger cancel-order">Cancel Order</button>
                </form>
            </div>
            @endif
        </div>
    </section>
</main>
@endsection


@push('scripts')
    <script>
        $(function() {
            $('.cancel-order').on('click', function(e){
                e.preventDefault();
                var form = $(this).closest('form');
                swal({
                    title: "Are you sure?",
                    text: "You want to cancel this order",
                    type: "warning",
                    buttons: ["No", "Yes"],
                    confirmButtonColor: '#dc3545' 
                }).then(function(result){
                    if (result) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
