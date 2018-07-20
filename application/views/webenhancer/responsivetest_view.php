<div id="wbhncsitecontents">
    <?php echo $content; ?>
</div>
    
    
<script
			  src="https://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			  crossorigin="anonymous"></script>

<script>
// wid 479px tel
// wid 767 tableta
// widd 1366 pc
    $("#wbhncsitecontents").css("width", "479px");
    $("#wbhncsitecontents").css("max-width", "479px");
    var text_telefon =  $("#wbhncsitecontents").text();

    // step 2 - tableta 
    $("#wbhncsitecontents").css("width", "767px");
    $("#wbhncsitecontents").css("max-width", "767px");
    var text_tableta = $("#wbhncsitecontents").text();

    // step 3 - pc
    $("#wbhncsitecontents").css("width", "1080px");
    $("#wbhncsitecontents").css("max-width", "1080px");
    var text_pc      = $("#wbhncsitecontents").text();

    $("body").text("<webenhancer_texttelefon>" + text_telefon + "</webenhancer_texttelefon><webenhancer_texttableta>" + text_tableta + "</webenhancer_texttableta><webenhancer_textpc>" + text_pc + "</webenhancer_textpc>");    
    $("script").each(function(){
       $(this).remove(); 
    });
</script>