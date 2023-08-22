<!-- Modal -->
<div class="modal fade" id="Users-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title" id="myCenterModalLabel">{{t_('Add Language')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <form class="form form-horizontal" data-toggle="validator" method="POST"  enctype="multipart/form-data">
                    {{ csrf_field() }} {{ method_field('POST') }}

                    <div class="form-group">
                        <label for="Name">{{t_('Language name')}}</label>
                        <input type="text" class="form-control" id="Name"  name="Name" placeholder="{{t_('EX . English')}}">
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <label for="name">{{t_('local')}}</label>
                        <input type="text" class="form-control" id="Local"  name="Local" placeholder="{{t_('EX . en_US')}}">
                        <span class="help-block with-errors"></span>

                    </div>

                    <div class="form-group">
                        <label for="Code">{{t_('Code')}}</label>
                        <input type="text" class="form-control" name="Code" id="Code" placeholder="{{t_('EX . en')}}">
                        <span class="help-block with-errors"></span>

                    </div>

                    <div class="form-group">
                        <label for="Direction">{{t_('Direction')}}</label>

                        <select name="Direction" class="form-control select2" id="Direction">
                            <option value="rtl">{{t_('RTL')}}</option>
                            <option value="ltr">{{t_('LTR')}}</option>
                        </select>
                        <span class="help-block with-errors"></span>

                    </div>

                    <div class="form-group">
                        <label for="Sort">{{t_('Sort')}}</label>
                        <input type="number" class="form-control" name="Sort" id="Sort" placeholder="Sort">
                        <span class="help-block with-errors"></span>

                    </div>

                    <div class="form-group">
                        <label for="active">{{t_('Active Status')}}</label>

                        <input name="active" type="checkbox" class="active-checkbox"
                               @isset($data)  id="Active_{{$data['id']}}" value="{{$data['id']}}" @endisset

                               @isset($data['active']) @if($data['active']) checked @endif  @endisset
                               netliva-switch data-active-text="{{t_('Active')}}" data-passive-text=" {{t_('Deactivate')}}"/>

                        <span class="help-block with-errors"></span>
                    </div>

                   <div class="form-group">
                        <p class="text-muted text-center mt-2 mb-0">flag</p>
                       <input id="flag" type="file" data-plugins="dropify"
                              @isset($data['flag'])
                              data-default-file="{{asset('storage/'.$data['flag'] ? 'storage/'.$data['flag'] : "img/no-image.png")}}"
                              @else
                              value="{{old('flag')}}"
                              @endisset
                              name="flag"/>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                            <!-- Progress bar -->
                            <div class="progress">
                                <div class="progress-bar"></div>
                            </div>
                            <!-- Display upload status -->
                            <div id="uploadStatus"></div>

                            <br/>
                            <div class="progress" style="display:none;">
                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%;">

                                </div>
                            </div>
                            <br>

                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-success waves-effect waves-light">@lang('User::admin.Save')</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">@lang('User::admin.Cancel')</button>
                    </div>

                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@section('js')
    @parent

    <script>
        // File type validation
        $("#avatar").change(function(){
            var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            var file = this.files[0];
            var fileType = file.type;
            if(!allowedTypes.includes(fileType)){
                toastr.error( 'من فضلك اختر نوع ملف مدعوم (JPEG/JPG/PNG/GIF). !');
                $("#Featured_Images").val('');
                return false;
            }
        });
    </script>

    <script>
        !function (t) {
            "use strict";
            function e() {
                this.$body = t("body")
            }
            e.prototype.init = function () {
                Dropzone.autoDiscover = !1, t('[data-plugin="dropzone"]').each(function () {
                    var e = t(this).attr("action"), o = t(this).data("previewsContainer"), i = {url: e};
                    o && (i.previewsContainer = o);
                    var r = t(this).data("uploadPreviewTemplate");
                    r && (i.previewTemplate = t(r).html());
                    t(this).dropzone(i)
                })
            }, t.FileUpload = new e, t.FileUpload.Constructor = e
        }(window.jQuery), function () {
            "use strict";
            window.jQuery.FileUpload.init()
        }(), 0 < $('[data-plugins="dropify"]').length && $('[data-plugins="dropify"]').dropify({
            messages: {
                default: '{{t_("Drag and drop a file here or click")}}',
                replace: '{{t_("Drag and drop or click to replace")}}',
                remove: '{{t_("Remove")}}',
                error: '{{t_("Ooops something wrong appended")}}'
            }, error: {fileSize: '{{t_("The file size is too big (1M max).")}}'}
        });
    </script>

@endsection
