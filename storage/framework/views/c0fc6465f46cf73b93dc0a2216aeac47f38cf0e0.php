<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-sm-6">
                                <a href="<?php echo e(route('admin.post.create')); ?>" class="btn btn-primary btn-rounded">
                                    <span class="btn-icon-left text-primary"><i
                                            class="fa-solid fa-pen-to-square"></i></span>Add Post
                                </a>
                                <a href="<?php echo e(route('admin.category.index')); ?>" class="btn btn-primary btn-rounded mx-4">
                                    Categories <span class="btn-icon-right"><i class="fa-regular fa-folder"></i></span>
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <form action="<?php echo e(route('admin.post.index')); ?>" method="GET" class="d-flex">
                                    <input class="form-control input-rounded" type="text" name="q"
                                        value="<?php echo e(request()->query('q')); ?>" placeholder="Search" aria-label="Search">
                                    <button class="btn btn-primary btn-rounded ml-4" type="submit">Search</button>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive mt-4">
                            <table class="table table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select-all"></th>
                                        <th>Title & Description</th>
                                        <th>Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <th>
                                                <input type="checkbox" name="posts[]" value="<?php echo e($post->id); ?>">
                                            </th>
                                            <td>
                                                <h6><?php echo e($post->title); ?></h6>
                                                <div><?php echo e(date('d M Y', strtotime($post->pub_date))); ?> |
                                                    <?php echo e($post->category->name); ?></div>
                                                <div class="flex mt-4">
                                                    <a href="<?php echo e(route('admin.post.edit', $post->id)); ?>"
                                                        class="badge badge-primary mr-2 badge-rounded">Edit</a>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if($post->image && file_exists(public_path('storage/posts/' . $post->image))): ?>
                                                    <img src="<?php echo e(asset('storage/posts/' . $post->image)); ?>"
                                                        alt="<?php echo e($post->title); ?>" class="admin-index-image">
                                                <?php else: ?>
                                                    <img src="<?php echo e(asset('storage/identities/no_image.jpg')); ?>"
                                                        class="admin-edit-image">
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <div class="bg-red text-white text-center">
                                            Data Belum Tersedia!
                                        </div>
                                    <?php endif; ?>
                                </tbody>
                            </table>

                            <div class="mt-4">
                                <button id="delete-selected" class="btn btn-danger btn-rounded mx-4">
                                    Delete Selected <span class="btn-icon-right"><i
                                            class="fa-solid fa-trash-can"></i></span>
                                </button>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <?php echo e($posts->links()); ?>

                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Select all checkboxes
        document.getElementById('select-all').onclick = function() {
            var checkboxes = document.getElementsByName('posts[]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        }

        // Ajax delete selected
        document.getElementById('delete-selected').onclick = function() {
            var selectedPosts = [];
            var checkboxes = document.getElementsByName('posts[]');
            var token = document.querySelector("meta[name='csrf-token']").getAttribute("content");

            for (var checkbox of checkboxes) {
                if (checkbox.checked) {
                    selectedPosts.push(checkbox.value);
                }
            }

            if (selectedPosts.length > 0) {
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
                        jQuery.ajax({
                            url: '<?php echo e(route('admin.post.massDestroy')); ?>',
                            data: {
                                "ids": selectedPosts,
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
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'PILIH DATA!',
                    text: 'PILIH DATA YANG INGIN DIHAPUS!',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ['title' => 'Blog'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/cms.jatidiri.app/resources/views/admin/post/index.blade.php ENDPATH**/ ?>