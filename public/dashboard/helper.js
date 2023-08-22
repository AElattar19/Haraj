$(document).ready(function () {
    // var swalInit = swal.mixin({});
    $(document).on('click', '.btn-trigger', function () {
        let id = $(this).data('id');
        let type = $(this).data('type') || '';
        let that = $(this);
        swal.fire({
            title: 'هل انت متاكد ؟',
            text: 'من تغيير حالة هذا البيان',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم , قم بالتغيير',
            cancelButtonText: 'لا , الغاء'
        })
            .then((isConfirm) => {
                if (isConfirm.value) {
                    $.post(window.routes + id + '/trigger', {
                        _method: 'PATCH',
                        type: type
                    }).done(function (response) {
                        if (response.value) {
                            $('.datatable-ajax').DataTable().ajax.reload();
                            swalInit.fire("عمل جيد!", response.data || 'لقد تم تنفيذ طلبك بنجاح', "success");
                        } else {
                            swalInit.fire("الطلب فشل", 'حدث خطئ غير متوقع حدث الصفحة', "error");
                            console.log(response);
                        }
                    })
                }
            });
    });

    $(document).on('click', '.btn-delete', function () {
        let id = $(this).data('id');
        let that = $(this);
        swal.fire({
            title: 'Are you sure ?',
            text: 'You wont be able to restore it again',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'No, cancel'
        }).then((isConfirm) => {
            if (isConfirm.value) {
                $.post(window.routes + id, {_method: 'DELETE'}).done(function (response) {
                    if (response.status) {
                        $('.datatable-ajax').DataTable().ajax.reload();
                        swalInit.fire("Good Job", response.data, "success");
                    } else {
                        swalInit.fire("Failed!", 'Unexpected error occurred', "error");
                        console.log(response);
                    }
                })
            }
        });
    });

    // text editor tinymce
    if ($(".tinymce textarea").length > 0) {
        tinymce.init({
            selector: ".tinymce_textarea",
            theme: "modern",
            height: 300,
            content_style:
                "body { background: #6A7A95; color: white; font-size: 14pt; font-family: Arial; }",
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],
            toolbar: "ltr rtl insertfile undo redo | fontsizeselect | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
            style_formats: [
                {title: 'Bold text', inline: 'b'},
                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                {title: 'Span', inline: 'span', classes: 'example1'},
                {title: 'Table styles'},
                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
            ]
        });
    }


});

