<style>/* {} LOADER */
    .loader2 {
        background-color: #4684ee;
        color: #fff;
        font-family: Consolas, Menlo, Monaco, monospace;
        font-weight: bold;
        font-size: 30vh;
        opacity: 1;
        height: 100%;
        width: 100%;
        position: fixed;
        text-align: center;
        z-index: 31;
    }
    .loader2 span {
        display: inline-block;
        animation: pulse 0.4s alternate infinite ease-in-out;
    }
    .loader2 .normaltext {
        font-size: 3vh;
    }

    span:nth-child(2) {
      animation-delay: 0.4s;
    }

    @keyframes pulse {
      to {
        transform: scale(0.8);
        opacity: 0.5;
      }
    }
    /* */
    </style>
    <div class='loader2'><span>{</span><span>}</span><br><span class='normaltext'>Analyzing DOM...</span></div>
<div class="content"><?php echo $content; ?></div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<script>
    var domelements = $("*").length;
    $.ajax({
        type: "POST",
        url: "<?= base_url('webenhancer/returndomelements/'); ?>",
        data: {"_token": "<?php echo $this->security->get_csrf_hash(); ?>","domelements":domelements}, 
        success: function (data) {
            window.close();
        }
    });
</script>