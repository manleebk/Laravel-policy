//get cookie from cookie name
function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

// load index...
function loadProduct() {
  if (getCookie('api_token')) {
    $.ajax({
      url: '/api/product',
      method: 'get',
      data: {},
      headers: {
        'Authorization': 'Bearer ' + getCookie('api_token')
      },
      success: function (response) {
        //console.log(response);
        let products = response.data;
        var content = '';
        for (const product of products) {
          //console.log(product.id + ' + ' + product.product_name);
          content += '<tr><td>' + product.id + '</td><td>' + product.product_name +
            '</td><td><button class="btn btn-default edit" id="' + product.id + '">Edit</button></td></tr>'
        }
        var content = '<table class = "table"><tr><th>ID</th><th>Product Name</th><th>Option</th></tr>' + content + '</table>';

        if (response.success) {
          $('#content-page').html(content);
        }
      }
    });
  } else {
    window.location = '/login';
  }
}
//