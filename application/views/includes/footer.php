    <footer class="footer">
        
        <div class="container">
            <div class="columns">
                <div class="column has-text-left">
                    <p><?php echo $this->lang->line("main_switchlang"); ?> <a href="<?php echo base_url(); ?>LanguageSwitch/switch_language/<?php if($this->session->userdata("language") == "romanian") echo "english"; else echo "romanian"; ?>"><?php if($this->session->userdata("language") == "romanian") echo "english"; else echo "română"; ?></a></p>
                </div>
                <div class="column has-text-right">
                    <a href="<?php echo base_url("terms"); ?>"><?php echo $this->lang->line("main_tos"); ?></a>
                </div>
            </div>
        </div>
    </footer>
    <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
    <script defer src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    <script defer src="<?php echo base_url(); ?>assets/js/custom.js"></script>
</body>
</html>