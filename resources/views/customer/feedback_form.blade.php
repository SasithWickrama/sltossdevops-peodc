@extends('customer.feedback_layout')

@section('content')
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Form Card -->
      <div class="card card-default" id="cd_form">
        <div class="card-body">
          <div class="row d-none">
            <div class="col-md-6">
              <div class="form-group">
                <!-- <label>Service Order No</label> -->
                <input type="text" class="form-control" id="service_order_no" name="service_order_no" value="{{ $unique_id }}" disabled>
              </div>
              <!-- /.form-group -->
            </div>
          </div>
          <!-- /.row -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Customer Name </label>
                <input type="text" class="form-control" id="" name="" value="{{ $canResponse->CUSTOMER_NAME }}" disabled>
              </div>
              <!-- /.form-group -->
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Phone Number </label>
                <input type="text" class="form-control" id="" name="" value="{{ $canResponse->PHONE_NO }}" disabled>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Account Number</label>
                <input type="text" class="form-control" id="" name="" value="{{ $canResponse->ACCOUNT_NO }}" disabled>
              </div>
              <!-- /.form-group -->
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>PEOTV Package </label>
                <input type="text" class="form-control" id="" name="" value="{{ $canResponse->PEOTV_PACKAGE }}" disabled>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Reason for Disconnection</label>
                <select class="form-control select2" style="width: 100%;" id="disconnection_reason">
                  <option value="">Select a value</option>
                  <option value="0">Due to financial difficulties</option>
                  <option value="1">Due to change of location</option>
                  <option value="2">Due to PEOTV product related issues</option>
                  <option value="3">DelawaDue to service maintenance issuesre</option>
                  <option value="4">Shifted to another Pay TV service</option>
                </select>
              </div>
              <!-- /.form-group -->
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Was the CP Handover to the Office?</label>
                <select class="form-control select2" style="width: 100%;" id="cp_handover">
                  <option value="">Select a value</option>
                  <option value="1">Yes</option>
                  <option value="0">No</option>
                </select>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <div class="row">
            <div class="col-md-6 text-right">
              
            </div>
            <div class="col-md-6 text-right">
              <div class="form-group">
                <button type="submit" class="btn btn-primary" id="btn-save">Submit</button>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          
        </div>
      </div>
      <!-- /.card -->
      <!-- Thank Card -->
      <div class="card card-default d-none" id="cd_thank">
        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-6">
              <div class="form-group">
                <h2 class="text-center">Already Responded!</h2>
                <h5 class="text-center">Thank You For Your Response</h5>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
      </div>
      <!-- /.card -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection


@push('js')
  <script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()
    })

    // save a user response
    $('#btn-save').unbind('click').bind('click', function(e) {

      //check for required field and show warning messages
      if (!$('#disconnection_reason').val()) {
        Swal.fire({
          title: 'Warning!',
          text: 'Please select a Reason for Disconnection',
          icon: 'warning',
          confirmButtonText: 'OK'
        })
        return;
      }

      //check for required field and show warning messages
      if (!$('#cp_handover').val()) {
        Swal.fire({
          title: 'Warning!',
          text: 'Please select whether Was the CP Handover to the Office?',
          icon: 'warning',
          confirmButtonText: 'OK'
        })
        return;
      }

      // save data using ajax call
      $.ajax({
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "{{ route('customerUpdate') }}",
        data: {
              'disconnectionreason': $('#disconnection_reason').val(),
              'cphandover': $('#cp_handover').val(),
              'serviceorderno': $('#service_order_no').val()
        },
        success: function (data, textStatus, jqXHR) {
                if(data['alert-type'] == 'success'){
                   $("#cd_form").addClass('d-none');
                   $("#cd_thank").removeClass('d-none');
                  Swal.fire({
                    title: 'Successfully Submitted!',
                    text: 'Thank You for your response',
                    icon: 'success',
                    confirmButtonText: 'OK'
                  })
                }else{
                  Swal.fire({
                    title: 'Error! Please Try Again!',
                    text: data['message'],
                    icon: 'error',
                    confirmButtonText: 'OK'
                  })
                }
        },
        error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire({
                  title: 'Error!',
                  text: 'Error occurred!' + errorThrown,
                  icon: 'error',
                  confirmButtonText: 'OK'
                })
        }
      });
    })
  </script>
@endpush
  

