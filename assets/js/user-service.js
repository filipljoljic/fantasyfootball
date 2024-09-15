var UserService = {
    init: function () {
        console.log("UserService init called");
        var token = localStorage.getItem("user_token");
        console.log("Token found:", token);
        // if (token && window.location.pathname !== '/index.html') {
        //     console.log("Redirecting to index.html");
        //     window.location.replace("index.html");
        // }
        $("#login-form").validate({
            submitHandler: function (form) {
                var entity = {
                    email: $('#email').val(),
                    password: $('#password').val(),
                };
                console.log("Submitting login:", entity);
                UserService.login(entity);
            },
        });

        $("#register-form").validate({
            submitHandler: function (form) {
                var entity = {
                    username: $('#username').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                };
                console.log("Submitting registration:", entity);
                UserService.register(entity);
            },
        });
    },

    login: function (entity) {
        console.log("Login function called with entity:", entity);
        $.ajax({
            url: "rest/login",
            type: "POST",
            data: JSON.stringify(entity),
            contentType: "application/json",
            dataType: "json",
            success: function (result) {
                console.log("Login successful, result:", result);
                
                // Ensure token and is_admin are stored in localStorage
                if (result.token) {
                    console.log("Token received in response:", result.is_admin);
                    console.log("Is admin flag received in response:", result);
                    localStorage.setItem("user_token", result.token);   // Store the token
                    localStorage.setItem("is_admin", result.is_admin);  // Store the is_admin flag
    
                    // Log stored values for debugging
                    console.log("Stored user_token:", localStorage.getItem("user_token"));
                    console.log("Stored is_admin:", localStorage.getItem("is_admin"));
                    
                    // Redirect based on admin or regular user
                    if (result.is_admin && result.is_admin === 1) {
                        console.log("Admin detected, redirecting to indexmain.html");
                        window.location.replace("indexmain.html");
                    } else {
                        console.log("Regular user detected, redirecting to index.html");
                        window.location.replace("index.html");
                    }
                } else {
                    console.error("No token received in response.");
                    toastr.error("Failed to log in. Please try again.");
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.error("Login failed:", textStatus, errorThrown);
                toastr.error(XMLHttpRequest.responseJSON.message);
            },
        });
    },

    register: function (entity) {
        console.log("Register function called with entity:", entity);
        $.ajax({
            url: "rest/register",
            type: "POST",
            data: JSON.stringify(entity),
            contentType: "application/json",
            dataType: "json",
            success: function (result) {
                console.log("Registration successful, result:", result);
                if (result.message === 'User registered') {
                    $('#registerMessage').text('Registration successful! Please log in.');
                    window.location.replace("login.html");
                } else {
                    $('#registerMessage').text(result.message);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.error("Registration failed:", textStatus, errorThrown);
                toastr.error(XMLHttpRequest.responseJSON.message);
            },
        });
    },

    logout: function () {
        localStorage.clear();
        window.location.replace("login.html");
    },
};

$(document).ready(function() {
    console.log("Document ready, initializing UserService");
    UserService.init();
});
