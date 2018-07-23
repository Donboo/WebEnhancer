<!DOCTYPE html>
<html>
    <head>
        <meta charset="<?php echo $this->config->item('charset'); ?>">
        <!--<script async src="https://cdn.ampproject.org/v0.js"></script>-->
        <!--<link rel="canonical" href="<?php echo base_url(); ?>">-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $this->config->item('site_name'); ?></title>
        <meta name="description" content="WebEnhancer is a all-in-one tool to enhance your website. Speed tests, security audit, seo helper and code validator.">
        <meta name="keywords" content="webenhancer,website enhance,website">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="#FFFFFF">
        <meta name="application-name" content="WebEnhancer" />
        <meta name="msapplication-TileColor" content="#a33486" />

        <link rel="apple-touch-icon" href="https://www.kwindo.ro/assets/images/touch-icon-iphone-retina.png">
        <link rel="apple-touch-icon" sizes="152x152" href="https://www.kwindo.ro/assets/images/touch-icon-ipad.png">
        <link rel="apple-touch-icon" sizes="180x180" href="https://www.kwindo.ro/assets/images/touch-icon-iphone-retina.png">
        <link rel="apple-touch-icon" sizes="167x167" href="https://www.kwindo.ro/assets/images/touch-icon-ipad-retina.png">
        <link rel="shortcut icon" type="image/png" href="https://www.kwindo.ro/assets/images/favicon.png" />
        
        <meta property="og:type" content="website" />
        <meta property="og:title" content="<?php echo $this->config->item('site_name'); ?>" />
        <meta property="og:description" content="WebEnhancer is a all-in-one tool to enhance your website. Speed tests, security audit, seo helper and code validator." />
        <meta property="og:url" content="<?php echo base_url(); ?>" />
        <meta property="og:site_name" content="<?php echo $this->config->item('site_name'); ?>" />
        <meta property="og:image" content="https://www.kwindo.ro/assets/images/opengraphCreateSite.png" />
        <meta property="og:image:type" content="image/png" />
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="628" />
        <meta property="og:updated_time" content="1525294697" />

        
        <meta property="article:publisher" content="https://www.facebook.com/kwindoro">
        <meta property="article:author" content="https://www.facebook.com/kwindoro">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:description" content="WebEnhancer is a all-in-one tool to enhance your website. Speed tests, security audit, seo helper and code validator.">
        <meta name="twitter:site" content="@webenhancer">
        <meta name="twitter:creator" content="@webenhancer">
        <meta name="twitter:title" content="<?php echo $this->config->item('site_name'); ?>">
        <meta name="twitter:image:src" content="https://www.kwindo.ro/assets/images/opengraphCreateSite.png">
        
        <link rel="stylesheet" href="<?php echo base_url("assets/css/bulma.min.css"); ?>">
        <link rel="stylesheet" href="<?php echo base_url("assets/css/custom.css"); ?>">
        
         <script type="application/ld+json">
         {
              "@context": "http://schema.org",
              "@type": "LocalBusiness",
              "email": "mailto:info@webenhancer.ro",
              "description": "WebEnhancer is a all-in-one tool to enhance your website. Speed tests, security audit, seo helper and code validator.",
              "name": "<?php echo $this->config->item('site_name'); ?>",
              "url": "<?php echo base_url(); ?>",
              "parentOrganization": "Kwindo Studios"
         }
        </script>
        
        <!--<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>-->

        <?php if($this->uri->segment(1) == "login" || $this->uri->segment(1) == "signup"): ?>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <?php endif; ?>
    </head>