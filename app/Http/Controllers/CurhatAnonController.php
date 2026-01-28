<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class CurhatAnonController extends Controller
{
    protected $apiBaseUrl;
    protected $client;

    public function __construct(){
        $this->middleware('auth');
        $this->apiBaseUrl = 'http://mading.farifam.com/api/curhat-anon';
        $this->client = new Client([
            'timeout' => 30,
            'verify' => false // Set to true in production if SSL is properly configured
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Define status options (same as in the model)
        $list_status_verifikasi = array(
            1 => "Belum Verifikasi",
            2 => "Disetujui",
            3 => "Tidak Disetujui",
        );
        
        return view('curhat_anon.index', compact('list_status_verifikasi'));
    }

    /**
     * Load data for AJAX requests
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loadData(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            $filterStatus = $request->get('filter_status_verifikasi');
            $page = $request->get('page', 1);
            
            $queryParams = [
                'per_page' => $perPage,
                'page' => $page
            ];
            
            if ($filterStatus && $filterStatus !== '') {
                $queryParams['filter_status_verifikasi'] = $filterStatus;
            }
            
            $response = $this->client->request('GET', $this->apiBaseUrl . '/load-data', [
                'query' => $queryParams
            ]);
            
            $data = json_decode($response->getBody()->getContents(), true);
            
            return response()->json($data);
        } catch (RequestException $e) {
            \Log::error('CurhatAnon API Error (loadData): ' . $e->getMessage());
            return response()->json([
                'success' => '0',
                'message' => 'Gagal memuat data dari server',
                'datas' => [],
                'pagination' => null
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $response = $this->client->request('POST', $this->apiBaseUrl, [
                'form_params' => [
                    'form_id_data' => $request->form_id_data ?? 0,
                    'form_content' => $request->form_content,
                    'form_status_verifikasi' => $request->form_status_verifikasi ?? 1
                ]
            ]);
            
            $data = json_decode($response->getBody()->getContents(), true);
            
            return response()->json($data);
        } catch (RequestException $e) {
            \Log::error('CurhatAnon API Error (store): ' . $e->getMessage());
            $statusCode = $e->hasResponse() ? $e->getResponse()->getStatusCode() : 500;
            $errorBody = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : 'Unknown error';
            
            try {
                $errorData = json_decode($errorBody, true);
                return response()->json($errorData, $statusCode);
            } catch (\Exception $ex) {
                return response()->json([
                    'success' => '0',
                    'message' => 'Gagal menyimpan data ke server'
                ], $statusCode);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $id = $request->form_id_data ?? $request->id;
            
            if ($id == 0 || $id == '') {
                return response()->json(['success' => '0', 'message' => 'ID tidak valid']);
            }
            
            $response = $this->client->request('POST', $this->apiBaseUrl . '/destroy', [
                'form_params' => [
                    'form_id_data' => $id
                ]
            ]);
            
            $data = json_decode($response->getBody()->getContents(), true);
            
            return response()->json($data);
        } catch (RequestException $e) {
            \Log::error('CurhatAnon API Error (destroy): ' . $e->getMessage());
            $statusCode = $e->hasResponse() ? $e->getResponse()->getStatusCode() : 500;
            $errorBody = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : 'Unknown error';
            
            try {
                $errorData = json_decode($errorBody, true);
                return response()->json($errorData, $statusCode);
            } catch (\Exception $ex) {
                return response()->json([
                    'success' => '0',
                    'message' => 'Gagal menghapus data dari server'
                ], $statusCode);
            }
        }
    }

    /**
     * Get approved curhats for public display
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getApprovedCurhats(Request $request)
    {
        try {
            $limit = $request->get('limit', 10);
            
            $response = $this->client->request('GET', $this->apiBaseUrl . '/approved', [
                'query' => [
                    'limit' => $limit
                ]
            ]);
            
            $data = json_decode($response->getBody()->getContents(), true);
            
            return response()->json($data);
        } catch (RequestException $e) {
            \Log::error('CurhatAnon API Error (getApprovedCurhats): ' . $e->getMessage());
            return response()->json([
                'success' => '0',
                'message' => 'Gagal memuat data dari server',
                'datas' => []
            ], 500);
        }
    }

    /**
     * Get pending curhat count (for sidebar badge)
     * This is a static helper method that can be called from views
     *
     * @return int
     */
    public static function getPendingCount()
    {
        try {
            $client = new Client([
                'timeout' => 5,
                'verify' => false
            ]);
            
            $apiBaseUrl = 'http://mading.farifam.com/api/curhat-anon';
            
            $response = $client->request('GET', $apiBaseUrl . '/load-data', [
                'query' => [
                    'filter_status_verifikasi' => 1,
                    'per_page' => 1,
                    'page' => 1
                ]
            ]);
            
            $data = json_decode($response->getBody()->getContents(), true);
            
            if (isset($data['pagination']['total'])) {
                return (int) $data['pagination']['total'];
            }
            
            return 0;
        } catch (\Exception $e) {
            \Log::error('CurhatAnon API Error (getPendingCount): ' . $e->getMessage());
            return 0;
        }
    }
}

