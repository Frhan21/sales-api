<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Marketing;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::all();
        return $penjualan;
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'transaction_number' => 'sometimes|required',
            'marketing_id' => 'sometimes|required|exists:marketings,id',
            'date' => 'sometimes|required|date',
            'cargo_fee' => 'sometimes|required|numeric',
            'total_balance' => 'sometimes|required|numeric',
            'grand_total' => 'sometimes|required|numeric',
        ]);

        if ($validate) {
            $penjualan = Penjualan::find($validate[$id]);
            $penjualan->update($validate);
            return response()->json(['message' => 'Penjualan updated successfully', 'data' => $penjualan], 200);
        } else {
            return response()->json(['message' => 'Validation failed', 'errors' => $validate->errors()], 422);
        };
    }

    public function show($id)
    {
        $penjualan = Penjualan::find($id);
        return $penjualan;
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::find($id);
        $penjualan->delete();
        return response()->json(['message' => 'Penjualan deleted successfully'], 200);
    }

    public function getComission(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        // Ambil data marketing dengan penjualan yang difilter berdasarkan bulan dan tahun
        $marketings = Marketing::with(['penjualan' => function ($query) use ($month, $year) {
            if ($year) {
                $query->whereYear('date', $year);
            }
            if ($month) {
                $query->whereMonth('date', $month);
            }
        }])->get();

        $res = [];
        foreach ($marketings as $marketing) {
            // Kelompokkan penjualan berdasarkan bulan dan tahun
            $penjualanPerBulan = [];
            foreach ($marketing->penjualan as $penjualan) {
                $bulan = date('F', strtotime($penjualan->date)); // Ambil nama bulan (contoh: Mei, Juni)
                $tahun = date('Y', strtotime($penjualan->date)); // Ambil tahun (contoh: 2023)
                $key = $bulan . ' ' . $tahun; // Gabungkan bulan dan tahun sebagai key

                if (!isset($penjualanPerBulan[$key])) {
                    $penjualanPerBulan[$key] = [
                        'total_omzet' => 0,
                        'penjualan' => [],
                        'tahun' => $tahun // Tambahkan tahun ke dalam data
                    ];
                }
                $penjualanPerBulan[$key]['total_omzet'] += $penjualan->grand_total;
                $penjualanPerBulan[$key]['penjualan'][] = [
                    'date' => $penjualan->date,
                    'grand_total' => $penjualan->grand_total,
                ];
            }

            // Hitung komisi untuk setiap bulan
            foreach ($penjualanPerBulan as $key => $data) {
                $omzet = $data['total_omzet'];
                $comission = $this->calculateComission($omzet);

                $res[] = [
                    'marketing' => $marketing->name,
                    'bulan' => explode(' ', $key)[0], // Ambil nama bulan dari key
                    'tahun' => $data['tahun'], // Ambil tahun dari data
                    'omzet' => $omzet,
                    'comission_percent' => $comission['percent'],
                    'comission_nominal' => $comission['nominal']
                ];
            }
        }

        // Urutkan data berdasarkan tahun dan bulan
        usort($res, function ($a, $b) {
            $tahunA = $a['tahun'];
            $tahunB = $b['tahun'];
            $bulanA = date('m', strtotime($a['bulan'] . ' 01'));
            $bulanB = date('m', strtotime($b['bulan'] . ' 01'));

            // Urutkan berdasarkan tahun terlebih dahulu, lalu bulan
            if ($tahunA === $tahunB) {
                return $bulanA <=> $bulanB;
            }
            return $tahunA <=> $tahunB;
        });

        return response()->json(['data' => $res, 'status' => 201]);
    }

    // Fungsi untuk menghitung komisi
    private function calculateComission($omzet)
    {
        // Contoh logika perhitungan komisi
        if ($omzet > 1000000000) {
            return ['percent' => 10, 'nominal' => $omzet * 0.10];
        } elseif ($omzet > 500000000) {
            return ['percent' => 5, 'nominal' => $omzet * 0.05];
        } elseif ($omzet > 100000000) {
            return ['percent' => 2.5, 'nominal' => $omzet * 0.025];
        } else {
            return ['percent' => 0, 'nominal' => 0];
        }
    }


    public function store(Request $request)
    {
        $validate = $request->validate([
            'transaction_number' => 'required',
            'marketing_id' => 'required|exists:marketings,id',
            'date' => 'required|date',
            'cargo_fee' => 'required|numeric',
            'total_balance' => 'required|numeric',
            'grand_total' => 'required|numeric',
        ]);

        if ($validate) {
            $penjualan = Penjualan::create($validate);
            return response()->json(['message' => 'Penjualan created successfully', 'data' => $penjualan], 201);
        } else {
            return response()->json(['message' => 'Validation failed', 'errors' => $validate->errors()], 422);
        }
    }
}
