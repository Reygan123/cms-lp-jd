<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-between align-items-center mb-4">
                        <div class="col-sm-6">
                            <h4 class="card-title mb-0">Daftar Pelatihan</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="<?php echo e(route('admin.pelatihan.create')); ?>" class="btn btn-primary btn-rounded">
                                <span class="btn-icon-left text-primary"><i class="fa-solid fa-plus"></i></span>Tambah Pelatihan
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-responsive-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Pelatihan</th>
                                    <th>Batch</th>
                                    <th>Tanggal</th>
                                    <th>Harga</th>
                                    <th>Peserta</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $pelatihans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($pelatihans->firstItem() + $i); ?></td>
                                    <td>
                                        <strong><?php echo e($p->title); ?></strong>
                                        <?php if($p->location): ?>
                                        <div class="text-muted small"><?php echo e($p->location); ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($p->batch ?? '-'); ?></td>
                                    <td class="small">
                                        <?php if($p->start_date): ?>
                                            <?php echo e(\Carbon\Carbon::parse($p->start_date)->format('d M Y')); ?>

                                            <?php if($p->end_date): ?> – <?php echo e(\Carbon\Carbon::parse($p->end_date)->format('d M Y')); ?> <?php endif; ?>
                                        <?php else: ?> -
                                        <?php endif; ?>
                                    </td>
                                    <td>Rp<?php echo e(number_format($p->price, 0, ',', '.')); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.pelatihan.participant.index', $p->id)); ?>" class="badge badge-primary">
                                            <?php echo e($p->participants_count); ?> Peserta
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?php echo e($p->status === 'active' ? 'success' : ($p->status === 'closed' ? 'danger' : 'warning')); ?>">
                                            <?php echo e($p->status_label); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <a href="<?php echo e(route('admin.pelatihan.edit', $p->id)); ?>" class="badge badge-warning mr-1">Edit</a>
                                            <a href="<?php echo e(route('admin.pelatihan.participant.index', $p->id)); ?>" class="badge badge-info mr-1">Peserta</a>
                                            <a href="<?php echo e(route('admin.pelatihan.referral.index', $p->id)); ?>" class="badge badge-secondary mr-1">Referral</a>
                                            <button class="badge badge-danger btn-delete border-0" data-id="<?php echo e($p->id); ?>">Hapus</button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">Belum ada data pelatihan.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <?php echo e($pelatihans->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.btn-delete').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var id = this.dataset.id;
        var token = document.querySelector("meta[name='csrf-token']").getAttribute("content");
        Swal.fire({
            title: 'APAKAH KAMU YAKIN ?',
            text: "INGIN MENGHAPUS PELATIHAN INI!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'BATAL',
            confirmButtonText: 'YA, HAPUS!',
        }).then(function(result) {
            if (result.isConfirmed) {
                jQuery.ajax({
                    url: '/admin/pelatihan/' + id,
                    data: { "_token": token, "_method": "DELETE" },
                    type: 'POST',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({ icon: 'success', title: 'BERHASIL!', text: 'DATA BERHASIL DIHAPUS!', showConfirmButton: false, timer: 2000 })
                                .then(function() { location.reload(); });
                        }
                    }
                });
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ['title' => 'Pelatihan'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Reygan Fadhilah\Downloads\cms-lp-jd-main\cms-lp-jd-main\resources\views/admin/pelatihan/index.blade.php ENDPATH**/ ?>