<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MovieService
{
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('omdb.api_key');
        $this->apiUrl = config('omdb.api_url', 'https://www.omdbapi.com/');
    }

    protected function callOmdb(array $params)
    {
        if (empty($this->apiKey)) {
            Log::error('OMDB API key is missing.');
            return false;
        }

        try {
            $response = Http::timeout(10)
                ->retry(2, 200)
                ->get($this->apiUrl, array_merge([
                    'apikey' => $this->apiKey,
                ], $params));

            if (! $response->successful()) {
                Log::error('OMDB request failed', [
                    'status' => $response->status(),
                    'url'    => $this->apiUrl,
                    'body'   => $response->body(),
                ]);
                return false;
            }

            $data = $response->json();
            if (! is_array($data)) {
                Log::error('OMDB returned invalid JSON', ['body' => $response->body()]);
                return false;
            }

            return $data;
        } catch (\Exception $e) {
            Log::error('OMDB error: ' . $e->getMessage(), [
                'url' => $this->apiUrl,
            ]);
            return false;
        }
    }

    public function search($query, $page = 1)
    {
        $data = $this->callOmdb([
            's'    => $query,
            'page' => $page,
            'type' => 'movie',
        ]);

        if ($data === false) {
            return false;
        }

        if (isset($data['Response']) && $data['Response'] === 'True') {
            return [
                'movies' => $data['Search'] ?? [],
                'total'  => (int) ($data['totalResults'] ?? 0),
                'error'  => null,
            ];
        }

        return [
            'movies' => [],
            'total'  => 0,
            'error'  => $data['Error'] ?? 'Data tidak ditemukan.',
        ];
    }

    public function detail($imdbId)
    {
        $data = $this->callOmdb([
            'i'    => $imdbId,
            'plot' => 'full',
        ]);

        if ($data === false) {
            return false;
        }

        if (isset($data['Response']) && $data['Response'] === 'True') {
            return $data;
        }

        return false;
    }
}