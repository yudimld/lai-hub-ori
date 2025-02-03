<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlanningWorkDate;
use Illuminate\Support\Facades\Log;

class MesBatchManagementController extends Controller
{
    public function planningWorkDate()
    {
        return view('mes.batchmanagement.planning-work-date');
    }

    public function getPlanningWorkDates(Request $request)
    {
        if ($request->ajax()) {
            // Mengambil data dari PostgreSQL menggunakan koneksi 'pgsql'
            $data = \DB::connection('pgsql')->table('planning_work_dates')
                ->select('id', 'year', 'month', 'target_production', 'target_workdays')
                ->get();

            // Formatkan tahun dan bulan menjadi datetime (YYYY-MM)
            $data = $data->map(function($item) {
                $item->datetime = sprintf('%04d-%02d', $item->year, $item->month);
                return $item;
            });

            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => $data->count(),
                'recordsFiltered' => $data->count(),
                'data' => $data
            ]);
        }
    }

    public function store(Request $request)
    {
        // Validasi input data
        $request->validate([
            'year' => 'required|integer|between:2020,2099', // Validasi untuk tahun
            'month' => 'required|integer|between:1,12',     // Validasi untuk bulan
            'target_production' => 'required|numeric',
            'target_workdays' => 'required|numeric',
        ]);
    
        // Simpan data ke database
        PlanningWorkDate::create([
            'year' => $request->year,
            'month' => $request->month,
            'target_production' => $request->target_production,
            'target_workdays' => $request->target_workdays,
        ]);
    
        return response()->json(['success' => 'Data added successfully']);
    }
    
    public function edit($id)
    {
        // Mengambil data berdasarkan ID
        $data = PlanningWorkDate::findOrFail($id);
    
        // Mengembalikan data dalam format JSON
        return response()->json($data);
    }
    

    public function update(Request $request, $id)
    {
        // Menambahkan log sebelum validasi untuk melihat data yang dikirimkan
        Log::info('Update request received', ['request_data' => $request->all()]);
    
        // Validasi input
        $request->validate([
            'year' => 'required|integer|between:2020,2099',
            'month' => 'required|integer|between:1,12',
            'target_production' => 'required|numeric',
            'target_workdays' => 'required|numeric',
        ]);
        Log::info('Update request received', ['request_data' => $request->all()]);
    
        // Log setelah validasi
        Log::info('Validation passed', ['validated_data' => $request->only(['year', 'month', 'target_production', 'target_workdays'])]);
    
        // Temukan data berdasarkan ID
        $planning = PlanningWorkDate::findOrFail($id);
    
        // Log data sebelum update
        Log::info('Found planning work date', ['existing_data' => $planning]);

        // Update data
        $planning->year = $request->year;
        $planning->month = $request->month;
        $planning->target_production = $request->target_production;
        $planning->target_workdays = $request->target_workdays;
        $planning->save();
    
        // Log setelah update
        Log::info('Planning work date updated', ['updated_data' => $planning]);
    
        return response()->json(['success' => 'Data updated successfully']);
    }
    
    
}
