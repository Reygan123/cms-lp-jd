<?php $__env->startSection('content'); ?>
<main class="flex-1 overflow-x-hidden overflow-y-auto">
    <div class="container mx-auto px-6 py-8">

        <?php if(session('status')): ?>
        <div class="bg-green-500 p-3 rounded-md shadow-sm mt-3">
            <?php if(session('status')=='profile-information-updated'): ?>
            Profile has been updated.
            <?php endif; ?>
            <?php if(session('status')=='password-updated'): ?>
            Password has been updated.
            <?php endif; ?>
            <?php if(session('status')=='two-factor-authentication-disabled'): ?>
            Two factor authentication disabled.
            <?php endif; ?>
            <?php if(session('status')=='two-factor-authentication-enabled'): ?>
            Two factor authentication enabled.
            <?php endif; ?>
            <?php if(session('status')=='recovery-codes-generated'): ?>
            Recovery codes generated.
            <?php endif; ?>
        </div>
        <?php endif; ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php if(Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication())): ?>
                                <div class="p-6 bg-white rounded-md shadow-md">
                                    <h4 class="capitalize">TWO-FACTOR AUTHENTICATION</h4>
                                    <hr class="mt-4">
            
                                    <div class="mt-4">
                                        <?php if(! auth()->user()->two_factor_secret): ?>
                                        
                                        <form method="POST" action="<?php echo e(url('user/two-factor-authentication')); ?>">
                                            <?php echo csrf_field(); ?>
            
                                            <button type="submit"
                                                class="btn btn-primary btn btn-lg">
                                                Enable Two-Factor
                                            </button>
                                        </form>
                                        <?php else: ?>
                                        
                                        <form method="POST" action="<?php echo e(url('user/two-factor-authentication')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
            
                                            <button type="submit"
                                                class="px-4 py-2 bg-red-600 text-gray-200 rounded-md hover:bg-red-900 focus:outline-none focus:bg-gray-700">
                                                Disable Two-Factor
                                            </button>
                                        </form>
            
                                        <?php if(session('status') == 'two-factor-authentication-enabled'): ?>
                                        
                                        <div class="mt-4">
                                            Otentikasi dua faktor sekarang diaktifkan. Pindai kode QR berikut menggunakan aplikasi
                                            pengautentikasi ponsel Anda.
                                        </div>
            
                                        <div class="mb-3 mt-4">
                                            <?php echo auth()->user()->twoFactorQrCodeSvg(); ?>

                                        </div>
                                        <?php endif; ?>
            
                                        
                                        <div class="mt-4">
                                            Simpan recovery code ini dengan aman. Ini dapat digunakan untuk memulihkan akses ke akun
                                            Anda jika perangkat otentikasi dua faktor Anda hilang.
                                        </div>
            
                                        <div style="background: rgb(44, 44, 44);color:white" class="rounded p-3 mb-2 mt-4">
                                            <?php $__currentLoopData = json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div><?php echo e($code); ?></div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
            
                                        
                                        <form method="POST" action="<?php echo e(url('user/two-factor-recovery-codes')); ?>">
                                            <?php echo csrf_field(); ?>
            
                                            <button type="submit"
                                                class="mt-4 px-4 py-2 bg-gray-600 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700">
                                                Regenerate Recovery Codes
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                    </div>
            
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <div class="p-6 bg-white rounded-md shadow-md">
                                <h4 class="">Edit Profile</h4>
                                <hr class="mt-4">
                                <form class="mt-4" action="<?php echo e(route('user-profile-information.update')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <div class="form-group">
                                        <label class="text-label" for="name">Full Name</label>
                                        <input class="form-control" type="text" name="name" value="<?php echo e(old('name') ?? auth()->user()->name); ?>">
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
                                    <div class="form-group mt-4">
                                        <label class="text-label" for="email">Email</label>
                                        <input class="form-control" type="email" name="email" value="<?php echo e(old('email') ?? auth()->user()->email); ?>">
                                        <?php $__errorArgs = ['email'];
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
                                    
                                    <div class="mt-4">
                                        <button type="submit"
                                            class="btn btn-primary">UPDATE
                                            PROFILE</button>
                                    </div>
                                </form>
                            </div>
            
                            <div class="mt-5">
                                <h4 class="">Update Password</h4>
                                <hr class="mt-2">
                                <form class="mt-4" action="<?php echo e(route('user-password.update')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <div class="form-group mt-4 row">
                                        <label class="col-sm-3 col-form-label" for="current_password">Old Password</label>
                                        <input class="col-sm-9 form-control" type="password" name="current_password">
                                        <?php $__errorArgs = ['current_password'];
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
                                    <div class="form-group mt-4 row">
                                        <label class="col-sm-3 col-form-label" for="password">New Password</label>
                                        <input class="col-sm-9 form-control" type="password" name="password">
                                        <?php $__errorArgs = ['password'];
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
                                    <div class="form-group mt-4 row">
                                        <label class="col-sm-3 col-form-label" for="password">New Password Confirmation</label>
                                        <input class="col-sm-9 form-control" type="password" name="password_confirmation">
                                        <span id="password-mismatch" class="text-danger mt-2" style="display: none;">Password tidak cocok.</span>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <button type="submit"
                                            class="btn btn-primary">UPDATE
                                            PASSWORD</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center my-3">
                            <h4 class="card-title">Role User <span class="badge badge-primary" data-toggle="modal"
                                    data-target="#exampleModalCenter">+ Tambah User Baru</span></h4>
                            <form method="GET" action="<?php echo e(route('admin.profile.index')); ?>" class="mb-3 col-6">
                                <div class="input-group">
                                    <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                                        class="form-control" placeholder="Cari pengguna...">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <th><?php echo e($loop->iteration); ?></th>
                                            <td><?php echo e($user->name); ?></td>
                                            <td><?php echo e($user->email); ?></td>
                                            <td class="color-primary">
                                                <span class="badge badge-warning" data-toggle="modal"
                                                    data-target="#editUserModal<?php echo e($user->id); ?>">Edit</span>
                                            </td>
                                        </tr>
                                        <!-- Modal Edit User -->
                                        <div class="modal fade" id="editUserModal<?php echo e($user->id); ?>" tabindex="-1"
                                            aria-labelledby="editUserModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editUserModalLabel">Edit Pengguna</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="POST"
                                                        action="<?php echo e(route('admin.profile.update', $user->id)); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PUT'); ?>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="name" class="form-label">Nama</label>
                                                                <input type="text" name="name" class="form-control"
                                                                    value="<?php echo e($user->name); ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="email" class="form-label">Email</label>
                                                                <input type="email" name="email" class="form-control"
                                                                    value="<?php echo e($user->email); ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="password" class="form-label">Password</label>
                                                                <input type="password" name="password" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Tutup</button>
                                                            <button type="submit" class="btn btn-primary">Simpan
                                                                Perubahan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            <?php echo e($users->links('pagination::bootstrap-4')); ?>

                        </div>
                    </div>
                </div>
            </div>
</main>
<!-- Modal -->
    <div class="modal fade" id="exampleModalCenter">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.profile.store')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" aria-describedby="name"
                                name="name">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">password</label>
                            <input type="password" class="form-control" id="password" aria-describedby="password"
                                name="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');

        const mismatchMessage = document.getElementById('password-mismatch');

        confirmPasswordInput.addEventListener('input', () => {
            if (passwordInput.value !== confirmPasswordInput.value) {
                mismatchMessage.style.display = 'block';
            } else {
                mismatchMessage.style.display = 'none';

            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ['title' => 'Profile - Admin'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/cms.jatidiri.app/resources/views/admin/profile/index.blade.php ENDPATH**/ ?>