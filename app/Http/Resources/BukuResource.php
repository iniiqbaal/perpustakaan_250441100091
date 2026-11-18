<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BukuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            // modul 4
            'kategori'         => $this->kategori?->nama ?? '-',
            'kategori_id'      => $this->kategori_id,
            'judul'            => $this->judul,
            'penulis'          => $this->penulis,
            'tahun_terbit'     => (int) $this->tahun_terbit,
            'gambar'           => $this->gambar,
            // <- modul 4
            'total_peminjaman' => $this->whenCounted('peminjamans'),
            'peminjamans'      => $this->whenLoaded('peminjamans'),
        ];
    }
}