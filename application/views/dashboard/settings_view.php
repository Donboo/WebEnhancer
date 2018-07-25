<section class="hero is-medium is-info is-bold">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                WebEnhancer Dashboard
            </h1>
            <h2 class="subtitle">
                <?php echo $text_manage_your_settings; ?>
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
                    <li><a href="<?php echo base_url("dashboard/logins"); ?>"><?php echo $text_logins; ?></a></li>
                    <li><a class="is-active" href="<?php echo base_url("dashboard/settings"); ?>"><?php echo $text_settings; ?></a></li>
                    <li><a href="<?php echo base_url("dashboard/logout"); ?>"><?php echo $text_signout; ?></a></li>
                </ul>
            </aside>
        </div>
        <div class="column">  
            <div class="modal">
                <div class="modal-background"></div>
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title"><?php echo $text_change_picture; ?></p>
                        <button class="delete kkfkfj" aria-label="close"></button>
                    </header>
                    <?php echo form_open_multipart('dashboard/uploadpicture');?>
                    <section class="modal-card-body">
                        <figure class="image is-256x256 roundedImage">
                            <img id="testPicUpload" class="profilePic" src="<?php echo base_url("assets/images/users/$avatar_name"); ?>">
                        </figure>
                        <hr>
                        <div class="file has-name is-centered">
                            <label class="file-label">
                                <input class="file-input" accept="image/*" type="file" name="fileinputed">
                                <span class="file-cta">
                                    <span class="file-icon">
                                        <i class="fas fa-upload"></i>
                                    </span>
                                    <span class="file-label">
                                        Choose a file…
                                    </span>
                                </span>
                                <span class="file-name">
                                      ...
                                    
                                </span>
                            </label>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <button type="submit" class="button is-success">Save changes</button>
                        <button class="button kkfkfj">Cancel</button>
                    </footer>
                    <?php echo form_close(); ?> 
                </div>
            </div>
            <?php if(isset($upload_message)): ?>
            <br>
            <div class="notification is-danger">
                <button class="delete"></button>
                <?php echo $upload_message["error"]; ?>
            </div>
            <?php endif; ?>
            <?php if(isset($text_uploaded)): ?>
            <br>
            <div class="notification is-success">
                <button class="delete"></button>
                <?php echo $text_uploaded; ?>
            </div>
            <?php endif; ?>
            <div class="column is-3 inlineblock verticalmiddle">
                <div class="profilePicContainer">
                    <figure class="image is-256x256 roundedImage">
                        <img class="profilePic" src="<?php echo base_url("assets/images/users/$avatar_name"); ?>">
                    </figure>
                    <div class="profilePicMiddle">
                        <div class="profilePicText"><button id="showModal" class="modal-button" data-target="modal-ter" aria-haspopup="true"><?php echo $text_change_picture; ?></button></div>
                    </div>
                </div>
            </div>
            <div class="column is-7 inlineblock">
                <h1 class="title"><?php echo $this->session->userdata('logged_in')["EMail"]; ?></h1>
            </div>
            <div class="column is-11">
                <hr>
            </div>
            <div class="column is-11">
                <div class="card">
                    <div class="card-content">
                        <div class="media">
                            <div class="media-content">
                                <p class="title is-4"><?php echo $text_update_email; ?></p>
                            </div>
                        </div>

                        <div class="content inlineblock">
                            You can update your current email <?php echo $this->session->userdata('logged_in')["EMail"]; ?>
                            <a>#css</a> <a>#responsive</a>
                            <br>
                            <small>Last updated: 11:09 PM - 1 Jan 2016</small>
                        </div>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-content">
                        <div class="media">
                            <div class="media-content">
                                <p class="title is-4"><?php echo $text_update_password; ?></p>
                            </div>
                        </div>

                        <div class="content inlineblock">
                            You can update your current email donbooo@yahoo.com
                            <a>#css</a> <a>#responsive</a>
                            <br>
                            <small>Last updated: 11:09 PM - 1 Jan 2016</small>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="media">
                            <div class="media-content">
                                <p class="title is-4"><?php echo $text_delete_account; ?></p>
                            </div>
                        </div>

                        <div class="content inlineblock">
                            You can update your current email donbooo@yahoo.com
                            <a>#css</a> <a>#responsive</a>
                            <br>
                            <small>Last updated: 11:09 PM - 1 Jan 2016</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script>
$("#showModal").click(function() {
  $(".modal").addClass("is-active");  
});

$(".kkfkfj").click(function() {
   $(".modal").removeClass("is-active");
});
    
$(".file-input").on('change', function() {   
    $('.file-name').text($(".file-input")[0].files[0].name);
});
</script>