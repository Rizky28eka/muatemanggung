<?php

namespace App\Services;

use App\Models\Mua;
use App\Models\SearchLog;

class RecommendationService
{
    public function __construct(private VectorBuilderService $vectorBuilder) {}

    /**
     * Returns top 3 MUA with scores, saves search log.
     * @return array{results: array, log: SearchLog}
     */
    public function recommend(array $preferences, string $sessionId): array
    {
        $prefVector = $this->vectorBuilder->buildFromPreferences($preferences);

        $muas = Mua::where('is_active', true)
            ->whereHas('vector')
            ->with(['vector', 'district', 'makeupLooks', 'eventTypes', 'packages' => fn ($q) => $q->where('is_available', true)])
            ->get();

        $scored = [];
        foreach ($muas as $mua) {
            $score = $this->cosineSimilarity($prefVector, $mua->vector->vector_data);
            if ($score > 0) {
                $scored[] = ['mua' => $mua, 'score' => round($score * 100, 1)];
            }
        }

        usort($scored, fn ($a, $b) => $b['score'] <=> $a['score']);
        $top3 = array_slice($scored, 0, 3);

        $log = SearchLog::create([
            'session_id'       => $sessionId,
            'preference_data'  => $preferences,
            'top1_mua_id'      => $top3[0]['mua']->id ?? null,
            'top2_mua_id'      => $top3[1]['mua']->id ?? null,
            'top3_mua_id'      => $top3[2]['mua']->id ?? null,
            'similarity_scores'=> array_map(fn ($r) => ['mua_id' => $r['mua']->id, 'score' => $r['score']], $top3),
        ]);

        return ['results' => $top3, 'log' => $log];
    }

    private function cosineSimilarity(array $a, array $b): float
    {
        $dot  = 0;
        $magA = 0;
        $magB = 0;
        $len  = max(count($a), count($b));

        for ($i = 0; $i < $len; $i++) {
            $ai = $a[$i] ?? 0;
            $bi = $b[$i] ?? 0;
            $dot  += $ai * $bi;
            $magA += $ai ** 2;
            $magB += $bi ** 2;
        }

        if ($magA === 0 || $magB === 0) {
            return 0.0;
        }

        return $dot / (sqrt($magA) * sqrt($magB));
    }
}
