<section class="hero <?php echo random_hero(); ?> is-fullheight">
    <a href='<?php echo base_url(); ?>'><i style="color:#333;font-size:25px;margin-left:25px;margin-top:25px" class="fas fa-arrow-left"></i> webenhancer.com</a>
    <div class="hero-body">
        <div class="column">
            <div id="monitorcontent">
                <img src="data:image/jpeg;base64,<?php echo $snapshot; ?>" style="width: 711px;margin-top: 28px;margin-left: 14px;" alt="Screenshot of your site" />
            </div>
            <div id="mobilecontent">
                <img src="data:image/jpeg;base64,<?php echo $snapshot_mobile; ?>" style="width: 711px;margin-top: 28px;margin-left: 14px;" alt="Screenshot of your site" />
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

        <br>

        <!-- pseudocod -->
        <ul id="metricspanel">
            <div class="columns is-mobile">
                <div class="column">
                    <center>
                        <div class="progressbox" style="margin-top: 60px;">
                            <div class="progressring_mini" id="speedprogress_mini">
                                <div class="inner subtitle" style="margin-top: 20px;">
                                    <?php echo $totalSpeed; ?>
                                </div>
                            </div>
                        </div>
                        <br> Speed
                        <br>
                        <a href="#speedtest">Jump to results...</a>
                    </center>
                </div>
                <div class="column">
                    <center>
                        <div class="progressbox" style="margin-top: 60px;">
                            <div class="progressring_mini" id="codeprogress_mini">
                                <div class="inner subtitle" style="margin-top: 20px;">
                                    <?php echo $totalCode; ?>
                                </div>
                            </div>
                        </div>
                        <br> Code
                        <br>
                        <a href="#codetest">Jump to results...</a>
                    </center>
                </div>
                <div class="column">
                    <center>
                        <div class="progressbox" style="margin-top: 60px;">
                            <div class="progressring_mini" id="seoprogress_mini">
                                <div class="inner subtitle" style="margin-top: 20px;">
                                    <?php echo $totalSEO; ?>
                                </div>
                            </div>
                        </div>
                        <br> SEO
                        <br>
                        <a href="#seotest">Jump to results...</a>
                    </center>
                </div>
                <div class="column">
                   <div class="column">
                    <center>
                        <div class="progressbox" style="margin-top: 60px;">
                            <div class="progressring_mini" id="securityprogress_mini">
                                <div class="inner subtitle" style="margin-top: 20px;">
                                    <?php echo $totalSecurity; ?>
                                </div>
                            </div>
                        </div>
                        <br> Security
                        <br>
                        <a href="#securitytest">Jump to results...</a>
                    </center>
                </div>
            </div>
        </ul>
        <!-- /pseudocod -->
    </div>
</section>

