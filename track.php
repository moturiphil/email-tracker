<!-- PMM comment  -->
<!-- Concept for building an email tracker -->
<!-- Generate Unique Tracking URL -->
<!-- Helps in identifying the specific email -->

function generateTrackingPixel($emailId) {
    $uniqueId = uniqid();
    return "http://yourserver.com/url/" . $emailId . "/" . $uniqueId;
}

function generateTrackingLink($originalUrl, $emailId) {
    $uniqueId = uniqid();
    return "http://yourserver.com/track/" . $emailId . "/" . $uniqueId . "?redirect_to=" . urlencode($originalUrl);
}

<!-- PMM comment  -->
<!--  Handle url tracking -->
if (preg_match('/\/pixel\/(.*)\/(.*).png$/', $_SERVER['REQUEST_URI'], $matches)) {
    $emailId = $matches[1];
    $uniqueId = $matches[2];
    
    logEmailOpen($emailId, $uniqueId);
    
    header('Content-Type: image/png');
    <!-- PMM comment  -->
    <!-- sample decode -->
    echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/wcAAgUB/aiu1zoAAAAASUVORK5CYII='); 
    exit;
}

if (isset($_GET['redirect_to']) && preg_match('/\/track\/(.*)\/(.*)$/', $_SERVER['REQUEST_URI'], $matches)) {
    $emailId = $matches[1];
    $uniqueId = $matches[2];
    $redirectTo = urldecode($_GET['redirect_to']);
    
    logLinkClick($emailId, $uniqueId);
    header("Location: " . $redirectTo);
    exit;
}

<!-- PMM comment  -->
<!-- file logging & timestamp on the db -->
function logEvent($event, $emailId) {
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] Event: $event Email ID: $emailId";
    file_put_contents('email_events.log', $logMessage . PHP_EOL, FILE_APPEND);
}

<!-- PMM comment -->
<!-- log when a user receives the email -->
function receiveEmail($emailId) {
    logEvent('received', $emailId);
}

<!-- PMM comment -->
<!-- log when a user reads the email -->
function readEmail($emailId) {
    logEvent('read', $emailId);
}

<!-- PMM comment -->
<!-- log when a user prints the email -->
function printEmail($emailId) {
    logEvent('printed', $emailId);
}

<!-- PMM comment -->
<!-- log when a user deletes the email -->
function deleteEmail($emailId) {
    logEvent('deleted', $emailId);
}

function logEvent($event, $emailId) {
    $start = microtime(true);
    
    <!-- PMM comment: Simulate operation delay
    simulate processing delay for demo -->
    usleep(rand(100, 1000)); 
    
    $end = microtime(true);
    <!-- PMM comment: Duration in seconds -->
    $duration = $end - $start;

    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] Event: $event Email ID: $emailId Duration: $duration sec";
    file_put_contents('email_events.log', $logMessage . PHP_EOL, FILE_APPEND);
}

