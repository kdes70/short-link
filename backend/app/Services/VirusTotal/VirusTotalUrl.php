<?php


namespace App\Services\VirusTotal;

use GuzzleHttp\Exception\GuzzleException;

/**
 * Class VirusTotalUrl
 *
 * @see https://developers.virustotal.com/v3.0/reference#url
 */
class VirusTotalUrl extends ApiClient
{
    const ENDPOINTS_SCAN_URL = 'urls';
    const ENDPOINTS_ANALYSES = 'analyses';

    /**
     * Analyse a URL
     *
     * @param string $url The URL that should be scanned.
     * @return mixed
     * @throws GuzzleException
     */
    public function analysis(string $url): bool
    {


        $data = $this->makePostRequest(self::ENDPOINTS_SCAN_URL, [
            'url' => $url,
        ]);

        if (isset($data['data']['id'])) {
            $res = $this->makeGetRequest(self::ENDPOINTS_ANALYSES . '/' . $data['data']['id'], []);

            // todo так как ответ можем получить не сразу, будем запрашивать в цикле
            while ($res['data']['attributes']['status'] !== 'completed') {
                sleep(5);
                $res = $this->makeGetRequest(self::ENDPOINTS_ANALYSES . '/' . $data['data']['id'], []);
            }

            if (isset($res['data']['attributes']['stats']['harmless']) && $res['data']['attributes']['stats']['harmless'] > 0) {
                return true;
            }
        }

        return false;
    }
}
