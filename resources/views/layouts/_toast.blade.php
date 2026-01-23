@if (session()->has('toast_notification.message'))
<div class="bs-toast toast toast-placement-ex m-2 fade show bg-{{ session()->get('toast_notification.level') }} top-0 end-0 hide"
    role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
        <i class="bx bx-bell me-2"></i>
        <div class="me-auto fw-medium">Notification</div>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        {!! session()->get('toast_notification.message') !!}
    </div>
</div>
<script>
    setTimeout(function() {
        var toast = document.querySelector('.bs-toast');
        var toastBootstrap = new bootstrap.Toast(toast);
        toastBootstrap.hide();
    }, 2000);
</script>
@endif
