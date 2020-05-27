<script>
    $(document).ready(function(){
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




        $('#transactions').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ url('alltrans') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}","type":"{{ $type ?? '' }}"}
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
            "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            // Update footer
            $( api.column( 8 ).footer() ).html(
                8000
            );
        }


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
</script>
