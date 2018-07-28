<section class="hero is-medium is-info is-bold">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                WebEnhancer Dashboard
            </h1>
            <h2 class="subtitle">
                <?php echo $text_manage_your_projects; ?>
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
                    <li><a href="<?php echo base_url("dashboard/"); ?>"><?php echo $text_news; ?></a></li>
                </ul>
                <p class="menu-label">
                    <?php echo $text_projects; ?>
                </p>
                <ul class="menu-list">
                    <li>
                        <ul>
                            <li><a class="is-active" href="<?php echo base_url("dashboard/projects"); ?>"><?php echo $text_projects; ?></a></li>
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
            <table class="table" style="width:98%">
                <thead>
                    <tr>
                        <th>
                            <abbr title="Position">#</abbr>
                        </th>
                        <th>
                            <?php echo $text_project_name; ?>
                        </th>
                        <th>
                            <?php echo $text_first_scan; ?>
                        </th>
                        <th>
                            <?php echo $text_last_scan; ?>
                        </th>
                        <th>
                            <?php echo $text_first_result; ?>
                        </th>
                        <th>
                            <?php echo $text_last_result; ?>
                        </th>
                        <th>
                            <?php echo $text_view_project; ?>    
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($project): ?>
                        <?php foreach($project as $row): ?>
                        <tr>
                            <th>1</th>
                            <td>
                                <a href="<?php echo $row["URL"]; ?>" title="<?php echo  parse_url($row["URL"])['host']; ?>"><?php echo  parse_url($row["URL"])['host']; ?></a>
                            </td>
                            <td>38</td>
                            <td>23</td>
                            <td>12</td>
                            <td>3</td>
                            <td><a href="<?php echo base_url("dashboard/viewproject/1"); ?>"><?php echo $text_view_project; ?></a></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>