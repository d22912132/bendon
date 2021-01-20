$('.btn-add-to-cart').click(function(){
    console.log($(this).data('id') + ' = ' + $('input[name=amount]').val());
    axios.post('{{ route('cart.store') }}',{
        product_id: $(this).data('id'),
        amount: $('input[name=amount]').val(),
    })
    .then(function (){ //請求成功時執行
        swal.fire('加入購物車成功', '', 'success');
    }, function (error) { // 請求失敗時執行：
        @guest
            swal.fire('請先登入', '', 'error');
        @endguest
        
        @auth
            swal.fire('系統錯誤', '', 'error');
        @endauth
    })
});