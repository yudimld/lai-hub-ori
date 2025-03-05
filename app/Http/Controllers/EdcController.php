<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use MongoDB\Client as MongoDBClient;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\ObjectId;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

// email
use App\Mail\Edc\CreateSPKMail;
use App\Mail\Edc\AssignSPKMail;
use App\Mail\Edc\RequestRejectSPKMail;
use App\Mail\Edc\RejectSPKMail;
use Illuminate\Support\Facades\Mail;

use App\Models\Edc;
use App\Models\User;



class EdcController extends Controller
{

    // public function dashboard()
    // {
    //     session(['active_menu' => 'edc']);
    
    //     try {
    //         // Data status SPK
    //         $rawData = Edc::getAggregatedStatusCounts();
    //         $statusData = [];
    //         foreach ($rawData as $item) {
    //             $statusData[$item->_id] = $item->count ?? 0;
    //         }
    //         $openCount = $statusData['Open'] ?? 0;
    //         $assignCount = $statusData['Assigned'] ?? 0;
    //         $requestToCloseCount = $statusData['Request to Close'] ?? 0;
    //         $closedCount = $statusData['Closed'] ?? 0;
    
    //         // Data prioritas dan assignee
    //         $priorityData = Edc::getPriorityCountsByAssignee();
    //         $priorityData = iterator_to_array($priorityData);

    
    //         $assignees = [];
    //         $majorData = [];
    //         $minorData = [];
    //         $totalSPKByAssignee = [];
    //         foreach ($priorityData as $item) {
    //             $assignee = $item->_id['assignee'] ?? 'Unknown';
    //             $priority = $item->_id['priority'] ?? 'Unknown';
    //             $count = $item['count'] ?? 0;
    
    //             if ($assignee === 'Unknown') {
    //                 continue; // Skip data dengan assignee Unknown
    //             }
    
    //             if (!in_array($assignee, $assignees)) {
    //                 $assignees[] = $assignee;
    //                 $majorData[$assignee] = 0;
    //                 $minorData[$assignee] = 0;
    //             }
    
    //             if ($priority === 'major') {
    //                 $majorData[$assignee] += $count;
    //             } elseif ($priority === 'minor') {
    //                 $minorData[$assignee] += $count;
    //             }
    
    //             $totalSPKByAssignee[$assignee] = ($totalSPKByAssignee[$assignee] ?? 0) + $count;
    //         }
    
    //         // Format data untuk chart prioritas
    //         $majorChartData = [];
    //         $minorChartData = [];
    //         foreach ($assignees as $assignee) {
    //             $majorChartData[] = $majorData[$assignee] ?? 0;
    //             $minorChartData[] = $minorData[$assignee] ?? 0;
    //         }
    
    //         // Data total fee berdasarkan assignee (dengan pembagian)
    //         $adjustedAmountOfFeeData = Edc::getAdjustedAmountOfFeeByAssignee();
    //         $assigneeNames = [];
    //         $assigneeFees = [];
    //         $totalFees = 0; // Tambahkan inisialisasi $totalFees

    //         foreach ($adjustedAmountOfFeeData as $item) {
    //             $assignee = $item->_id ?? 'Unknown';
    //             if ($assignee === 'Unknown') {
    //                 continue; // Skip data dengan assignee Unknown
    //             }

    //             $fee = $item->total_fee ?? 0;
    //             $assigneeNames[] = $assignee;
    //             $assigneeFees[] = $fee;
    //             $totalFees += $fee; // Hitung total fees
    //         }

