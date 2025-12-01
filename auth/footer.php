
<script>
//  Preloader
jQuery(window).on("load", function() {
    $("#preloader").fadeOut(2000);
    $("#main-wrapper").addClass("show");
});
</script>

<script src="<?= $web_url ?>/assets/panel/js/main.js"></script>
<!-- ========= JS Files =========  -->
<!-- Bootstrap -->
<script src="<?= $web_url ?>/assets/panel/js/lib/bootstrap.bundle.min.js"></script>
<!-- Ionicons -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<!-- Splide -->
<script src="<?= $web_url ?>/assets/panel/js/plugins/splide/splide.min.js"></script>
<!-- Base Js File -->
<script src="<?= $web_url ?>/assets/panel/js/base.js"></script>


<?= $tawk ?>
<script>
var style_url, url, token;
style_url = "<?=$web_url.'/assets/panel/css/'?>";
url = "{{url('/')}}";
token = "{{Session::token()}}";
</script>

</body>

</html>