var UserService = {
    init: function () {
      var token = localStorage.getItem("user_token");
      if (token) {
        window.location.replace("index.html");
      }
      $("#login-form").validate({
        submitHandler: function (form) {
            var entity = {
                email: $('#email').val(),
                password: $('#password').val(),
            };
          UserService.login(entity);
        },
      });
    },
    login: function (entity) {
      $.ajax({
        url: "rest/login",
        type: "POST",
        data: JSON.stringify(entity),
        contentType: "application/json",
        dataType: "json",
        success: function (result) {
          console.log(result);
          localStorage.setItem("user_token", result.token);
          window.location.replace("index.html");
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          toastr.error(XMLHttpRequest.responseJSON.message);
        },
      });
    },
  
    logout: function () {
      localStorage.clear();
      window.location.replace("login.html");
    },
  };

