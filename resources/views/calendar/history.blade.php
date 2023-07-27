<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HSS | Application History</title>
    <link href="{{ asset('import/assets/css/styles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" rel="stylesheet"/>  
    <link href="{{ asset('import/assets/vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/simple-datatables/style.css') }}" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <style>
        .status-button {
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .status-yes {
            background-color: rgb(14, 170, 0);
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
                {{ __('Application History') }}
            </h2>
        </x-slot>

        <!-- ======= Sidebar ======= -->
        <aside id="sidebar" class="sidebar">

            <ul class="sidebar-nav" id="sidebar-nav">

                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('calendar.leave') }}">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Leave Application</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('calendar.oncall') }}">
                    <i class="bi bi-grid"></i>
                    <span>On Call Application</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="">
                    <i class="bi bi-clock-history"></i>
                    <span>Application History</span>
                    </a>
                </li>
            
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
                        <div class="form-group">
                            <label for="reviewName">Name:</label><br>
                            <input class="form-control" id="reviewName" readonly>
                        </div>
                        <div class="form-group">
                            <label for="reviewDepartment">Department:</label><br>
                            <input class="form-control" id="reviewDepartment" readonly>
                        </div>
                        <div class="form-group">
                            <label for="reviewStartDate">Start Date:</label><br>
                            <input class="form-control" id="reviewStartDate" readonly>
                        </div>
                        <div class="form-group">
                            <label for="reviewEndDate">End Date:</label><br>
                            <input class="form-control" id="reviewEndDate" readonly>
                        </div>
                        <div class="form-group">
                            <label for="reviewReason">Reason of rejection:</label><br>
                            <input class="form-control" id="rejection" rows="3" readonly>
                        </div>
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
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Reason</th>
                            <th scope="col">Status</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($applications as $application)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $application->application_type }}</td>
                                    <td>{{ $application->start_date }}</td>
                                    <td>{{ $application->end_date }}</td>
                                    <td>{{ $application->reason }}</td>
                                    <td>
                                        @if ($application->status === 'yes' || $application->status === 'Yes')
                                            <button class="status-button status-yes">Approved</button>
                                        @elseif ($application->status === 'no' || $application->status === 'No')
                                        <button class="status-button status-no" data-application-id="{{ $application->id }}" data-application-title="{{ $application->title }}" data-application-department="{{ $application->department }}" data-application-start-date="{{ $application->start_date }}" data-application-end-date="{{ $application->end_date }}" data-application-reason="{{ $application->rejection }}">Rejected</button>
                                        @elseif ($application->status === 'pending' || $application->status === 'Pending')
                                            <button class="status-button status-pending">Pending Approval</button>
                                        @endif
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
        
                // Attach click event handler to the buttons with class 'status-no'
                $('.status-no').on('click', function () {
                    // Get the application details from data attributes
                    var applicationId = $(this).data('application-id');
                    var title = $(this).data('application-title');
                    var department = $(this).data('application-department');
                    var start_date = $(this).data('application-start-date');
                    var end_date = $(this).data('application-end-date');
                    var reason = $(this).data('application-reason');
        
                    // Set the values in the modal
                    $('#reviewName').val(title);
                    $('#reviewDepartment').val(department);
                    $('#reviewStartDate').val(start_date);
                    $('#reviewEndDate').val(end_date);
                    $('#rejection').val(reason);
        
                    // Show the modal
                    $('#rejectionReasonModal').modal('show');
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