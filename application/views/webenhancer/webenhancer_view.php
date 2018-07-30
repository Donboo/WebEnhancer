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
                                                <?php echo ($data_result->speed->loaddesc != "none") ? $data_result->speed->loaddesc->load_time : "Could not calculate"; ?>s
                                            </p>
                                            <p class="subtitle">
                                                Load Time
                                            </p>
                                        </article>
                                        <article class="tile is-child notification is-success">
                                            <p class="title">
                                                <?php echo ($data_result->speed->loaddesc != "none") ? $data_result->speed->loaddesc->total_resources : "Could not calculate"; ?>
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
                                                <?php echo ($data_result->speed->loaddesc != "none") ? $data_result->speed->loaddesc->load_time : "Could not calculate"; ?>
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

                <table class="table is-fullwidth is-striped is-network">
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
                        if($data_result->speed->loaddesc != "none") {
                            foreach($data_result->speed->loaddesc->resources as $load_data): 
                            ?>
                                <tr>
                                    <td><span class="responsecodehttp resp<?php echo $load_data->http_code; ?>"><?php echo $load_data->http_code; ?></span></td>
                                    <td>GET</td>
                                    <td>
                                        <?php echo $load_data->file_name; ?>
                                    </td>
                                    <td>
                                        <?php echo $load_data->domain; ?>
                                    </td>
                                    <td>document</td>
                                    <td>
                                        <?php echo strlen($load_data->path_info < 5) ? $load_data->path_info : "?"; ?>
                                    </td>
                                    <td>
                                        <?php echo $load_data->redirect_time; ?>
                                    </td>
                                    <td>
                                        <?php echo $load_data->dns_lookup; ?>
                                    </td>
                                    <td>
                                        <?php echo $load_data->fetch; ?>
                                    </td>
                                    <td>
                                        <?php echo $load_data->file_size; ?>
                                    </td>
                                    <td>
                                        <?php echo $load_data->our_grade;  ?>
                                    </td>
                                </tr>
                                <?php  
                            endforeach; 
                        } else echo "<td colspan=11><center>No resources were detected.</center></td>";
                        ?>
                    </tbody>
                </table>

            </center>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
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
                                                <?php //echo print_r($data_result->code->encoding); ?>
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

                <table class="table is-fullwidth is-striped is-network">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Line</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $totalErrors = 0;
                        foreach($data_result->code->validdesc->messages as $loaddata): 
                        $totalErrors++;
                        ?>
                            <tr>
                                <td>
                                    <span class="validatortype type<?php echo $loaddata->type; ?>">
                                        <?php echo ($loaddata->type); ?>
                                    </span>
                                </td>
                                <td><?php echo ($loaddata->line); ?></td>
                                <td><?php echo alive_validate_messages($loaddata->message); ?></td>
                            </tr>
                            <?php  
                        endforeach; 
                        ?>
                    </tbody>
                </table>
                
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
            <p class="title">
                <?php echo $securityaudit; ?>
            </p>
            <center>
                <div class="columns">
                    <div class="column">
                        <div class="tile is-ancestor">
                            <div class="tile is-vertical is-12">
                                <div class="tile">
                                    <div class="tile is-parent is-vertical">
                                        <article class="tile is-child notification is-link">
                                            <p class="title">
                                                <?php echo ($score_result->security->mis->autocomplete); ?>/14.28
                                            </p>
                                            <p class="subtitle">
                                                <abbr title="Disable autocomplete on inputs by adding autocomplete=off as attribute for input">Autocomplete inputs</abbr>
                                            </p>
                                        </article>
                                        <article class="tile is-child notification is-success">
                                            <p class="title">
                                                <?php echo ($score_result->security->mis->powered); ?>/14.28
                                            </p>
                                            <p class="subtitle">
                                                <abbr title="Should be disabled everytime. Google it.">X-Powered-by header</abbr>
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
                                                <?php echo ($score_result->security->mis->headers); ?>/14.28
                                            </p>
                                            <p class="subtitle">
                                                <abbr title="Always hide your headers!">Headers</abbr>
                                            </p>
                                        </article>
                                        <article class="tile is-child notification is-warning">
                                            <p class="title">
                                                <?php echo ($score_result->security->ssl); ?>/14.28
                                            </p>
                                            <p class="subtitle">
                                                <?php echo ($data_result->security->ssldesc); ?>
                                            </p>
                                        </article>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </center>
            <br>
            
            <table class="table is-fullwidth is-striped is-network">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>URL</th>
                        <th>Method</th>
                        <th>Query</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if($data_result->security->sqlidesc != 'none') {
                        foreach($data_result->security->sqlidesc as $sqli): 
                    ?>
                            <tr>
                                <td>
                                    <span class="responsecodehttp resp404">
                                        SQLi
                                    </span>
                                </td>
                                <td><?php echo ($sqli->url); ?></td>
                                <td><?php echo ($sqli->method); ?></td>
                                <td><?php echo html_entity_decode($sqli->query); ?></td>
                            </tr>
                    <?php  
                        endforeach; 
                    }
                    ?>
                    <?php 
                    if($data_result->security->xssdesc != 'none') {
                        foreach($data_result->security->xssdesc as $xss): 
                    ?>
                            <tr>
                                <td>
                                    <span class="responsecodehttp resp404">
                                        XSS
                                    </span>
                                </td>
                                <td><?php echo ($xss->line); ?></td>
                                <td><?php echo alive_validate_messages($xss->message); ?></td>
                            </tr>
                    <?php  
                        endforeach; 
                    }
                    ?>
                </tbody>
            </table>
            
            <center>
                <div class="columns">
                    <div class="column">
                        <div class="tile is-ancestor">
                            <div class="tile is-vertical is-12">
                                <div class="tile">
                                    <div class="tile is-parent is-vertical">
                                        <article class="tile is-child notification is-link">
                                            <p class="title">
                                                <?php echo ($score_result->security->xss); ?>/14.28
                                            </p>
                                            <p class="subtitle">
                                                <abbr title="Cross site scripting. Google is your friend.">XSS</abbr>
                                            </p>
                                        </article>
                                    </div>
                                    <div class="tile is-parent is-vertical">
                                        <article class="tile is-child notification is-danger">
                                            <p class="title" id="totalSize">
                                                <?php echo ($score_result->security->sqli); ?>/14.28
                                            </p>
                                            <p class="subtitle">
                                                <abbr title="SQL Injection. Filter user data. Google?">SQLi</abbr>
                                            </p>
                                        </article>
                                    </div>
                                </div>
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
        $("#totalSize").text("<?php echo format_size($data_result->speed->loaddesc->total_size); ?>");
        $("#totalErrors").text("<?php echo $totalErrors ; ?>");
    };
</script>