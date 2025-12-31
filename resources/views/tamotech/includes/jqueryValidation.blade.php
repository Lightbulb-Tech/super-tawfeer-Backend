<script src="{{asset('')}}form-validator/jquery.form-validator.min.js"></script>
<script>
    $.validate({
        modules: 'security, date',
        lang: "{{app()->getLocale() == 'ar' ? 'ar' : 'en'}}"
    });
</script>
