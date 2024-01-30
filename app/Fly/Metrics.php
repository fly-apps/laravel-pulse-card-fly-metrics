<?php

namespace App\Fly;


class Metrics
{
    public function http_requests(string $slug, int $start, int $end, string $step='15m'): array
    {
        $data = (new MetricsApi)->http_requests($slug, $start, $end, $step);

        $labels = [];
        $datasets = [];

        // We build up our labels first, so we can fill in
        // dataset "gaps" with a zero value
        foreach($data['data']['result'] ?? [] as $key => $result) {
            foreach($result['values'] as $value) {
                $labels[] = date('H:i:s', $value[0]);
            }
        }

        // Remove repeated labels and sort asc
        $labels = array_unique($labels);
        sort($labels);

        // Parse through the data, filling in "gaps"
        // (no values for a label) with a zero value
        foreach($data['data']['result'] ?? [] as $key => $result) {
            $datasets[$key] = ['label' => $result['metric']['status'], 'borderWidth' => 1, 'spanGaps' => false];
            $datasets[$key]['data'] = [];

            // This is a bit funky, but we do some logic in here to
            // fill in data sets with "gaps" in the time series with
            // a zero value
            foreach($labels as $label) {
                foreach($result['values'] as $value) {
                    $l = date('H:i:s', $value[0]);

                    // If the current value matches a label,
                    // we add a value
                    if($label == $l) {
                        $datasets[$key]['data'][$label] = $value[1];
                    } else {
                        // Else we set a value of zero, unless this label
                        // already isset (it might be set with zero or greater)
                        if (! isset($datasets[$key]['data'][$label])) {
                            $datasets[$key]['data'][$label] = 0;
                        }
                    }
                }
            }

            // Clean up the data, which can be just "plain" arrays instead
            // of associated arrays. This isn't necessary but outputs less
            // cruft into the HTML
            $datasets[$key]['data'] = array_values($datasets[$key]['data']);
        }

        return [
            'labels' => $labels,
            'datasets' => $datasets,
        ];
    }
}
