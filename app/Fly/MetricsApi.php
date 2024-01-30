<?php

namespace App\Fly;


use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MetricsApi
{
    public function http_requests(string $slug, int $start, int $end, string $step='15m'): array
    {
        // TODO: Cache these for when Fly has minor outages
        try {
            $response = $this->client()->post('prometheus/'.config('services.fly.organization').'/api/v1/query_range', [
                'query' => 'sum(increase(fly_app_http_responses_count{app="'.$slug.'"})) by (status) > 0',
                'start' => $start,
                'end' => $end,
                'step' => $step,
            ]);

            if (! $response->successful()) {
                Log::error('could not get http request metrics', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return [];
            }

            return $response->json();
        } catch(ConnectionException $e) {
            Log::error($e);
            return [];
        }
    }

    public function client()
    {
        return Http::withToken(config('services.fly.api_token'))
            ->asForm()
            ->acceptJson()
//            ->throw()
            ->timeout(4)
            ->baseUrl('https://api.fly.io/');
    }
}
