<?php $__env->startSection('title', 'Historical Bonus'); ?>

<?php $__env->startSection('vendor-style'); ?>
    <!-- vendor css files -->
    <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/pickers/pickadate/pickadate.css'))); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section id="register-layout">
        <div class="row">
            <div class="col-md-12">
                <form class="form form-vertical" id="form-transfer-pin" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="form-body">
                        <div class="row">

                            <div class="col-md-3"></div>
                            <div class="col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header pt-50 pb-1">
                                        <div class="card-title">
                                            <h4 class="mb-0">Historical Bonus</h4>
                                        </div>
                                    </div>
                                    <p class="px-2"></p>
                                    <div class="card-content">
                                        <?php
                                        $current = Carbon\Carbon::now();
                                        $start_date = Carbon\Carbon::create($current->year, $current->month, 1, 0);
                                        $end_date = Carbon\Carbon::create($current->year, $current->month, 1, 0)->addMonth()->subDay();
                                        ?>
                                        <div class="card-body pt-0">

                                            <form id="form-history">
                                                <?php echo csrf_field(); ?>

                                                <div class="form-group">
                                                    <label for="start_date">Periode Transaksi</label>
                                                    <input type="text" id="start_date" class="form-control start-date-picker" required placeholder="Start date"
                                                           value="<?php echo e($start_date->format('d-M-Y')); ?>"
                                                           data-validation-required-message="This start date field is required">
                                                </div>

                                                <div class="form-group">
                                                    <label for="amount"></label>
                                                    <input type="text" id="end_date" class="form-control end-date-picker" required placeholder="End date"
                                                           value="<?php echo e($end_date->format('d-M-Y')); ?>"
                                                           data-validation-required-message="This end date field is required">

                                                </div>

                                                <div class="form-group d-flex justify-content-center">
                                                    <button type="button" id="btn-show" class="btn btn-primary float-right btn-inline mb-50">Tampilkan Data</button>
                                                    <input type="hidden" id="_acc_" name="_acc_" value="<?php echo e(auth()->id()); ?>">
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12 d-flex justify-content-center">
                                    <table id="table-history" width="100%" style="display: none">
                                        <tr>
                                            <th>Tgl</th>
                                            <th>Poin</th>
                                            <th>Poin Balance</th>
                                            <th>Bonus Poin</th>
                                            <th>Bonus Sponsor</th>
                                            <th>Bonus Dibayar</th>
                                            <th>Saldo Bonus</th>
                                        </tr>
                                        <tbody></tbody>
                                    </table>

                                    <table id="bonustable" class="table table-bordered mt-2 small">
                                        <thead>
                                        <tr>
                                            <th class="text-center align-middle">Tgl</th>
                                            <th class="text-center align-middle" style="min-width: 50px">Poin</th>
                                            <th class="text-center align-middle" style="min-width: 60px">Poin Balance</th>
                                            <th class="text-center align-middle">Bonus Poin</th>
                                            <th class="text-center align-middle">Bonus Sponsor</th>
                                            <th class="text-center align-middle">Transfer Bonus</th>
                                            <th class="text-center align-middle">Bonus Dibayar</th>
                                            <th class="text-center align-middle">Saldo Bonus</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="text-center align-middle">01 Jun 2020</td>
                                            <td class="text-center align-middle">150 | 75</td>
                                            <td class="text-center align-middle">150 | 75</td>
                                            <td class="text-center align-middle">180,000</td>
                                            <td class="text-center align-middle">160,000</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">02 Jun 2020</td>
                                            <td class="text-center align-middle">475 | 0</td>
                                            <td class="text-center align-middle">550 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">03 Jun 2020</td>
                                            <td class="text-center align-middle">600 | 0</td>
                                            <td class="text-center align-middle">1,150 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">04 Jun 2020</td>
                                            <td class="text-center align-middle">100 | 0</td>
                                            <td class="text-center align-middle">1,250 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">06 Jun 2020</td>
                                            <td class="text-center align-middle">250 | 0</td>
                                            <td class="text-center align-middle">1,500 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">07 Jun 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">1,525 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">08 Jun 2020</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">1,575 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">11 Jun 2020</td>
                                            <td class="text-center align-middle">150 | 0</td>
                                            <td class="text-center align-middle">1,725 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">12 Jun 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">1,750 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">16 Jun 2020</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">1,800 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">30 Jun 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">1,825 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">03 Jul 2020</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">1,875 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">11 Jul 2020</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">1,925 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">14 Jul 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">1,950 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">17 Jul 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">1,975 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">19 Jul 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">2,000 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">20 Jul 2020</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">2,050 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">21 Jul 2020</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">2,100 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">22 Jul 2020</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">2,150 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">23 Jul 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">2,175 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">24 Jul 2020</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">2,225 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">25 Jul 2020</td>
                                            <td class="text-center align-middle">200 | 0</td>
                                            <td class="text-center align-middle">2,425 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">26 Jul 2020</td>
                                            <td class="text-center align-middle">150 | 0</td>
                                            <td class="text-center align-middle">2,575 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">27 Jul 2020</td>
                                            <td class="text-center align-middle">75 | 0</td>
                                            <td class="text-center align-middle">2,650 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">28 Jul 2020</td>
                                            <td class="text-center align-middle">75 | 0</td>
                                            <td class="text-center align-middle">2,725 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">29 Jul 2020</td>
                                            <td class="text-center align-middle">125 | 0</td>
                                            <td class="text-center align-middle">2,850 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">30 Jul 2020</td>
                                            <td class="text-center align-middle">100 | 0</td>
                                            <td class="text-center align-middle">2,950 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">01 Aug 2020</td>
                                            <td class="text-center align-middle">200 | 0</td>
                                            <td class="text-center align-middle">3,150 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">02 Aug 2020</td>
                                            <td class="text-center align-middle">125 | 0</td>
                                            <td class="text-center align-middle">3,275 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">04 Aug 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">3,300 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">08 Aug 2020</td>
                                            <td class="text-center align-middle">150 | 0</td>
                                            <td class="text-center align-middle">3,450 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">09 Aug 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">3,475 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">10 Aug 2020</td>
                                            <td class="text-center align-middle">75 | 0</td>
                                            <td class="text-center align-middle">3,550 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">11 Aug 2020</td>
                                            <td class="text-center align-middle">100 | 0</td>
                                            <td class="text-center align-middle">3,650 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">12 Aug 2020</td>
                                            <td class="text-center align-middle">150 | 0</td>
                                            <td class="text-center align-middle">3,800 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">13 Aug 2020</td>
                                            <td class="text-center align-middle">275 | 0</td>
                                            <td class="text-center align-middle">4,075 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">14 Aug 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">4,100 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">16 Aug 2020</td>
                                            <td class="text-center align-middle">75 | 0</td>
                                            <td class="text-center align-middle">4,175 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">19 Aug 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">4,200 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">21 Aug 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">4,225 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">22 Aug 2020</td>
                                            <td class="text-center align-middle">275 | 0</td>
                                            <td class="text-center align-middle">4,500 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">23 Aug 2020</td>
                                            <td class="text-center align-middle">200 | 0</td>
                                            <td class="text-center align-middle">4,700 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">25 Aug 2020</td>
                                            <td class="text-center align-middle">75 | 0</td>
                                            <td class="text-center align-middle">4,775 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">26 Aug 2020</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">4,825 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">27 Aug 2020</td>
                                            <td class="text-center align-middle">325 | 0</td>
                                            <td class="text-center align-middle">5,150 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">28 Aug 2020</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">5,200 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">29 Aug 2020</td>
                                            <td class="text-center align-middle">150 | 0</td>
                                            <td class="text-center align-middle">5,350 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">30 Aug 2020</td>
                                            <td class="text-center align-middle">150 | 0</td>
                                            <td class="text-center align-middle">5,500 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">31 Aug 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">5,525 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">03 Sep 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">5,550 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">05 Sep 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">5,575 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">06 Sep 2020</td>
                                            <td class="text-center align-middle">100 | 0</td>
                                            <td class="text-center align-middle">5,675 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">07 Sep 2020</td>
                                            <td class="text-center align-middle">100 | 0</td>
                                            <td class="text-center align-middle">5,775 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">09 Sep 2020</td>
                                            <td class="text-center align-middle">200 | 0</td>
                                            <td class="text-center align-middle">5,975 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">10 Sep 2020</td>
                                            <td class="text-center align-middle">200 | 0</td>
                                            <td class="text-center align-middle">6,175 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">11 Sep 2020</td>
                                            <td class="text-center align-middle">150 | 0</td>
                                            <td class="text-center align-middle">6,325 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">13 Sep 2020</td>
                                            <td class="text-center align-middle">125 | 0</td>
                                            <td class="text-center align-middle">6,450 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">14 Sep 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">6,475 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">16 Sep 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">6,500 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">20 Sep 2020</td>
                                            <td class="text-center align-middle">125 | 0</td>
                                            <td class="text-center align-middle">6,625 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">21 Sep 2020</td>
                                            <td class="text-center align-middle">150 | 0</td>
                                            <td class="text-center align-middle">6,775 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">22 Sep 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">6,800 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">25 Sep 2020</td>
                                            <td class="text-center align-middle">225 | 0</td>
                                            <td class="text-center align-middle">7,025 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">27 Sep 2020</td>
                                            <td class="text-center align-middle">75 | 0</td>
                                            <td class="text-center align-middle">7,100 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">28 Sep 2020</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">7,150 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">29 Sep 2020</td>
                                            <td class="text-center align-middle">325 | 0</td>
                                            <td class="text-center align-middle">7,475 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">30 Sep 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">7,500 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">01 Oct 2020</td>
                                            <td class="text-center align-middle">200 | 0</td>
                                            <td class="text-center align-middle">7,700 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">06 Oct 2020</td>
                                            <td class="text-center align-middle">225 | 0</td>
                                            <td class="text-center align-middle">7,925 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">07 Oct 2020</td>
                                            <td class="text-center align-middle">150 | 0</td>
                                            <td class="text-center align-middle">8,075 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">08 Oct 2020</td>
                                            <td class="text-center align-middle">125 | 0</td>
                                            <td class="text-center align-middle">8,200 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">09 Oct 2020</td>
                                            <td class="text-center align-middle">475 | 0</td>
                                            <td class="text-center align-middle">8,675 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">12 Oct 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">8,700 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">13 Oct 2020</td>
                                            <td class="text-center align-middle">75 | 0</td>
                                            <td class="text-center align-middle">8,775 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">14 Oct 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">8,800 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">16 Oct 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">8,825 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">19 Oct 2020</td>
                                            <td class="text-center align-middle">200 | 0</td>
                                            <td class="text-center align-middle">9,025 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">20 Oct 2020</td>
                                            <td class="text-center align-middle">350 | 0</td>
                                            <td class="text-center align-middle">9,375 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">23 Oct 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">9,400 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">24 Oct 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">9,425 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">25 Oct 2020</td>
                                            <td class="text-center align-middle">225 | 0</td>
                                            <td class="text-center align-middle">9,650 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">29 Oct 2020</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">9,700 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">31 Oct 2020</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">9,750 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">01 Nov 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">9,775 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">02 Nov 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">9,800 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">03 Nov 2020</td>
                                            <td class="text-center align-middle">75 | 0</td>
                                            <td class="text-center align-middle">9,875 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">04 Nov 2020</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">9,925 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">06 Nov 2020</td>
                                            <td class="text-center align-middle">275 | 0</td>
                                            <td class="text-center align-middle">10,200 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">07 Nov 2020</td>
                                            <td class="text-center align-middle">350 | 0</td>
                                            <td class="text-center align-middle">10,550 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">10 Nov 2020</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">10,600 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">11 Nov 2020</td>
                                            <td class="text-center align-middle">75 | 0</td>
                                            <td class="text-center align-middle">10,675 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">13 Nov 2020</td>
                                            <td class="text-center align-middle">500 | 0</td>
                                            <td class="text-center align-middle">11,225 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">16 Nov 2020</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">11,275 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">17 Nov 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">11,300 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">18 Nov 2020</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">11,350 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">20 Nov 2020</td>
                                            <td class="text-center align-middle">100 | 0</td>
                                            <td class="text-center align-middle">11,450 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">21 Nov 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">11,475 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">23 Nov 2020</td>
                                            <td class="text-center align-middle">150 | 0</td>
                                            <td class="text-center align-middle">11,625 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">24 Nov 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">11,650 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">25 Nov 2020</td>
                                            <td class="text-center align-middle">150 | 0</td>
                                            <td class="text-center align-middle">11,800 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">26 Nov 2020</td>
                                            <td class="text-center align-middle">100 | 0</td>
                                            <td class="text-center align-middle">11,900 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">27 Nov 2020</td>
                                            <td class="text-center align-middle">100 | 0</td>
                                            <td class="text-center align-middle">12,000 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">30 Nov 2020</td>
                                            <td class="text-center align-middle">75 | 0</td>
                                            <td class="text-center align-middle">12,075 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">01 Dec 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">12,100 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">03 Dec 2020</td>
                                            <td class="text-center align-middle">200 | 0</td>
                                            <td class="text-center align-middle">12,300 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">06 Dec 2020</td>
                                            <td class="text-center align-middle">250 | 0</td>
                                            <td class="text-center align-middle">12,550 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">07 Dec 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">12,575 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">08 Dec 2020</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">12,625 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">09 Dec 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">12,650 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">11 Dec 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">12,675 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">12 Dec 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">12,700 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">13 Dec 2020</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">12,750 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">15 Dec 2020</td>
                                            <td class="text-center align-middle">75 | 0</td>
                                            <td class="text-center align-middle">12,825 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">16 Dec 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">12,850 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">17 Dec 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">12,875 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">18 Dec 2020</td>
                                            <td class="text-center align-middle">100 | 0</td>
                                            <td class="text-center align-middle">12,975 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">19 Dec 2020</td>
                                            <td class="text-center align-middle">75 | 0</td>
                                            <td class="text-center align-middle">13,050 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">20 Dec 2020</td>
                                            <td class="text-center align-middle">75 | 0</td>
                                            <td class="text-center align-middle">13,125 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">21 Dec 2020</td>
                                            <td class="text-center align-middle">100 | 0</td>
                                            <td class="text-center align-middle">13,225 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">22 Dec 2020</td>
                                            <td class="text-center align-middle">100 | 0</td>
                                            <td class="text-center align-middle">13,325 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">23 Dec 2020</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">13,375 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">24 Dec 2020</td>
                                            <td class="text-center align-middle">75 | 0</td>
                                            <td class="text-center align-middle">13,450 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">25 Dec 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">13,475 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">27 Dec 2020</td>
                                            <td class="text-center align-middle">150 | 0</td>
                                            <td class="text-center align-middle">13,625 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">28 Dec 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">13,650 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">30 Dec 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">13,675 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">31 Dec 2020</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">13,700 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">01 Jan 2021</td>
                                            <td class="text-center align-middle">125 | 0</td>
                                            <td class="text-center align-middle">13,825 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">02 Jan 2021</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">13,875 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">03 Jan 2021</td>
                                            <td class="text-center align-middle">125 | 0</td>
                                            <td class="text-center align-middle">14,000 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">04 Jan 2021</td>
                                            <td class="text-center align-middle">225 | 0</td>
                                            <td class="text-center align-middle">14,225 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">06 Jan 2021</td>
                                            <td class="text-center align-middle">500 | 0</td>
                                            <td class="text-center align-middle">14,725 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">08 Jan 2021</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">14,750 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">10 Jan 2021</td>
                                            <td class="text-center align-middle">200 | 0</td>
                                            <td class="text-center align-middle">14,950 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">13 Jan 2021</td>
                                            <td class="text-center align-middle">175 | 0</td>
                                            <td class="text-center align-middle">15,125 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">15 Jan 2021</td>
                                            <td class="text-center align-middle">125 | 0</td>
                                            <td class="text-center align-middle">15,250 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">16 Jan 2021</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">15,300 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">17 Jan 2021</td>
                                            <td class="text-center align-middle">100 | 0</td>
                                            <td class="text-center align-middle">15,400 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">19 Jan 2021</td>
                                            <td class="text-center align-middle">150 | 0</td>
                                            <td class="text-center align-middle">15,550 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">22 Jan 2021</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">15,575 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">23 Jan 2021</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">15,625 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">26 Jan 2021</td>
                                            <td class="text-center align-middle">200 | 0</td>
                                            <td class="text-center align-middle">15,825 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">27 Jan 2021</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">15,850 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">30 Jan 2021</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">15,875 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">31 Jan 2021</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">15,900 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">01 Feb 2021</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">15,925 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">03 Feb 2021</td>
                                            <td class="text-center align-middle">350 | 0</td>
                                            <td class="text-center align-middle">16,275 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">04 Feb 2021</td>
                                            <td class="text-center align-middle">50 | 0</td>
                                            <td class="text-center align-middle">16,325 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">05 Feb 2021</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">16,350 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">06 Feb 2021</td>
                                            <td class="text-center align-middle">100 | 0</td>
                                            <td class="text-center align-middle">16,450 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">11 Feb 2021</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">16,475 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">18 Feb 2021</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">16,500 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">24 Feb 2021</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">16,525 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">26 Feb 2021</td>
                                            <td class="text-center align-middle">175 | 0</td>
                                            <td class="text-center align-middle">16,700 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">27 Feb 2021</td>
                                            <td class="text-center align-middle">200 | 0</td>
                                            <td class="text-center align-middle">16,900 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">28 Feb 2021</td>
                                            <td class="text-center align-middle">25 | 0</td>
                                            <td class="text-center align-middle">16,925 | 0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">0</td>
                                            <td class="text-center align-middle">340,000</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-3"></div>

                        </div>
                    </div>

                </form>
            </div>
        </div>

    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('vendor-script'); ?>
    <!-- vendor files -->
    <script src="<?php echo e(asset(mix('vendors/js/pickers/pickadate/picker.js'))); ?>"></script>
    <script src="<?php echo e(asset(mix('vendors/js/pickers/pickadate/picker.date.js'))); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-script'); ?>
    <!-- Page js files -->
    <script type="text/javascript">
        $(document).ready(function (e) {
            $('#start_date').pickadate({
                format: 'dd-mmm-yyyy'
            });
            $('#end_date').pickadate({
                format: 'dd-mmm-yyyy'
            });
        });

        $('#btn-show').click(function (e) {
            let _data = $('#form-history').serializeArray();
            _data.push({'name': '_acc_', 'value': $('#_acc_').val()});
            _data.push({'name': '_token', 'value': $('meta[name="csrf-token"]').attr('content')});

            $('#modal-backdrop').modal('show');

            $.ajaxSetup({
                type: "POST",
                url: "/member/getBonusHistory",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({ data: _data })
            .fail(function (e) {

            })
            .done(function( data ) {
                $('#modal-backdrop').modal('hide');
                var histories = JSON.parse(data);

                $('#table-history tbody').clear();
                for (let i = 0; i < histories.length; i++) {
                    let item = histories[i];
                    $('#table-history tbody').append('<tr>' +
                        '<td>' + item.tanggal + '</td>' +
                        '<td>' + item.new_left_point + ' | ' + item.new_right_point + '</td>' +
                        '<td>' + item.left_point + ' | ' + item.right_point + '</td>' +
                        '<td>' + item.sponsor_bonus + '</td>' +
                        '<td>' + item.paid_bonus + '</td>' +
                        '<td>' + item.bonus_balance + '</td>' +
                        '</tr>');
                }
            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\repos\stj\dummy\resources\views/members/bonus-history.blade.php ENDPATH**/ ?>