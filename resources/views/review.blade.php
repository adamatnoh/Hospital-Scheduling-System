<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HSS | Leave Application</title>
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
                <a class="nav-link collapsed" href="{{ route('calendar.depschedule') }}" :active="request()->routeIs('calendar.depschedule')">
                <i class="bi bi-building"></i>
                <span>Department Schedule</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="">
                <i class="bi bi-calendar-event"></i>
                <span>Your Schedule</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-pencil"></i><span>Create Schedule</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                  <li>
                    <a href="">
                      <i class="bi bi-grid"></i><span>On Call Schedule</span>
                    </a>
                  </li>
                  <li>
                    <a href="">
                      <i class="bi bi-hospital"></i><span>Ward Schedule</span>
                    </a>
                  </li>
                  <li>
                    <a href="">
                      <i class="bi bi-person-workspace"></i><span>Staff Schedule</span>
                    </a>
                  </li>
                </ul>
              </li><!-- End Create Schedule Nav -->
            <li class="nav-item">
                <a class="nav-link " href="">
                <i class="bi bi-check-circle"></i>
                <span>Review Changes Requested</span>
                </a>
            </li>
            
        </aside><!-- End Sidebar-->
               
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
                            <th scope="col">Name</th>
                            <th scope="col">Reason</th>
                            <th scope="col">Date</th>
                            <th scope="col">Approval</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th scope="row">1</th>
                            <td>Dr Firdaus</td>
                            <td>Leave: Emergency</td>
                            <td>2023-05-25</td>
                            <td><button class="btn btn-primary btn-sm">Approve</button>&nbsp;<button class="btn btn-danger btn-sm">Reject</button></td>
                          </tr>
                          <tr>
                            <th scope="row">2</th>
                            <td>Dr Farah</td>
                            <td>On Call: Preferred</td>
                            <td>2023-05-17</td>
                            <td><button class="btn btn-primary btn-sm">Approve</button>&nbsp;<button class="btn btn-danger btn-sm">Reject</button></td>
                          </tr>
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