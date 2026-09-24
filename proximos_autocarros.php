<?php
/**
 * proximos_autocarros.php
 *
 * Vai buscar as próximas passagens ao(s) endpoint(s) do Qmob, junta tudo,
 * guarda em cache e devolve JSON limpo para o ecrã do café.
 *
 * O ecrã só fala com ESTE ficheiro (nunca diretamente com o Qmob), por isso
 * mesmo que o monitor atualize de 30 em 30 segundos, o Qmob só é contactado
 * uma vez por CACHE_TTL.
 */

declare(strict_types=1);

date_default_timezone_set('Europe/Lisbon');

// ---------- CONFIGURAÇÃO ----------
const ENDPOINTS = [
    // Um lado da estrada e o outro. Agrinha (Carreira), Famalicão.
    'https://services.qmob.pt/v3/busdata/stop?stop_id=MOBVNF:11003',
    'https://services.qmob.pt/v3/busdata/stop?stop_id=MOBVNF:11004',
];
const STOP_LABEL      = 'Agrinha (Carreira)';
const CACHE_TTL       = 30;    // segundos entre pedidos reais à API
const STALE_MAX_AGE   = 600;   // se a API falhar, usa a cache antiga até 10 min
const MAX_DEPARTURES  = 5;     // quantas passagens mostrar no ecrã
const MAX_HORIZON_MIN = 180;   // ignora passagens a mais de 3 h
const GRACE_MIN       = 10;    // continua a mostrar até 10 min DEPOIS da hora prevista (pode estar atrasado)

// Tradução dos estados que a API devolve
const STATUS_LABELS = [
    'ONTIME'  => 'A horas',
    'DELAYED' => 'Atrasado',
    'EARLY'   => 'Adiantado',
    'LATE'    => 'Atrasado',
];

$cacheFile = sys_get_temp_dir() . '/autocarros_agrinha_cache.json';

// ---------- MODO DE TESTE ----------
// Abre proximos_autocarros.php?test=1 no browser (ou muda o ENDPOINT no
// widget para isto temporariamente) para ver dados falsos, sem depender
// da API real. Nunca ativa sozinho: só com o parâmetro no URL.
if (isset($_GET['test'])) {
    $now = time();
    $mock = [
        ['line' => '453', 'destination' => 'Carreira (Fojo)', 'via' => 'Pedome', 'status' => 'A horas', 'chegando' => false, 'agency' => 'MOB', 'operator' => 'SBST', 'time' => date('H:i', $now + 4 * 60), 'minutes' => 4],
        ['line' => '453', 'destination' => 'Carreira (Fojo)', 'via' => 'Pedome', 'status' => 'A horas', 'chegando' => false, 'agency' => 'MOB', 'operator' => 'SBST', 'time' => date('H:i', $now + 4 * 60), 'minutes' => 4],
        ['line' => '451', 'destination' => 'Pedro Marques (Delães)', 'via' => 'Ruivães (Cova)', 'status' => 'Atrasado', 'chegando' => false, 'agency' => 'MOB', 'operator' => 'SBST', 'time' => date('H:i', $now + 28 * 60), 'minutes' => 28],
        ['line' => '9803', 'destination' => 'Vizela (Centro de Saúde)', 'via' => '', 'status' => 'A horas', 'chegando' => false, 'agency' => 'AVE', 'operator' => 'AVE MOBILIDADE', 'time' => date('H:i', $now + 41 * 60), 'minutes' => 41],
        ['line' => '453', 'destination' => 'Fojo (Carreira)', 'via' => 'Pedome', 'status' => 'A horas', 'chegando' => false, 'agency' => 'MOB', 'operator' => 'SBST', 'time' => date('H:i', $now + 62 * 60), 'minutes' => 62],
    ];

    // ?test=vazio -> testa o estado "sem passagens"
    // ?test=falha -> testa o estado "informação indisponível"
    if ($_GET['test'] === 'vazio') {
        $mock = [];
    }

    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
    echo json_encode([
        'ok'         => $_GET['test'] !== 'falha',
        'stale'      => $_GET['test'] === 'stale',
        'stop'       => STOP_LABEL,
        'departures' => $mock,
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// ---------- FUNÇÕES ----------
function fetchJson(string $url): ?array
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 3,
        CURLOPT_TIMEOUT        => 5,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTPHEADER     => [
            'Accept: application/json',
            'Referer: https://www.qmob.pt/',
            'Origin: https://www.qmob.pt',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0 Safari/537.36',
        ],
        // Aponta para o ficheiro de certificados (resolve erro 60: SSL
        // certificate problem: unable to get local issuer certificate).
        // Descarrega de https://curl.se/ca/cacert.pem e coloca-o nesta pasta.
        CURLOPT_CAINFO         => __DIR__ . '/cacert.pem',
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
    ]);
    $body = curl_exec($ch);
    $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($body === false || $code !== 200) {
        return null;
    }
    $data = json_decode($body, true);
    return is_array($data) ? $data : null;
}

