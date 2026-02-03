<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class DopaminMotivasiController extends Controller
{
    protected $apiBaseUrl;
    protected $client;

    public function __construct()
    {
        $this->middleware('auth');
        $this->apiBaseUrl = 'http://mading.farifam.com/api/kata-motivasi';
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
        return view('dopamin_motivasi.index');
    }

    /**
     * Load data for AJAX requests (proxies to external API)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loadData(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            $page = $request->get('page', 1);
            $isActive = $request->get('filter_is_active');

            $queryParams = [
                'per_page' => $perPage,
                'page' => $page,
            ];
            if ($isActive !== null && $isActive !== '') {
                $queryParams['is_active'] = (int) $isActive;
            }

            $response = $this->client->request('GET', $this->apiBaseUrl, [
                'query' => $queryParams,
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            return response()->json($data);
        } catch (RequestException $e) {
            \Log::error('KataMotivasi API Error (loadData): ' . $e->getMessage());
            return response()->json([
                'success' => '0',
                'message' => 'Gagal memuat data dari server',
                'datas' => [],
                'pagination' => null,
            ], 500);
        }
    }

    /**
     * Store a newly created resource (proxies to external API).
     * created_nip is set from logged-in user's email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $createdNip = Auth::user() ? (Auth::user()->email ?? null) : null;

            // Get kata_motivasi from request (support both form_ and direct key for API compatibility)
            $kataMotivasi = $request->input('form_kata_motivasi') ?? $request->input('kata_motivasi') ?? '';

            $payload = [
                'kata_motivasi' => is_string($kataMotivasi) ? trim($kataMotivasi) : $kataMotivasi,
                'dikutip_dari' => trim((string) ($request->input('form_dikutip_dari') ?? $request->input('dikutip_dari') ?? '')) ?: null,
                'created_nip' => $createdNip,
                'is_active' => (int) ($request->input('form_is_active') ?? $request->input('is_active') ?? 1),
            ];

            $options = [
                'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json'],
                'json' => $payload,
            ];

            // Update: send PUT to /{id}
            if ($request->form_id_data && $request->form_id_data != '0' && $request->form_id_data != '') {
                $response = $this->client->request('PUT', $this->apiBaseUrl . '/' . $request->form_id_data, $options);
            } else {
                $response = $this->client->request('POST', $this->apiBaseUrl, $options);
            }

            $data = json_decode($response->getBody()->getContents(), true);
            return response()->json($data);
        } catch (RequestException $e) {
            \Log::error('KataMotivasi API Error (store): ' . $e->getMessage());
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
            $id = $id ?? $request->form_id_data ?? $request->id;
            if ($id == 0 || $id == '' || $id === null) {
                return response()->json(['success' => '0', 'message' => 'ID tidak valid']);
            }

            $response = $this->client->request('DELETE', $this->apiBaseUrl . '/' . $id);
            $data = json_decode($response->getBody()->getContents(), true);
            return response()->json($data);
        } catch (RequestException $e) {
            \Log::error('KataMotivasi API Error (destroy): ' . $e->getMessage());
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
