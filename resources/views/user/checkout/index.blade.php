<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>checkout page</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- font poopins -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <style>
        * {
            font-family: "Poppins", sans-serif;
        }
    </style>
</head>

<body>
    <form action="{{ route('user.checkout.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="addresses_id" id="addresses_id">
        <input type="hidden" name="id_discount" id="id_discount" value="" />
        <div class="grid md:grid-cols-2 grid-cols-1">
            <div class="bg-white min-h-screen">
                <div class="py-10 px-20">

                    @if (session('success'))
                        <div class="bg-green-300 mb-5 text-xs text-white py-5 px-3 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-7">
                        <h1 class="text-xl font-bold mb-1 text-slate-800">Payment</h1>
                        <p class="text-sm text-slate-700 mb-5">
                            All transactions are secure and encrypted
                        </p>

                        <div class="border-2 py-3 px-3 rounded-md">
                            <div class="mb-3">
                                <h6 class="text-slate-700 font-semibold text-xl mb-2">
                                    <span class="text-yellow-500">BNI</span>
                                    <span class="text-sm">(bank Negara Indonesia)</span>
                                </h6>
                                <p class="text-sm text-slate-700 font-medium tracking-tighter">
                                    Admin: <span class="text-yellow-500">1122334455</span>
                                </p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-slate-700 font-semibold text-xl mb-2">
                                    <span class="text-blue-600">BRI</span>
                                    <span class="text-sm">(bank Rakyat Indonesia)</span>
                                </h6>
                                <p class="text-sm text-slate-700 font-medium tracking-tighter">
                                    Admin: <span class="text-blue-600">5566778899</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-7">
                        <h1 class="text-xl font-bold mb-1 text-slate-800">
                            Your Information
                        </h1>
                        <p class="text-sm text-slate-700 mb-5">
                            provide your information clearly
                        </p>

                        <div class="mb-3">
                            <input type="text" value="{{ auth()->user()->name }}" name="nama" placeholder="Name"
                                class="w-full py-3 px-3 outline-none border border-gray-300 text-slate-700 rounded-lg text-sm" />
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" value="{{ auth()->user()->email }}" placeholder="Email"
                                class="w-full py-3 px-3 outline-none border border-gray-300 text-slate-700 rounded-lg text-sm" />
                        </div>
                        <div class="w-full border border-gray-300 rounded-lg overflow-hidden">
                            @forelse($addresses as $address)
                                <div class="flex gap-5 border-b-2 py-2 px-3">
                                    <input type="radio" onchange="setAddress(event)" name="alamat"
                                        id="alamat_{{ $address->id }}" value="{{ $address->city_id }}"
                                        {{ $loop->first ? 'checked' : '' }} data-addresses_id="{{ $address->id }}" />
                                    <label for="alamat_{{ $address->id }}" class="w-full">
                                        <h6 class="text-lg text-slate-700 font-semibold">{{ $address->mark }}</h6>
                                        <p class="text-sm text-slate-600">
                                            {{ $address->address }}
                                        </p>
                                        <span
                                            class="text-slate-700 text-sm font-medium">{{ $address->no_telepon }}</span>
                                    </label>
                                </div>
                            @empty
                                <div class="flex gap-5 border-b-2 py-2 px-3">
                                    <p class="text-slate-700 text-xs text-center"> Address not found</p>
                                </div>
                            @endforelse
                            <div class="flex gap-5 border-b-2 py-2 px-3 w-full">
                                <button type="button" onclick="ShowAddAddress()"
                                    class="text-xs text-slate-700 block w-full text-center py-2 px-3">Tambahkan
                                    Alamat</button>
                            </div>
                        </div>
                    </div>



                    <div class="mb-7">
                        <h1 class="text-xl font-bold mb-1 text-slate-800">Delivery</h1>
                        <p class="text-sm text-slate-700 mb-5">
                            Select the sender option below
                        </p>
                        <div class="mb-3">
                            <label for="courier" class="text-slate-700 font-medium text-sm">Courier</label>
                            <select onchange="setCourier(this.value)" name="courier" id="courier"
                                class="w-full py-3 px-3 outline-none border border-gray-300 text-slate-700 rounded-lg text-sm">
                                <option value="" selected disabled>select courier</option>
                                <option value="jne">Jalur Nugraha Ekakurir (JNE)</option>
                                <option value="pos">POS Indonesia (POS)</option>
                                <option value="tiki">Citra Van Titipan Kilat (TIKI)</option>
                            </select>
                        </div>
                        @error('courier')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                        <div id="costs" class="mb-3"></div>
                        @error('cost')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-7">
                        <h1 class="text-xl font-bold mb-1 text-slate-800">Voucher</h1>
                        <p class="text-sm text-slate-700 mb-1">
                            enter the voucher code if you have it
                            <br />
                            <span class="text-red-500 text-[10px]"> Optinal </span>
                        </p>

                        <div class="flex items-center justify-center w-full border rounded-md overflow-hidden">
                            <input type="text" id="vocher"
                                class="w-full px-3 outline-none text-slate-700 text-md rounded-lg font-medium"
                                placeholder="Voucher Code" />
                            <button type="button" onclick="checkVoucher(this)"
                                class="bg-blue-500 text-white px-3 py-2 text-md block w-auto">
                                Check
                            </button>
                        </div>
                        <p id="voucher-status" class="mt-1"></p>
                    </div>

                    <div class="mb-7">
                        <h1 class="text-xl font-bold mb-1 text-slate-800">
                            proof of transfer
                        </h1>
                        <p class="text-sm text-slate-700 mb-5">
                            Send proof of transfer according to your order total
                        </p>
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file"
                                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50">
                                <div id="text_area" class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                        </path>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                        <span class="font-semibold">Upload a file</span>
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        PNG, JPG or JPEG
                                    </p>
                                </div>
                                <div id="bukti_area_preview" class="h-full w-full overflow-hidden bg-center hidden">
                                    <img id="bukti_area" src="../image/headset-2.png"
                                        class="w-full h-full object-contain" />
                                </div>
                                <input id="dropzone-file" type="file" class="hidden" name="bukti_image"
                                    accept="image/png, image/jpeg, image/jpg" onchange="preview(event)" />
                            </label>
                        </div>
                        @error('bukti_image')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="block w-full py-2 px-5 w-full bg-blue-600 text-white rounded-md">
                        Pay Now
                    </button>
                </div>
            </div>
            <div>
                @php
                    $total = 0;
                @endphp
                @if (count($carts) > 0)
                    <div class="md:fixed static top-0 bg-neutral-100 min-h-screen">
                        <h5 class="px-20 text-2xl font-medium text-slate-800 py-5">
                            {{ count($carts) }} items
                        </h5>
                        <div class="px-10 h-96 overflow-y-auto">
                            <table class="table-auto w-full">
                                <tr class="sticky top-0 z-10">
                                    <th class="text-slate-700 text-sm font-medium">Image</th>
                                    <td class="text-slate-700 text-sm font-medium">Product</td>
                                    <td class="text-slate-700 text-sm font-medium">Price</td>
                                </tr>
                                @foreach ($carts as $cart)
                                    @php
                                        $total += $cart->product->price_product * $cart->quantity;
                                        $weight = 0;
                                    @endphp
                                    <input type="hidden" name="product_id_quantity[{{ $cart->product->id }}]"
                                        id="product_id_quantity_{{ $cart->id }}" value="{{ $cart->quantity }}">

                                    <tr class="border-b-2 border-slate-300">
                                        <th>
                                            <div
                                                class="w-28 h-28 bg-cover bg-center overflow-hidden flex justify-center items-center p-5">
                                                <img src="{{ asset('storage/' . $cart->product->image_product) }}"
                                                    alt="">
                                            </div>
                                        </th>
                                        <td class="w-full align-bottom">
                                            <div class="text-sm text-slate-700 mb-5">
                                                {{ $cart->product->name_product }}
                                            </div>
                                            <div class="w-24 bg-white flex border-2 border-blue-200 rounded-md mb-4">
                                                <button type="button" class="px-2 py-1 text-slate-800"
                                                    onclick="minus('quantity_{{ $cart->id }}', '{{ $cart->product->price_product }}', 'product_id_quantity_{{ $cart->id }}')">
                                                    -
                                                </button>
                                                <input type="text"
                                                    class="w-10 outline-none px-2 py-1 text-center text-slate-800"
                                                    value="{{ $cart->quantity }}"
                                                    id="quantity_{{ $cart->id }}" />
                                                <button type="button" class="px-2 py-1 text-slate-800"
                                                    onclick="plus('quantity_{{ $cart->id }}', {{ $cart->product->stock_product }}, '{{ $cart->product->price_product }}', 'product_id_quantity_{{ $cart->id }}')">
                                                    +
                                                </button>
                                            </div>
                                        </td>
                                        <td class="align-center">
                                            <p class="text-sm text-slate-500 text-nowrap">
                                                Rp. {{ number_format($cart->product->price_product, 0, ',', '.') }}
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>

                        <div class="py-4 flex justify-between items-center mt-5 px-20">
                            <table class="table-auto w-full">
                                <tr>
                                    <td class="text-xs text-slate-600 w-full">Subtotal</td>
                                    <td class="text-xs text-slate-800 text-right text-nowrap flex justify-end">
                                        Rp. <div id="subtotal">{{ number_format($total, 0, ',', '.') }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-xs text-slate-600">Postage</td>
                                    <td class="text-xs text-slate-800 text-right text-nowrap">
                                        <div id="ongkir-cek">+</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-xs text-slate-600">Discount</td>
                                    <td class="text-xs text-slate-800 text-right text-nowrap">
                                        <div id="discount">-</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-sm text-slate-600">Total</td>
                                    <td class="text-sm text-slate-800 text-right text-nowrap flex">
                                        Rp.
                                        <div id="total">{{ number_format($total, 0, ',', '.') }}</div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" name="subtotal" id="subtotal_input" value="{{ $total }}" />
                    <input type="hidden" name="discount" id="discount_input" value="0" />
                    <input type="hidden" name="total" id="total_input" value="{{ $total }}" />
                    <input type="hidden" name="weight" id="weight_input" value="{{ $weight }}" />
                    <input type="hidden" name="order_form" value="cart">
                @else
                    <div class="md:fixed static top-0 bg-neutral-100 min-h-screen">
                        <h5 class="px-20 text-2xl font-medium text-slate-800 py-5">
                            1 items
                        </h5>
                        <div class="px-10 h-96 overflow-y-auto">
                            <table class="table-auto w-full">
                                <tr class="sticky top-0 z-10">
                                    <th class="text-slate-700 text-sm font-medium">Image</th>
                                    <td class="text-slate-700 text-sm font-medium">Product</td>
                                    <td class="text-slate-700 text-sm font-medium">Price</td>
                                </tr>
                                <tr class="border-b-2 border-slate-300">
                                    <th>
                                        <div
                                            class="w-28 h-28 bg-cover bg-center overflow-hidden flex justify-center items-center p-5">
                                            <img src="{{ asset('storage/') }}" alt="">
                                        </div>
                                    </th>
                                    <td class="w-full align-bottom">
                                        <p class="text-sm text-slate-700 mb-5">
                                            hp samsung galaxy a55 5g 8/128 8/256 | 5000mAh
                                            <br />
                                            <span class="text-xs text-slate-700">x1</span>
                                        </p>
                                    </td>
                                    <td class="align-center">
                                        <p class="text-sm text-slate-500 text-nowrap">
                                            Rp. 10.000.000
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="py-4 flex justify-between items-center mt-5 px-20">
                            <table class="table-auto w-full">
                                <tr>
                                    <td class="text-xs text-slate-600 w-full">Subtotal</td>
                                    <td class="text-xs text-slate-800 text-right text-nowrap">
                                        Rp. 10.000.000
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-xs text-slate-600">Postage</td>
                                    <td class="text-xs text-slate-800 text-right text-nowrap">
                                        <div id="ongkir-cek">+</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-xs text-slate-600">Discount</td>
                                    <td class="text-xs text-slate-800 text-right text-nowrap">
                                        <div id="discount">-</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-sm text-slate-600">Total</td>
                                    <td class="text-sm text-slate-800 text-right text-nowrap flex">
                                        Rp.
                                        <div id="total">10.000.000</div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" name="subtotal" id="subtotal_input" value="10000000" />
                    <input type="hidden" name="discount" id="discount_input" value="0" />
                    <input type="hidden" name="total" id="total_input" value="10000000" />
                    <input type="hidden" name="weight" id="weight_input" value="0" />
                    <input type="hidden" name="order_form" value="product">
                @endif
            </div>
        </div>
    </form>


    <!-- start address-->
    <div id="show_add_address"
        class="hidden w-full h-screen overflow-hidden fixed top-0 right-0 left-0 bottom-0 z-20 backdrop-brightness-50 flex justify-center p-5">
        <div id="address-content" class="relative bg-white shadow-xl h-full w-full rounded-md md:w-2/5">
            <div class="absolute top-0 right-0 cursor-pointer m-3" id="close-address">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-7 h-7">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path
                            d="M10.0303 8.96965C9.73741 8.67676 9.26253 8.67676 8.96964 8.96965C8.67675 9.26255 8.67675 9.73742 8.96964 10.0303L10.9393 12L8.96966 13.9697C8.67677 14.2625 8.67677 14.7374 8.96966 15.0303C9.26255 15.3232 9.73743 15.3232 10.0303 15.0303L12 13.0607L13.9696 15.0303C14.2625 15.3232 14.7374 15.3232 15.0303 15.0303C15.3232 14.7374 15.3232 14.2625 15.0303 13.9696L13.0606 12L15.0303 10.0303C15.3232 9.73744 15.3232 9.26257 15.0303 8.96968C14.7374 8.67678 14.2625 8.67678 13.9696 8.96968L12 10.9393L10.0303 8.96965Z"
                            fill="#1C274C"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12 1.25C6.06294 1.25 1.25 6.06294 1.25 12C1.25 17.9371 6.06294 22.75 12 22.75C17.9371 22.75 22.75 17.9371 22.75 12C22.75 6.06294 17.9371 1.25 12 1.25ZM2.75 12C2.75 6.89137 6.89137 2.75 12 2.75C17.1086 2.75 21.25 6.89137 21.25 12C21.25 17.1086 17.1086 21.25 12 21.25C6.89137 21.25 2.75 17.1086 2.75 12Z"
                            fill="#1C274C"></path>
                    </g>
                </svg>
            </div>
            <div class="p-5 pt-12 overflow-y-auto">
                <form action="{{ route('user.addresses.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="mark" class="text-slate-700 font-medium text-sm">
                            Mark
                        </label>
                        <input type="text" id="mark" name="mark"
                            class="w-full py-3 px-3 outline-none border border-gray-300 text-slate-700 rounded-lg text-sm"
                            placeholder="Rumah, Kantor, Kosan, ...">
                    </div>
                    <div class="mb-3">
                        <label for="city_id" class="text-slate-700 font-medium text-sm">
                            City
                        </label>
                        <select name="city_id" id="city_id"
                            class="w-full py-3 px-3 outline-none border border-gray-300 text-slate-700 rounded-lg text-sm">
                            <option value="" selected disabled>Select City</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="no_telp" class="text-slate-700 font-medium text-sm">
                            No Telp
                        </label>
                        <input type="number" name="no_telepon"
                            class="w-full py-3 px-3 outline-none border border-gray-300 text-slate-700 rounded-lg text-sm"
                            placeholder="628**********">
                    </div>

                    <div class="mb-3">
                        <label for="address" class="text-slate-700 font-medium text-sm">
                            Alamat
                        </label>
                        <textarea name="address" id="address" rows="5"
                            class="w-full py-3 px-3 outline-none border border-gray-300 text-slate-700 rounded-lg text-sm"
                            placeholder="Jalan 123, Kota ..., ...."></textarea>
                    </div>

                    <button type="submit"
                        class="bg-blue-500 text-white px-5 py-2 text-sm text-slate-700 rounded-md w-full">
                        Save Address
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- end address-->

    <script>
        const subtotal_input = document.getElementById("subtotal_input");
        const discount_input = document.getElementById("discount_input");
        const total_input = document.getElementById("total_input");
        const weight_input = document.getElementById("weight_input");
        const order_form_input = document.getElementById("order_form");
        const dropzone_file_input = document.getElementById("dropzone-file");
        const vocher_input = document.getElementById("vocher");
        const courier_input = document.getElementById("courier");
        const id_discount_input = document.getElementById('id_discount');
        const discount = document.getElementById("discount");
        const ongkir = document.getElementById("ongkir-cek");
        const sub_total = document.getElementById("subtotal");
        const total = document.getElementById("total");
        const addresses_id = document.getElementById("addresses_id");

        let courier = false
        let city_id = false
        let weight = 0;

        function ShowAddAddress() {
            const show_add_address = document.getElementById('show_add_address')
            const close_address = document.getElementById('close-address')

            show_add_address.classList.remove('hidden');
            close_address.addEventListener('click', function() {
                show_add_address.classList.add('hidden');
            })


            show_add_address.addEventListener("click", (e) => {
                if (!e.target.closest("#address-content")) {
                    show_add_address.classList.add("hidden");
                }
            });
        }



        function preview(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function() {
                const img = document.getElementById("bukti_area");
                img.src = reader.result;
                const preview = document.getElementById("bukti_area_preview");
                preview.classList.remove("hidden");
                const text_area = document.getElementById("text_area");
                text_area.classList.add("hidden");
            };

        }

        async function checkVoucher(el) {
            el.disabled = true;
            const vocher = vocher_input.value;
            const total = total_input.value;
            let message = document.getElementById("voucher-status");
            message.innerHTML = `<span class="text-xs text-slate-700 font-medium">Checking voucher...</span>`;

            if (vocher.trim() === '') {
                setTimeout(() => {
                    message.innerHTML =
                        `<span class="text-xs text-yellow-700 font-medium">Vocher Not Found</span>`;
                    el.disabled = false;
                }, 1000);
                return;

            };

            const response = await fetch('/api/validate-promo', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                body: JSON.stringify({
                    code: vocher,
                    total: total
                })
            });
            const data = await response.json();
            if (data.status === 'success') {
                message.innerHTML = `<span class="text-xs text-green-500 font-medium">Voucher code is valid</span>`;
                id_discount_input.value = data.id;
                discount_input.value = data.discount;
                discount.textContent = `-Rp. ${parseInt(data.discount).toLocaleString("id-ID")}`;
                setTotal();
                el.disabled = false;

            } else if (data.status === 'error') {
                message.innerHTML = `<span class="text-xs text-red-500 font-medium">${data.message}</span>`;
                id_discount_input.value = "";
                discount_input.value = 0;
                discount.textContent = 0;
                setTotal('clear');
                el.disabled = false;

            } else {
                message.innerHTML = `<span class="text-xs text-green-500 font-medium">Error</span>`;
                id_discount_input.value = "";
                discount_input.value = 0;
                discount.textContent = 0;
                setTotal('clear');
                el.disabled = false;

            }
        }


        window.addEventListener("DOMContentLoaded", function() {
            city_id = document.querySelector("input[name='alamat']:checked").value
            addresses_id.value = document.querySelector("input[name='alamat']:checked").getAttribute(
                "data-addresses_id")

            weight = weight_input.value
            setTotal();
        })


        function setTotal(clear) {
            let totalAmount = 0;
            if (clear == "clear") {
                ongkir.innerHTML = totalAmount;
            }

            // subtotal
            totalAmount += parseInt(subtotal_input.value);

            // ongkir
            const input_courier = document.querySelector("input[name='cost']:checked")
            let cek_courier = 0;
            if (input_courier) {
                cek_courier = parseInt(input_courier.value);
            }

            ongkir.innerHTML = `+ Rp. ${parseInt(cek_courier).toLocaleString("id-ID")}`;

            totalAmount += parseInt(cek_courier);

            // discount
            totalAmount -= parseInt(discount_input.value);

            // total
            total.innerHTML = totalAmount.toLocaleString("id-ID");

            // set total
            document.getElementById("total_input").value = totalAmount;
        }


        function minus(id, price, product_id_quantity = false) {
            const input = document.getElementById(id);
            if (input.value > 1) {
                const quantity = input.value = parseInt(input.value) - 1;
                if (product_id_quantity) {
                    document.getElementById(product_id_quantity).value = quantity;
                }

                const sti = parseInt(subtotal_input.value) - parseInt(price);
                subtotal_input.value = sti;
                sub_total.textContent = sti.toLocaleString('id-ID');

                const ti = parseInt(total_input.value) - parseInt(price);
                total_input.value = ti;
                total.textContent = ti.toLocaleString('id-ID');
            }

        }

        function plus(id, max, price, product_id_quantity = false) {
            const input = document.getElementById(id);
            if (input.value < max) {
                const quantity = input.value = parseInt(input.value) + 1;
                if (product_id_quantity) {
                    document.getElementById(product_id_quantity).value = quantity;
                }

                const sti = parseInt(subtotal_input.value) + parseInt(price);
                subtotal_input.value = sti;
                sub_total.textContent = sti.toLocaleString('id-ID');

                const ti = parseInt(total_input.value) + parseInt(price);
                total_input.value = ti;
                total.textContent = ti.toLocaleString('id-ID');



            }
        }

        function setAddress(event) {
            city_id = document.querySelector("input[name='alamat']:checked").value
            addresses_id.value = document.querySelector("input[name='alamat']:checked").getAttribute("data-addresses_id")

            if (!courier) return false;
            setCity()
        }

        function setCourier(value) {
            courier = value
            setCity()
        }

        async function setCity() {

            ongkir.innerHTML = `+ Rp. 0`;

            const costs_document = document.getElementById('costs')

            costs_document.innerHTML = `<p class="text-slate-700 font-medium text-md">Loading...</p>`
            const response = await fetch('/api/raja-ongkir/cost', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                body: JSON.stringify({
                    destination: city_id,
                    weight: 97,
                    courier: courier
                })
            });
            const data = await response.json();
            const rajaongkir = await data.rajaongkir;
            if (rajaongkir.status.code === 200) {

                const costs = rajaongkir.results[0].costs;

                let elementChild =
                    '<label for="courier" class="text-slate-700 font-medium text-sm">Courier & Cost</label><div class="w-full border border-gray-300 rounded-lg overflow-hidden">';
                costs.forEach(cost => {
                    elementChild += `<div class="flex gap-5 border-b-2 py-2 px-3">
                    <input onchange="setTotal()" type="radio" name="cost" id="courier_${cost.service}" value="${(cost.cost[0].value)}"  />
                    <label for="courier_${cost.service}" class="w-full">
                            <h6 class="text-md text-slate-700 font-semibold">${cost.service}</h6>
                            <p class="text-sm text-slate-600 mb-3">${cost.description}</p>
                            <p class="text-lg font-medium text-slate-800">Rp. ${(cost.cost[0].value).toLocaleString("id-ID")}</p>
                    </label>
                    </div>`
                });
                elementChild += '</div>'
                costs_document.innerHTML = elementChild

            } else {
                alert('error')
            }
        }
    </script>
</body>

</html>
