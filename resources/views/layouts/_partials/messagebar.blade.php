<!-- messageboard-section -->
<div class="messageboard-section position-fixed">
        
    @if(session()->has('message-error'))
    <div class="alert alert-danger alert-dismissible timeabl">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5 class="alert-heading"><i class="icon fa fa-ban"></i> Alert!</h5>
        {{session('message-error')}}
    </div>
    @endif

    @if(session()->has('message-info'))
    <div class="alert alert-info alert-dismissible timeabl">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5 class="alert-heading"><i class="icon fa fa-info"></i> Hello!</h5>
        {{session('message-info')}}
    </div>
    @endif

    @if(session()->has('message-warning'))
    <div class="alert alert-warning alert-dismissible timeabl">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5 class="alert-heading"><i class="icon fa fa-warning"></i> Warning!</h5>
        {{session('message-warning')}}
    </div>
    @endif
    
    @if(session()->has('message-success'))
    <div class="alert alert-success alert-dismissible timeabl">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5 class="alert-heading"><i class="icon fa fa-check"></i> Success!</h5>
        {{session('message-success')}}
    </div>
    @endif

</div>
<!-- messageboard-section -->
<script>

    $(document).ready(function(){
          $(".timeabl").delay(5000).slideUp(300);
    });

</script>
