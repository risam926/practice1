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
    // 共通データ取得関数
    function fetchData(url, additionalParams = {}) {
        const formData = {
            keyword: $('#keyword').val(),
            company_id: $('select[name="company_id"]').val(),
            price_min: $('#price_min').val(),
            price_max: $('#price_max').val(),
            stock_min: $('#stock_min').val(),
            stock_max: $('#stock_max').val(),
            ...additionalParams
        };

        $.ajax({
            url: url,
            type: "GET",
            data: formData,
            success: function(response) {
                $('#products-table-body').html(response);
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
    }

    // 検索処理
    $('#search-btn').click(function(e) {
        e.preventDefault(); // フォームの通常送信を防ぐ
        fetchData($(this).data('url'));
    });

    // ソート処理
    $(document).on('click', '.sort-link', function(e) {
        e.preventDefault();
        const $link = $(this);
        fetchData($link.attr('href'), {
            column: $link.data('column'),
            direction: $link.data('direction')
        });
    });
});



$(document).ready(function() {
    // 削除処理の関数化
    function initializeDeleteHandlers() {
        $(document).off('click', '.delete-btn').on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const $button = $(this);
            const productId = $button.data('id');
            const deleteUrl = $button.data('url');
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            if (confirm('本当に削除しますか？')) {
                $.ajax({
                    url: deleteUrl,
                    type: "POST",
                    data: {
                        _method: "DELETE",
                        _token: csrfToken
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#product-' + productId).fadeOut('normal', function() {
                                $(this).remove();
                            });
                        } else {
                            alert(response.message || '削除に失敗しました');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        alert('エラーが発生しました: ' + xhr.responseJSON?.message);
                    }
                });
            }
        });
    }

    // 初回読み込み時にイベントを登録
    initializeDeleteHandlers();

    // テーブル更新後にイベントを再登録
    $(document).ajaxComplete(function() {
        initializeDeleteHandlers();
    });
});