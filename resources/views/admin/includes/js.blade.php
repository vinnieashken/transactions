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

                    if(Mess)
                        {
                            $('#addModal').modal('toggle');
                            frm.trigger("reset");
                            toastr.success('Action performed successfully.', 'Shortcode', {timeOut: 5000, closeButton:true, progressBar:true, newestOnTop:true});
                            location.reload();
                        }
                    else
                        {
                            toastr.error('Action not successful.', 'Shortcode', {timeOut: 5000, closeButton:true, progressBar:true, newestOnTop:true});
                        }
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
            $('#editModal').modal('toggle');
        });
        $(document).on('click','.shortcode-notify',function(){
            // console.log($(this).data('shortcode'));
            $.ajax({
                type:'POST',
                url:'{{ url('notify') }}',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:$(this).data('shortcode'),
                success:function(Mess){
                    if(Mess)
                        {

                            toastr.success('Notification started successfully.', 'Notification', {timeOut: 5000, closeButton:true, progressBar:true, newestOnTop:true});

                        }
                    else
                        {
                            toastr.error('Notification failed to start.', 'Notification', {timeOut: 5000, closeButton:true, progressBar:true, newestOnTop:true});
                        }
                    location.reload();
                },
                error:function (e) {
                   
                }
            });
        });
    });
</script>
