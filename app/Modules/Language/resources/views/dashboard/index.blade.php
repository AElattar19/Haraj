@extends('admin.layout.master')

@php
    $api_keys=setting('api_keys');
    $trans_api = get_value('yandex_translation_api',$api_keys);
@endphp
@section('content')

    <!-- end page title -->
    <div class="row">
        <div class="col-12">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        {{t_('blog_Table')}}
                    </h3>
                    @can('create_language')

                        <a onclick="addForm()" class="btn btn-primary btn-sm float-right"> <i class="fa fa-plus"></i>
                            {{t_('Add Language')}} </a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <div class="text-sm-right">
                                {{--                                            <button type="button" class="btn btn-light mb-2 mr-1">@lang(t_('Import'))</button>
                                                                            <button type="button" class="btn btn-light mb-2">@lang(t_('Export'))</button>--}}

                            </div>
                        </div>
                        <div class="col-sm-8">

                        </div><!-- end col-->
                    </div>

                    <div class="col-lg-12 table-responsive">
                        <table class="table table-bordered table-striped table-hover"  width="100%" id="Lang_table">
                            <thead>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>الاختصار</th>
                            <th>الاتجاه</th>
                            <th>الحالة</th>
                            <th>الصورة</th>
                            <th style="width: 85px;">العمليات</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                </div> <!-- end card-body-->

            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->


    @include('Languages::admin._form')


@endsection

@section('scripts')
    <script>
        $('#general-tab').click();
        $('#Languages').addClass('active');
    </script>

    <script type="text/javascript">

        var table, save_method;
        $(function(){

            table = $('#Lang_table').DataTable({

                // "dom":            "Bfrtip",
                // "dom": 'C<"clear">lfrtip',
                dom: "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4'i><'col-sm-8'p>>",
                buttons: [

                    {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> {{t_("Excel")}}',
                        titleAttr: 'Excel'
                    },

                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i> {{t_("PDF")}}',
                        titleAttr: 'PDF'
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fas fa-eye"></i>',
                        titleAttr: '{{t_("Change_Columns")}}'
                    }
                ],

                "processing": true,
                responsive: !0,
                fixedHeader: true,
                "ajax": {
                    "url": "{{ route('admin.language.data') }}",
                    "type": "GET"
                },
                "language": {
                    "sEmptyTable": '{{t_("No data available in table")}}',
                    "sInfo": '{{t_('Showing')}} _START_ {{t_('to')}} _END_ {{t_('of')}} _TOTAL_ {{t_('records')}}',
                    "sInfoEmpty": ' {{t_('Showing')}} 0 {{t_('to')}} 0 {{t_('of')}} 0 {{t_('records')}}',
                    "sInfoFiltered": "({{t_('filtered')}} {{t_('from')}} _MAX_ {{t_('total')}}  {{t_('records')}} )",
                    "sInfoPostFix": "",
                    "sInfoThousands": ",",
                    "sLengthMenu": '{{t_('Show')}} _MENU_ {{t_('records')}}',
                    "sLoadingRecords": '{{t_('loading...')}}',
                    "sProcessing": '{{t_('Processing...')}}',
                    "sSearch": '{{t_("search")}} : ',
                    "sZeroRecords": '{{t_('No matching records found')}}',
                    "oPaginate": {
                        "sFirst": '{{t_('First')}}',
                        "sLast": '{{t_('Last')}}',
                        "sNext": '{{t_('Next')}}',
                        "sPrevious": '{{t_('previous')}}'
                    },
                }
            });




            $('#Users-modal form').validator().on('submit', function(e){
                if(!e.isDefaultPrevented()){
                    if(save_method == "add")
                        url = "{{ route('admin.language.store') }}";
                    else url = "{{ route('admin.language.update') }}";

                    // console.log(new FormData($(".form")[0]));
                    $.ajax({
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function(evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = ((evt.loaded / evt.total) * 100);
                                    $(".progress-bar").width(percentComplete + '%');
                                    $(".progress-bar").html(percentComplete+'%');
                                }
                            }, false);
                            return xhr;
                        },
                        type : 'POST',
                        url : url,
                        data : new FormData($(".form")[0]),
                        contentType: false,
                        cache: false,
                        processData:false,
                        beforeSend: function(){
                            $(".progress-bar").width('0%');
                            $('#uploadStatus').html('<div class="spinner-border avatar-lg text-primary m-2" role="status"></div>');
                        },
                        success : function(resp){
                            if(resp == 'ok'){
                                $('#Users-modal')[0].reset();
                                $('#uploadStatus').html('<p style="color:#28A74B;">File has uploaded successfully!</p>');
                            }else if(resp == 'err'){
                                $('#uploadStatus').html('<p style="color:#EA4335;">Please select a valid file to upload.</p>');
                            }
                            toastr.success('تم حفظ البيانات بنجاح');

                            $('#Users-modal').modal('hide');
                            $('.progress-bar').width('0%');
                            $(".progress-bar").html('');
                            $('#uploadStatus').html('');
                            table.ajax.reload();

                        },
                        error : function(){
                            toastr.error('لا يمكن حفظ البيانات !');
                            $('#uploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');


                        }
                    });

                    return false;
                }
            });
        });

        function addForm(){
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#Users-modal').modal('show');
            $('#Users-modal form')[0].reset();
            $("#Logo").val('');
            $('.modal-title').text('اضافة لغة');
        }

        function editForm(id){

            save_method = "edit";
            // $('input[name=_method]').val('PATCH');
            $('#Users-modal form')[0].reset();
            $.ajax({
                url : '{{route('admin.language.edit')}}?id='+id+'',
                type : "GET",
                dataType : "JSON",
                success : function(data){
                    $('#Users-modal form')[0].reset();
                    $("#Logo").val('');
                    $('#Users-modal').modal('show');
                    $('.modal-title').text(' تعديل ');

                    $('#client_id').val(data.id);
                    $('#client_name').val(data.name);
                    $('#Logo').removeAttr('required');

                },
                error : function(){
                    toastr.error( 'لا يمكن الوصول للبيانات !');
                }
            });
        }

        function deleteData(id){
            if(confirm("هل انت متأكد من حذف البيانات")){
                $.ajax({
                    url : '{{url('/')}}/admin/language/delete/'+id,
                    type : "GET",
                    data : {'_method' : 'GET', '_token' : $('meta[name=csrf-token]').attr('content')},
                    success : function(data){
                        table.ajax.reload();
                        toastr.success( 'تم الحذف بنجاح');
                    },
                    error : function(){
                        toastr.error( 'لا يمكن الوصول للبيانات !');

                    }
                });
            }
        }
    </script>

@endsection
