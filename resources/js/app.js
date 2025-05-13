import './bootstrap';

console.log("hello");

const buttons = document.querySelectorAll('.btn-danger');
buttons.forEach(function (button) {
    button.addEventListener('click', function () {
        if (confirm('本当に削除しますか？')) {
            alert('削除しました。');
        } else {
            alert('削除をキャンセルしました。');
        }
    });
}); 

$(document).ready(function(){
    $('#search-btn').click(function(e){
        e.preventDefault(); // フォームの通常送信を防ぐ

        let searchUrl = $(this).data('url');
        let keyword = $('#keyword').val();
        let companyId = $('select[name="company_id"]').val();
        let priceMin = $('#price_min').val();
        let priceMax = $('#price_max').val();
        let stockMin = $('#stock_min').val();
        let stockMax = $('#stock_max').val();

        $.ajax({
            url: searchUrl,
            type: "GET",
            data: {
                keyword: keyword,
                company_id: companyId,
                price_min: priceMin,
                price_max: priceMax,
                stock_min: stockMin,
                stock_max: stockMax
            },
            success: function(response) {
                console.log(response); 
                $('.table-responsive table tbody').empty();

                response.forEach(product => {
                    $('.table-responsive table tbody').append(`
                        <tr>
                            <td>${product.id}</td>
                            <td><img src="/storage/images/${product.img_path}" width="100"></td>
                            <td>${product.product_name}</td>
                            <td>${product.price}</td>
                            <td>${product.stock}</td>
                            <td>${product.company.company_name}</td>
                            <td><a href="/detail/${product.id}" class="btn btn-info">詳細</a></td>
                            <td>
                                <form action="/delete/${product.id}" method="POST">
                                    <button type="submit" class="btn btn-danger">削除</button>
                                </form>
                            </td>
                        </tr>
                    `);
                });
            }
        });
    });
});



$(document).ready(function(){
    $('.btn-danger').click(function(){
        let productId = $(this).data('id'); // 商品IDを取得
        let deleteUrl = $(this).data('url'); // 削除APIのURLを取得
        let csrfToken = $('meta[name="csrf-token"]').attr('content'); // CSRFトークンを取得

        console.log("削除対象の商品ID:", productId);
        console.log("削除URL:", deleteUrl);
        console.log("CSRFトークン:", csrfToken);

        $.ajax({
            url: deleteUrl,
            type: "DELETE",
            headers: { "X-CSRF-TOKEN": csrfToken }, // CSRFトークンを送信
            success: function(response) {
                console.log("削除成功:", response);

                if (response.success) {
                    $('#product-' + productId).fadeOut(); // 商品を非表示
                } else {
                    alert("削除に失敗しました: " + response.message);
                }
            },
            error: function(xhr) {
                console.error("削除エラー:", xhr.responseText);
                alert("エラーが発生しました: " + xhr.responseText);
            }
        });
    });
});