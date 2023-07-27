{{-- This is Review Application View by Scheduler --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HSS | Leave Application</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('import/assets/css/styles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>

    <link href="{{ asset('import/assets/vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/simple-datatables/style.css') }}" rel="stylesheet">

    <style>
      .status-button {
          padding: 5px 10px;
          border-radius: 5px;
          font-weight: bold;
      }
      .status-yes {
          background-color: rgb(20, 133, 240);
          color: rgb(255, 255, 255);
      }
      .status-no {
          background-color: rgb(197, 0, 0);
          color: white;
      }
      .status-pending {
          background-color: rgb(212, 209, 37);
          color: rgb(0, 0, 0);
      }
  </style>
</head>
<body>
    
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-list toggle-sidebar-btn"></i> &nbsp;
                {{ __('Review Changes Requested') }}
            </h2>
        </x-slot>

        <!-- ======= Sidebar ======= -->
        <aside id="sidebar" class="sidebar">

          <ul class="sidebar-nav" id="sidebar-nav">

          <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#dep-nav" data-bs-toggle="collapse" href="#">
              <i class="bi bi-building"></i><span>Department Schedule</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="dep-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
              <li>
                <a href="{{ route('calendar.depschedule') }}">
                  <i class="bi bi-grid"></i><span>On Call Schedule</span>
                </a>
              </li>
              <li>
                <a href="{{ route('calendar.view-ward') }}">
                  <i class="bi bi-hospital"></i><span>Ward Schedule</span>
                </a>
              </li>
              <li>
                <a href="{{ route('calendar.view-shift') }}">
                  <i class="bi bi-person-workspace"></i><span>Shift Schedule</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
              <a class="nav-link collapsed" href="{{ route('calendar.yourschedule') }}">
              <i class="bi bi-calendar-event"></i>
              <span>Your Schedule</span>
              </a>
          </li>
          @if (Auth::check() && Auth::user()->role === 'scheduler')
          <li class="nav-item">
              <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-pencil"></i><span>Create Schedule</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                  <a href="{{ route('create-oncall') }}">
                    <i class="bi bi-grid"></i><span>On Call Schedule</span>
                  </a>
                </li>
                <li>
                  <a href="{{ route('create-ward') }}">
                    <i class="bi bi-hospital"></i><span>Ward Schedule</span>
                  </a>
                </li>
                <li>
                  <a href="{{ route('create-shift') }}">
                    <i class="bi bi-person-workspace"></i><span>Shift Schedule</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link " data-bs-target="#change-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-check-circle"></i><span>Changes Requested</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="change-nav" class="nav-content  " data-bs-parent="#sidebar-nav">
                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('review') }}">
                      <i class="bi bi-check-circle"></i><span>Review Changes Requested</span>
                    </a>
                </li>
                <li>
                  <a href="{{ route('reviewHistory') }}">
                    <i class="bi bi-clock-history"></i><span>Changes Requested History</span>
                  </a>
                </li>
              </ul>
            </li>
            @endif
        </aside><!-- End Sidebar-->

        <!-- Modal -->
        <div class="modal fade" id="rejectionReasonModal" tabindex="-1" aria-labelledby="rejectionReasonModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="rejectionReasonModalLabel">Rejection Reason</h5>
                      <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                      <div class="mb-3">
                          <textarea class="form-control" id="rejectionReason" rows="3" required></textarea>
                      </div> 
                  </div>
                  <div class="modal-footer">
                    <button id='closeModal' class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button id="confirmBtn" class="btn btn-primary">Confirm</button>
                  </div>
              </div>
          </div>
        </div>
               
        <main id="main" class="main">
        
            <section class="section">
              <div class="row">
                <div class="col-lg-12">
        
                  <div class="card">
                    <div class="card-body">
                     
                    <!-- Table with stripped rows -->
                      <table class="table datatable">
                        <thead>
                          <tr>
                            <th scope="col">No</th>
                            <th scope="col">Type</th>
                            <th scope="col">Name</th>
                            <th scope="col">Reason</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Approval</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($applications as $application)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $application->application_type }}</td>
                                <td>{{ $application->title }}</td>
                                <td>{{ $application->reason }}</td>
                                <td>{{ $application->start_date }}</td>
                                <td>{{ $application->end_date }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm status-no" data-application-id="{{ $application->id }}">Reject</button>&nbsp;
                                    <button class="btn btn-primary btn-sm status-yes" data-application-id="{{ $application->id }}">Approve</button>
                                </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      <!-- End Table with stripped rows -->
                    </div>
                  </div>
        
                </div>
              </div>
            </section>
        
          </main><!-- End #main -->
        
          <!-- ======= Footer ======= -->
          <footer id="footer" class="footer">
            <div class="copyright">
              &copy; Copyright <strong><span>Hospital Scheduling System</span></strong>. All Rights Reserved
            </div>
          </footer><!-- End Footer -->
        
          <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
          
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script> 
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
          <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
          <script>
            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                // var id = $(this).data('application-id');
                var url = '';
                
                // Handle "Not Approved" button click event
                $('.status-no').on('click', function () {
                    var id = $(this).data('application-id');
                    $('#rejectionReasonModal').modal('show');
                    // Handle rejection reason form submission
                    $(document).on('click', '#confirmBtn', function () {
                      var status = "No";
                      var rejectionReason = $('#rejectionReason').val();
                      if ('{{ $application->application_type }}' === 'On Call') {
                          url = "{{ route('updateReviewOnCall', ['id' => ':id']) }}";
                      } else {
                          url = "{{ route('updateReviewLeave', ['id' => ':id']) }}";
                      }
                      url = url.replace(':id', id);
                      $.ajax({
                          url: url,
                          type: "PATCH",
                          dataType: 'json',
                          data: {
                              status: status,
                              rejection: rejectionReason
                          },
                          success: function (response) {
                              Swal.fire("Success", "Successfully rejected an application!", "success");
                              setTimeout(function() {
                                location.reload();
                            }, 3000);
                          },
                          error: function (xhr, status, error) {
                            Swal.fire('Error', 'Error encountered.', 'error');
                              if(error.responseJSON.errors) {
                                  $('#titleError').html(error.responseJSON.errors.title);
                              }
                              return;
                          }
                      });
                      $('#rejectionReasonModal').modal('hide');
                    });
                });
                $('.status-yes').on('click', function () {
                  var status = "Yes";
                  var id = $(this).data('application-id');
                  var rejectionReason = $('#rejectionReason').val();
                  if ('{{ $application->application_type }}' === 'On Call') {
                      url = "{{ route('updateStatusOnCall', ['id' => ':id']) }}";
                  } else {
                      url = "{{ route('updateStatusLeave', ['id' => ':id']) }}";
                  }
                  url = url.replace(':id', id);
                  $.ajax({
                        url: url, 
                        type: "PATCH",
                        dataType: 'json',
                        data: {
                            status: status
                        },
                        success: function (response) {
                            Swal.fire("Approved", "Approval successfully saved!", "success");
                            setTimeout(function() {
                                location.reload();
                            }, 3000);
                        },
                        error: function (xhr, status, error) {
                            Swal.fire('Error', 'Error encountered.', 'error');
                              if(error.responseJSON.errors) {
                                  $('#titleError').html(error.responseJSON.errors.title);
                              }
                              return;
                        }
                    });
                });
            });
          </script>                       
          <script src="{{ asset('import/assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
          <script src="{{ asset('import/assets/vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
          <script src="{{ asset('import/assets/vendors/chart.js/chart.umd.js') }}"></script>
          <script src="{{ asset('import/assets/vendors/echarts/echarts.min.js') }}"></script>
          <script src="{{ asset('import/assets/vendors/quill/quill.min.js') }}"></script>
          <script src="{{ asset('import/assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
          <script src="{{ asset('import/assets/vendors/tinymce/tinymce.min.js') }}"></script>
          <script src="{{ asset('import/assets/vendors/php-email-form/validate.js') }}"></script>
          <script src="{{ asset('import/assets/js/mains.js') }}"></script>
    </x-app-layout>

</body>
</html>