// if(getCookie('api_token')) {
//     window.location = '/product';
// }

$('#form1').on('submit', function (e) {
    e.preventDefault();
    $('.error').removeClass('d-none');
    var username = $('#username').val();
    var password = $('#password').val();
    $.ajax({
        url: '/api/user/login',
        method: 'post',
        data: {
            username: username,
            password: password
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            var result = response.success;
            if (result) {
                console.log('Dang nhap thanh cong');
                $('.error').addClass('d-none');
                let api_token = response.data.api_token;
                document.cookie = 'api_token=' + api_token;
                window.location = '/product';
            } else {
                let error = response.error;
                $('.error').removeClass('d-none');
                $('.error').text(error);
            }
        }
    });
});
