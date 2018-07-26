<div class="content"><?php echo $content; ?></div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>

<script>
$(".content").remove();
Cookies.set("domelements", $("*").length);
</script>