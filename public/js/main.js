document.addEventListener('DOMContentLoaded', function () {
    // document.addEventListener('DOMContentLoaded', function() {
    // $(document).on('click','.element',function(){
    //
    //     alert('Clicked');
    //
    // });
    $(document).on('click', '.has_action', function () {

        content = $('#modal-form #content');
        content.hide();
        $('#modal-form #load').show();
        $('#modal-form').show();
        var url = $(this).data('action');
        console.log(url)
        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                content.html(data);
                content.show();
                $('#modal-form #load').hide();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $(document).on('submit', '#kt_modal_form', function (event) {
        event.preventDefault();
        content = $('#modal-form #content');
        $('#modal-form #load').show();

        var form = $(this);
        var formUrl = form.attr('action');
        var method = form.data('method');

        // var formUrl = $(this).action;
        // var method = $(this).data('method');
        console.log(formUrl);
        console.log(method);
        $.ajax({
            url: formUrl,
            type: method,
            dataType: "json",
            data: $(this).serialize(),
            success: function (data) {
                console.log(data)
                $('#modal-form').hide();
                // Assuming data is an array of objects
                Swal.fire({
                    text: "Form has been successfully submitted!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                }).then(function (result) {
                    $('#areas-table').DataTable().ajax.reload();

                    // if (result.isConfirmed) {
                    //     modal.hide();
                    // }
                });
            },
            error: function (error) {
                console.log(error);
            }
        });
        // More code...
    });

    $(document).on('click', '.close', function () {
        var model = $(this).closest('#modal-form');
        model.hide();
    });
});

