<section class="hero is-medium is-info is-bold">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                WebEnhancer Dashboard
            </h1>
            <h2 class="subtitle">
                Primary bold subtitle
            </h2>
        </div>
    </div>
</section>

<section>
    
    <div class="columns">
        <div class="column is-one-fifth" style="padding:30px;">
            <aside class="menu">
                <p class="menu-label">
                    General
                </p>
                <ul class="menu-list">
                    <li><a class="is-active"><?php echo $text_news; ?></a></li>
                </ul>
                <p class="menu-label">
                    <?php echo $text_projects; ?>
                </p>
                <ul class="menu-list">
                    <li>
                        <ul>
                            <li><a href="<?php echo base_url("dashboard/projects"); ?>"><?php echo $text_projects; ?></a></li>
                            <li><a href="<?php echo base_url("dashboard/addproject"); ?>"><?php echo $text_add_project; ?></a></li>
                        </ul>
                    </li>
                </ul>
                <p class="menu-label">
                    Account
                </p>
                <ul class="menu-list">
                    <li><a href="<?php echo base_url("dashboard/logins"); ?>"><?php echo $text_logins; ?></a></li>
                    <li><a href="<?php echo base_url("dashboard/settings"); ?>"><?php echo $text_settings; ?></a></li>
                    <li><a href="<?php echo base_url("dashboard/logout"); ?>"><?php echo $text_signout; ?></a></li>
                </ul>
            </aside>
        </div>
        <div class="column">
            <?php foreach($news as $row): ?>
            <div class="dashboard_news is-fullwidth has-text-centered" style="background:url(<?php echo base_url('assets/images/news/'. $row["Image"]); ?>) no-repeat;position: relative;background-size: 100%;">
                <h1 class="title has-text-centered"><a href="<?php echo base_url("news/" . $row["ID"]); ?>"><?php echo substr($row["Content"], 0, 20); ?></a></h1>
                <div class="opacity_front"></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
    console.log(window.performance);
</script>