<script>
    $(document).ready(function(){
        $(document).on('click','.updaterecord',function(e){
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '{{ url('updaterecord') }}',
                headers: { "X-CSRF-TOKEN":"{{csrf_token()}}" },
                data: {"id":$(this).data("id"),"table":$(this).data("table"),"column":$(this).data("column"),"value":$(this).data("value")},
                success: function (Mess) {
                    if (Mess.status == true) {
                        toastr.success(Mess.msg, Mess.header, {
                            timeOut: 1000,
                            closeButton: true,
                            progressBar: true,
                            newestOnTop: true,
                            onHidden: function () {
                                //window.location.reload();
                            }
                        });


                    } else {
                        toastr.error(Mess.msg, Mess.header, {
                            timeOut: 1000,
                            closeButton: true,
                            progressBar: true,
                            newestOnTop: true,
                            onHidden: function () {
                                //window.location.reload();
                            }
                        });
                    }
                },
                error: function (f) {
                    console.log(f);
                    $.each(f.responseJSON.errors, function (key, val) {
                        toastr.error(val[0], f.responseJSON.message, {
                            timeOut: 1000,
                            closeButton: true,
                            progressBar: true,
                            newestOnTop: true,
                            onHidden: function () {
                                window.location.reload();
                            }
                        });

                    });


                }

            });

        });
        $(document).on('submit','.create_form',function(e){
            e.preventDefault();
            var frm = $(this);
            $.ajax({
                type:'POST',
                url:frm.attr('action'),
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:$(this).serialize(),
                success:function(Mess){
                    if(Mess.status == true)
                        {
                            $('#addModal').modal('toggle');

                            toastr.success(Mess.msg, '', {timeOut: 1000, closeButton:true, progressBar:true, newestOnTop:true, onHidden: function () {
                                    frm.trigger("reset");
                                    window.location.reload();
                                }});


                        }
                    else
                        {
                            toastr.error(Mess.msg, '', {timeOut: 1000, closeButton:true, progressBar:true, newestOnTop:true});
                        }
                },
                error:function (f) {
                        $.each(f.responseJSON.errors, function (key, val) {
                            toastr.error(val[0], f.responseJSON.message, {timeOut: 1000, closeButton:true, progressBar:true, newestOnTop:true,onHidden: function () {
                                    window.location.reload();
                                }});
                        });


                }
            });

        });

        $(document).on('click','.edit-shortcode',function(){
            var shortcode = $(this).data('shortcode');
            $('#edit-id').val(shortcode.id);
            $('#edit-shortcode').val(shortcode.shortcode);
            $('#edit-shortcode_type').val(shortcode.shortcode_type);
            $('#edit-consumerkey').val(shortcode.consumerkey);
            $('#edit-consumersecret').val(shortcode.consumersecret);
            $('#edit-passkey').val(shortcode.passkey)
            $('#editModal').modal('toggle');
        });

        $(document).on('click','.edit-service',function(e){
            e.preventDefault();
            var service  =  $(this).data('service');
            $('#edit-id').val(service.id);
            $('#edit-shortcode option[value="'+service.shortcode_id+'"]').attr('selected','selected');
            $('#edit-code-prefix').val(service.prefix);
            $('#edit-service-name').val(service.service_name);
            $('#edit-description').summernote('code',service.service_description);
            $('#edit-verification-callback').val(service.verification_url);
            $('#edit-response-callback').val(service.callback_url);
            $('#editModal').modal('toggle');
        });
        $(document).on('change','.shortcode-notify',function(){
            // console.log($(this).data('shortcode'));
            var chk  = $(this);
            if(chk.is(':checked'))
            {
                $.ajax({
                    type:'POST',
                    url:'{{ url('notify') }}',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data:$(this).data('shortcode'),
                    success:function(Mess){
                        if(Mess)
                            {
                                toastr.success('Notification started successfully.', 'Notification', {timeOut: 1000, closeButton:true, progressBar:true, newestOnTop:true});
                            }
                        else
                            {
                                toastr.error('Notification failed to start.', 'Notification', {timeOut: 1000, closeButton:true, progressBar:true, newestOnTop:true,onHidden: function () {
                                        chk.prop("checked", false);
                                    }});

                            }

                    },
                    error:function (e) {
                        toastr.error(e.responseJSON.error, e.responseJSON.message, {timeOut: 1000, closeButton:true, progressBar:true, newestOnTop:true,onHidden: function () {
                                chk.prop("checked", false);
                            }});

                    }
                });
            }
        });

        $('#userstable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ url('get_users') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "email" },
                { "data": "status" },
                { "data": "action" }
            ],
            "order": [[ 0, "desc" ]],
            "dom": 'Bfrtip',
            "buttons": [
                {
                    extend: 'copy',
                    className: 'green glyphicon glyphicon-duplicate',
                    exportOptions:
                        {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                },
                {
                    extend: 'print',
                    className: 'green glyphicon glyphicon-print',
                    title: 'Report',
                    text: 'Print',
                    exportOptions:
                        {
                            modifier:
                                {
                                    page: 'current'
                                }
                        }
                },
                {
                    extend: 'excel',
                    className: 'green glyphicon glyphicon-list-alt',
                    title: 'Report',
                    filename: 'Report',
                    exportOptions:
                        {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                },
                'csv',
                {
                    extend: 'pdf',
                    className: 'green glyphicon glyphicon-file',
                    title: 'Report',
                    filename: 'Report',
                    exportOptions:
                        {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                },
                'pageLength'

            ],
            "lengthMenu": [
                [ 10, 25, 50,100,500,1000,5000,10000,18446744073709551615 ],
                [ '10 rows', '25 rows', '50 rows','100 rows','500 rows', '1,000 rows','5,000 rows','10,000 rows','Show all' ]
            ],


        });


        $('#transactions').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ url('alltrans') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                { "data": "shortcode" },
                { "data": "customer_name" },
                { "data": "msisdn" },
                { "data": "transaction_code" },
                { "data": "account" },
                { "data": "origin" },
                { "data": "channel" },
                { "data": "transaction_time" },
                { "data": "amount" }
            ],
            "order": [[ 7, "desc" ]],
            "dom": 'Bfrtip',
            "buttons": [
                {
                    extend: 'copy',
                    className: 'green glyphicon glyphicon-duplicate',
                    exportOptions:
                        {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                },
                {
                    extend: 'print',
                    className: 'green glyphicon glyphicon-print',
                    title: 'Report',
                    text: 'Print',
                    exportOptions:
                        {
                            modifier:
                                {
                                    page: 'current'
                                }
                        }
                },
                {
                    extend: 'excel',
                    className: 'green glyphicon glyphicon-list-alt',
                    title: 'Report',
                    filename: 'Report',
                    exportOptions:
                        {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                },
                'csv',
                {
                    extend: 'pdf',
                    className: 'green glyphicon glyphicon-file',
                    title: 'Report',
                    filename: 'Report',
                    exportOptions:
                        {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                },
                'pageLength'

            ],
            "lengthMenu": [
                [ 10, 25, 50,100,500,1000,5000,10000,18446744073709551615 ],
                [ '10 rows', '25 rows', '50 rows','100 rows','500 rows', '1,000 rows','5,000 rows','10,000 rows','Show all' ]
            ],


        });
    });

