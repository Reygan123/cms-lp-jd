<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-1">Tambah Kode Referral</h5>
                    <p class="text-muted small mb-4"><?php echo e($pelatihan->title); ?></p>

                    <form action="<?php echo e(route('admin.pelatihan.referral.store', $pelatihan->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-group mb-4">
                            <label class="text-label">Kode Referral <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="code" value="<?php echo e(old('code')); ?>" placeholder="Contoh: SINERGI2026" style="text-transform:uppercase">
                            <small class="text-muted">Akan otomatis diubah ke huruf kapital.</small>
                            <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group mb-4">
                            <label class="text-label">Nama Mitra / PIC Marketing</label>
                            <input class="form-control" type="text" name="partner_name" value="<?php echo e(old('partner_name')); ?>" placeholder="Nama mitra atau tim marketing">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="text-label">Tipe Diskon <span class="text-danger">*</span></label>
                                    <select class="form-control" name="discount_type" id="discount_type">
                                        <option value="nominal" <?php echo e(old('discount_type') === 'nominal' ? 'selected' : ''); ?>>Nominal (Rp)</option>
                                        <option value="percent" <?php echo e(old('discount_type') === 'percent' ? 'selected' : ''); ?>>Persentase (%)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="text-label" id="discount_label">Nilai Diskon (Rp) <span class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="discount_value" value="<?php echo e(old('discount_value', 0)); ?>" min="0" step="0.01">
                                    <?php $__errorArgs = ['discount_value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="text-label">Batas Penggunaan</label>
                            <input class="form-control" type="number" name="max_usage" value="<?php echo e(old('max_usage')); ?>" min="1" placeholder="Kosongkan = tidak terbatas">
                        </div>

                        <div class="form-group mb-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" <?php echo e(old('is_active', '1') ? 'checked' : ''); ?>>
                                <label class="custom-control-label" for="is_active">Kode Aktif</label>
                            </div>
                        </div>

                        <div class="d-flex">
                            <a href="<?php echo e(route('admin.pelatihan.referral.index', $pelatihan->id)); ?>" class="btn btn-secondary mr-2">Batal</a>
                            <button type="submit" class="btn btn-primary">SIMPAN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('discount_type').addEventListener('change', function() {
    var label = document.getElementById('discount_label');
    label.innerHTML = this.value === 'percent'
        ? 'Nilai Diskon (%) <span class="text-danger">*</span>'
        : 'Nilai Diskon (Rp) <span class="text-danger">*</span>';
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ['title' => 'Tambah Kode Referral'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Reygan Fadhilah\Downloads\cms-lp-jd-main\cms-lp-jd-main\resources\views/admin/pelatihan/referral/create.blade.php ENDPATH**/ ?>