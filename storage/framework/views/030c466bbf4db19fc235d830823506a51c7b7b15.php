<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="card-title mb-0">Paket Bundling</h5>
                            <small class="text-muted"><?php echo e($pelatihan->title); ?> <?php echo e($pelatihan->batch ? '— ' . $pelatihan->batch : ''); ?></small>
                        </div>
                        <div>
                            <a href="<?php echo e(route('admin.pelatihan.index')); ?>" class="btn btn-secondary btn-rounded btn-sm mr-2">
                                <i class="fa-solid fa-arrow-left mr-1"></i>Kembali
                            </a>
                            <a href="<?php echo e(route('admin.pelatihan.bundle.create', $pelatihan->id)); ?>" class="btn btn-primary btn-rounded btn-sm">
                                <i class="fa-solid fa-plus mr-1"></i>Tambah Paket
                            </a>
                        </div>
                    </div>

                    <?php echo $__env->make('layouts.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <p class="text-muted small mb-3">
                        Paket bundling memungkinkan harga khusus untuk pendaftaran kelompok. Contoh: Paket 3 Orang = Rp 2.100.000.
                        Harga satuan per pelatihan: <strong>Rp<?php echo e(number_format($pelatihan->price, 0, ',', '.')); ?></strong>
                    </p>

                    <div class="table-responsive">
                        <table class="table table-responsive-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Paket</th>
                                    <th>Jumlah Orang</th>
                                    <th>Harga Paket</th>
                                    <th>Harga / Orang</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $bundles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($i + 1); ?></td>
                                    <td><strong><?php echo e($b->name); ?></strong></td>
                                    <td><?php echo e($b->person_count); ?> orang</td>
                                    <td>Rp<?php echo e(number_format($b->bundle_price, 0, ',', '.')); ?></td>
                                    <td class="text-muted">Rp<?php echo e(number_format($b->price_per_person, 0, ',', '.')); ?></td>
                                    <td class="small text-muted"><?php echo e($b->description ?? '-'); ?></td>
                                    <td>
                                        <?php if($b->is_active): ?>
                                            <span class="badge badge-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.pelatihan.bundle.edit', [$pelatihan->id, $b->id])); ?>" class="btn btn-sm btn-warning btn-rounded">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.pelatihan.bundle.destroy', [$pelatihan->id, $b->id])); ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus paket ini?')">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger btn-rounded"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">Belum ada paket bundling.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ['title' => 'Paket Bundling - ' . $pelatihan->title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/cms.jatidiri.app/resources/views/admin/pelatihan/bundle/index.blade.php ENDPATH**/ ?>