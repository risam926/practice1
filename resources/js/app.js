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
   
