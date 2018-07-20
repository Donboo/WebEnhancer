<section class="hero is-light is-bold is-fullheight">
    <a href='<?php echo base_url(); ?>'><i style="color:#333;font-size:25px;margin-left:25px;margin-top:25px" class="fas fa-arrow-left"></i> webenhancer.com</a>
    <div class="hero-body">
        <div class="column">
            <div id="monitorcontent">
                <figure class="image is-2by2" id="snapshot"></figure>
            </div>
        </div>
        <br>
        <div class="column">
            <h1 class="title">
                <a title="Link to site" href="<?php echo $url; ?>"><?php echo $sitename; ?></a><br>
                <?php echo $has_been_analyzed; ?>

            </h1>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h1 class="title"><?php echo $resultsready . $resultid; ?>. <?php echo $shortreview; ?></h1>
        <!-- pseudocod -->
        <ul id="metricspanel">
            <!-- <?php foreach($test as $row): ?>
            <li>
                <?php $row->passed ? '<i style="color:#30b636" class="fas fa-check-circle"></i>' : '<i style="color:#b63030" class="fas fa-times-circle"></i>'; ?>
            </li>
            <?php endforeach; ?>-->
            <li>
                <span class="metrics_panel metrics_positive"><span class="mtext">99</span></span> Speed. <a href="#speedtest">Jump to results...</a>
            </li>
            <li>
                <span class="metrics_panel metrics_negative"> <span class="mtext">22</span></span> Code. <a href="#codetest">Jump to results...</a>
            </li>
            <li>
                <span class="metrics_panel metrics_negative"> <span class="mtext">32</span></span> SEO. <a href="#seotest">Jump to results...</a>
            </li>
            <li>
                <span class="metrics_panel metrics_zero"> <span class="mtext"><?php echo $score_result->security->ssl; ?></span></span> Security. <a href="#securitytest">Jump to results...</a>
            </li>
        </ul>
        <!-- /pseudocod -->
    </div>
</section>

<section class="hero is-info is-fullheight" id="speedtest">
    <div class="hero-body">
        <div class="container">
            <p class="title">
                <?php echo $speedtests; ?>
            </p>
            <?php echo print_r(apache_request_headers()); ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h1 class="title">a</h1>
        <h2 class="subtitle">
        A simple container to divide your page into <strong>sections</strong>, like the one you're currently reading
        </h2>
    </div>
</section>

<section class="hero is-info is-fullheight" id="codetest">
    <div class="hero-body">
        <div class="container">
            <p class="title">
                <?php echo $codevalidator; ?>
            </p>
            <p class="subtitle">
                Info subtitle
            </p>
        </div>
    </div>
</section>


<section class="section">
    <div class="container">
        <h1 class="title">
            <?php echo $text_why_is_security_important; ?>
        </h1>
        <h2 class="subtitle">
            <?php echo $text_answer_security_important; ?>
        </h2>
    </div>
</section>

<section class="hero is-info is-fullheight" id="securitytest">
    <div class="hero-body">
        <div class="container">
            <p class="title">
                <?php echo $securityaudit; ?>
            </p>
            <p class="subtitle">
                Info subtitle
            </p>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h1 class="title">
            <?php echo $text_why_is_seo_important; ?>
        </h1>
        <h2 class="subtitle">
            <?php echo $text_answer_seo_important; ?>
        </h2>
    </div>
</section>

<section class="hero is-info is-fullheight" id="seotest">
    <div class="hero-body">
        <div class="container">
            <p class="title">
                <?php echo $seohelper; ?>
            </p>
            
            <h2 class="subtitle">Subtest 1: Meta</h2>
            <p>
                <?php echo ($score_result->seo->meta->description ? '<i class="fas fa-check-circle"></i> ' : '<i class="fas fa-times-circle"></i> '); ?>
                <?php echo $text_descrleng; ?>: <?php echo $data_result->seo->meta->descriptiondesc; ?><br>
                
                <?php echo ($score_result->seo->meta->title ? '<i class="fas fa-check-circle"></i> ' : '<i class="fas fa-times-circle"></i> '); ?>
                <?php echo $text_titleleng; ?>: <?php echo $data_result->seo->meta->titledesc; ?><br>
                
                <?php echo ($score_result->seo->meta->keywords ? '<i class="fas fa-check-circle"></i> ' : '<i class="fas fa-times-circle"></i> '); ?>
                <?php echo $text_keywordsleng; ?>: <?php echo $data_result->seo->meta->keywordsdesc; ?>
            </p>
            <br>
            
            <h2 class="subtitle">Subtest 2: Responsiveness</h2>
            <p>
                <?php echo ($score_result->seo->responsive ? '<i class="fas fa-check-circle"></i> ' : '<i class="fas fa-times-circle"></i> '); ?>
                <?php echo $text_descrleng; ?>: <?php echo $data_result->seo->responsivedesc; ?>
            </p>
        </div>
    </div>
</section>

<div id="capture" style="position:absolute;top:-99999px;">
    <?php echo clear_snapshot($snapshot, $url); ?>
</div>

<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/html2canvas.min.js"></script>
<script>


html2canvas(document.querySelector("#capture")).then(canvas => {
    
    var img = new Image();
    img.src = canvas.toDataURL("image/png");
    img.width = 300;
    
    $("#snapshot").html(img);
    
    $("#capture").css("display", "none");
});
    
</script>