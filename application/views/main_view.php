<body>
    <section class="hero is-info is-fullheight is-bold" id="mainbackground">
        <?php if($this->session->flashdata('error') != null): ?>
        <div class="notification is-danger">
            <button class="delete"></button>
            <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('success') != null): ?>
        <div class="notification is-success">
            <button class="delete"></button>
            <?php echo $this->session->flashdata('success'); ?>
        </div>
        <?php endif; ?>
        <div class="hero-head">
            <nav class="navbar">
                <div class="container">

                    <div id="navbarMenu" class="navbar-menu is-active">
                        <div class="navbar-start">
                            <a href="#mainbackground" class="navbar-item is-active">
                                <?php echo $home; ?>
                            </a>
                            <a href="#firstmaincontainer" class="navbar-item">
                                <?php echo $about; ?>
                            </a>
                            <a href="#paddingmore" class="navbar-item">
                                <?php echo $enhanceyourwebsite; ?>
                            </a>
                            <span class="navbar-item">
                                <?php if($this->session->userdata('logged_in') !== null) { ?>
                                <a class="button is-white is-outlined is-small" href="<?php echo base_url("dashboard"); ?>">
                                    <span class="icon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <span>Dashboard</span>
                                </a>
                                <?php } else { ?>
                                <a class="button is-white is-outlined is-small" href="<?php echo base_url("login"); ?>">
                                    <span class="icon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <span><?php echo $login; ?></span>
                                </a>
                                <?php } ?>
                            </span>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div class="hero-body">
            <div class="container">
                <h1 class="title is-2">
                    <?php echo $title; ?>
                </h1>
                <h2 class="subtitle is-4">
                    <?php echo $subtitle; ?>
                </h2>
            </div>
        </div>
        <a  href="#firstmaincontainer" class="container has-text-centered">
            <span class="icon is-large container has-text-centered ">
                <i class="fa-3x fas fa-arrow-down"></i>
            </span>
        </a>
    </section>
    <div class="box cta">
        <p class="has-text-centered">
            <span class="tag is-primary">New</span> <span><?php echo html_purify($lastnews); ?></span>
        </p>
    </div>
    <section class="container" id="firstmaincontainer">
        <div class="intro column is-10 is-offset-1 has-text-centered" style="padding:85px;">
            <h3 class="title is-2"><?php echo $firstargument; ?></h3>
            <p class="subtitle">
                <?php echo $firstargumentsubtitle; ?>
            </p>
        </div>
        <div class="sandbox">
            <div class="tile is-ancestor">
                <div class="tile is-parent is-shady">
                    <article class="tile is-child notification is-grey">
                        <p class="title">
                            <?php echo $speedtests; ?>
                        </p>
                        <p class="subtitle">
                            <?php echo $speedtestsargument; ?>
                        </p>
                    </article>
                </div>
                <div class="tile is-parent is-shady">
                    <article class="tile is-child notification is-grey">
                        <p class="title">
                            <?php echo $codevalidator; ?>
                        </p>
                        <p class="subtitle">
                            <?php echo $codevalidatorargument; ?>
                        </p>
                    </article>
                </div>
                <div class="tile is-parent is-shady">
                    <article class="tile is-child notification is-grey">
                        <p class="title">
                            <?php echo $seohelper; ?>
                        </p>
                        <p class="subtitle">
                            <?php echo $seohelperargument; ?>
                        </p>
                    </article>
                </div>
            </div>

            <div class="tile is-ancestor">
                <div class="tile is-vertical is-12">
                    <div class="tile">
                        <div class="tile is-parent">
                            <article class="tile is-child notification is-grey">
                                <p class="title">
                                    <?php echo $securityaudit; ?>
                                </p>
                                <p class="subtitle">
                                    <?php echo $securityauditargument; ?>
                                </p>
                            </article>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <br>
    <br>
    <br>
    <section class="hero is-info has-text-centered is-bold" id="paddingmore">
        <div class="hero-body">
            <div class="container">
                <p class="title">
                    <?php echo $testyoursite; ?>
                </p>
                <br>
                <p class="subtitle">
                    <?php echo form_open("WebEnhancer/start_test/"); ?>
                        <input id="testinput" name="testinput" class="input is-rounded is-primary is-inverted is-outlined" type="url" placeholder="http://yoursite.com/">
                        <button type="submit" class="button is-rounded is-primary is-inverted is-outlined">
                            <span class="icon">
                                <i class="fa fa-arrow-right"></i>
                            </span>
                        </button>
                    <?php echo form_close(); ?>
                </p>
            </div>
        </div>
    </section>