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
                                <tr><td class="text-muted" style="width:40%">Nama Lengkap</td><td><strong><?php echo e($participant->full_name); ?></strong></td></tr>
                                <tr><td class="text-muted">Nama Sertifikat</td><td><?php echo e($participant->name_for_certificate); ?></td></tr>
                                <tr><td class="text-muted">Jenis Kelamin</td><td><?php echo e($participant->gender ?? '-'); ?></td></tr>
                                <tr><td class="text-muted">TTL / Usia</td><td>
                                    <?php echo e($participant->birth_place ?? '-'); ?><?php echo e($participant->birth_date ? ', ' . \Carbon\Carbon::parse($participant->birth_date)->format('d/m/Y') : ''); ?>

                                    <?php if($participant->age): ?><span class="badge badge-info ml-1"><?php echo e($participant->age); ?> th</span><?php endif; ?>
                                </td></tr>
                                <tr><td class="text-muted">Email</td><td><?php echo e($participant->email); ?></td></tr>
                                <tr><td class="text-muted">WhatsApp</td><td>
                                    <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $participant->whatsapp)); ?>" target="_blank"><?php echo e($participant->whatsapp); ?></a>
                                </td></tr>
                                <tr><td class="text-muted">Domisili</td><td><?php echo e($participant->domicile ?? '-'); ?></td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr><td class="text-muted" style="width:40%">Institusi</td><td><strong><?php echo e($participant->institution_name ?? '-'); ?></strong></td></tr>
                                <tr><td class="text-muted">Kota Lembaga</td><td><?php echo e($participant->institution_city ?? '-'); ?></td></tr>
                                <tr><td class="text-muted">Jenjang (Q4)</td><td>
                                    <?php if($participant->institution_level): ?>
                                        <?php $__currentLoopData = explode(', ', $participant->institution_level); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lvl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge badge-light border text-dark mr-1 mb-1"><?php echo e(trim($lvl)); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td></tr>
                                <tr><td class="text-muted">Jabatan</td><td><?php echo e($participant->role_in_institution ?? '-'); ?></td></tr>
                                <tr><td class="text-muted">Pernah Pelatihan</td><td><?php echo e($participant->had_previous_training ? 'Pernah' : 'Belum pernah'); ?></td></tr>
                                <tr><td class="text-muted">Tipe Daftar</td><td>
                                    <?php echo e($participant->registration_type === 'kolektif' ? 'Kolektif (' . $participant->collective_count . ' orang)' : 'Individu'); ?>

                                    <?php if($participant->collective_coordinator): ?><br><small class="text-muted">Koordinator: <?php echo e($participant->collective_coordinator); ?></small><?php endif; ?>
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
                                <?php if($participant->bundle_name): ?>
                                <tr><td class="text-muted">Paket Bundling</td><td><span class="badge badge-info"><?php echo e($participant->bundle_name); ?></span></td></tr>
                                <?php endif; ?>
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

            <?php if($participant->registration_type === 'kolektif' && $participant->subParticipants->count() > 0): ?>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fa-solid fa-users mr-1"></i> Daftar Data Lengkap Peserta Kolektif Lembaga (<?php echo e($participant->subParticipants->count()); ?> orang)</span>
                    <form action="<?php echo e(route('admin.pelatihan.participant.send-all-certificates', [$pelatihan->id, $participant->id])); ?>" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-sm btn-primary btn-rounded" onclick="return confirm('Kirim semua sertifikat yang sudah diupload?')">
                            <i class="fa-solid fa-paper-plane mr-1"></i> Kirim Semua Sertifikat
                        </button>
                    </form>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama & Gelar</th>
                                    <th>Gender / TTL / Usia</th>
                                    <th>Kontak & Domisili</th>
                                    <th>Institusi & Jenjang</th>
                                    <th>Jabatan</th>
                                    <th>Sertifikat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $participant->subParticipants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($i + 1); ?></td>
                                    <td>
                                        <strong><?php echo e($sub->full_name); ?></strong><br>
                                        <small class="text-muted"><?php echo e($sub->name_for_certificate); ?></small>
                                    </td>
                                    <td class="small">
                                        <?php echo e($sub->gender ?? '-'); ?><br>
                                        <?php echo e($sub->birth_place ?? '-'); ?><?php echo e($sub->birth_date ? ', ' . \Carbon\Carbon::parse($sub->birth_date)->format('d/m/Y') : ''); ?>

                                        <?php if($sub->age): ?><span class="badge badge-info ml-1"><?php echo e($sub->age); ?> th</span><?php endif; ?>
                                    </td>
                                    <td class="small">
                                        <i class="fa-solid fa-envelope mr-1 text-muted"></i><?php echo e($sub->email ?? '-'); ?><br>
                                        <i class="fa-brands fa-whatsapp mr-1 text-success"></i><?php echo e($sub->whatsapp ?? '-'); ?><br>
                                        <small class="text-muted"><i class="fa-solid fa-location-dot mr-1"></i><?php echo e($sub->domicile ?? '-'); ?></small>
                                    </td>
                                    <td class="small">
                                        <strong><?php echo e($sub->institution_name ?? '-'); ?></strong>
                                        <?php if($sub->institution_city): ?><br><small class="text-muted"><?php echo e($sub->institution_city); ?></small><?php endif; ?>
                                        <?php if($sub->institution_level): ?>
                                            <div class="mt-1">
                                                <?php $__currentLoopData = explode(', ', $sub->institution_level); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lvl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="badge badge-light border text-dark" style="font-size:10px;"><?php echo e(trim($lvl)); ?></span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="small"><?php echo e($sub->role_in_institution ?? '-'); ?></td>
                                    <td>
                                        <?php if($sub->certificate_file): ?>
                                            <span class="badge badge-success">Ada</span>
                                            <a href="<?php echo e(asset('storage/certificates/' . $sub->certificate_file)); ?>" target="_blank" class="d-block small text-primary mt-1"><i class="fa-solid fa-file-pdf"></i> Lihat</a>
                                            <?php if($sub->certificate_sent_at): ?>
                                            <div class="text-muted" style="font-size:11px;">Terkirim <?php echo e(\Carbon\Carbon::parse($sub->certificate_sent_at)->format('d/m/Y')); ?></div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Belum</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <form action="<?php echo e(route('admin.pelatihan.participant.sub.upload-certificate', [$pelatihan->id, $participant->id, $sub->id])); ?>" method="POST" enctype="multipart/form-data" class="d-flex align-items-center mb-1" style="gap:4px">
                                            <?php echo csrf_field(); ?>
                                            <input type="file" name="certificate_file" class="form-control form-control-sm" style="max-width:140px" accept=".pdf,.jpg,.jpeg,.png">
                                            <button type="submit" class="btn btn-xs btn-outline-primary btn-rounded" style="white-space:nowrap">Upload</button>
                                        </form>
                                        <?php if($sub->certificate_file): ?>
                                        <form action="<?php echo e(route('admin.pelatihan.participant.sub.send-certificate', [$pelatihan->id, $participant->id, $sub->id])); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-xs btn-primary btn-rounded btn-block" <?php echo e(!$sub->email ? 'disabled title="Email tidak ada"' : ''); ?>>
                                                <i class="fa-solid fa-paper-plane mr-1"></i> Kirim
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-4">
            <?php echo $__env->make('layouts.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
                <div class="card-header">Ubah Status Manual</div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.pelatihan.participant.update-status', [$pelatihan->id, $participant->id])); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-group mb-2">
                            <label class="small text-muted">Status Baru</label>
                            <select name="status" class="form-control form-control-sm" required>
                                <option value="pending" <?php echo e($participant->status === 'pending' ? 'selected' : ''); ?>>Menunggu</option>
                                <option value="approved" <?php echo e($participant->status === 'approved' ? 'selected' : ''); ?>>Disetujui</option>
                                <option value="rejected" <?php echo e($participant->status === 'rejected' ? 'selected' : ''); ?>>Ditolak</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label class="small text-muted">Catatan Admin (opsional)</label>
                            <textarea class="form-control form-control-sm" name="admin_note" rows="2" placeholder="Catatan..."><?php echo e($participant->admin_note); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning btn-block btn-rounded btn-sm">
                            <i class="fa-solid fa-rotate mr-1"></i> Perbarui Status & Kirim Notifikasi
                        </button>
                    </form>
                </div>
            </div>

            <?php if($participant->registration_type === 'individu'): ?>
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
            <?php endif; ?>

            <a href="<?php echo e(route('admin.pelatihan.participant.index', $pelatihan->id)); ?>" class="btn btn-secondary btn-block btn-rounded">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ['title' => 'Detail Peserta'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Reygan Fadhilah\Downloads\cms-lp-jd-main\cms-lp-jd-main\resources\views/admin/pelatihan/participant/show.blade.php ENDPATH**/ ?>