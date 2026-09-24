<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?php $__currentLoopData = $juduls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="title-section">
                        <h4 class="text-center"><?php echo $title->title; ?></h4>
                        <div class="text-center mt-2"><?php echo $title->description; ?></div>
                        <div class="btn-center mt-4">
                            <div class="flex">
                                <a href="<?php echo e(route('admin.judul.edit', $title->id)); ?>" class="btn btn-primary btn btn-rounded"><span class="btn-icon-left text-primary"><i class="fa-solid fa-pen-to-square"></i></span>Edit Title</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-sm-6">
                            <a href="<?php echo e(route('admin.testimony.create')); ?>" class="btn btn-primary btn btn-rounded"><span class="btn-icon-left text-primary"><i class="fa-solid fa-pen-to-square"></i></span>Add</a>
                        </div>
                        <div class="col-sm-6">
                            <form action="<?php echo e(route('admin.testimony.index')); ?>" method="GET" class="d-flex">
                                <input class="form-control input-rounded" type="text" name="q" value="<?php echo e(request()->query('q')); ?>" placeholder="Search" aria-label="Search">
                                <button class="btn btn-primary btn-rounded ml-4" type="submit">Search</button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-responsive-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title & Description</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $testimonies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <th><?php echo e($loop->iteration); ?></th>
                                    <td>
                                        <h6><?php echo e($t->name); ?> | <?php echo e($t->title); ?></h6>
                                        <b><?php echo e($t->program_id ? ($t->program?->name ?? 'N/A') : 'N/A'); ?></b>
                                        <div><?php echo $t->description; ?></div>
                                        <div class="flex">
                                            <a href="<?php echo e(route('admin.testimony.edit', $t->id)); ?>" class="badge badge-primary mr-2 badge-rounded">Edit</a>
                                            <a onClick="destroy(this.id)" id="<?php echo e($t->id); ?>" class="badge badge-danger badge-rounded text-white">Delete</a>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="<?php echo e(asset('storage/testimonies/'.$t->image)); ?>" class="admin-index-image">
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="bg-red text-white text-center">
                                    Data Belum Tersedia!
                                </div>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    //ajax delete
    function destroy(id) {
        var id = id;
        var token = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
            title: 'APAKAH KAMU YAKIN ?',
            text: "INGIN MENGHAPUS DATA INI!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'BATAL',
            confirmButtonText: 'YA, HAPUS!',
        }).then((result) => {
            if (result.isConfirmed) {
                //ajax delete
                jQuery.ajax({
                    url: `/admin/testimony/${id}`,
                    data: {
                        "id": id,
                        "_token": token
                    },
                    type: 'DELETE',
                    success: function(response) {
                        if (response.status == "success") {
                            Swal.fire({
                                icon: 'success',
                                title: 'BERHASIL!',
                                text: 'DATA BERHASIL DIHAPUS!',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(function() {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'GAGAL!',
                                text: 'DATA GAGAL DIHAPUS!',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(function() {
                                location.reload();
                            });
                        }
                    }
                });
            }
        })
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ['title' => 'Testimony'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/cms.jatidiri.app/resources/views/admin/testimony/index.blade.php ENDPATH**/ ?>