@extends('customer.feedback_layout')

@section('content')
    <!-- Main content -->
    <section class="content d-flex align-items-center">
        <div class="container">
            <!-- Thank You Card -->
            <div class="card card-default">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h2 class="text-center">{{ $h2Text}}</h2>
                                <h5 class="text-center">{{ $h5Text}}</h5>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /.content -->
@endsection

@push('css')
@endpush
@push('js')
@endpush

            
       