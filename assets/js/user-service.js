var UserService = {

     openConfirmationDialog: function(id) {
        $("#deleteUserModal").modal("show");
        $("#delete-user-body").html("Do you wnat to delte student with id = " + id);
        $("#userId").val(id);
    },

    deleteUser: function(){
        $.ajax({
            url: 'rest/users/' + $("#user_id").val(),
            type: 'DELETE',
            success: function(response) {
                console.log("User Deleted:", response);
                $("#deleteUserModal").modal("hide");
                toastr.success(response.message);
                getUsers();
                },
            error: function (XMLHttpRequest, textstatus, errorThrow) {
                console.error("Error Deleting User:" + errorThrow);
            },
        });
    }
}
