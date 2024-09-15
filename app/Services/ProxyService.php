<?php
class ProxyService {
    private $proxyList;

    public function __construct() {
        $this->proxyList = file('../storage/proxy_list.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }

    public function getRandomProxy() {
        $proxyLine = $this->proxyList[array_rand($this->proxyList)];
        list($ip, $port, $type) = explode(":", $proxyLine);

        return [
            'ip' => $ip,
            'port' => $port,
            'type' => $type
        ];
    }

    public function sendRequestThroughProxy($url, $headers, $proxy, $concurrentRequests) {
        $multiHandle = curl_multi_init();
        $curlHandles = [];

        for ($i = 0; $i < $concurrentRequests; $i++) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_PROXY, $proxy['ip'] . ':' . $proxy['port']);
            curl_setopt($ch, CURLOPT_PROXYTYPE, $proxy['type'] == 'https' ? CURLPROXY_HTTPS : CURLPROXY_HTTP);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_multi_add_handle($multiHandle, $ch);
            $curlHandles[] = $ch;
        }

        $active = null;
        do {
            curl_multi_exec($multiHandle, $active);
        } while ($active > 0);

        foreach ($curlHandles as $ch) {
            curl_multi_remove_handle($multiHandle, $ch);
            curl_close($ch);
        }

        curl_multi_close($multiHandle);
    }
}
?>
