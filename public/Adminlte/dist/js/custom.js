$(function () {
    // Summernote
    $('#summernote').summernote()

    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
        mode: "htmlmixed",
        theme: "monokai"
    });
})

$(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })


})

$(document).ready(function () {
    $('#pieces').select2({
        tags: true
    });
    $('#show').on('click', function (e) {
        alert($('#pieces').val());
    });

    $('#summernote').summernote({
        height: 300,
        focus: true
    });

    $('.summernote').each(function (i, obj) {
        $(obj).summernote({
            onblur: function (e) {
                var id = $(obj).data('id');
                var sHTML = $(obj).code();
            },
            height: 300,
            focus: true,
        });

        if ($(obj).hasClass('is-invalid')) {
            $(obj).next('.note-editor').css('border-color', 'red');
        }
        $(obj).on('summernote.change', function (we, contents, $editable) {
            resetSummernoteBorder(obj);
        });
    });
    function resetSummernoteBorder(obj) {
        $(obj).removeClass('is-invalid');
        $(obj).next('.note-editor').css('border-color', '');
    }
});
$(function () {
    $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });
});
