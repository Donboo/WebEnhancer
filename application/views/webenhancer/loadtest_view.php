<!DOCTYPE html>
<html>
    <style>.loader2{background-color:#4684ee;color:#fff;font-family:Consolas,Menlo,Monaco,monospace;font-weight:700;font-size:30vh;opacity:1;height:100%;width:100%;position:fixed;text-align:center;z-index:9999}.loader2 span{display:inline-block;animation:pulse .4s alternate infinite ease-in-out}.loader2 .normaltext{font-size:3vh}span:nth-child(2){animation-delay:.4s}@keyframes pulse{to{transform:scale(.8);opacity:.5}}</style>
    <div class='loader2'><span>{</span><span>}</span><br><span class='normaltext'>Analyzing...</span><span class='normaltext'>This could take a while</span></div>
    <div class="loadcontent" id="loadcontente"><?php echo $content; ?></div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    
    <script type="text/javascript">
        function isPathAbsolute(path) {
            return /^(?:\/|[a-z]+:\/\/)/.test(path);
        }

        $(document).ready(function(){
            let json_string = "";
            function get_resources() {
            // Check performance support
                if (performance === undefined) {
                    return;
                }

                // Get a list of "resource" performance entries
                var resources = performance.getEntriesByType("resource");
                if (resources === undefined || resources.length <= 0) {
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
            $("#loadcontente").remove();

            var domelements = $("*").length;
            
            $.ajax({
                type: "POST",
                url: "<?= base_url('webenhancer/returnload/'); ?>",
                data: {"_token": "<?php echo $this->security->get_csrf_hash(); ?>","cookieset":json_string,"domelements":domelements},
                success: function (data) {
                    window.location.assign("<?php echo base_url("webenhancer/continue_test/" . $given_url); ?>");
                }
            });
        });
    </script>
</html>