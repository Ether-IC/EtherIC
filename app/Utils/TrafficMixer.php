<?php
class TrafficMixer {
    private $userAgents;
    private $acceptHeaders;
    private $languages;

    public function __construct() {
        $this->userAgents = [
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36",
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15",
            "Mozilla/5.0 (X11; Linux x86_64; rv:89.0) Gecko/20100101 Firefox/89.0",
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/18.18362",
            "Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/604.1",
        ];

        $this->acceptHeaders = [
            "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
            "application/json, text/javascript, */*; q=0.01",
            "text/css,*/*;q=0.1",
        ];

        $this->languages = [
            "en-US,en;q=0.9",
            "en-GB,en;q=0.8",
            "fr-FR,fr;q=0.7,en;q=0.5",
            "de-DE,de;q=0.8,en-US;q=0.5",
            "zh-CN,zh;q=0.9",
        ];
    }

    public function generateHeaders() {
        return [
            'User-Agent: ' . $this->userAgents[array_rand($this->userAgents)],
            'Accept: ' . $this->acceptHeaders[array_rand($this->acceptHeaders)],
            'Accept-Language: ' . $this->languages[array_rand($this->languages)],
            'Connection: keep-alive',
            'Cache-Control: no-cache',
        ];
    }
}
?>
