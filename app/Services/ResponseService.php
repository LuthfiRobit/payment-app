<?php

namespace App\Services;

use Yajra\DataTables\Facades\DataTables;

class ResponseService
{
    // Mengembalikan response JSON untuk DataTables dengan kolom yang fleksibel
    public function getDataTableResponse($query, $columns = [])
    {
        $dataTable = DataTables::of($query);

        // Menambahkan kolom default
        $dataTable->addColumn('aksi', function ($item) {
            return '<button class="btn btn-outline-primary btn-sm detail-button" title="Edit" data-id="' . $item->id_siswa . '">
                <i class="fas fa-edit"></i>
            </button>';
        });

        // Menambahkan kolom lain berdasarkan parameter $columns
        foreach ($columns as $column => $callback) {
            $dataTable->addColumn($column, $callback);
        }

        // Menambahkan kolom default untuk nama_siswa dan kelas
        $dataTable->editColumn('nama_siswa', function ($item) {
            return strtoupper($item->nama_siswa);
        })
            ->editColumn('kelas', function ($item) {
                return strtoupper($item->kelas);
            })
            ->rawColumns(['aksi'])
            ->make(true);

        return $dataTable;
    }

    // Mengembalikan response JSON sukses dengan kunci tambahan
    public function successResponse($message, $data = [], $additional = [])
    {
        return response()->json(array_merge([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $additional), 200);
    }

    // Mengembalikan response JSON error
    public function errorResponse($message, $error = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $error,
        ], 500);
    }

    // Mengembalikan response JSON saat data tidak ditemukan
    public function notFoundResponse($message = 'Data tidak ditemukan')
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 404);
    }
}
