<?php
class TorService {
    public function sendRequestThroughTor($url, $headers, $concurrentRequests) {
        $multiHandle = curl_multi_init();
        $curlHandles = [];

        for ($i = 0; $i < $concurrentRequests; $i++) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:9050');
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
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
