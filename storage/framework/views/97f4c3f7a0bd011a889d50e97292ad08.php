<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HSS | Leave Application</title>
    <link href="<?php echo e(asset('import/assets/css/styles.css')); ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>

    <link href="<?php echo e(asset('import/assets/vendors/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('import/assets/vendors/bootstrap-icons/bootstrap-icons.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('import/assets/vendors/boxicons/css/boxicons.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('import/assets/vendors/quill/quill.snow.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('import/assets/vendors/quill/quill.bubble.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('import/assets/vendors/remixicon/remixicon.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('import/assets/vendors/simple-datatables/style.css')); ?>" rel="stylesheet">

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
                <?php echo e(__('Leave Application')); ?>

            </h2>
         <?php $__env->endSlot(); ?>

        <!-- ======= Sidebar ======= -->
        <aside id="sidebar" class="sidebar">

            <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link " href="#">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Leave Application</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="<?php echo e(route('calendar.index')); ?>">
                <i class="bi bi-grid"></i>
                <span>On Call Application</span>
                </a>
            </li>
            
        </aside><!-- End Sidebar-->
               
        <main id="main" class="main">

            <section class="section">
              <div class="row">
        
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">
                        <br>
                        <div id="calendar"></div>
                        <div class="card-footer text-left">
                            <a href="#" class="btn btn-primary float-left">Apply</a>
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
                $('#calendar').fullCalendar({
                    header: {
                        left: 'prev, next today',
                        center: 'title',
                        right: 'month, agendaWeek, agendaDay',
                    }
                })
            });
        </script>
        <script src="<?php echo e(asset('import/assets/vendor/apexcharts/apexcharts.min.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/vendor/chart.js/chart.umd.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/vendor/echarts/echarts.min.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/vendor/quill/quill.min.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/vendor/simple-datatables/simple-datatables.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/vendor/tinymce/tinymce.min.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/vendor/php-email-form/validate.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/js/mains.js')); ?>"></script>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>

</body>
</html><?php /**PATH E:\@UTM\FYP\HSS\resources\views/calendar/index.blade.php ENDPATH**/ ?>