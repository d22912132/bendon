@extends('layouts.app')
@section('content')
@php
    $total = 0;
@endphp

    <h1>我的購物車</h1>
    <form action="{{ route('order.store') }}" method="post" id="order-form">
        @csrf
        <table class="table table-striped">
            <tr>
                <th colspan="2">商品名稱</th>
                <th nowrap class="text-right">商品單價</th>
                <th nowrap class="text-center">購買數量</th>
                <th nowrap class="text-right">小計</th>
                <th>功能</th>
            </tr>
            @forelse ($user->carts as $cart)
                <tr>
                    <td>
                        <a target="_blank" href="/product/{{ $cart->product_id }}">
                            <img src="{{ $cart->product->image_url }}" class="img-thumbnail" style="width: 120px;">
                        </a>
                    </td>
                    <td>
                        <a target="_blank" href="/product/{{ $cart->product_id }}"><h5>{{ $cart->product->title }}</h5></a>
                        @if(!$cart->product->on_sale)
                            <div class="warning">該商品已下架</div>
                        @endif                    
                    </td>
                    <td  class="text-right">
                        <span id="price-{{ $cart->id }}">
                            {{ $cart->product->price }}
                        </span>
                    </td>
                    <td  class="text-center">
                        @if ($cart->product->on_sale)
                            <input type="number" min="1" class="form-control text-center amount" name="amount[{{ $cart->product_id }}]" value="{{ $cart->amount }}" data-cartid="{{ $cart->id }}">
                        @else
                            <div class="warning">該商品已下架</div>
                        @endif
                    </td>
                    <td  class="text-right">
                        <span class="sum" id="sum-{{ $cart->id }}">
                            {{ $cart->product->price * $cart->amount }}
                        </span>
                    </td>
                    <td nowrap><a href="#" class="btn btn-danger btn-sm btn-del-from-cart" data-id="{{ $cart->product_id }}">移除</a></td>
                </tr>
                @php
                    $total+=$cart->product->price * $cart->amount
                @endphp
            @empty
            <tr>
                <td><h1>購物車空無一物</h1></td>
            </tr>
            @endforelse
            <tr>
                <th colspan=4 class="text-right">共計</th>
                <th nowrap class="text-right">
                    <span id="total">{{ $total }}</span>
                </th>
                <th>元</th>
            </tr>
        </table>
        @if(count($user->carts))
        <div class="form-group row">
            <label class="col-form-label col-sm-3 text-md-right">收貨地址</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="address" value="{{ $user->address }}">
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary">送出訂單</button>
            </div>
        </div>
    @endif
    </form>
@endsection

@section('scriptsAfterJs')
    <script>
        $(document).ready(function () {
            $('.amount').change(function(){
                var cartid = $(this).data('cartid');
                var sum = $(this).val() * $('#price-'+cartid).text();
                $('#sum-'+cartid).text(sum);

                var total = 0;
                $('.sum').each(function() {
                    total += Number($(this).text());
                });
                $('#total').text(total);
            });

            $('.btn-del-from-cart').click(function(){
                {{--  在then()中，是無法直接用$(this).data('id')來取的商品編號，所以，
                我們先用var product_id=$(this).data('id');來將取得編號設給自訂變數product_id，
                以便等會在then()中使用。 --}}
                var product_id=$(this).data('id');
                swal.fire({
                    title: "確認要將該商品移除？",
                    icon: "warning",
                    showCancelButton: true, 
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '確定', 
                    cancelButtonText: '取消',
                }).then(function(willDelete){
                    {{--  用戶點擊 確定 按鈕，willDelete 的值就會是 true，否則為 false  --}}
                    if(!willDelete){
                        return;
                    }
                    axios.delete('/cart/' + product_id)
                    .then(function(){
                        location.reload();
                    })
                });
            });
        });
    </script>
@endsection