<section class="hero is-info is-fullheight" id="speedtest">
    <div class="hero-body">
        <div class="container">
            <center>
                <p class="title">
                    <?php echo $speedtests; ?>
                </p>
                <br>
                <div class="columns">
                    <div class="column">
                        <div class="tile is-ancestor">
                            <div class="tile is-vertical is-12">
                                <div class="tile">
                                    <div class="tile is-parent is-vertical">
                                        <article class="tile is-child notification is-link">
                                            <p class="title">
                                                <?php echo ($data_result->speed->loaddesc != "none") ? $data_result->speed->loaddesc->loadTime : "Could not calculate"; ?>s
                                            </p>
                                            <p class="subtitle">
                                                Load Time
                                            </p>
                                        </article>
                                        <article class="tile is-child notification is-success">
                                            <p class="title">
                                                <?php echo ($data_result->speed->loaddesc != "none") ? $data_result->speed->loaddesc->totalResources : "Could not calculate"; ?>
                                            </p>
                                            <p class="subtitle">
                                                Total Resources
                                            </p>
                                        </article>
                                    </div>
                                    <div class="tile is-parent">
                                        <article class="tile is-child notification is-light">
                                            <div class="progressbox">
                                                <div class="progressring" id="speedprogress">
                                                    <div class="inner title" style="margin-top: 20px;">
                                                        <?php echo $totalSpeed; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                    <div class="tile is-parent is-vertical">
                                        <article class="tile is-child notification is-link">
                                            <p class="title" id="totalSize">
                                                <?php echo ($data_result->speed->loaddesc != "none") ? "Calculating..." : "Could not calculate"; ?>
                                            </p>
                                            <p class="subtitle">
                                                <abbr title='Keep it under 2MB. Seriously.'>Total Res. Size</abbr>
                                            </p>
                                        </article>
                                        <article class="tile is-child notification is-warning">
                                            <p class="title">
                                                <?php echo ($data_result->speed->loaddesc != "none") ? $data_result->speed->loaddesc->domTime : "Could not calculate"; ?>
                                            </p>
                                            <p class="subtitle">
                                                DOM Time
                                            </p>
                                        </article>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table is-striped is-network">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Method</th>
                            <th>File</th>
                            <th>Domain</th>
                            <th>Cause</th>
                            <th>Type</th>
                            <th>Redirect time</th>
                            <th>DNS time</th>
                            <th>Load time</th>
                            <th>Size</th>
                            <th>Our grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $load_id    = 0;
                        $totalSize  = 0;
                        if($data_result->speed->loaddesc != "none") {
                            foreach($data_result->speed->loaddesc->resources as $loaddata): 
                            $totalSize += getRemoteFilesize($data_result->speed->loaddesc->resources->{$load_id}->name, false);
                            ?>
                                <tr>
                                    <td><span class="responsecodehttp resp<?php echo get_http_code($data_result->speed->loaddesc->resources->{$load_id}->name); ?>"><?php echo get_http_code($data_result->speed->loaddesc->resources->{$load_id}->name); ?></span></td>
                                    <td>GET</td>
                                    <td>
                                        <?php echo ($data_result->speed->loaddesc->resources->{$load_id}->name); ?>
                                    </td>
                                    <td>
                                        <?php echo get_domain($data_result->speed->loaddesc->resources->{$load_id}->name); ?>
                                    </td>
                                    <td>document</td>
                                    <td>
                                        <?php echo pathinfo(parse_url($data_result->speed->loaddesc->resources->{$load_id}->name, PHP_URL_PATH), PATHINFO_EXTENSION); ?>
                                    </td>
                                    <td>
                                        <?php echo $data_result->speed->loaddesc->resources->{$load_id}->redirectTime; ?>
                                    </td>
                                    <td>
                                        <?php echo $data_result->speed->loaddesc->resources->{$load_id}->dnsLookup; ?>
                                    </td>
                                    <td>
                                        <?php echo $data_result->speed->loaddesc->resources->{$load_id}->fetchUntilResponseEnd; ?>
                                    </td>
                                    <td>
                                        <?php echo getRemoteFilesize($data_result->speed->loaddesc->resources->{$load_id}->name); ?>
                                    </td>
                                    <td>
                                        <?php echo calculate_grade(
                                                    getRemoteFilesize($data_result->speed->loaddesc->resources->{$load_id}->name, false), 
                                                    pathinfo(parse_url($data_result->speed->loaddesc->resources->{$load_id}->name, PHP_URL_PATH), PATHINFO_EXTENSION), 
                                                    $data_result->speed->loaddesc->resources->{$load_id}->redirectTime, 
                                                    get_http_code($data_result->speed->loaddesc->resources->{$load_id}->name)
                                                );  ?>
                                    </td>
                                </tr>
                                <?php  
                            $load_id++; 
                            endforeach; 
                        } else echo "<td colspan=11><center>No resources were detected.</center></td>";
                        ?>
                    </tbody>
                </table>

                <div class="tile is-ancestor">
                    <div class="tile is-vertical is-12">
                        <div class="tile">
                            <div class="tile is-parent is-vertical">
                                <article class="tile is-child notification is-link">
                                    <p class="title">
                                        OK
                                    </p>
                                    <p class="subtitle">
                                        Cache
                                    </p>
                                </article>
                                <article class="tile is-child notification is-link">
                                    <p class="title">
                                        OK
                                    </p>
                                    <p class="subtitle">
                                        Page redirects
                                    </p>
                                </article>
                            </div>

                            <div class="tile is-parent is-vertical">
                                <article class="tile is-child notification is-link">
                                    <p class="title" id="totalSize">
                                        OK
                                    </p>
                                    <p class="subtitle">
                                        Compression
                                    </p>
                                </article>
                                <article class="tile is-child notification is-link">
                                    <p class="title">
                                        NOT OK
                                    </p>
                                    <p class="subtitle">
                                        Render blocking
                                    </p>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>

            </center>
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
            <br>
            <center>
                <div class="columns">
                    <div class="column">
                        <div class="tile is-ancestor">
                            <div class="tile is-vertical is-12">
                                <div class="tile">
                                    <div class="tile is-parent is-vertical">
                                        <article class="tile is-child notification is-link">
                                            <p class="title">
                                                <?php echo $data_result->code->domdesc; ?>
                                            </p>
                                            <p class="subtitle">
                                                DOM Elements
                                            </p>
                                        </article>
                                        <article class="tile is-child notification is-success">
                                            <p class="title">
                                                <?php echo get_html_version($data_result->code->doctype); ?>
                                            </p>
                                            <p class="subtitle">
                                                <abbr title='We strongly recommend HTML5.'>DOC Type</abbr>
                                            </p>
                                        </article>
                                    </div>
                                    <div class="tile is-parent">
                                        <article class="tile is-child notification is-light">
                                            <div class="progressbox">
                                                <div class="progressring" id="codeprogress">
                                                    <div class="inner title" style="margin-top: 20px;">
                                                        <?php echo $totalCode; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                    <div class="tile is-parent is-vertical">
                                        <article class="tile is-child notification is-link">
                                            <p class="title" id="totalErrors">
                                                0
                                            </p>
                                            <p class="subtitle">
                                                HTML Errors
                                            </p>
                                        </article>
                                        <article class="tile is-child notification is-warning">
                                            <p class="title">
                                                <?php echo $data_result->code->encoding; ?>
                                            </p>
                                            <p class="subtitle">
                                                Encoding
                                            </p>
                                        </article>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table is-striped is-network">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Line</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $totalErrors    = 0;
                        foreach($data_result->code->validdesc->messages as $loaddata): 
                        ?>
                            <tr>
                                <td>
                                    <span class="validatortype type<?php echo $data_result->code->validdesc->messages->{$totalErrors}->type; ?>">
                                        <?php echo ($data_result->code->validdesc->messages->{$totalErrors}->type); ?>
                                    </span>
                                </td>
                                <td><?php echo ($data_result->code->validdesc->messages->{$totalErrors}->line); ?></td>
                                <td><?php echo alive_validate_messages($data_result->code->validdesc->messages->{$totalErrors}->message); ?></td>
                            </tr>
                            <?php  
                        $totalErrors++; 
                        endforeach; 
                        ?>
                    </tbody>
                </table>

                <div class="tile is-ancestor">
                    <div class="tile is-vertical is-12">
                        <div class="tile">
                            <div class="tile is-parent is-vertical">
                                <article class="tile is-child notification is-link">
                                    <p class="title">
                                        OK
                                    </p>
                                    <p class="subtitle">
                                        Cache
                                    </p>
                                </article>
                                <article class="tile is-child notification is-link">
                                    <p class="title">
                                        OK
                                    </p>
                                    <p class="subtitle">
                                        Page redirects
                                    </p>
                                </article>
                            </div>

                            <div class="tile is-parent is-vertical">
                                <article class="tile is-child notification is-link">
                                    <p class="title" >
                                        OK
                                    </p>
                                    <p class="subtitle">
                                        Compression
                                    </p>
                                </article>
                                <article class="tile is-child notification is-link">
                                    <p class="title">
                                        NOT OK
                                    </p>
                                    <p class="subtitle">
                                        Render blocking
                                    </p>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </center>
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
            <center>
                <p class="title">
                    <?php echo $securityaudit; ?>
                </p>
                <div class="tile is-ancestor">
                    <div class="tile is-vertical is-12">
                        <div class="tile">
                            <div class="tile is-parent is-vertical">
                                <article class="tile is-child notification is-link">
                                    <p class="title">

                                    </p>
                                    <p class="subtitle">

                                    </p>
                                </article>
                                <article class="tile is-child notification is-success">
                                    <p class="title">

                                    </p>
                                    <p class="subtitle">

                                    </p>
                                </article>
                            </div>
                            <div class="tile is-parent">
                                <article class="tile is-child notification is-light">
                                    <div class="progressbox" style="margin-top: 60px;">
                                        <div class="progressring" id="securityprogress">
                                            <div class="inner title" style="margin-top: 20px;">
                                                <?php echo $totalSecurity; ?>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="tile is-parent is-vertical">
                                <article class="tile is-child notification is-link">
                                    <p class="title" id="totalSize">

                                    </p>
                                    <p class="subtitle">

                                    </p>
                                </article>
                                <article class="tile is-child notification is-warning">
                                    <p class="title">

                                    </p>
                                    <p class="subtitle">

                                    </p>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </center>
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
             <center>
                <p class="title">
                    <?php echo $seohelper; ?>
                </p>

                <div class="tile is-ancestor">
                    <div class="tile is-vertical is-12">
                        <div class="tile">
                            <div class="tile is-parent is-vertical">
                                <article class="tile is-child notification is-link">
                                    <p class="title">
                                        <?php echo ($score_result->seo->meta->description ? '<i class="fas fa-check-circle"></i> ' : '<i class="fas fa-times-circle"></i> '); ?> Description
                                    </p>
                                    <p class="subtitle">
                                        <?php echo $data_result->seo->meta->descriptiondesc; ?>
                                    </p>
                                </article>
                                <article class="tile is-child notification is-success">
                                    <p class="title">
                                        <?php echo ($score_result->seo->meta->title ? '<i class="fas fa-check-circle"></i> ' : '<i class="fas fa-times-circle"></i> '); ?> Title
                                    </p>
                                    <p class="subtitle">
                                        <?php echo $data_result->seo->meta->titledesc; ?>
                                    </p>
                                </article>
                            </div>
                            <div class="tile is-parent">
                                <article class="tile is-child notification is-light">
                                    <div class="progressbox" style="margin-top: 60px;">
                                        <div class="progressring" id="seoprogress">
                                            <div class="inner title" style="margin-top: 20px;">
                                                <?php echo $totalSEO; ?>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="tile is-parent is-vertical">
                                <article class="tile is-child notification is-link">
                                    <p class="title" id="totalSize">
                                        <?php echo ($score_result->seo->meta->keywords ? '<i class="fas fa-check-circle"></i> ' : '<i class="fas fa-times-circle"></i> '); ?> Keywords
                                    </p>
                                    <p class="subtitle">
                                        <?php echo $data_result->seo->meta->keywordsdesc; ?>
                                    </p>
                                </article>
                                <article class="tile is-child notification is-warning">
                                    <p class="title">
                                        <?php echo ($score_result->seo->responsive ? '<i class="fas fa-check-circle"></i> ' : '<i class="fas fa-times-circle"></i> '); ?> Responsive
                                    </p>
                                    <p class="subtitle">
                                        <?php echo $data_result->seo->responsivedesc; ?>
                                    </p>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </center>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h1 class="title">WebEnhancer guidelines</h1>
        <div class="content">
            <?php echo $text_guidelines; ?>
        </div>
    </div>
