<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="card-title mb-0"><?php echo e($participant->full_name); ?></h5>
                            <small class="text-muted"><?php echo e($participant->registration_code); ?></small>
                        </div>
                        <span class="badge badge-<?php echo e($participant->status_badge); ?> badge-pill" style="font-size:13px;">
                            <?php echo e($participant->status_label); ?>

                        </span>
                    </div>

                    <h6 class="text-primary border-bottom pb-1 mb-3">Identitas Peserta</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr><td class="text-muted" style="width:45%">Nama Lengkap</td><td><strong><?php echo e($participant->full_name); ?></strong></td></tr>
                                <tr><td class="text-muted">Nama Sertifikat</td><td><?php echo e($participant->name_for_certificate); ?></td></tr>
                                <tr><td class="text-muted">Email</td><td><?php echo e($participant->email); ?></td></tr>
                                <tr><td class="text-muted">WhatsApp</td><td>
                                    <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $participant->whatsapp)); ?>" target="_blank"><?php echo e($participant->whatsapp); ?></a>
                                </td></tr>
                                <tr><td class="text-muted">Domisili</td><td><?php echo e($participant->domicile ?? '-'); ?></td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr><td class="text-muted" style="width:45%">Institusi</td><td><?php echo e($participant->institution_name ?? '-'); ?></td></tr>
                                <tr><td class="text-muted">Jenjang</td><td><?php echo e($participant->institution_level ?? '-'); ?></td></tr>
                                <tr><td class="text-muted">Jabatan</td><td><?php echo e($participant->role_in_institution ?? '-'); ?></td></tr>
                                <tr><td class="text-muted">Pernah Pelatihan</td><td><?php echo e($participant->had_previous_training ? 'Pernah' : 'Belum pernah'); ?></td></tr>
                                <tr><td class="text-muted">Tipe Daftar</td><td>
                                    <?php echo e($participant->registration_type === 'kolektif' ? 'Kolektif (' . $participant->collective_count . ' orang)' : 'Individu'); ?>

                                    <?php if($participant->collective_coordinator): ?><br><small>Koordinator: <?php echo e($participant->collective_coordinator); ?></small><?php endif; ?>
                                </td></tr>
                            </table>
                        </div>
                    </div>

                    <?php if($participant->skill_to_improve): ?>
                    <div class="mb-3">
                        <label class="text-muted small">Keterampilan yang ingin diperkuat</label>
                        <p class="mb-0"><?php echo e($participant->skill_to_improve); ?></p>
                    </div>
                    <?php endif; ?>

                    <h6 class="text-primary border-bottom pb-1 mb-3">Pembayaran</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr><td class="text-muted">Pengirim</td><td><?php echo e($participant->payment_sender_name ?? '-'); ?></td></tr>
                                <tr><td class="text-muted">Tanggal Bayar</td><td><?php echo e($participant->payment_date ? \Carbon\Carbon::parse($participant->payment_date)->format('d M Y') : '-'); ?></td></tr>
                                <tr><td class="text-muted">Butuh Invoice</td><td><?php echo e($participant->needs_invoice ? 'Ya (' . ($participant->invoice_name ?? '-') . ')' : 'Tidak'); ?></td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr><td class="text-muted">Harga Awal</td><td>Rp<?php echo e(number_format($participant->original_price, 0, ',', '.')); ?></td></tr>
                                <?php if($participant->discount_amount > 0): ?>
                                <tr><td class="text-muted">Diskon</td><td class="text-danger">-Rp<?php echo e(number_format($participant->discount_amount, 0, ',', '.')); ?></td></tr>
                                <?php endif; ?>
                                <tr><td class="text-muted">Total Bayar</td><td><strong class="text-success">Rp<?php echo e(number_format($participant->final_price, 0, ',', '.')); ?></strong></td></tr>
                            </table>
                        </div>
                    </div>
                    <?php if($participant->payment_proof): ?>
                    <a href="<?php echo e(asset('storage/payment_proofs/' . $participant->payment_proof)); ?>" target="_blank" class="btn btn-info btn-sm btn-rounded mb-3">
                        <i class="fa-solid fa-eye mr-1"></i> Lihat Bukti Pembayaran
                    </a>
                    <?php else: ?>
                    <p class="text-muted small">Bukti pembayaran belum diunggah oleh peserta.</p>
                    <?php endif; ?>

                    <?php if($participant->referral_code): ?>
                    <h6 class="text-primary border-bottom pb-1 mb-2">Referral</h6>
                    <p class="mb-3">Kode: <strong><?php echo e($participant->referral_code); ?></strong>
                        <?php if($participant->referral_giver_name): ?> | Dari: <?php echo e($participant->referral_giver_name); ?><?php endif; ?>
                    </p>
                    <?php endif; ?>

                    <?php if($participant->answers->count() > 0): ?>
                    <h6 class="text-primary border-bottom pb-1 mb-3">Jawaban Pertanyaan Tambahan</h6>
                    <?php $__currentLoopData = $participant->answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="mb-3">
                        <label class="text-muted small"><?php echo e($answer->question->question ?? 'Pertanyaan'); ?></label>
                        <p class="mb-0"><?php echo e($answer->answer ?? '-'); ?></p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                    <?php if($participant->admin_note): ?>
                    <h6 class="text-primary border-bottom pb-1 mb-2">Catatan Admin</h6>
                    <p><?php echo e($participant->admin_note); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <?php if($participant->status === 'pending'): ?>
            <div class="card mb-3 border-warning">
                <div class="card-header bg-warning text-white">Approval Peserta</div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.pelatihan.participant.approve', [$pelatihan->id, $participant->id])); ?>" method="POST" class="mb-3">
                        <?php echo csrf_field(); ?>
                        <div class="form-group mb-2">
                            <textarea class="form-control" name="admin_note" rows="2" placeholder="Catatan (opsional)"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-block btn-rounded">
                            <i class="fa-solid fa-check mr-1"></i> Approve Peserta
                        </button>
                    </form>
                    <form action="<?php echo e(route('admin.pelatihan.participant.reject', [$pelatihan->id, $participant->id])); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-group mb-2">
                            <textarea class="form-control" name="admin_note" rows="2" placeholder="Alasan penolakan..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger btn-block btn-rounded">
                            <i class="fa-solid fa-times mr-1"></i> Tolak Peserta
                        </button>
                    </form>
                </div>
            </div>
            <?php endif; ?>

            <div class="card mb-3">
                <div class="card-header">Sertifikat</div>
                <div class="card-body">
                    <?php if($participant->certificate_file): ?>
                    <div class="mb-3">
                        <span class="badge badge-success">File Tersedia</span>
                        <?php if($participant->certificate_sent_at): ?>
                        <div class="text-muted small mt-1">
                            Dikirim: <?php echo e(\Carbon\Carbon::parse($participant->certificate_sent_at)->format('d M Y H:i')); ?>

                        </div>
                        <?php endif; ?>
                    </div>
                    <form action="<?php echo e(route('admin.pelatihan.participant.send-certificate', [$pelatihan->id, $participant->id])); ?>" method="POST" class="mb-3">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-primary btn-block btn-rounded btn-sm">
                            <i class="fa-solid fa-paper-plane mr-1"></i>
                            <?php echo e($participant->certificate_sent_at ? 'Kirim Ulang Sertifikat' : 'Kirim Sertifikat ke Email'); ?>

                        </button>
                    </form>
                    <?php endif; ?>

                    <form action="<?php echo e(route('admin.pelatihan.participant.upload-certificate', [$pelatihan->id, $participant->id])); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="form-group mb-2">
                            <label class="text-label small"><?php echo e($participant->certificate_file ? 'Ganti' : 'Upload'); ?> Sertifikat (PDF/JPG)</label>
                            <input type="file" class="dropify" name="certificate_file" data-allowed-file-extensions="pdf jpg jpeg png" data-max-file-size="5M">
                        </div>
                        <button type="submit" class="btn btn-outline-primary btn-block btn-rounded btn-sm">
                            <i class="fa-solid fa-upload mr-1"></i> Simpan Sertifikat
                        </button>
                    </form>
                </div>
            </div>

            <a href="<?php echo e(route('admin.pelatihan.participant.index', $pelatihan->id)); ?>" class="btn btn-secondary btn-block btn-rounded">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ['title' => 'Detail Peserta'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Reygan Fadhilah\Downloads\cms-lp-jd-main\cms-lp-jd-main\resources\views/admin/pelatihan/participant/show.blade.php ENDPATH**/ ?>