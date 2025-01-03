<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MongoDB\Client as MongoDBClient;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\ObjectId;
use Carbon\Carbon;

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

    public function dashboard()
    {
        session(['active_menu' => 'edc']);

        try {
            // Ambil data status
            $rawData = Edc::getAggregatedStatusCounts();

            // Proses data menjadi array yang mudah digunakan
            $statusData = [];
            foreach ($rawData as $item) {
                $statusData[$item->_id] = $item->count ?? 0;
            }

            // Nilai default untuk setiap status
            $openCount = $statusData['Open'] ?? 0;
            $assignCount = $statusData['Assigned'] ?? 0;
            $requestToCloseCount = $statusData['Request to Close'] ?? 0;
            $closedCount = $statusData['Closed'] ?? 0;

            // Ambil data kategori
            $categoryCounts = Edc::getCategoryCounts();

            // Filter kategori "create" dan "modification"
            $filteredCategories = [];
            $totalCategories = 0;
            foreach ($categoryCounts as $category) {
                if (in_array($category->_id, ['create', 'modification'])) {
                    $filteredCategories[$category->_id] = $category->count ?? 0;
                    $totalCategories += $category->count ?? 0;
                }
            }

            // Hitung persentase
            $categoryPercentages = [];
            foreach ($filteredCategories as $key => $value) {
                $categoryPercentages[$key] = $totalCategories > 0 ? round(($value / $totalCategories) * 100, 2) : 0;
            }

            $categories = array_keys($filteredCategories);
            $percentages = array_values($categoryPercentages);

            // Ambil data assignee
            $assigneeCounts = Edc::getAssigneeCounts();

            $assignees = [];
            $ticketCounts = [];
            foreach ($assigneeCounts as $assignee) {
                if (!empty($assignee->_id)) {
                    $assignees[] = $assignee->_id;
                    $ticketCounts[] = $assignee->count ?? 0;
                }
            }

            // Kirim semua data ke view
            return view('edc.dashboard', compact(
                'openCount',
                'assignCount',
                'requestToCloseCount',
                'closedCount',
                'categories',
                'percentages',
                'assignees',
                'ticketCounts'
            ));
        } catch (\Exception $e) {
            // Tangani error dengan mengembalikan respons JSON
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // tabel request to close
    public function assignSpk()
    {
        $spkList = Edc::getUnassignedSpk(); // Fungsi ini sudah hanya mengambil status Open

        // Data untuk tabel dengan status 'Request to Close'
        $assignedList = Edc::where('status', 'Assigned')->orderBy('created_at', 'desc')->get();
       
          // Kirim data ke view
          return view('edc/assign-spk', [
            'spkList' => $spkList,
            'assignedList' => $assignedList,
        ]);
    }

    // submit assign
    public function assignSpkAction(Request $request, $id)
    {
        $validated = $request->validate([
            'assignee'     => 'required|string|max:255',
            'category'     => 'required|string',
            'priority'     => 'required|string',
            'startDate'    => 'required|date',
            'deadlineDate' => 'required|date|after_or_equal:startDate',
            'jenisBiaya'   => 'required|string|max:255',
            'jenisSpk'     => 'required|string|in:Plant,Non-Plant',
        ]);
    
        $result = Edc::assignSpk($id, [
            'assignee'       => $validated['assignee'],
            'category'       => $validated['category'],
            'priority'       => $validated['priority'],
            'start_date'     => $validated['startDate'],
            'deadline_date'  => $validated['deadlineDate'],
            'jenis_biaya'    => $validated['jenisBiaya'],
            'jenis_spk'      => $validated['jenisSpk'],
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
    public function listSpk()
    {
        session(['active_menu' => 'edc']);
    
        // Panggil data dari model
        $spkList = Edc::getAllSpks();
  
        return view('edc.list-spk', ['spkList' => $spkList]);
    }

    // form generate spknumber
    public function createSpk()
    {
        $spkNumber = Edc::generateSpkNumber();

        session(['active_menu' => 'edc']);
        return view('edc.create-spk', compact('spkNumber'));
    }
    // menyimpan data
    public function storeSpk(Request $request)
    {
        $validated = $request->validate([
            'spkNumber'    => 'required|string|max:50',
            'requestDate'  => 'required|date',
            'subject'      => 'required|string|max:255',
            'deskripsi'    => 'required|string|max:1000',
            'attachments.*' => 'nullable|file|max:3072|mimes:jpg,jpeg,bmp,png,xls,xlsx,doc,docx,pdf,txt,ppt,pptx',
        ]);
    
        // Simpan attachments
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
            // Simpan SPK ke database
            $spk = Edc::create([
                'spkNumber'   => $validated['spkNumber'],
                'requestDate' => $validated['requestDate'],
                'subject'     => $validated['subject'],
                'deskripsi'   => $validated['deskripsi'],
                'createdBy'   => Auth::user()->id_card ?? 'guest',
                'status'      => 'Open',
                'attachments' => $attachments,
                'createdAt'   => now(),
            ]);
    
            if (!$spk) {
                return redirect()->route('edc.list-spk')->with('error', 'Failed to save SPK.');
            }
    
            // Ambil email dari manager dan staff
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
    public function update_assign(Request $request, $id)
    {
        $spk = Edc::find($id);

        if (!$spk) {
            return response()->json(['success' => false, 'message' => 'SPK not found'], 404);
        }

        // Validasi data
        $request->validate([
            'category' => 'nullable|string|max:255',
            'priority' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'deadline_date' => 'nullable|date',
            'jenis_biaya' => 'nullable|string|max:255',
            'jenis_spk' => 'nullable|string|max:255',
        ]);

        // Update data
        $spk->update([
            'category' => $request->category,
            'priority' => $request->priority,
            'start_date' => $request->start_date,
            'deadline_date' => $request->deadline_date,
            'jenis_biaya' => $request->jenis_biaya,
            'jenis_spk' => $request->jenis_spk,
        ]);

        return response()->json(['success' => true, 'message' => 'SPK updated successfully']);
    }
    








    
    



    


    


}

