<div class="columns is-vcentered">
    <div class="login column is-4 ">
        <section class="section">
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
            <h1 class="title has-text-centered">
                WebEnhancer
            </h1>
            <h2 class="subtitle has-text-centered">
                <?php echo $logintitle; ?>
            </h2>
            
            <?php echo form_open("login/index"); ?>
            <div class="field">
                <label class="label">EMail address</label>
                <div class="control has-icons-right">
                    <input class="input" name="email" value="<?php echo set_value('email'); ?>" type="email" autocomplete="off"> 
                    <span class="icon is-small is-right">
                        <i class="fa fa-envelope"></i>
                    </span>
                </div>
            </div>
            <?php echo form_error('email');?>

            <div class="field">
                <label class="label">Password</label>
                <div class="control has-icons-right">
                    <input class="input" name="password" value="<?php echo set_value('password'); ?>" type="password" autocomplete="off">
                    <span class="icon is-small is-right">
                        <i class="fa fa-key"></i>
                    </span>
                </div>
            </div>
            <?php echo form_error('password');?>
            <div class="has-text-centered">
                <button type="submit" class="button is-vcentered is-info is-outlined">Login</button>
            </div>
            <br>
            <center>
                <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('recaptcha_sitekey'); ?>"></div>
            </center>
            <?php echo form_close(); ?>
            
            <div class="has-text-centered">
                <a href="<?php echo base_url("signup"); ?>"> <?php echo $text_alternativebottom; ?></a>
            </div>
        </section>
    </div>
    <div id="particles-js" class="interactive-bg column is-8">
    </div>
</div>

<script src="<?php echo base_url("assets/js/particles.js"); ?>" type="application/javascript"></script>