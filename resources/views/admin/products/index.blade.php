@extends('layouts.admin')

@section('main')
    <style>
        * {
            /* border: 1px solid black; */
        }
    </style>
    <div class="container-fluid">
        <div class="container p-6">
            <div class="flex flex-col md:flex-row mb-4 gap-4">
                <!-- Banner -->
                <div class="w-full md:w-3/4 bg-blue-500 bg-opacity-20 p-4 rounded-lg">
                    <div class="flex justify-between items-center">
                        <!-- Kiri: Judul dan Breadcrumb -->
                        <div>
                            <h1 class="text-3xl font-semibold text-gray-800">Daftar Produk</h1>
                            <nav class="mt-2">
                                <ol class="flex text-sm text-gray-600">
                                    <li><a href="{{ route('dashboard.index') }}" class="hover:text-blue-500">Dashboard</a>
                                    </li>
                                    <li class="mx-2">/</li>
                                    <li><a href="{{ route('admin.products.index') }}" class="hover:text-blue-500">Produk</a>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <!-- Kanan: Gambar (Vector) -->
                        <div class="hidden md:block">
                            <img src="{{ asset('img/img-banner/produk.png') }}" alt="Gambar Banner"
                                class="w-32 h-32 object-contain">
                        </div>
                    </div>
                </div>
              
                <div class="w-full md:w-1/4 bg-gradient-to-t from-blue-800 to-blue-400 p-2 rounded-lg shadow-md">
                    <div class="flex flex-col items-center">
                        <!-- Ikon di atas dengan latar belakang putih dan tinggi penuh -->
                        <div class="bg-white p-4 rounded-md h-16 w-16 flex justify-center items-center w-full">
                            <i class="fas fa-boxes text-3xl text-blue-600"></i>
                        </div>
                        <!-- Keterangan di bawah ikon -->
                        <div class="mt-4 text-center">
                            <h2 class="text-xl font-medium text-white">Jumlah Produk</h2>
                            <p class="text-2xl font-semibold text-white mt-2">120 Produk</p>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="card w-full">
            <div class="card-body p-4">
                <!-- Pencarian dan Filter -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
                    <!-- Pencarian -->
                    <div class="w-full md:w-auto">
                        <form action="{{ route('admin.products.index') }}" method="GET" class="w-full">
                            <div class="flex items-center w-full">
                                <input type="text" name="search"
                                    class="form-control me-2 border-lg border-[#5d85fa] w-full" placeholder="Cari produk"
                                    value="{{ request('search') }}">
                                <button type="submit"
                                    class="btn btn-primary md:mt-0 md:ml-2 px-4 py-2  md:w-auto">Cari</button>
                            </div>
                        </form>
                    </div>

                    <!-- Tombol Tambah Produk -->
                    <div class="flex items-center gap-4 w-full md:w-auto">
                        <a href="{{ route('admin.products.create') }}"
                            class="btn btn-primary text-white font-medium py-2 px-4 rounded-lg w-full md:w-auto">
                            + Tambahkan produk baru
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.products.index') }}" method="GET">
                    <div
                        class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 text-white border-t border-gray-600 pt-4 mb-4">
                        <!-- Merek Filter -->
                        <div class="col-span-1">
                            <select name="category_id"
                                class="bg-[#5d85fa] text-white border border-gray-600 rounded-lg py-2 px-3 w-full"
                                onchange="this.form.submit()">
                                <option value="">Kategori</option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name_category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-1">
                            <select name="brand_id"
                                class="bg-[#5d85fa] text-white border border-gray-600 rounded-lg py-2 px-3 w-full"
                                onchange="this.form.submit()">
                                <option value="">Merek</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name_brand }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Harga Filter -->
                        <div class="col-span-1">
                            <select name="price_product"
                                class="bg-[#5d85fa] text-white border border-gray-600 rounded-lg py-2 px-3 w-full"
                                onchange="this.form.submit()">
                                <option value="">Harga</option>
                                <option value="asc" {{ request('price_product') == 'asc' ? 'selected' : '' }}>
                                    Terendah ke Tertinggi</option>
                                <option value="desc" {{ request('price_product') == 'desc' ? 'selected' : '' }}>
                                    Tertinggi ke Terendah</option>
                            </select>
                        </div>

                        <!-- Rating Filter -->
                        <div class="col-span-1">
                            <select name="rating"
                                class="bg-[#5d85fa] text-white border border-gray-600 rounded-lg py-2 px-3 w-full"
                                onchange="this.form.submit()">
                                <option value="">Rating</option>
                                <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Bintang
                                </option>
                                <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Bintang
                                </option>
                                <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Bintang
                                </option>
                                <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Bintang
                                </option>
                                <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Bintang
                                </option>
                            </select>
                        </div>

                        <!-- Stok Filter -->
                        <div class="col-span-1">
                            <select name="stock_product"
                                class="bg-[#5d85fa] text-white border border-gray-600 rounded-lg py-2 px-3 w-full"
                                onchange="this.form.submit()">
                                <option value="">Stok</option>
                                <option value="1" {{ request('stock_product') == '1' ? 'selected' : '' }}>Ada
                                </option>
                                <option value="0" {{ request('stock_product') == '0' ? 'selected' : '' }}>Habis
                                </option>
                            </select>
                        </div>

                        <!-- Tanggal Filter -->
                        <div class="col-span-1">
                            <select name="created_at"
                                class="bg-[#5d85fa] text-white border border-gray-600 rounded-lg py-2 px-3 w-full"
                                onchange="this.form.submit()">
                                <option value="">Tanggal</option>
                                <option value="asc" {{ request('created_at') == 'asc' ? 'selected' : '' }}>Lama
                                </option>
                                <option value="desc" {{ request('created_at') == 'desc' ? 'selected' : '' }}>Terbaru
                                </option>
                            </select>
                        </div>
                    </div>
                </form>

                <!-- Daftar Produk -->
                <div class="table-responsive">
                    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                        <!-- Table Head -->
                        <thead class="bg-[#5D87FF] text-white">
                            <tr>
                                <th class="px-4 py-2 text-left">Nama Produk</th>
                                <th class="px-4 py-2 text-left">Kategori</th>
                                <th class="px-4 py-2 text-left">Merek</th>
                                <th class="px-4 py-2 text-left">Harga</th>
                                <th class="px-4 py-2 text-left">Stok</th>
                                <th class="px-4 py-2 text-left">Rating</th>
                                <th class="px-6 py-2 text-center">Dibuat</th>
                                <th class="px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody>
                            @foreach ($products as $product)
                                <tr class="hover:bg-gray-50 cursor-pointer border-b">
                                    <td class="px-6 py-6 flex items-center">
                                        <img src="{{ asset('storage/' . $product->image_product) }}"
                                            alt="{{ $product->name_product }}" class="w-8 h-8 rounded-full mr-3">
                                        <span>{{ $product->name_product }}</span>
                                    </td>
                                    <td class="px-6 py-5">{{ $product->category->name_category ?? '-' }}</td>
                                    <td class="px-6 py-5">{{ $product->brand->name_brand ?? '-' }}</td>
                                    <td class="px-6 py-5">Rp. {{ number_format($product->price_product, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-5">{{ $product->stock_product }} unit</td>
                                    <td class="px-6 py-5">
                                        {{ $product->reviews->avg('rating') ? number_format($product->reviews->avg('rating'), 1) . ' / 5' : 'Belum ada' }}
                                    </td>
                                    <td class="px-6 py-5 text-center">{{ $product->created_at->format('d F Y') }}</td>
                                    <td class="px-6 py-5 text-center space-x-2 flex">
                                        <!-- Edit Button with Tooltip -->
                                        <div class="relative group inline-block">
                                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                                class="bg-yellow-500 text-white flex items-center justify-center px-3 py-2 rounded hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                                                <i class="fas fa-pen text-sm"></i>
                                            </a>
                                            <!-- Tooltip -->
                                            <div
                                                class="absolute hidden group-hover:flex items-center justify-center bg-gray-800 text-white text-sm rounded px-2 py-1 mt-2 left-1/2 transform -translate-x-1/2">
                                                Edit
                                                <div
                                                    class="absolute bg-gray-800 h-2 w-2 transform rotate-45 -translate-x-1/2 top-[-4px] left-1/2">
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Detail Button with Tooltip -->
                                        <div class="relative group inline-block">
                                            <a href="{{ route('admin.products.show', $product->slug) }}"
                                                class="bg-blue-500 rounded text-white flex items-center relative px-3 py-2 hover:bg-blue-600 ">
                                                <i class="fas fa-eye text-sm"></i>
                                            </a>
                                            <span
                                                class="absolute hidden group-hover:block bg-gray-800 text-white text-sm rounded px-2 py-1 mt-2 left-1/2 transform -translate-x-1/2">
                                                <span
                                                    class="absolute bg-gray-800 h-2 w-2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rotate-45"></span>
                                                Detail
                                            </span>
                                        </div>

                                        {{-- <a href="{{ route('admin.products.show', $product->slug) }}">show</a> --}}

                                        <!-- Delete Button with Tooltip -->
                                        <div class="relative group inline-block">
                                            <button
                                                class="bg-red-500 rounded text-white flex items-center relative px-3 py-2 hover:bg-red-600 "
                                                data-bs-toggle="modal" data-bs-target="#deleteModal_{{ $product->id }}">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                            <span
                                                class="absolute hidden group-hover:block bg-gray-800 text-white text-sm rounded px-2 py-1 mt-2 left-1/2 transform -translate-x-1/2">
                                                <span
                                                    class="absolute bg-gray-800 h-2 w-2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rotate-45"></span>
                                                Hapus
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr id="details_{{ $product->id }}" class="hidden">
                                    <td colspan="8" class="px-4 py-2 bg-gray-50">
                                        <div class="flex items-center space-x-4">
                                            @if ($product->image_product)
                                                <img src="{{ asset('storage/' . $product->image_product) }}"
                                                    alt="{{ $product->name_product }}"
                                                    class="w-24 h-24 object-cover rounded">
                                            @endif
                                            <div>
                                                <strong>Deskripsi:</strong>
                                                <p>{{ $product->description_product }}</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
    </div>


    <!-- Modal Hapus Produk -->
    @foreach ($products as $product)
        <div class="modal fade" id="deleteModal_{{ $product->id }}" tabindex="-1"
            aria-labelledby="deleteModalLabel_{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel_{{ $product->id }}">Hapus Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus produk <strong>{{ $product->name_product }}</strong>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach


    <script>
        function toggleDropdown(element) {
            var dropdown = element.nextElementSibling;
            dropdown.classList.toggle('hidden');
        }
    </script>
@endsection
