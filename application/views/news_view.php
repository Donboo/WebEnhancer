<section class="hero is-medium is-info is-bold has-text-centered" style="background:url(<?php echo base_url("assets/images/news/" . $image); ?>) no-repeat;background-size:100%">
    <a href='<?php echo base_url(); ?>'><i style="color:#333;font-size:25px;margin-left:25px;margin-top:25px" class="fas fa-arrow-left"></i> webenhancer.com</a>
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                <?php echo $title; ?>...
            </h1>
        </div>
    </div>
</section>

<section>
    <div class="columns">
        <div class="column has-text-centered" style="padding:30px;">
            <div class="container is-fluid">
                <div class="notification">
                    <p><?php echo $content; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>