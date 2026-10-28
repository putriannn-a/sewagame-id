<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Tarif Denda Keterlambatan Pengembalian (Late Fee Rate)
    |--------------------------------------------------------------------------
    | Denda dihitung per hari keterlambatan setelah melewati due_date.
    | Satuan: Rupiah (IDR).
    */
    'late_fee_per_day' => env('RENTAL_LATE_FEE_PER_DAY', 10000),

    /*
    |--------------------------------------------------------------------------
    | Pilihan Durasi Sewa yang Diizinkan (Allowed Durations)
    |--------------------------------------------------------------------------
    | Sesuai spesifikasi UAS: 3 hari, 7 hari, atau 14 hari.
    */
    'allowed_durations' => [3, 7, 14],

    /*
    |--------------------------------------------------------------------------
    | Metode Pengambilan / Pengiriman
    |--------------------------------------------------------------------------
    */
    'delivery_methods' => [
        'pickup'  => 'Ambil di Toko',
        'courier' => 'Kurir Instan',
    ],
];