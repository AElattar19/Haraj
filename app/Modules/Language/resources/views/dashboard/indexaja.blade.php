@extends('admin.layouts.app')

@section('title')
  عملائنا
@endsection

@section('style')

@endsection

@section('content')



    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">

                            <h4 class="m-t-0 header-title"><b>العملاء</b></h4>

                            <p class="text-muted font-13 m-b-30">

                                <a onclick="addForm()" class="btn btn-success"><i class="fa fa-plus-circle"></i> اضافة </a>
                            </p>

                            <table  id="datatable-colvid" class="table table-striped table-bordered dataTable no-footer">
                                <thead>
                                <tr>
                                    <th width="30">#</th>
                                    <th> اسم العميل</th>
                                    <th>اللوجو</th>
                                    <th width="100">العمليات</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>


            </div>
        </div>




    @include('admin.clients._form')

            </div>


        </div>
    </div>
@endsection