/**
 * Extrai todas as passagens de uma resposta do Qmob.
 * Os campos *_ms são tempos RELATIVOS ao "time_utc" da própria resposta,
 * por isso a hora absoluta = time_utc + arrival_ms.
 */
function collectDepartures(array $data): array
{
    $out  = [];
    $base = isset($data['time_utc']) ? ((float) $data['time_utc']) / 1000 : (float) time();

    foreach (($data['services'] ?? []) as $service) {
        foreach (['next', 'subsequent', 'next2', 'next3', 'next4'] as $key) {
            $p = $service[$key] ?? null;
            if (!is_array($p)) {
                continue;
            }
            $ms = $p['departure_ms'] ?? $p['arrival_ms'] ?? null;
            if ($ms === null) {
                continue;
            }

            // "via X" extraído do nome longo da rota, ex.:
            // "CARREIRA (FOJO) - ESCOLA ... (JOANE) VIA PEDOME" -> "Pedome"
            $via = '';
            $longName = (string) ($p['original_route_long_name'] ?? '');
            if (preg_match('/\bVIA\s+(.+)$/ui', $longName, $m)) {
                $via = mb_convert_case(trim($m[1]), MB_CASE_TITLE, 'UTF-8');
            }

            $out[] = [
                'ts'          => (int) round($base + ((float) $ms) / 1000),
                'line'        => (string) ($p['line'] ?? $service['no'] ?? '?'),
                // último destino (nome limpo), não o nome da rota inteira
                'destination' => (string) ($p['destination'] ?? $p['last_stop_name'] ?? ''),
                'via'         => $via,
                'status'      => (string) ($p['load'] ?? ''),
                'agency'      => (string) ($service['agency'] ?? ''),
                'operator'    => (string) ($service['operator'] ?? ''),
                'trip_id'     => (string) ($p['trip_id'] ?? ''),
            ];
        }
    }
    return $out;
}

function loadCache(string $file): ?array
{
    if (!is_file($file)) {
        return null;
    }
    $data = json_decode((string) file_get_contents($file), true);
    return is_array($data) ? $data : null;
}

// ---------- LÓGICA ----------
$now   = time();
$cache = loadCache($cacheFile);
$stale = false;

$isFresh = $cache !== null && ($now - (int) ($cache['fetched_at'] ?? 0)) < CACHE_TTL;

if (!$isFresh) {
    $all = [];
    $ok  = false;

    foreach (ENDPOINTS as $url) {
        $data = fetchJson($url);
        if ($data === null) {
            continue;
        }
        $ok  = true;
        $all = array_merge($all, collectDepartures($data));
    }

    if ($ok) {
        // Tira duplicados (a mesma viagem pode vir de duas paragens/pedidos)
        $unique = [];
        foreach ($all as $d) {
            $key = $d['trip_id'] !== '' ? $d['trip_id'] . '|' . $d['line'] : $d['line'] . '|' . $d['ts'];
            $unique[$key] = $d;
        }
        $all = array_values($unique);
        usort($all, fn($a, $b) => $a['ts'] <=> $b['ts']);

        $cache = ['fetched_at' => $now, 'departures' => $all];
        file_put_contents($cacheFile, json_encode($cache), LOCK_EX);
    } elseif ($cache !== null && ($now - (int) ($cache['fetched_at'] ?? 0)) <= STALE_MAX_AGE) {
        $stale = true;   // API em baixo: mostra o que tínhamos, marcado como desatualizado
    } else {
        $cache = null;   // sem dados fiáveis
    }
}

// ---------- RESPOSTA ----------
$departures = [];
foreach (($cache['departures'] ?? []) as $d) {
    $minutes = (int) floor(($d['ts'] - $now) / 60);
    if ($minutes < -GRACE_MIN || $minutes > MAX_HORIZON_MIN) {
        continue;
    }

    // Depois da hora prevista (ou mesmo agora), o autocarro pode só estar
    // atrasado. Em vez de "-3 min", mostra "a chegar".
    $chegando = $minutes <= 0;
    $statusBruto = strtoupper($d['status']);
    $statusLabel = $chegando
        ? 'A chegar'
        : (STATUS_LABELS[$statusBruto] ?? ($d['status'] !== '' ? $d['status'] : ''));

    $departures[] = [
        'line'        => $d['line'],
        'destination' => $d['destination'],
        'via'         => $d['via'],
        'status'      => $statusLabel,
        'chegando'    => $chegando,
        'agency'      => $d['agency'],
        'operator'    => $d['operator'],
        'time'        => date('H:i', $d['ts']),
        'minutes'     => $minutes,
    ];
    if (count($departures) >= MAX_DEPARTURES) {
        break;
    }
}

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
echo json_encode([
    'ok'         => $cache !== null,
    'stale'      => $stale,
    'stop'       => STOP_LABEL,
    'departures' => $departures,
], JSON_UNESCAPED_UNICODE);