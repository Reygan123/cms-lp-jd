<?php $__env->startSection('content'); ?>
<div class="container-body">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="row justify-content-center">
              <div class="col-md-4">
                <img src="<?php echo e(asset('storage/identities/'.$identities[0]->logo)); ?>" alt="<?php echo e($identities[0]->name); ?>" class="logo">
                <div class="mt-4"></div>
                <h6 class="text-center"><?php echo $identities[0]->description; ?></h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
        <div class="col-xl-12">
            <div class="card" id="user-activity">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#user" role="tab" aria-controls="" aria-selected="true">
                            <div class="icon-wrap primary">
                                <i class="mdi mdi-account-group"></i>
                            </div>                                        
                            <h4><span x-data="animatedCounter(<?php echo e($sumVisitors); ?>,5, 0)" x-init="updatecounter" x-text="Math.round(current)"></span></h4>
                            <span class="type-name">Jumlah Pengunjung</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#session" role="tab" aria-controls="" aria-selected="false">
                            <div class="icon-wrap success">
                                <i class="mdi mdi-newspaper"></i>
                            </div>
                            <h4><?php echo e($sumPosts); ?></h4>
                            <span class="type-name">Jumlah Artikel</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#bounce" role="tab" aria-controls="" aria-selected="false">
                            <div class="icon-wrap info">
                                <i class="mdi mdi-calendar"></i>
                            </div>
                            <h4>
                              <?php
function getAcademicYear() {
    $currentYear = date('Y');
    $currentMonth = date('n'); // Mengambil bulan saat ini dalam format numerik (1-12)

    if ($currentMonth > 6) {
        // Jika bulan saat ini adalah setelah bulan Juni
        $academicYearStart = $currentYear;
        $academicYearEnd = $currentYear + 1;
    } else {
        // Jika bulan saat ini adalah sebelum atau sama dengan bulan Juni
        $academicYearStart = $currentYear - 1;
        $academicYearEnd = $currentYear;
    }

    return $academicYearStart . '-' . $academicYearEnd;
}

// Contoh penggunaan
echo getAcademicYear();
?>

                            </h4>
                            <span class="type-name">Tahun Akademik</span>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card p-4">
              <div class="w-full h-64 md:h-80 lg:h-96">
                <canvas id="visitorChart"></canvas>
            </div>
            </div>
        </div>
    </div>
</div>
</div>




    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1"></script>
    <script>
  document.addEventListener("DOMContentLoaded", function () {
    const visitorData = <?php echo json_encode($monthlyVisitors); ?>;

    const monthLabels = [];
    const visitorCounts = [];

    Object.keys(visitorData).forEach(function (month) {
      const monthLabel = moment(month + "-01", "YYYY-MM-DD").format("MMMM");
      monthLabels.push(monthLabel);
      visitorCounts.push(visitorData[month]);
    });

    const ctx = document.getElementById('visitorChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: monthLabels,
        datasets: [
          {
            label: 'Grafik Pengunjung',
            data: visitorCounts,
            backgroundColor: '#3b1183',
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
          },
        },
      },
    });
  });
</script>
<script>
  function animatedCounter(targer, time = 100, start = 0, smoothingFactor = 0.1) {
    return {
      current: 0,
      target: targer,
      time: time,
      start: start,
      updatecounter: function() {
        start = this.start;
        const increment = (this.target - start) / this.time;
        const handle = setInterval(() => {
          if (this.current < this.target)
            this.current += increment
          else {
            clearInterval(handle);
            this.current = this.target
          }
        }, 1);
      }
    };
  }

</script>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ['title' => 'Dashboard'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/cms.jatidiri.app/resources/views/admin/dashboard/index.blade.php ENDPATH**/ ?>