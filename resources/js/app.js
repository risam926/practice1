import './bootstrap';
console.log("hello");
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.deleteButton');
    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            if (confirm('本当に削除しますか？')) {
                alert('削除しました。');
            } else {
                alert('削除をキャンセルしました。');
            }
        });
    });
});
    
   
