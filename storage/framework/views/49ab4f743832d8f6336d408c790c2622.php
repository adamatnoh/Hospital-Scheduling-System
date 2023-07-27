<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HSS | Your Schedule</title>
    <link href="<?php echo e(asset('import/assets/css/styles.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/css/print.css')); ?>" rel="stylesheet" media="print">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" rel="stylesheet"/>  
    <link href="<?php echo e(asset('import/assets/vendors/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('import/assets/vendors/bootstrap-icons/bootstrap-icons.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('import/assets/vendors/boxicons/css/boxicons.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('import/assets/vendors/quill/quill.snow.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('import/assets/vendors/quill/quill.bubble.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('import/assets/vendors/remixicon/remixicon.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('import/assets/vendors/simple-datatables/style.css')); ?>" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
</head>
<body>
    
    <?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('header', null, []); ?> 
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-list toggle-sidebar-btn"></i> &nbsp;
                Dr <?php echo e(Auth::user()->name); ?> Schedule
            </h2>
         <?php $__env->endSlot(); ?>

        <!-- ======= Sidebar ======= -->
        <aside id="sidebar" class="sidebar">

          <ul class="sidebar-nav" id="sidebar-nav">

          <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#dep-nav" data-bs-toggle="collapse" href="#">
              <i class="bi bi-building"></i><span>Department Schedule</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="dep-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
              <li>
                <a href="<?php echo e(route('calendar.depschedule')); ?>">
                  <i class="bi bi-grid"></i><span>On Call Schedule</span>
                </a>
              </li>
              <li>
                <a href="<?php echo e(route('calendar.view-ward')); ?>">
                  <i class="bi bi-hospital"></i><span>Ward Schedule</span>
                </a>
              </li>
              <li>
                <a href="<?php echo e(route('calendar.view-shift')); ?>">
                  <i class="bi bi-person-workspace"></i><span>Shift Schedule</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
              <a class="nav-link " href="<?php echo e(route('calendar.yourschedule')); ?>">
              <i class="bi bi-calendar-event"></i>
              <span>Your Schedule</span>
              </a>
          </li>
          <?php if(Auth::check() && Auth::user()->role === 'scheduler'): ?>
          <li class="nav-item">
              <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-pencil"></i><span>Create Schedule</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                  <a href="<?php echo e(route('create-oncall')); ?>">
                    <i class="bi bi-grid"></i><span>On Call Schedule</span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo e(route('create-ward')); ?>">
                    <i class="bi bi-hospital"></i><span>Ward Schedule</span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo e(route('create-shift')); ?>">
                    <i class="bi bi-person-workspace"></i><span>Shift Schedule</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link collapsed" data-bs-target="#change-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-check-circle"></i><span>Changes Requested</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="change-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li class="nav-item">
                    <a class="nav-link collapsed" href="<?php echo e(route('review')); ?>">
                      <i class="bi bi-check-circle"></i><span>Review Changes Requested</span>
                    </a>
                </li>
                <li>
                  <a href="<?php echo e(route('reviewHistory')); ?>">
                    <i class="bi bi-clock-history"></i><span>Changes Requested History</span>
                  </a>
                </li>
              </ul>
            </li>
            <?php endif; ?>
        </aside><!-- End Sidebar-->
               
        <main id="main" class="main">

            <section class="section">
              <div class="row">
        
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">
                        <br>
                        <div id="calendar"></div>
                        <div class="text-right">
                          <button id="print" class="btn btn-primary float-right"><i class="bi bi-printer-fill"></i> Print Schedule</button>
                        </div>
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
                       
        <script>
            $(document).ready(function() {
                var schedule = <?php echo json_encode($events, 15, 512) ?>;

                $('#calendar').fullCalendar({
                    header: {
                        left: 'prev, next, today',
                        center: 'title',
                        right: 'month, agendaWeek, agendaDay',
                    },
                    events: schedule,
                    displayEventTime: false,
                    selectable: true,
                    selectHelper: true,
                });

                $('#print').on('click', function() {
                    window.print();
                });
            });
        </script>
        <script src="<?php echo e(asset('import/assets/vendors/apexcharts/apexcharts.min.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/vendors/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/vendors/chart.js/chart.umd.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/vendors/echarts/echarts.min.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/vendors/quill/quill.min.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/vendors/simple-datatables/simple-datatables.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/vendors/tinymce/tinymce.min.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/vendors/php-email-form/validate.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/js/mains.js')); ?>"></script>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>

</body>
</html><?php /**PATH E:\@UTM\FYP\HSS\resources\views/calendar/your-schedule.blade.php ENDPATH**/ ?>