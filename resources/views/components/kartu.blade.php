@props(['judul', 'penulis', 'tahun', 'kategori', 'gambar'])
<div class="kartu">
    <img src="{{ asset('img/' . $gambar) }}" alt="{{ $judul }}" class="img-buku">
    
    <span class="badge">{{ $kategori }}</span>
    <h3 style="color: #142850; margin-top: 10px;">{{ $judul }}</h3>
    <p>Penulis: <b>{{ $penulis }}</b></p>
    <p>Tahun: {{ $tahun }}</p>
    <div>
        {{ $slot }}
    </div>
</div>