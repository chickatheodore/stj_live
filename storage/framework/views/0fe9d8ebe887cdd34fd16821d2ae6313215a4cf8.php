<!-- BEGIN: Footer-->
<?php if($configData["mainLayoutType"] == 'horizontal' && isset($configData["mainLayoutType"])): ?>
<footer
    class="footer <?php echo e($configData['footerType']); ?> <?php echo e(($configData['footerType']=== 'footer-hidden') ? 'd-none':''); ?> footer-light navbar-shadow">
    <?php else: ?>
    <footer
        class="footer <?php echo e($configData['footerType']); ?> <?php echo e(($configData['footerType']=== 'footer-hidden') ? 'd-none':''); ?> footer-light">
        <?php endif; ?>
        <p class="clearfix blue-grey lighten-2 mb-0">
            <span class="float-md-left d-block d-md-inline-block mt-25">
                Copyright &copy; 2021
                <a class="text-bold-800 grey darken-2" href="https://www.stj.com" target="_blank">PT. STJ,</a>
                All rights Reserved
            </span>
            <span class="float-md-right d-none d-md-block">Hand-crafted & Made with<i class="feather icon-heart pink"></i></span>
            <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="feather icon-arrow-up"></i></button>
        </p>
    </footer>
    <!-- END: Footer--><?php /**PATH D:\repos\stj\dummy\resources\views/panels/footer.blade.php ENDPATH**/ ?>