<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'nama_produk'      => 'Tenda Summit 4P',
                'deskripsi'        => 'Tenda camping kapasitas 4 orang dengan konstruksi anti-badai dan lapisan waterproof 5000mm. Cocok untuk segala cuaca, ringan, dan mudah dipasang. Dilengkapi tiang aluminium dan inner mesh untuk sirkulasi udara optimal.',
                'harga'            => 899000,
                'stok'             => 25,
                'nama_file_gambar' => 'product_tent.png',
            ],
            [
                'nama_produk'      => 'Trail Carrier 60L',
                'deskripsi'        => 'Tas carrier ergonomis berkapasitas 60 liter dengan frame aluminium internal untuk distribusi beban yang optimal. Dilengkapi rain cover, tali kompresi, dan banyak kantong aksesoris. Ideal untuk pendakian multi-hari.',
                'harga'            => 749000,
                'stok'             => 40,
                'nama_file_gambar' => 'product_carrier.png',
            ],
            [
                'nama_produk'      => 'Peak Hiker Pro',
                'deskripsi'        => 'Sepatu hiking mid-cut dengan outsole Vibram untuk traksi maksimal di segala medan. Upper berbahan waterproof leather menjaga kaki tetap kering. Tersedia dalam ukuran 36 hingga 45. Cocok untuk trail berbatu dan medan basah.',
                'harga'            => 595000,
                'stok'             => 60,
                'nama_file_gambar' => 'product_boots.png',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