</script>
<script>
    $('.summernote').summernote({
        height: 150  //set editable area's height

    }).on('summernote.change', function(we, contents, $editable) {
        $(this).val(contents);
    });
    $('#datatables-basic').DataTable({
        responsive: true,
    });
    // Datatables with Buttons
    var datatablesButtons = $('#datatables-buttons').DataTable({
        lengthChange: !1,
        buttons: ["copy", "print"],
        responsive: true,
        order: [[ 0, "asc" ]]
    });
    datatablesButtons.buttons().container().appendTo("#datatables-buttons_wrapper .col-md-6:eq(0)");

    var datatablesButtonsDesc = $('#datatables-buttons-desc').DataTable({
        lengthChange: !1,
        buttons: ["copy", "print"],
        responsive: true,
        order: [[ 0, "desc" ], [ 1, "desc" ]]
    });
    datatablesButtonsDesc.buttons().container().appendTo("#datatables-buttons_wrapper .col-md-6:eq(0)");
    document.addEventListener("DOMContentLoaded", function(event) {
        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            data   =    '{"start":"'+picker.startDate.format('YYYY-MM-DD')+'","end":"'+picker.endDate.format('YYYY-MM-DD')+'", "X-CSRF-TOKEN": "{{csrf_token()}}" }';
            $.post('{{ url('dashboard') }}',JSON.parse(data),function(te){
                document.open("text/html", "replace");
                document.write(te);
                document.close();
            });
        });
        var start = moment().subtract(1, 'days');
        var end = moment();
        $('#reportrange').daterangepicker({
            opens: 'left',
            startDate: start,
            endDate: end
        });



    });
</script>
