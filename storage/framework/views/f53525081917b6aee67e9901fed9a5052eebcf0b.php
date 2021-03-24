<?php $__env->startSection('title', 'Register Page'); ?>

<?php $__env->startSection('page-style'); ?>
    
    <link rel="stylesheet" href="<?php echo e(asset(mix('css/pages/authentication.css'))); ?>">
    <style rel="stylesheet">
        .custselect {
            top: -24px;
            color: rgba(34, 41, 47, 0.4) !important;
            opacity: 1;
            font-size: 0.7rem;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section class="row flexbox-container">
        <div class="col-xl-10 col-12 d-flex justify-content-center">

            <div class="card bg-authentication rounded-0 mb-0" style="background-color: #fff">
                <div class="row m-0">
                    <div class="col-lg-6 col-12 p-0">

                        <div class="card rounded-0 mb-0 p-2">
                            <div class="card-header pt-50 pb-1">
                                <div class="card-title">
                                    <h4 class="mb-0">Registrasi Member</h4>
                                </div>
                            </div>

                            <div class="card-content">
                                <div class="card-body pt-0">
                                    <div class="form-label-group">
                                        <input id="name" type="text" class="form-control" name="name" placeholder="Nama Sesuai KTP" value="<?php echo e($member->name); ?>" readonly autofocus>
                                        <label for="name">Username</label>
                                    </div>

                                    <div class="form-label-group">
                                        <input type="text" id="nik" name="nik" class="form-control" placeholder="Nomor KTP" value="<?php echo e($member->nik); ?>" readonly>
                                        <label for="nik">Nomor KTP</label>
                                    </div>

                                    <div class="form-label-group">
                                        <input type="text" id="address" name="address" class="form-control" placeholder="Alamat" value="<?php echo e($member->address); ?>" readonly>
                                        <label for="address">Alamat</label>
                                    </div>

                                    <div class="form-label-group">
                                        <select class="form-control city_id" id="city_id" name="city_id" readonly="readonly">
                                            <?php if(!$member->city_id): ?>
                                                <option></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($member->city_id); ?>"><?php echo e($member->city->name); ?></option>
                                            <?php endif; ?>
                                        </select>
                                        <label for="city_id" class="custselect">Kota</label>
                                    </div>
                                    <div class="form-label-group">
                                        <select class="form-control province_id" id="province_id" name="province_id" readonly="readonly">
                                            <?php if(!$member->province_id): ?>
                                                <option></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($member->province_id); ?>"><?php echo e($member->province->name); ?></option>
                                            <?php endif; ?>
                                        </select>
                                        <label for="province_id" class="custselect">Propinsi</label>
                                    </div>
                                    <div class="form-label-group">
                                        <input type="text" id="postal_code" name="postal_code" class="form-control" placeholder="Kode POS" value="<?php echo e($member->postal_code); ?>" readonly>
                                        <label for="postal_code">Kode POS</label>
                                    </div>
                                    <div class="form-label-group">
                                        <select class="form-control country_id" id="country_id" name="country_id" readonly="readonly">
                                            <?php if(!$member->country_id): ?>
                                                <option></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($member->country_id); ?>"><?php echo e($member->country->name); ?></option>
                                            <?php endif; ?>
                                        </select>
                                        <label for="country_id" class="custselect">Negara</label>
                                    </div>

                                    <div class="form-label-group">
                                        <input id="phone" type="text" class="form-control" name="phone" placeholder="Nomor Telepon" value="<?php echo e($member->phone); ?>" readonly>
                                        <label for="phone">Nomor Telepon</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card rounded-0 mb-0 p-2">
                            <div class="card-header pt-50 pb-1">
                                <div class="card-title">
                                    <h4 class="mb-0">Penempatan Member</h4>
                                </div>
                            </div>
                            <p class="px-2"></p>
                            <div class="card-content">
                                <div class="card-body pt-0">

                                    <div class="form-label-group">
                                        <select class="form-control sponsor_id" id="sponsor_id" name="sponsor_id" readonly="readonly">
                                            <?php if($member->sponsor_id): ?>
                                            <option value="<?php echo e($member->sponsor_id); ?>"><?php echo e($member->sponsor->code); ?> - <?php echo e($member->sponsor->name); ?></option>
                                            <?php else: ?>
                                            <option></option>
                                            <?php endif; ?>
                                        </select>
                                        <label for="sponsor_id" class="custselect">Sponsor</label>
                                    </div>

                                    <div class="form-label-group">
                                        <select class="form-control upline_id" id="upline_id" name="upline_id" readonly="readonly">
                                            <?php if($member->upline_id): ?>
                                            <option value="<?php echo e($member->upline_id); ?>"><?php echo e($member->upLine->code); ?> - <?php echo e($member->upLine->name); ?></option>
                                            <?php else: ?>
                                            <option></option>
                                            <?php endif; ?>
                                        </select>
                                        <label for="upline_id" class="custselect">Upline</label>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-6 col-12 p-0">

                        <div class="card rounded-0 mb-0 p-2">
                            <div class="card-header pt-50 pb-1">
                                <div class="card-title">
                                    <h4 class="mb-0">Rincian Bank</h4>
                                </div>
                            </div>
                            <p class="px-2">Wajib Diisi.</p>
                            <div class="card-content">
                                <div class="card-body pt-0">
                                    <div class="form-label-group">
                                        <input id="bank" type="text" class="form-control" name="bank" placeholder="Bank" value="<?php echo e($member->bank); ?>" readonly autofocus>
                                        <label for="bank">Bank</label>
                                    </div>
                                    <div class="form-label-group">
                                        <input id="account_number" type="text" class="form-control" name="account_number" placeholder="Nomor Rekening" value="<?php echo e($member->account_number); ?>" readonly>
                                        <label for="account_number">Nomor Rekening</label>
                                    </div>
                                    <div class="form-label-group">
                                        <input id="account_name" type="text" class="form-control" name="account_name" placeholder="Nama Nasabah" value="<?php echo e($member->account_name); ?>" readonly>
                                        <label for="account_name">Nama Nasabah</label>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card rounded-0 mb-0 p-2">
                            <div class="card-header pt-50 pb-1">
                                <div class="card-title">
                                    <h4 class="mb-0">Member ID</h4>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body pt-0">
                                    <div class="form-label-group">
                                        <input id="code" type="text" class="form-control" style="border: solid 1px #ff0000;" name="code" placeholder="Member ID" value="<?php echo e($member->code); ?>" autofocus readonly>
                                        <label for="code">Member ID</label>
                                    </div>
                                    <div class="form-label-group">
                                        <input id="username" type="text" class="form-control" name="username" placeholder="User Name" value="<?php echo e($member->username); ?>" autofocus readonly>
                                        <label for="username">Username</label>
                                    </div>
                                    <div class="form-label-group">
                                        <!-- <input type="email" id="inputEmail" class="form-control" placeholder="Email" required> -->
                                        <input id="email" type="email" class="form-control" name="email" placeholder="Email" value="<?php echo e($member->email); ?>" readonly>
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\repos\stj\dummy\resources\views/members/registered.blade.php ENDPATH**/ ?>