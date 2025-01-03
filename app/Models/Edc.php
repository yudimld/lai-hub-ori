<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use MongoDB\BSON\Regex; // generate code
use Carbon\Carbon;

class Edc extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Secara eksplisit tetapkan koleksi
        $this->setTable('edc');
    }

    protected $connection = 'mongodb'; // Nama koneksi MongoDB yang telah dikonfigurasi
    protected $collection = 'edc'; // Nama koleksi di MongoDB


    protected $fillable = [
        'spkNumber',
        'requestDate',
        'subject',
        'deskripsi',
        'createdBy',
        'assignee',
        'category',
        'priority',
        'start_date',
        'deadline_date',
        'attachments',
        'status',
        'jenis_biaya',
        'jenis_spk',
        'reason',
    ];

    protected $casts = [
        'requestDate'    => 'date:Y-m-d',
        'start_date'     => 'date:Y-m-d',
        'deadline_date'  => 'date:Y-m-d',
        'attachments'    => 'array',
        'createdAt'      => 'datetime',
        'updatedAt'      => 'datetime',
    ];

    public static function getAggregatedStatusCounts()
    {
        return DB::connection('mongodb')->table('edc')->raw(function ($collection) {
            return $collection->aggregate([
                ['$match' => ['status' => ['$ne' => null]]],
                ['$group' => ['_id' => '$status', 'count' => ['$sum' => 1]]]
            ]);
        });
    }

    public static function getCategoryCounts()
    {
        return DB::connection('mongodb')->table('edc')->raw(function ($collection) {
            return $collection->aggregate([
                ['$group' => ['_id' => '$category', 'count' => ['$sum' => 1]]]
            ]);
        });
    }

    public static function getAssigneeCounts()
    {
        return DB::connection('mongodb')->table('edc')->raw(function ($collection) {
            return $collection->aggregate([
                ['$group' => ['_id' => '$assignee', 'count' => ['$sum' => 1]]]
            ]);
        });
    }

    // halaman assign spk
    public static function getUnassignedSpk()
    {
        return self::where('status', 'Open')->orderBy('created_at', 'desc')->get()->map(function ($spk) {
            logger()->info("Processing SPK with ID: {$spk->_id}", ['attachments' => $spk->attachments]); // Tambahkan log
            return [
                'id'            => isset($spk->_id) ? (string) $spk->_id : null,
                'spkNumber'     => $spk->spkNumber ?? '-',
                'requestDate' => isset($spk->requestDate) ? $spk->requestDate->format('Y-m-d') : '-',
                'subject'       => $spk->subject ?? '-',
                'createdBy'     => $spk->createdBy ?? '-',
                'status'        => $spk->status ?? 'Open',
                'priority'      => $spk->priority ?? '-',
                'category'      => $spk->category ?? '-',
                'assignee'      => $spk->assignee ?? '-',
                'start_date'    => $spk->start_date ?? 'Not Set',
                'deadline_date' => $spk->deadline_date ?? 'Not Set',
                'jenis_biaya'   => $spk->jenis_biaya ?? 'Not Defined',
                'jenis_spk'     => $spk->jenis_spk ?? 'Undefined',
                'deskripsi'   => $spk->deskripsi ?? 'No Description Available',
                'attachments'   => $spk->attachments ?? [], // Pastikan attachments ada
            ];
        })->toArray();
    }
    
    
    public static function getSpkDetails($id)
    {
        return DB::connection('mongodb')->table('edc')->raw(function ($collection) use ($id) {
            $objectId = new \MongoDB\BSON\ObjectId($id);

            return $collection->findOne(['_id' => $objectId]);
        });
    }

    public static function assignSpk($id, $data)
    {
        return DB::connection('mongodb')->table('edc')->raw(function ($collection) use ($id, $data) {
            $objectId = new \MongoDB\BSON\ObjectId($id);

            return $collection->updateOne(
                ['_id' => $objectId],
                ['$set' => $data]
            );
        });
    }

    // halaman list SPK
    // public static function getAllSpks()
    // {
    //     return DB::connection('mongodb')->table('edc')->get()->map(function ($spk) {
               
    //         // Tentukan status berdasarkan kondisi saat ini
    //         $status = $spk->status ?? 'Open'; // Default status 'Open'
            
    //         if ($status === 'Open') {
    //             // Jika status saat ini 'Open', cek apakah semua field sudah lengkap
    //             $isComplete = isset($spk->assignee, $spk->priority, $spk->category, $spk->start_date, $spk->deadline_date, $spk->jenis_biaya, $spk->jenis_spk) &&
    //                           !empty($spk->assignee) &&
    //                           !empty($spk->priority) &&
    //                           !empty($spk->category) &&
    //                           !empty($spk->start_date) &&
    //                           !empty($spk->deadline_date) &&
    //                           !empty($spk->jenis_biaya) &&
    //                           !empty($spk->jenis_spk);
    
    //             if ($isComplete) {
    //                 $status = 'Assigned'; // Ubah status ke 'Assigned' jika semua field lengkap
    //             }
    //         }
    
    //         return [
    //             'id'            => isset($spk->id) && $spk->id instanceof \MongoDB\BSON\ObjectId ? (string) $spk->id : null,
    //             'spkNumber'     => $spk->spkNumber ?? '-',
    //             'requestDate'   => $spk->requestDate ?? '-',
    //             'subject'       => $spk->subject ?? '-',
    //             'createdBy'     => $spk->createdBy ?? '-',
    //             'status'        => $status, // Status berdasarkan kondisi
    //             'priority'      => $spk->priority ?? '-',
    //             'category'      => $spk->category ?? '-',
    //             'assignee'      => $spk->assignee ?? 'Unassigned',
    //             'start_date'    => $spk->start_date ?? '-',
    //             'deadline_date' => $spk->deadline_date ?? '-',
    //             'jenis_biaya'   => $spk->jenis_biaya ?? '-',
    //             'jenis_spk'     => $spk->jenis_spk ?? '-',
    //             'description'   => $spk->deskripsi ?? 'No Description Available', // Tambahkan description
    //             'attachments' => isset($spk->attachments) ? (is_string($spk->attachments) ? json_decode($spk->attachments, true) : $spk->attachments) : [],

    //         ];
    //     })->toArray();
    // }
    public static function getAllSpks()
{
    return DB::connection('mongodb')->table('edc')->get()
        ->filter(function ($spk) {
            // Filter data dengan status 'Request to Reject'
            return ($spk->status ?? 'Open') !== 'Request to Reject';
        })
        ->map(function ($spk) {
            // Tentukan status berdasarkan kondisi saat ini
            $status = $spk->status ?? 'Open'; // Default status 'Open'
            
            if ($status === 'Open') {
                // Jika status saat ini 'Open', cek apakah semua field sudah lengkap
                $isComplete = isset($spk->assignee, $spk->priority, $spk->category, $spk->start_date, $spk->deadline_date, $spk->jenis_biaya, $spk->jenis_spk) &&
                              !empty($spk->assignee) &&
                              !empty($spk->priority) &&
                              !empty($spk->category) &&
                              !empty($spk->start_date) &&
                              !empty($spk->deadline_date) &&
                              !empty($spk->jenis_biaya) &&
                              !empty($spk->jenis_spk);
    
                if ($isComplete) {
                    $status = 'Assigned'; // Ubah status ke 'Assigned' jika semua field lengkap
                }
            }
    
            return [
                'id'            => isset($spk->id) && $spk->id instanceof \MongoDB\BSON\ObjectId ? (string) $spk->id : null,
                'spkNumber'     => $spk->spkNumber ?? '-',
                'requestDate'   => $spk->requestDate ?? '-',
                'subject'       => $spk->subject ?? '-',
                'createdBy'     => $spk->createdBy ?? '-',
                'status'        => $status, // Status berdasarkan kondisi
                'priority'      => $spk->priority ?? '-',
                'category'      => $spk->category ?? '-',
                'assignee'      => $spk->assignee ?? 'Unassigned',
                'start_date'    => $spk->start_date ?? '-',
                'deadline_date' => $spk->deadline_date ?? '-',
                'jenis_biaya'   => $spk->jenis_biaya ?? '-',
                'jenis_spk'     => $spk->jenis_spk ?? '-',
                'description'   => $spk->deskripsi ?? 'No Description Available', // Tambahkan description
                'attachments'   => isset($spk->attachments) ? (is_string($spk->attachments) ? json_decode($spk->attachments, true) : $spk->attachments) : [],
            ];
        })->toArray();
}


    // halaman create SPK
    public function storeSpk(Request $request)
    {
        // Validasi input
        $request->validate([
            'spkNumber' => 'required|string|max:50',
            'requestDate' => 'required|date',
            'subject' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:1000',
            'attachments.*' => 'nullable|file|max:3072|mimes:jpg,jpeg,bmp,png,xls,xlsx,doc,docx,pdf,txt,ppt,pptx',
        ]);

        // Siapkan data untuk disimpan
        $data = [
            'spkNumber' => $request->input('spkNumber'),
            'requestDate' => $request->input('requestDate'),
            'subject' => $request->input('subject'),
            'deskripsi' => $request->input('deskripsi'),
            'createdBy' => Auth::user()->id_card ?? 'guest',
            'status' => 'Open', // Status default
        ];

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');
                $attachments[] = [
                    'originalName' => $file->getClientOriginalName(),
                    'path' => $path,
                ];
            }
        }

        // Simpan data menggunakan model
        Edc::create($data);
        

        return redirect()->route('list-spk')->with('success', 'SPK successfully created.');
    }

    public static function generateSpkNumber()
    {
        $idCard = Auth::user()->id_card ?? abort(403, 'User does not have a valid ID card');
        $currentDate = date('ym'); // Format YYMM
    
        logger()->info("Generating Global SPK Number for ID Card: {$idCard}, Date: {$currentDate}");
    
        // Regex global mencocokkan berdasarkan tanggal (tanpa id_card)
        $regex = new \MongoDB\BSON\Regex("-{$currentDate}-", 'i');
    
        try {
            // Query MongoDB untuk menemukan nomor SPK terakhir secara global
            $lastSpk = DB::connection('mongodb')->getMongoClient()
                ->selectCollection('lai-hub', 'edc')
                ->find(
                    ['spkNumber' => $regex],
                    [
                        'sort' => ['created_at' => -1],
                        'projection' => ['spkNumber' => 1],
                        'limit' => 1
                    ]
                )->toArray();
    
            $lastSpk = $lastSpk[0] ?? null; // Ambil dokumen pertama jika ada
            logger()->info("Last Global SPK Found", ['result' => $lastSpk]);
        } catch (\Exception $e) {
            logger()->error("MongoDB Query Error", ['error' => $e->getMessage()]);
            abort(500, 'Database query failed.');
        }
    
        // Ambil angka increment terakhir
        $lastIncrement = 0;
        if ($lastSpk && isset($lastSpk['spkNumber'])) {
            $parts = explode('-', $lastSpk['spkNumber']);
            if (count($parts) === 3 && is_numeric($parts[2])) {
                $lastIncrement = (int) $parts[2];
            }
        }
    
        // Tambahkan increment untuk nomor baru
        $newIncrement = $lastIncrement + 1;
        $formattedIncrement = str_pad($newIncrement, 5, '0', STR_PAD_LEFT);
    
        // Bangun nomor SPK baru dengan ID Card
        $spkNumber = "{$idCard}-{$currentDate}-{$formattedIncrement}";
        logger()->info("Generated Global SPK Number", ['spk_number' => $spkNumber]);
    
        return $spkNumber;
    }
    
    
    // Fungsi untuk memperbarui status
    public static function updateStatus($id, $status)
    {
        try {
            // Cari dokumen berdasarkan ID
            $spk = self::find($id);
            if (!$spk) {
                return false; // Jika dokumen tidak ditemukan
            }

            // Perbarui status
            $spk->status = $status;
            $spk->save();

            return true; // Indikator sukses
        } catch (\Exception $e) {
            // Tangani error
            \Log::error('Error updating status: ' . $e->getMessage());
            return false;
        }
    }
    






    

}
