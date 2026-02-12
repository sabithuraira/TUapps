<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class DopaminSpadaController extends Controller
{
    protected $apiBaseUrl;
    protected $client;

    public function __construct()
    {
        $this->middleware('auth');
        $this->apiBaseUrl = 'http://mading.farifam.com/api/spada-question';
        $this->client = new Client([
            'timeout' => 30,
            'verify' => false,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $unitKerjas = config('app.unit_kerjas', []);
        $satkerOptions = [];
        foreach ($unitKerjas as $code => $label) {
            $satkerOptions['16' . $code] = $label;
        }
        return view('dopamin_spada.index', compact('satkerOptions'));
    }

    /**
     * Show hasil (list of answers) for a question - dedicated page.
     *
     * @param  int  $questionId
     * @return \Illuminate\Http\Response
     */
    public function showHasil($questionId)
    {
        return view('dopamin_spada.hasil', [
            'questionId' => $questionId,
        ]);
    }

    /**
     * Load data for AJAX requests (proxies to external API).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loadData(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            $page = $request->get('page', 1);

            $queryParams = [
                'per_page' => $perPage,
                'page' => $page,
            ];

            $response = $this->client->request('GET', $this->apiBaseUrl, [
                'query' => $queryParams,
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            return response()->json($data);
        } catch (RequestException $e) {
            \Log::error('SpadaQuestion API Error (loadData): ' . $e->getMessage());
            return response()->json([
                'success' => '0',
                'message' => 'Gagal memuat data dari server',
                'datas' => [],
                'pagination' => null,
            ], 500);
        }
    }

    /**
     * Store a newly created resource or update (proxies to external API).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $question = $request->input('form_question') ?? $request->input('question') ?? '';
            $typeQuestion = (int) ($request->input('form_type_question') ?? $request->input('type_question') ?? 0);
            $startActive = $request->input('form_start_active') ?? $request->input('start_active') ?? '';
            $lastActive = $request->input('form_last_active') ?? $request->input('last_active') ?? '';
            $validateRule = $request->input('form_validate_rule') ?? $request->input('validate_rule');
            $satker = $request->input('form_satker') ?? $request->input('satker') ?? '';

            $payload = [
                'question' => is_string($question) ? trim($question) : $question,
                'type_question' => $typeQuestion,
                'start_active' => $startActive ?: null,
                'last_active' => $lastActive ?: null,
                'validate_rule' => $validateRule ? trim((string) $validateRule) : null,
                'satker' => $satker ? substr((string) $satker, 0, 4) : null,
            ];

            $options = [
                'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json'],
                'json' => $payload,
            ];

            $idData = $request->input('form_id_data') ?? $request->input('id');
            if ($idData && $idData != '0' && $idData != '') {
                $response = $this->client->request('PUT', $this->apiBaseUrl . '/' . $idData, $options);
            } else {
                $response = $this->client->request('POST', $this->apiBaseUrl, $options);
            }

            $data = json_decode($response->getBody()->getContents(), true);
            return response()->json($data);
        } catch (RequestException $e) {
            \Log::error('SpadaQuestion API Error (store): ' . $e->getMessage());
            $statusCode = $e->hasResponse() ? $e->getResponse()->getStatusCode() : 500;
            $errorBody = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : 'Unknown error';
            try {
                $errorData = json_decode($errorBody, true);
                return response()->json($errorData ?: ['success' => '0', 'message' => 'Gagal menyimpan data'], $statusCode);
            } catch (\Exception $ex) {
                return response()->json(['success' => '0', 'message' => 'Gagal menyimpan data ke server'], $statusCode);
            }
        }
    }

    /**
     * Remove the specified resource (proxies to external API).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id = null)
    {
        try {
            $id = $id ?? $request->input('form_id_data') ?? $request->input('id');
            if ($id === null || $id === '' || $id === '0') {
                return response()->json(['success' => '0', 'message' => 'ID tidak valid']);
            }

            $response = $this->client->request('DELETE', $this->apiBaseUrl . '/' . $id);
            $data = json_decode($response->getBody()->getContents(), true);
            return response()->json($data);
        } catch (RequestException $e) {
            \Log::error('SpadaQuestion API Error (destroy): ' . $e->getMessage());
            $statusCode = $e->hasResponse() ? $e->getResponse()->getStatusCode() : 500;
            $errorBody = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : 'Unknown error';
            try {
                $errorData = json_decode($errorBody, true);
                return response()->json($errorData ?: ['success' => '0', 'message' => 'Gagal menghapus data'], $statusCode);
            } catch (\Exception $ex) {
                return response()->json(['success' => '0', 'message' => 'Gagal menghapus data dari server'], $statusCode);
            }
        }
    }
}