    //         // Pastikan $totalFees dikirimkan ke view jika digunakan
    //         return view('edc.dashboard', compact(
    //             'openCount',
    //             'assignCount',
    //             'requestToCloseCount',
    //             'closedCount',
    //             'assignees',
    //             'majorChartData',
    //             'minorChartData',
    //             'totalSPKByAssignee',
    //             'assigneeNames',
    //             'assigneeFees',
    //             'totalFees' // Kirimkan variabel $totalFees ke view
    //         ));
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    public function dashboard()
    {
        session(['active_menu' => 'edc']);
    
        try {
            // Data status SPK
            $rawData = Edc::getAggregatedStatusCounts();
            $statusData = [];
            foreach ($rawData as $item) {
                $statusData[$item->_id] = $item->count ?? 0;
            }
            $openCount = $statusData['Open'] ?? 0;
            $assignCount = $statusData['Assigned'] ?? 0;
            $requestToCloseCount = $statusData['Request to Close'] ?? 0;
            $closedCount = $statusData['Closed'] ?? 0;
    
            // Ambil data SPK beserta team_members dari database
            $spkData = Edc::getSPKWithTeamMembers();
            $spkData = iterator_to_array($spkData);
    
            $assignees = [];
            $majorData = [];
            $minorData = [];
            $totalSPKByAssignee = [];
            $assigneeLabels = []; // Tambahkan untuk label baru
    
            foreach ($spkData as $item) {
                $assignee = $item['assignee'] ?? null;
                $teamMembers = $item['team_members'] ?? [];
                $priority = $item['priority'] ?? 'Unknown';
    
                if (empty($assignee)) {
                    continue; // Skip data dengan assignee kosong/null
                }
    
                // Inisialisasi data assignee
                if (!in_array($assignee, $assignees)) {
                    $assignees[] = $assignee;
                    $majorData[$assignee] = 0;
                    $minorData[$assignee] = 0;
                }
    
                // Hitung SPK untuk assignee
                $totalSPKByAssignee[$assignee] = ($totalSPKByAssignee[$assignee] ?? 0) + 1;
    
                // Hitung SPK untuk team members
                foreach ($teamMembers as $member) {
                    if (!empty($member)) { // Pastikan team member tidak kosong
                        $totalSPKByAssignee[$member] = ($totalSPKByAssignee[$member] ?? 0) + 1;
                    }
                }
    
                // Hitung data prioritas
                if ($priority === 'major') {
                    $majorData[$assignee]++;
                    foreach ($teamMembers as $member) {
                        if (!empty($member)) {
                            $majorData[$member] = ($majorData[$member] ?? 0) + 1;
                        }
                    }
                } elseif ($priority === 'minor') {
                    $minorData[$assignee]++;
                    foreach ($teamMembers as $member) {
                        if (!empty($member)) {
                            $minorData[$member] = ($minorData[$member] ?? 0) + 1;
                        }
                    }
                }
            }
    
            // Format data untuk chart prioritas
            $majorChartData = [];
            $minorChartData = [];
    
            foreach ($totalSPKByAssignee as $assignee => $count) {
                if (!empty($assignee)) { // Pastikan hanya nama yang valid
                    $majorChartData[] = $majorData[$assignee] ?? 0;
                    $minorChartData[] = $minorData[$assignee] ?? 0;
    
                    // Ambil kata pertama dari nama assignee
                    $firstWord = explode(' ', $assignee)[0];
                    $assigneeLabels[] = $firstWord;
                }
            }
    
            // Data total fee berdasarkan assignee (dengan pembagian)
            $adjustedAmountOfFeeData = Edc::getAdjustedAmountOfFeeByAssignee();
            $assigneeNames = [];
            $assigneeFees = [];
            $totalFees = 0;
    
            foreach ($adjustedAmountOfFeeData as $item) {
                $assignee = $item->_id ?? null;
                if (empty($assignee)) {
                    continue; // Skip jika assignee kosong
                }
    
                $fee = $item->total_fee ?? 0;
                $assigneeNames[] = $assignee;
                $assigneeFees[] = $fee;
                $totalFees += $fee;
            }
    
            return view('edc.dashboard', compact(
                'openCount',
                'assignCount',
                'requestToCloseCount',
                'closedCount',
                'assignees',
                'majorChartData',
                'minorChartData',
                'totalSPKByAssignee',
                'assigneeNames',
                'assigneeFees',
                'totalFees',
                'assigneeLabels' // Kirimkan label baru ke view
            ));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    // tabel open
    public function getUnassignedSpkData(Request $request)
    {
        $spkList = Edc::getUnassignedSpk(); // Ambil data dari model
    
        // Kembalikan data dalam format DataTables
        return response()->json([
            'data' => $spkList // Pastikan data berada dalam array 'data'
        ]);
    }
    
    // submit assign
    public function assignSpkAction(Request $request, $id)
    {
        \Log::info('Request Data:', $request->all());
        $validated = $request->validate([
            'assignee'     => 'required|string|max:255',
            'category'     => 'required|string',
            'priority'     => 'required|string',
            'startDate'    => 'required|date',
            'deadlineDate' => 'required|date|after_or_equal:startDate',
            'jenisBiaya'   => 'required|string|max:255',
            'jenisSpk'     => 'required|string|in:Plant,Non-Plant',
            'teamMembers'  => 'nullable|array|max:10', // Validasi anggota tim sebagai array, maksimal 10 anggota
            'teamMembers.*'=> 'nullable|string|max:255', // Validasi setiap anggota tim
        ]);
        \Log::info('Validated Data:', $validated);

        // Transformasi Team Members ke huruf kapital di awal kata
        $validated['teamMembers'] = array_map(function ($member) {
            return ucwords(strtolower($member)); // Huruf kapital di awal setiap kata
        }, $validated['teamMembers'] ?? []);

        $result = Edc::assignSpk($id, [
            'assignee'       => $validated['assignee'],
            'category'       => $validated['category'],
            'priority'       => $validated['priority'],
            'start_date'     => $validated['startDate'],
            'deadline_date'  => $validated['deadlineDate'],
            'jenis_biaya'    => $validated['jenisBiaya'],
            'jenis_spk'      => $validated['jenisSpk'],
            'team_members'   => $validated['teamMembers'] ?? [], // Simpan sebagai array
            'status'         => 'Assigned',
            'updatedAt'      => now(),
        ]);

        if ($result->getModifiedCount() > 0) {
            $spk = Edc::find($id);

            // Ambil email pembuat SPK
            $creator = User::where('id_card', $spk->createdBy)->first();

            if ($creator) {
                try {
                    $spkNumber = (string) $spk->spkNumber;
                    $message = (string) "No. SPK {$spkNumber} telah di-assign oleh tim EDC. Tunggu update perkembangan project Anda.";

                    // Kirim email
                    \Mail::to($creator->email)->send(
                        new \App\Mail\Edc\AssignSPKMail($spkNumber, $message)
                    );
                } catch (\Exception $e) {
                    return response()->json(['status' => 'error', 'message' => 'SPK updated, but failed to send email.'], 500);
                }
            }

            return response()->json(['status' => 'success', 'message' => 'SPK updated successfully and email notification sent.']);
        }

        return response()->json(['status' => 'error', 'message' => 'No document was updated.'], 500);
    }

    // tabel assigned
    public function assignSpk()
    {

        // Data untuk tabel dengan status 'Request to Close'
        $assignedList = Edc::where('status', 'Assigned')->orderBy('created_at', 'desc')->get();
       
          // Kirim data ke view
          return view('edc/assign-spk', [
            
            'assignedList' => $assignedList,
        ]);
    }

    // detail spk
    public function getSpkDetails($id)
    {
        $spk = Edc::getSpkDetails($id);
    
        if (!$spk) {
            return response()->json(['error' => 'SPK not found'], 404);
        }
    
        return response()->json($spk);
    }
    
    public function requestCloseSpk($id)
    {
        try {
            // Validasi ID
            $objectId = new \MongoDB\BSON\ObjectId($id);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid ID format: ' . $e->getMessage(),
            ], 400);
        }
    
        try {
            // Ambil detail SPK
            $spk = Edc::find($objectId);
            if (!$spk) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'SPK not found.',
                ], 404);
            }
    
            // Update status SPK
            $updated = Edc::updateStatus($objectId, 'Request to Close');
            if ($updated) {
                // Ambil email pembuat SPK
                $creator = User::where('id_card', $spk->createdBy)->first();
                if ($creator) {
                    try {
                        // Kirim email ke pembuat SPK
                        \Mail::to($creator->email)->send(
                            new \App\Mail\Edc\RequestCloseSPKMail($spk->spkNumber)
                        );
                    } catch (\Exception $e) {
                        // Abaikan kesalahan pengiriman email
                    }
                }
    
                return response()->json([
                    'status' => 'success',
                    'message' => 'Status successfully updated to Request to Close and email notification sent.',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'SPK not found or no changes made.',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error while updating: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    // tabel list spk
    // public function listSpk(Request $request)
    // {
    //     session(['active_menu' => 'edc']);
        
    //     // Ambil data SPK dari database tanpa filter
    //     $spkList = Edc::getAllSpks();

    //     // Menampilkan tampilan awal
    //     return view('edc.list-spk', ['spkList' => $spkList]);
    // }
    public function listSpk(Request $request)
    {
        session(['active_menu' => 'edc']);
        
        // Ambil data SPK dari database tanpa filter
        $spkList = Edc::getAllSpks();
    
        // Looping untuk menambahkan department berdasarkan id_card
        foreach ($spkList as &$spk) {
            // Pastikan $spk adalah array atau objek, dan akses menggunakan cara yang sesuai
            if (is_array($spk)) {
                $createdBy = isset($spk['createdBy']) ? $spk['createdBy'] : null;
            } elseif (is_object($spk)) {
                $createdBy = isset($spk->createdBy) ? $spk->createdBy : null;
            } else {
                $createdBy = null;
            }
            
            if ($createdBy) {
                // Cari user berdasarkan id_card
                $user = User::where('id_card', $createdBy)->first();
    
                if (!$user) {
                    Log::error("User not found for SPK ID: " . $spk['id']);
                }
    
                $department = $user ? $user->department : 'No Department';
                Log::info("Department for SPK ID " . $spk['id'] . ": " . $department);
    
                // Menambahkan department ke dalam SPK untuk ditampilkan
                if (is_array($spk)) {
                    $spk['department'] = $department;
                } elseif (is_object($spk)) {
                    $spk->department = $department;
                }
            } else {
                // Jika createdBy tidak ada, berikan nilai default
                if (is_array($spk)) {
                    $spk['department'] = 'No Department';
                } elseif (is_object($spk)) {
                    $spk->department = 'No Department';
                }
            }
        }
        
        // Menampilkan tampilan dengan spkList yang sudah diperbarui
        return view('edc.list-spk', ['spkList' => $spkList]);
    }
    
    
    public function filterSpk(Request $request)
    {
        try {
            logger()->info('Request filter SPK', $request->all());
    
            // Validasi input: start_date dan end_date harus diisi
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
    
            if (!$startDate || !$endDate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Both start date and end date are required.'
                ], 400);
            }
    
            // Query ke database menggunakan filter tanggal
            $query = Edc::where('requestDate', '>=', $startDate)
                ->where('requestDate', '<=', $endDate);
    
            // Ambil data dan map ke format yang sesuai
            $filteredData = $query->get()->map(function ($spk) {
                return [
                    'id'            => (string) ($spk->_id ?? '-'),
                    'spkNumber'     => $spk->spkNumber ?? '-',
                    'requestDate'   => $spk->requestDate ? $spk->requestDate->format('Y-m-d') : '-',
                    'subject'       => $spk->subject ?? '-',
                    'createdBy'     => $spk->createdBy ?? '-',
                    'status'        => $spk->status ?? 'Open',
                    'priority'      => $spk->priority ?? '-',
                    'category'      => $spk->category ?? '-',
                    'assignee'      => $spk->assignee ?? 'Unassigned',
                    'start_date'    => $spk->start_date ? $spk->start_date->format('Y-m-d') : '-',
                    'deadline_date' => $spk->deadline_date ? $spk->deadline_date->format('Y-m-d') : '-',
                    'jenis_biaya'   => $spk->jenis_biaya ?? '-',
                    'jenis_spk'     => $spk->jenis_spk ?? '-',
                    'updatedAt'     => $spk->updatedAt ? $spk->updatedAt->format('Y-m-d H:i:s') : 'Not Available',
                ];
            });
    
            logger()->info('Filtered Data:', $filteredData->toArray());
    
            // Berikan respons sukses dengan data yang difilter
            return response()->json(['success' => true, 'data' => $filteredData]);
        } catch (\Exception $e) {
            // Tangani error dan log pesan error
            logger()->error('Error filtering SPK', ['error' => $e->getMessage()]);
    
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while filtering data. Please try again.'
            ], 500);
        }
    }
    
    // form generate spknumber
    // public function createSpk()
    // {
    //     session(['active_menu' => 'edc']);
    //     return view('edc.create-spk');
    // }
    public function createSpk()
    {
        // Ambil ID Card pengguna yang sedang login
        $userId = Auth::user()->id_card ?? 'guest';
    
        // Ambil bulan dan tahun saat ini dalam format YYMM
        $yearMonth = now()->format('ym');  // Format '2503' untuk Maret 2025
    
        // Cari SPK terakhir yang ada dengan bulan yang sama
        $lastSpk = Edc::where('spkNumber', 'like', "%-{$yearMonth}-%")  // Cari berdasarkan bulan (tanpa ID pengguna)
            ->orderBy('spkNumber', 'desc')  // Urutkan berdasarkan nomor SPK
            ->first();
    
        // Tentukan nomor urut untuk SPK
        if ($lastSpk) {
            // Ambil nomor urut terakhir dan tambahkan 1
            $lastNumber = substr($lastSpk->spkNumber, -5);  // Ambil nomor urut dari format SPK
            $newIncrement = str_pad((int)$lastNumber + 1, 5, '0', STR_PAD_LEFT);  // Format 5 digit
        } else {
            // Jika belum ada, mulai dari 1
            $newIncrement = str_pad(1, 5, '0', STR_PAD_LEFT);  // Format 5 digit
        }
    
        // Gabungkan ID Card, bulan-tahun dan nomor urut untuk membuat nomor SPK
        $spkNumber = "{$userId}-{$yearMonth}-{$newIncrement}";
    
        // Kirim data SPK Number ke view
        session(['active_menu' => 'edc']);
        return view('edc.create-spk', compact('spkNumber'));
    }
    
    // menyimpan data
    // public function storeSpk(Request $request)
    // {
    //     $validated = $request->validate([
    //         'spkNumber'          => 'required|string|max:50',
    //         'requestDate'        => 'required|date',
    //         'expectedFinishDate' => 'required|date|after_or_equal:requestDate',
    //         'subject'            => 'required|string|max:255',
    //         'deskripsi'          => 'required|string|max:1000',
    //         'reason'             => 'required|string|max:1000',
    //         'attachments.*'      => 'required|file|max:3072|mimes:jpg,jpeg,bmp,png,xls,xlsx,doc,docx,pdf,txt,ppt,pptx.zip',
    //     ]);
    
    //     // Simpan attachments
    //     $attachments = [];
    //     if ($request->hasFile('attachments')) {
    //         foreach ($request->file('attachments') as $file) {
    //             $path = $file->store('attachments', 'public');
    //             $attachments[] = [
    //                 'originalName' => $file->getClientOriginalName(),
    //                 'path' => $path,
    //             ];
    //         }
    //     }
    
    //     try {
    //         // Simpan SPK ke database
    //         $spk = Edc::create([
    //             'spkNumber'          => $validated['spkNumber'],
    //             'requestDate'        => $validated['requestDate'],
    //             'expectedFinishDate' => $validated['expectedFinishDate'],
    //             'subject'            => $validated['subject'],
    //             'deskripsi'          => $validated['deskripsi'],
    //             'reason'             => $validated['reason'],
    //             'createdBy'   => Auth::user()->id_card ?? 'guest',
    //             'status'      => 'Open',
    //             'attachments' => $attachments,
    //             'createdAt'   => now(),
    //         ]);
    
    //         if (!$spk) {
    //             return redirect()->route('edc.list-spk')->with('error', 'Failed to save SPK.');
    //         }
    
    //         // Ambil email dari manager dan staff
    //         $recipients = User::whereIn('role', ['manager_edc', 'staff_edc'])->pluck('email')->toArray();
    
    //         if (!empty($recipients)) {
    //             // Kirim email ke semua recipients
    //             \Mail::to($recipients)->send(
    //                 new \App\Mail\Edc\CreateSPKMail(
    //                     $spk->spkNumber,
    //                     "SPK dengan nomor {$spk->spkNumber} telah dibuat dan menunggu persetujuan."
    //                 )
    //             );
    //         }
    
    //         return redirect()->route('edc.list-spk')->with('success', 'SPK created and notification sent.');
    //     } catch (\Exception $e) {
    //         return redirect()->route('edc.list-spk')->with('error', 'Failed to create SPK.');
    //     }
    // }
    public function storeSpk(Request $request)
    {
        // Validasi request
        $validated = $request->validate([
            'spkNumber'          => 'required|string|max:50',
            'requestDate'        => 'required|date',
            'expectedFinishDate' => 'required|date|after_or_equal:requestDate',
            'subject'            => 'required|string|max:255',
            'deskripsi'          => 'required|string|max:1000',
            'reason'             => 'required|string|max:1000',
            'attachments.*'      => 'nullable|file|max:3072|mimes:jpg,jpeg,bmp,png,xls,xlsx,doc,docx,pdf,txt,ppt,pptx',
        ]);
    
        // Simpan attachments jika ada
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
    
        try {
            // Ambil ID Card pengguna yang sedang login
            $userId = Auth::user()->id_card ?? 'guest';
    
            // Ambil bulan dan tahun saat ini dalam format YYMM (tanpa tanda hubung)
            $yearMonth = now()->format('ym');  // Format '2503' untuk Maret 2025
    
            // Cari SPK terakhir yang ada dengan bulan yang sama
            $lastSpk = Edc::where('spkNumber', 'like', "%{$yearMonth}%")
                ->orderBy('spkNumber', 'desc')  // Pastikan diurutkan berdasarkan nomor SPK
                ->first();
    
            // Tentukan nomor urut untuk SPK
            if ($lastSpk) {
                // Ambil nomor urut terakhir dan tambahkan 1
                $lastNumber = substr($lastSpk->spkNumber, -5);  // Ambil nomor urut dari format SPK
                $newIncrement = str_pad((int)$lastNumber + 1, 5, '0', STR_PAD_LEFT);  // Format 5 digit
            } else {
                // Jika belum ada, mulai dari 1
                $newIncrement = str_pad(1, 5, '0', STR_PAD_LEFT);  // Format 5 digit
            }
    
            // Gabungkan ID Card, bulan-tahun dan nomor urut untuk membuat nomor SPK
            $spkNumber = "{$userId}-{$yearMonth}-{$newIncrement}";
    
            // Simpan SPK ke database
            $spk = Edc::create([
                'spkNumber'          => $spkNumber,  // SPK number yang baru di-generate
                'requestDate'        => $validated['requestDate'],
                'expectedFinishDate' => $validated['expectedFinishDate'],
                'subject'            => $validated['subject'],
                'deskripsi'          => $validated['deskripsi'],
                'reason'             => $validated['reason'],
                'createdBy'          => $userId,
                'status'             => 'Open',  // Status default 'Open'
                'attachments'        => $attachments,
                'createdAt'          => now(),
            ]);
    
            if (!$spk) {
                return redirect()->route('edc.list-spk')->with('error', 'Failed to save SPK.');
            }
    
            // Kirim email notifikasi ke manager dan staff
            $recipients = User::whereIn('role', ['manager_edc', 'staff_edc'])->pluck('email')->toArray();
    
            if (!empty($recipients)) {
                // Kirim email ke semua recipients
                \Mail::to($recipients)->send(
                    new \App\Mail\Edc\CreateSPKMail(
                        $spk->spkNumber,
                        "SPK dengan nomor {$spk->spkNumber} telah dibuat dan menunggu persetujuan."
                    )
                );
            }
    
            // Kembalikan response setelah berhasil
            return redirect()->route('edc.list-spk')->with('success', 'SPK created and notification sent.');
        } catch (\Exception $e) {
            return redirect()->route('edc.list-spk')->with('error', 'Failed to create SPK.');
        }
    }
    
    // action close spk
    public function closeSpk($id)
    {
        try {
            $spk = Edc::getSpkDetails($id); // Ambil data SPK
    
            // Ambil ID Card user saat ini
            $currentUserIdCard = auth()->user()->id_card;
    
            // Validasi apakah user adalah pembuat SPK
            if ($spk->createdBy !== $currentUserIdCard) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to close this SPK.',
                ], 403);
            }
    
            // Validasi status SPK
            if ($spk->status !== 'Request to Close') {
                return response()->json([
                    'success' => false,
                    'message' => 'SPK is not in Request to Close status.',
                ], 400);
            }
    
            // Update status ke Closed
            Edc::updateStatus($id, 'Closed');
    
            // Ambil email untuk role manager_edc dan staff_edc
            $recipients = User::whereIn('role', ['manager_edc', 'staff_edc'])->pluck('email');
    
            // Kirim email ke manager dan staff
            foreach ($recipients as $email) {
                try {
                    \Mail::to($email)->send(
                        new \App\Mail\Edc\CloseSPKMail($spk->spkNumber)
                    );
                } catch (\Exception $e) {
                    // Abaikan jika terjadi error pada pengiriman email
                }
            }
    
            return response()->json([
                'success' => true,
                'message' => 'SPK successfully closed.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    // action request reject
    public function rejectSPK(Request $request, $id)
    {
        // Validasi format ObjectId
        try {
            $objectId = new \MongoDB\BSON\ObjectId($id);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Invalid ID format.'], 400);
        }
    
        // Cari SPK berdasarkan ID
        $spk = Edc::find($id);
    
        if (!$spk) {
            return response()->json(['status' => 'error', 'message' => 'SPK not found.'], 404);
        }
    
        // Update status dan reason
        $reason = $request->input('reason');
        $spk->reason = $reason;
        $spk->status = 'Request to Reject';
    
        if ($spk->save()) {
            // Ambil semua email dengan role manager_edc
            $managers = User::where('role', 'manager_edc')->pluck('email');
            foreach ($managers as $email) {
                try {
                    // Kirim email ke manager_edc
                    Mail::to($email)->send(new RequestRejectSPKMail($spk->spkNumber));
                } catch (\Exception $e) {
                    // Log error pengiriman email dihapus karena sudah ditangani di lingkungan produksi
                    continue;
                }
            }
    
            return response()->json(['status' => 'success', 'message' => 'SPK has been marked as Request to Reject and email notification sent.']);
        }
    
        return response()->json(['status' => 'error', 'message' => 'Failed to update SPK.'], 500);
    }
    

    // tabel request to reject
    public function showApprovalRejectPage()
    {
        $spkList = Edc::where('status', 'Request to Reject')
            ->select(['spkNumber', 'requestDate', 'subject', 'deskripsi', 'reason', 'attachments', 'status']) // Tambahkan kolom status
            ->get();
    
        return view('edc.approval-reject', compact('spkList'));
    }
    // action reject
    public function rejectToRejected($id)
    {    
        // Cari SPK berdasarkan ID
        $spk = Edc::find($id);
    
        if (!$spk) {
            return response()->json(['success' => false, 'message' => 'SPK not found'], 404);
        }
    
        if ($spk->status !== 'Request to Reject') {
            return response()->json(['success' => false, 'message' => 'Status is not Request to Reject'], 400);
        }
    
    
        $spk->status = 'Rejected';
        if ($spk->save()) {
            // Kirim email ke pembuat SPK
            $creator = User::where('id_card', $spk->createdBy)->first();
    
            if ($creator) {
                try {
                    Mail::to($creator->email)->send(new RejectSPKMail($spk->spkNumber));
                } catch (\Exception $e) {
                    return response()->json(['success' => false, 'message' => 'SPK status updated, but failed to send email.'], 500);
                }
            }
    
            return response()->json(['success' => true, 'message' => 'SPK status has been updated to Rejected and email notification sent.']);
        }
    
        return response()->json(['success' => false, 'message' => 'Failed to update SPK status'], 500);
    }
    
    
    // Fungsi untuk mengupload file
    private function uploadAttachments($files)
    {
        $attachments = [];
        if ($files) {
            foreach ($files as $file) {
                $path = $file->store('attachments', 'public');
                $attachments[] = [
                    'originalName' => $file->getClientOriginalName(),
                    'path' => $path,
                ];
            }
        }
        return $attachments;
    }

    // fungsi edit dan deleted spk
    public function update(Request $request, $id)
    {
    
        $spk = Edc::find($id);
    
        if (!$spk) {
            return response()->json(['success' => false, 'message' => 'SPK not found'], 404);
        }
    
        // Update data SPK
        $spk->update([
            'spkNumber' => $request->spkNumber,
            'requestDate' => $request->requestDate,
            'subject' => $request->subject,
            'deskripsi' => $request->description,
        ]);
    
        // Handle attachments
        $attachments = $spk->attachments ?? [];
    
        // Remove attachments
        if ($request->has('removed_attachments')) {
            foreach ($request->removed_attachments as $path) {
                $attachments = array_filter($attachments, function ($attachment) use ($path) {
                    return $attachment['path'] !== $path;
                });
                \Storage::delete($path); // Hapus file dari storage
            }
        }
    
        // Add new attachments
        if ($request->hasFile('new_attachments')) {
            foreach ($request->file('new_attachments') as $file) {
                $path = $file->store('attachments');
                $attachments[] = [
                    'originalName' => $file->getClientOriginalName(),
                    'path' => $path,
                ];
            }
        }
    
        // Simpan perubahan attachments
        $spk->update(['attachments' => $attachments]);
    
        return response()->json(['success' => true, 'message' => 'SPK updated successfully']);
    }
    
    // Delete SPK
    public function destroy($id)
    {
        $spk = Edc::find($id);
    
        if (!$spk) {
            return response()->json(['success' => false, 'message' => 'SPK not found'], 404);
        }
    
        // Hapus file terkait, jika ada
        if (is_array($spk->attachments)) {
            foreach ($spk->attachments as $attachment) {
                \Storage::disk('public')->delete($attachment['path']);
            }
        }
    
        $spk->delete();
    
        return response()->json(['success' => true, 'message' => 'SPK deleted successfully']);
    }

    // update/edit data assign spk
    // public function update_assign(Request $request, $id)
    // {
    //     $spk = Edc::find($id);

    //     if (!$spk) {
    //         return response()->json(['success' => false, 'message' => 'SPK not found'], 404);
    //     }

    //     // Validasi data
    //     $request->validate([
    //         'category' => 'nullable|string|max:255',
    //         'priority' => 'nullable|string|max:255',
    //         'start_date' => 'nullable|date',
    //         'deadline_date' => 'nullable|date',
    //         'jenis_biaya' => 'nullable|string|max:255',
    //         'jenis_spk' => 'nullable|string|max:255',
    //         'persentase' => 'nullable|integer|min:0|max:100', 
    //         'team_members' => 'nullable|array|max:10', // Maksimal 10 anggota
            
    //     ]);

    //     // Update data
    //     $spk->update([
    //         'category' => $request->category,
    //         'priority' => $request->priority,
    //         'start_date' => $request->start_date,
    //         'deadline_date' => $request->deadline_date,
    //         'jenis_biaya' => $request->jenis_biaya,
    //         'jenis_spk' => $request->jenis_spk,
    //         'persentase' => $request->persentase,
            
    //     ]);

    //     return response()->json(['success' => true, 'message' => 'SPK updated successfully']);
    // }
    public function update_assign(Request $request, $id)
    {
        $spk = Edc::find($id);

        if (!$spk) {
            return response()->json(['success' => false, 'message' => 'SPK not found'], 404);
        }

        // Validasi data
        $request->validate([
            'category'      => 'nullable|string|max:255',
            'priority'      => 'nullable|string|max:255',
            'start_date'    => 'nullable|date',
            'deadline_date' => 'nullable|date',
            'jenis_biaya'   => 'nullable|string|max:255',
            'jenis_spk'     => 'nullable|string|max:255',
            'persentase'    => 'nullable|integer|min:0|max:100',
            'team_members'  => 'nullable|array|max:10', // Maksimal 10 anggota
            'team_members.*'=> 'nullable|string|max:255', // Validasi setiap anggota tim
        ]);

        // Transformasi data anggota tim jika ada
        $teamMembers = $request->team_members ?? [];
        $teamMembers = array_map(function ($member) {
            return ucwords(strtolower($member)); // Ubah setiap anggota tim menjadi huruf kapital di awal kata
        }, $teamMembers);

        // Update data
        $spk->update([
            'category'      => $request->category,
            'priority'      => $request->priority,
            'start_date'    => $request->start_date,
            'deadline_date' => $request->deadline_date,
            'jenis_biaya'   => $request->jenis_biaya,
            'jenis_spk'     => $request->jenis_spk,
            'persentase'    => $request->persentase,
            'team_members'  => $teamMembers, // Simpan sebagai array
        ]);

        return response()->json(['success' => true, 'message' => 'SPK updated successfully']);
    }

    








    
    



    


    


}

