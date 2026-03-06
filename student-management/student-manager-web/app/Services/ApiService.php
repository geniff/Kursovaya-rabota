<?php
namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class ApiService
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('api.base_url');
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 10.0,
            'http_errors' => false,
        ]);
    }

    public function get($endpoint, $query = [])
    {
        try {
            $response = $this->client->get($endpoint, ['query' => $query]);
            return $this->handleResponse($response);
        } catch (RequestException $e) {
            Log::error('API GET Error: ' . $e->getMessage());
            return ['error' => 'Connection failed', 'status' => 500];
        }
    }

    public function post($endpoint, $data = [])
    {
        try {
            $response = $this->client->post($endpoint, ['json' => $data]);
            return $this->handleResponse($response);
        } catch (RequestException $e) {
            Log::error('API POST Error: ' . $e->getMessage());
            return ['error' => 'Connection failed', 'status' => 500];
        }
    }

    public function put($endpoint, $data = [])
    {
        try {
            $response = $this->client->put($endpoint, ['json' => $data]);
            return $this->handleResponse($response);
        } catch (RequestException $e) {
            Log::error('API PUT Error: ' . $e->getMessage());
            return ['error' => 'Connection failed', 'status' => 500];
        }
    }

    public function delete($endpoint)
    {
        try {
            $response = $this->client->delete($endpoint);
            return $this->handleResponse($response);
        } catch (RequestException $e) {
            Log::error('API DELETE Error: ' . $e->getMessage());
            return ['error' => 'Connection failed', 'status' => 500];
        }
    }

    private function handleResponse($response)
    {
        $status = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        $data = json_decode($body, true);

        return [
            'status' => $status,
            'data'   => $data,
            'ok'     => $status >= 200 && $status < 300,
        ];
    }
}
