<?php

declare(strict_types=1);

namespace BTCPayServer\Client;

class LightningStore extends AbstractClient
{
    public function getNodeInformation(string $cryptoCode, string $storeId): \BTCPayServer\Result\LightningNode
    {
        $url = $this->getApiUrl() . 'stores/' .
                    urlencode($storeId) . '/lightning/' .
                    urlencode($cryptoCode) . '/info';

        $headers = $this->getRequestHeaders();
        $method = 'GET';

        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            return new \BTCPayServer\Result\LightningNode(
                json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR)
            );
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    public function connectToLightningNode(
        string $cryptoCode,
        string $storeId,
        ?string $nodeURI
    ): bool {
        $url = $this->getApiUrl() . 'stores/' .
                urlencode($storeId) . '/lightning/' .
                urlencode($cryptoCode) . '/connect';

        $headers = $this->getRequestHeaders();
        $method = 'POST';

        $body = json_encode(
            [
                'nodeURI' => $nodeURI,
            ],
            JSON_THROW_ON_ERROR
        );

        $response = $this->getHttpClient()->request($method, $url, $headers, $body);

        if ($response->getStatus() === 200) {
            return true;
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    public function getChannels(string $cryptoCode, string $storeId): \BTCPayServer\Result\LightningChannelList
    {
        $url = $this->getApiUrl() . 'stores/' .
                    urlencode($storeId) . '/lightning/' .
                    urlencode($cryptoCode) . '/channels';

        $headers = $this->getRequestHeaders();
        $method = 'GET';

        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            return new \BTCPayServer\Result\LightningChannelList(
                json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR)
            );
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    public function openChannel(
        string $cryptoCode,
        string $storeId,
        string $nodeURI,
        string $channelAmount,
        int $feeRate
    ): bool {
        $url = $this->getApiUrl() . 'stores/' .
                urlencode($storeId) . '/lightning/' .
                urlencode($cryptoCode) . '/channels';

        $headers = $this->getRequestHeaders();
        $method = 'POST';

        $body = json_encode(
            [
                'nodeURI' => $nodeURI,
                'channelAmount' => $channelAmount,
                'feeRate' => $feeRate
            ],
            JSON_THROW_ON_ERROR
        );

        $response = $this->getHttpClient()->request($method, $url, $headers, $body);

        if ($response->getStatus() === 200) {
            return true;
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    public function getDepositAddress(string $cryptoCode, string $storeId): string
    {
        $url = $this->getApiUrl() . 'stores/' .
                    urlencode($storeId) . '/lightning/' .
                    urlencode($cryptoCode) . '/address';

        $headers = $this->getRequestHeaders();
        $method = 'POST'; //should be get

        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    public function getInvoice(
        string $cryptoCode,
        string $storeId,
        string $id
    ): \BTCPayServer\Result\Invoice {
        $url = $this->getApiUrl() . 'stores/' .
            urlencode($storeId) . '/lightning/' .
            urlencode($cryptoCode) . '/invoices/' .
            urlencode($id);

        $headers = $this->getRequestHeaders();
        $method = 'GET';
        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            return new \BTCPayServer\Result\Invoice(
                json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR)
            );
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    public function payLightningInvoice(
        string $cryptoCode,
        string $storeId,
        string $BOLT11
    ): bool {
        $url = $this->getApiUrl() . 'stores/' .
                urlencode($storeId) . '/lightning/' .
                urlencode($cryptoCode) . '/info';

        $headers = $this->getRequestHeaders();
        $method = 'POST';

        $body = json_encode(
            [
                'BOLT11' => $BOLT11
            ],
            JSON_THROW_ON_ERROR
        );

        $response = $this->getHttpClient()->request($method, $url, $headers, $body);

        if ($response->getStatus() === 200) {
            return true;
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    public function createLightningInvoice(
        string $cryptoCode,
        string $storeId,
        string $amount,
        int $expiry,
        ?string $description = null,
        ?bool $privateRouteHints = false
    ): \BTCPayServer\Result\Invoice {
        $url = $this->getApiUrl() . 'stores/' .
                    urlencode($storeId) . '/lightning/' .
                    urlencode($cryptoCode) . '/invoices';

        $headers = $this->getRequestHeaders();
        $method = 'POST';

        $body = json_encode(
            [
                'amount' => $amount,
                'description' => $description,
                'expiry' => $expiry,
                'privateRouteHints' => $privateRouteHints
            ],
            JSON_THROW_ON_ERROR
        );

        $response = $this->getHttpClient()->request($method, $url, $headers, $body);

        if ($response->getStatus() === 200) {
            return new \BTCPayServer\Result\Invoice(
                json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR)
            );
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }
}
