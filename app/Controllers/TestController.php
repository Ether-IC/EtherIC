<?php
require_once '../app/Services/ProxyService.php';
require_once '../app/Services/TorService.php';
require_once '../app/Utils/TrafficMixer.php';

class TestController {
    private $proxyService;
    private $torService;
    private $trafficMixer;

    public function __construct() {
        $this->proxyService = new ProxyService();
        $this->torService = new TorService();
        $this->trafficMixer = new TrafficMixer();
    }

    public function startTest($targetUrl, $useTor = false, $concurrentRequests = 10) {
        $headers = $this->trafficMixer->generateHeaders();

        if ($useTor) {
            $this->torService->sendRequestThroughTor($targetUrl, $headers, $concurrentRequests);
        } else {
            $proxy = $this->proxyService->getRandomProxy();
            $this->proxyService->sendRequestThroughProxy($targetUrl, $headers, $proxy, $concurrentRequests);
        }
    }
}
?>