</section>

<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script>
    window.onload = function onLoad() {
        var speedBar =
            new ProgressBar.Circle('#speedprogress', {
                color: '#209CEE',
                strokeWidth: 1,
                duration: 2000,
                easing: 'easeInOut'
            });
        var speedBar_mini =
            new ProgressBar.Circle('#speedprogress_mini', {
                color: '#209CEE',
                strokeWidth: 2,
                duration: 2000,
                easing: 'easeInOut'
            });
        
        var codeBar =
            new ProgressBar.Circle('#codeprogress', {
                color: '#209CEE',
                strokeWidth: 1,
                duration: 2000,
                easing: 'easeInOut'
            });
        var codeBar_mini =
            new ProgressBar.Circle('#codeprogress_mini', {
                color: '#209CEE',
                strokeWidth: 2,
                duration: 2000,
                easing: 'easeInOut'
            });
        
        var securityBar =
            new ProgressBar.Circle('#securityprogress', {
                color: '#209CEE',
                strokeWidth: 1,
                duration: 2000,
                easing: 'easeInOut'
            });
        var securityBar_mini =
            new ProgressBar.Circle('#securityprogress_mini', {
                color: '#209CEE',
                strokeWidth: 2,
                duration: 2000,
                easing: 'easeInOut'
            });

        var seoBar =
            new ProgressBar.Circle('#seoprogress', {
                color: '#209CEE',
                strokeWidth: 1,
                duration: 2000,
                easing: 'easeInOut'
            });
        var seoBar_mini =
            new ProgressBar.Circle('#seoprogress_mini', {
                color: '#209CEE',
                strokeWidth: 2,
                duration: 2000,
                easing: 'easeInOut'
            });

        speedBar.animate(<?php echo $totalSpeed/100; ?>);
        speedBar_mini.animate(<?php echo $totalSpeed/100; ?>);
        
        codeBar.animate(<?php echo $totalCode/100; ?>);
        codeBar_mini.animate(<?php echo $totalCode/100; ?>);
        
        securityBar.animate(<?php echo $totalSecurity/100; ?>);
        securityBar_mini.animate(<?php echo $totalSecurity/100; ?>);

        seoBar.animate(<?php echo $totalSEO/100; ?>);
        seoBar_mini.animate(<?php echo $totalSEO/100; ?>);
        $("#totalSize").text("<?php echo format_size($totalSize); ?>");
        $("#totalErrors").text("<?php echo ($totalErrors); ?>");
    };
</script>