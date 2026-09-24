<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-right">Create</h5>
                        <form action="<?php echo e(route('admin.partner.store')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group mb-4">
                                                <label class="text-label" for="name">Partner's Name</label>
                                                <input class="form-control" type="text" name="name"
                                                    value="<?php echo e(old('name')); ?>" placeholder="Name">
                                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm"><?php echo e($message); ?></p>
                                                        </div>
                                                    </div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label class="text-label" for="web">Partner's Web Address</label>
                                                <input class="form-control" type="text" name="web"
                                                    value="<?php echo e(old('web')); ?>" placeholder="Web">
                                                <?php $__errorArgs = ['web'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm"><?php echo e($message); ?></p>
                                                        </div>
                                                    </div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="text-label" for="description">Partner Description</label>
                                                <textarea id="editor1" class="form-control" name="description" rows="3"><?php echo e(old('description')); ?></textarea>
                                                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm"><?php echo e($message); ?></p>
                                                        </div>
                                                    </div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="text-label" for="program_desc">Partenership Details</label>
                                                <textarea id="editor2" class="form-control" name="program_desc" rows="3"><?php echo e(old('program_desc')); ?></textarea>
                                                <?php $__errorArgs = ['program_desc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm"><?php echo e($message); ?></p>
                                                        </div>
                                                    </div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-2 mt-4">
                                                <label class="text-gray-700" for="image">Gambar (Max Size: 750kb)</label>
                                                <input type="file" class="dropify" data-default-file="" id="image"
                                                    name="image" />
                                                <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm"><?php echo e($message); ?></p>
                                                        </div>
                                                    </div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-start mt-4">
                                <button type="submit" class="btn btn-primary">CREATE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor1'))
            .catch(error => {
                console.error(error);
            });
            ClassicEditor
            .create(document.querySelector('#editor2'))
            .catch(error => {
                console.error(error);
            });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ['title' => 'Partners'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/cms.jatidiri.app/resources/views/admin/partner/create.blade.php ENDPATH**/ ?>