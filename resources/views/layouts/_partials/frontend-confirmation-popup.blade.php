<div class="modal fade all-modal" id="{{$resourceName}}-{{$resource->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{$heading}}</h4>
            </div>
            <div class="modal-body">
                <h5 class="sub-text">Are you sure you want to delete the <?php echo strtolower($heading);?> ?</h5>
            </div>
            <div class="modal-footer">
                <form method="post" action="{{url('company/'.$resourceName.'/destroy/'.encrypt($resource->id))}}">
                    @csrf
                    @method('delete')
                    
                    <!-- <button type="button" class="btn btn-info pull-left" data-dismiss="modal">Close</button> &nbsp; -->
                    <button type="submit" class="btn btn-primary">Delete</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->