<div class="modal" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form class="form form-horizontal" data-toggle="validator" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }} {{ method_field('POST') }}

                <div class="modal-header">
                    <h3 class="modal-title"></h3>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span></button>


                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label for="client_name" class="col-md-3 control-label"> {{t_('Key')}} </label>
                        <div class="col-md-6">
                            <input id="code" type="text" class="form-control" name="key" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-save"><i class="fa fa-floppy-o"></i> {{t_('save')}} </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> {{t_('Cancel')}}
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
