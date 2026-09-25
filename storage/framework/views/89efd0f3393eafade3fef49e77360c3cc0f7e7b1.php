<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h5 class="card-title mb-0">Peserta Pelatihan</h5>
                            <small class="text-muted"><?php echo e($pelatihan->title); ?> <?php echo e($pelatihan->batch ? '— ' . $pelatihan->batch : ''); ?></small>
                        </div>
                        <div class="d-flex align-items-center flex-wrap" style="gap:6px">
                            <a href="<?php echo e(route('admin.pelatihan.bundle.index', $pelatihan->id)); ?>" class="btn btn-outline-info btn-rounded btn-sm">
                                <i class="fa-solid fa-box-open mr-1"></i>Bundling
                            </a>
                            <a href="<?php echo e(route('admin.pelatihan.participant.export', [$pelatihan->id])); ?><?php echo e(request('status') ? '?status='.request('status') : ''); ?>" class="btn btn-success btn-rounded btn-sm">
                                <i class="fa-solid fa-file-csv mr-1"></i>Export CSV
                            </a>
                            <a href="<?php echo e(route('admin.pelatihan.index')); ?>" class="btn btn-secondary btn-rounded btn-sm">
                                <i class="fa-solid fa-arrow-left mr-1"></i>Kembali
                            </a>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-2">
                            <div class="card border text-center py-3">
                                <div class="text-2xl font-bold text-dark"><?php echo e($counts['all']); ?></div>
                                <div class="text-muted small">Total Peserta</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card border text-center py-3">
                                <div class="text-2xl font-bold text-warning"><?php echo e($counts['pending']); ?></div>
                                <div class="text-muted small">Menunggu</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card border text-center py-3">
                                <div class="text-2xl font-bold text-success"><?php echo e($counts['approved']); ?></div>
                                <div class="text-muted small">Disetujui</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card border text-center py-3">
                                <div class="text-2xl font-bold text-danger"><?php echo e($counts['rejected']); ?></div>
                                <div class="text-muted small">Ditolak</div>
                            </div>
                        </div>
                        <?php if($pelatihan->quota !== null): ?>
                        <div class="col-md-2">
                            <div class="card border text-center py-3">
                                <div class="text-2xl font-bold <?php echo e($pelatihan->quota_remaining <= 0 ? 'text-danger' : 'text-info'); ?>"><?php echo e($pelatihan->quota_remaining); ?></div>
                                <div class="text-muted small">Sisa Kuota</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card border text-center py-3">
                                <div class="text-2xl font-bold text-secondary"><?php echo e($pelatihan->quota); ?></div>
                                <div class="text-muted small">Total Kuota</div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <div>
                            <a href="<?php echo e(route('admin.pelatihan.participant.index', [$pelatihan->id])); ?>" class="btn btn-sm <?php echo e(!request('status') ? 'btn-primary' : 'btn-outline-secondary'); ?> mr-1">Semua (<?php echo e($counts['all']); ?>)</a>
                            <a href="<?php echo e(route('admin.pelatihan.participant.index', [$pelatihan->id])); ?>?status=pending" class="btn btn-sm <?php echo e(request('status') === 'pending' ? 'btn-warning' : 'btn-outline-warning'); ?> mr-1">Menunggu (<?php echo e($counts['pending']); ?>)</a>
                            <a href="<?php echo e(route('admin.pelatihan.participant.index', [$pelatihan->id])); ?>?status=approved" class="btn btn-sm <?php echo e(request('status') === 'approved' ? 'btn-success' : 'btn-outline-success'); ?> mr-1">Disetujui (<?php echo e($counts['approved']); ?>)</a>
                            <a href="<?php echo e(route('admin.pelatihan.participant.index', [$pelatihan->id])); ?>?status=rejected" class="btn btn-sm <?php echo e(request('status') === 'rejected' ? 'btn-danger' : 'btn-outline-danger'); ?>">Ditolak (<?php echo e($counts['rejected']); ?>)</a>
                        </div>
                        <form action="<?php echo e(route('admin.pelatihan.participant.index', $pelatihan->id)); ?>" method="GET" class="d-flex">
                            <?php if(request('status')): ?><input type="hidden" name="status" value="<?php echo e(request('status')); ?>"><?php endif; ?>
                            <input class="form-control form-control-sm input-rounded" type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari nama, email, kode...">
                            <button class="btn btn-primary btn-sm btn-rounded ml-2" type="submit">Cari</button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-responsive-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Peserta</th>
                                    <th>Institusi</th>
                                    <th>Kontak</th>
                                    <th>Pembayaran</th>
                                    <th>Referral</th>
                                    <th>Sertifikat</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $participants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="small text-muted"><?php echo e($participants->firstItem() + $i); ?></td>
                                    <td>
                                        <strong><?php echo e($p->full_name); ?></strong>
                                        <div class="text-muted small"><?php echo e($p->registration_code); ?></div>
                                        <div class="text-muted small"><?php echo e($p->registration_type === 'kolektif' ? 'Kolektif (' . $p->collective_count . ' org)' : 'Individu'); ?></div>
                                    </td>
                                    <td class="small">
                                        <strong><?php echo e($p->institution_name ?? '-'); ?></strong><br>
                                        <span class="text-muted"><?php echo e($p->institution_city ? $p->institution_city . ' • ' : ''); ?><?php echo e($p->institution_level ?? ''); ?></span>
                                    </td>
                                    <td class="small">
                                        <?php echo e($p->email); ?><br>
                                        <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $p->whatsapp)); ?>" target="_blank" class="text-success">
                                            <i class="fa-brands fa-whatsapp"></i> <?php echo e($p->whatsapp); ?>

                                        </a>
                                    </td>
                                    <td class="small">
                                        <div>Rp<?php echo e(number_format($p->original_price, 0, ',', '.')); ?></div>
                                        <?php if($p->discount_amount > 0): ?>
                                        <div class="text-danger">-Rp<?php echo e(number_format($p->discount_amount, 0, ',', '.')); ?></div>
                                        <div class="text-success font-weight-bold">= Rp<?php echo e(number_format($p->final_price, 0, ',', '.')); ?></div>
                                        <?php endif; ?>
                                        <?php if($p->payment_proof): ?>
                                        <a href="<?php echo e(asset('storage/payment_proofs/' . $p->payment_proof)); ?>" target="_blank" class="badge badge-info mt-1">Lihat Bukti</a>
                                        <?php else: ?>
                                        <span class="badge badge-secondary mt-1">Belum Upload</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="small">
                                        <?php if($p->referral_code): ?>
                                        <span class="badge badge-light"><?php echo e($p->referral_code); ?></span>
                                        <?php if($p->referral_giver_name): ?><div class="text-muted"><?php echo e($p->referral_giver_name); ?></div><?php endif; ?>
                                        <?php else: ?>
                                        <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="small text-center">
                                        <?php if($p->certificate_sent_at): ?>
                                            <span class="badge badge-success">Terkirim</span>
                                            <div class="text-muted" style="font-size:10px;"><?php echo e(\Carbon\Carbon::parse($p->certificate_sent_at)->format('d M Y H:i')); ?></div>
                                        <?php elseif($p->certificate_file): ?>
                                            <span class="badge badge-warning">Ada, Belum Kirim</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Belum Ada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?php echo e($p->status_badge); ?>"><?php echo e($p->status_label); ?></span>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.pelatihan.participant.show', [$pelatihan->id, $p->id])); ?>" class="badge badge-info mr-1">Detail</a>
                                        <?php if($p->status === 'pending'): ?>
                                        <button class="badge badge-success border-0 btn-approve mr-1" data-id="<?php echo e($p->id); ?>">Approve</button>
                                        <button class="badge badge-danger border-0 btn-reject" data-id="<?php echo e($p->id); ?>">Tolak</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">Belum ada peserta.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4"><?php echo e($participants->links()); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="approveForm" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_method" value="POST">
                <div class="modal-header"><h5 class="modal-title">Approve Peserta</h5></div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Catatan Admin (opsional)</label>
                        <textarea class="form-control" name="admin_note" rows="3" placeholder="Misal: Konfirmasi pembayaran diterima, kursi terkonfirmasi."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Ya, Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="rejectForm" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_method" value="POST">
                <div class="modal-header"><h5 class="modal-title">Tolak Peserta</h5></div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Alasan Penolakan</label>
                        <textarea class="form-control" name="admin_note" rows="3" placeholder="Tulis alasan penolakan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.btn-approve').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var id = this.dataset.id;
        document.getElementById('approveForm').action = '/admin/pelatihan/<?php echo e($pelatihan->id); ?>/participant/' + id + '/approve';
        jQuery('#approveModal').modal('show');
    });
});
document.querySelectorAll('.btn-reject').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var id = this.dataset.id;
        document.getElementById('rejectForm').action = '/admin/pelatihan/<?php echo e($pelatihan->id); ?>/participant/' + id + '/reject';
        jQuery('#rejectModal').modal('show');
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ['title' => 'Peserta - ' . $pelatihan->title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Reygan Fadhilah\Downloads\cms-lp-jd-main\cms-lp-jd-main\resources\views/admin/pelatihan/participant/index.blade.php ENDPATH**/ ?>