<!DOCTYPE html>
<html>
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

            $("html").append(json_string);
            Cookies.set("loadtest", json_string);
        });
    </script>
</html>