<!DOCTYPE html>
<html>
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
    <div class='loader2'><span>{</span><span>}</span><br><span class='normaltext'>Analyzing speed...</span></div>
    <div class="loadcontent" id="loadcontente"><?php echo $content; ?></div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    
    <script type="text/javascript">
        function isPathAbsolute(path) {
            return /^(?:\/|[a-z]+:\/\/)/.test(path);
        }

        $(document).ready(function(){
            let json_string = "";
            function get_resources() {
            // Check performance support
                if (performance === undefined) {
                    console.log("= Calculate Load Times: performance NOT supported");
                    return;
                }

                // Get a list of "resource" performance entries
                var resources = performance.getEntriesByType("resource");
                if (resources === undefined || resources.length <= 0) {
                    console.log("= Calculate Load Times: there are NO `resource` performance records");
                    return;
                }

                json_string += '{"totalResources":"' + resources.length + '",';

                json_string += '"resources":{';
                    for (var i=0; i < resources.length; i++) {
                        //if(isPathAbsolute(resources[i].name)) document.write(resources[i].name + " e vrajeala");

                        json_string += '"' + i + '":{';
                        json_string += '"name": "' + resources[i].name + '",';
                        json_string += '"totalTime": "' + (resources[i].responseEnd - resources[i].startTime) + '",';
                        json_string += '"redirectTime": "' + (resources[i].redirectEnd - resources[i].redirectStart) + '",';
                        json_string += '"dnsLookup": "' + (resources[i].domainLookupEnd - resources[i].domainLookupStart) + '",';
                        json_string += '"tcpTime": "' + (resources[i].connectEnd - resources[i].connectStart) + '",';
                        json_string += '"secureConnectionTime": "' + ((resources[i].secureConnectionStart > 0) ? (resources[i].connectEnd - resources[i].secureConnectionStart) : "0") + '",';
                        json_string += '"responseTime": "' + (resources[i].responseEnd - resources[i].responseStart) + '",';
                        json_string += '"fetchUntilResponseEnd": "' + ((resources[i].fetchStart > 0) ? (resources[i].responseEnd - resources[i].fetchStart) : "0") + '",';
                        json_string += '"requestStartUntilRespEnd": "' + ((resources[i].requestStart > 0) ? (resources[i].responseEnd - resources[i].requestStart) : "0") + '",';
                        json_string += '"startUntilRespEnd": "' + ((resources[i].startTime > 0) ? (resources[i].responseEnd - resources[i].startTime) : "0") + '"';
                        json_string += '}';
                        if(i != resources.length - 1) json_string += ',';
                    }
                json_string += '},';
            }

            get_resources();

            json_string += '"loadTime":"' + (window.performance.timing.domContentLoadedEventEnd - window.performance.timing.navigationStart      )/100 + '",';
            json_string += '"domTime":"'  + (window.performance.timing.domInteractive           - window.performance.timing.domLoading           )/100 + '",';
            json_string += '"sslTime":"'  + (window.performance.timing.secureConnectionStart    - window.performance.timing.secureConnectionStop )     + '"}';

            $(".loadcontent").remove();
            $("#loadcontent").remove();

            
            //Cookies.remove('loadtest');
            Cookies.set('xxxxx', "" + json_string + "");
            
            $.ajax({
                type: "POST",
                url: "<?= base_url('webenhancer/returnload/'); ?>",
                data: {"_token": "<?php echo $this->security->get_csrf_hash(); ?>","cookieset":json_string},  // fix: need to append your data to the call
                success: function (data) {
                    window.close();
                }
            });
        });
    </script>
</html>