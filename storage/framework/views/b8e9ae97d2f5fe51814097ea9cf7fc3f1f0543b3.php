<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="card-title mb-0">Tambah Paket Bundling</h5>
                            <small class="text-muted"><?php echo e($pelatihan->title); ?></small>
                        </div>
                        <a href="<?php echo e(route('admin.pelatihan.bundle.index', $pelatihan->id)); ?>" class="btn btn-secondary btn-rounded btn-sm">
                            <i class="fa-solid fa-arrow-left mr-1"></i>Kembali
                        </a>
                    </div>

                    <?php echo $__env->make('layouts.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <form action="<?php echo e(route('admin.pelatihan.bundle.store', $pelatihan->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label>Nama Paket <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Paket 3 Orang" value="<?php echo e(old('name')); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Orang dalam Paket <span class="text-danger">*</span></label>
                            <input type="number" name="person_count" class="form-control" min="1" placeholder="Contoh: 3" value="<?php echo e(old('person_count')); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Harga Total Paket (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="bundle_price" class="form-control" min="0" placeholder="Contoh: 2100000" value="<?php echo e(old('bundle_price')); ?>" required>
                            <small class="text-muted">Harga satuan reguler: Rp<?php echo e(number_format($pelatihan->price, 0, ',', '.')); ?> × jumlah orang</small>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Paket</label>
                            <input type="text" name="description" class="form-control" placeholder="Opsional, misal: Hemat Rp150.000" value="<?php echo e(old('description')); ?>">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" <?php echo e(old('is_active', '1') == '1' ? 'checked' : ''); ?>>
                                <label class="custom-control-label" for="is_active">Paket Aktif (tampil di form pendaftaran)</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-rounded">
                            <i class="fa-solid fa-save mr-1"></i>Simpan Paket
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ['title' => 'Tambah Paket Bundling - ' . $pelatihan->title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/cms.jatidiri.app/resources/views/admin/pelatihan/bundle/create.blade.php ENDPATH**/ ?>