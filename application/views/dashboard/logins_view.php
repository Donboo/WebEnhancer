<section class="hero is-medium is-info is-bold">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                WebEnhancer Dashboard
            </h1>
            <h2 class="subtitle">
                <?php echo $text_manage_your_logins; ?>
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
                    <li><a><?php echo $text_news; ?></a></li>
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
                    <li><a class="is-active" href="<?php echo base_url("dashboard/logins"); ?>"><?php echo $text_logins; ?></a></li>
                    <li><a href="<?php echo base_url("dashboard/settings"); ?>"><?php echo $text_settings; ?></a></li>
                    <li><a href="<?php echo base_url("dashboard/logout"); ?>"><?php echo $text_signout; ?></a></li>
                </ul>
            </aside>
        </div>
        <div class="column">
            <table class="table" style="width:98%">
                <thead>
                    <tr>
                        <th>
                            <abbr title="Position">#</abbr>
                        </th>
                        <th>
                            <abbr>IP</abbr>
                        </th>
                        <th>
                            <abbr title="Provided by ipstack.com">Location</abbr>
                        </th>
                        <th>
                            <abbr>Time</abbr>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($logins) { $i= 0 ; foreach($logins as $row): $i++;  ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo ($row["IP"]); ?></td>
                        <td><?php echo get_ip_location($row["IP"]); ?></td>
                        <td><?php echo $row["Time"]; ?></td>
                    </tr>
                    <?php endforeach; } else echo "<td>$text_invalid_login</td>"; ?>
                </tbody>
                <?php if (isset($links)) echo $links; ?>
            </table>
        </div>
    </div>
</section>