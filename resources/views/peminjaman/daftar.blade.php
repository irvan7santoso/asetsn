@extends('layouts.main')

@section('container')
<div class="main-content">
    @include('layouts.alert')
    <div class="container-fluid">
        <!-- Alert -->
        <div id="alert-container" class="alert alert-success" style="display: none;"></div>

        <!-- TABLE HOVER -->
        <div class="panel">
            <div class="panel-body">
                <h1>Peminjaman Aset Yayasan Satunama</h1>
                <div class="row">
                    <div class="col-md-9">
                        <form class="search-left" action="{{ url('peminjaman') }}" method="get">
                            <div class="input-group">
                                <input type="search" class="form-control" name='katakunci' value="{{ Request::get('katakunci') }}" placeholder="Cari Aset/Alat">
                                <span class="input-group-btn"><button type="submit" class="btn btn-success">Cari</button></span>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3 text-right">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#cartModal" id="cartButton" disabled>
                            <i class="lnr lnr-cart"></i> Keranjang Peminjaman (<span id="cart-count">{{ count($cart) }}</span>)
                        </button>
                    </div>
                </div>
                <table class="table table-hover mt-3">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Nama Aset</th>
                            <th>Tahun</th>
                            <th>Nomor Inventaris</th>
                            <th>Nomor Seri</th>
                            <th>Jumlah Tersedia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assets as $asset)
                        <tr>
                            <td><button type="button" class="btn btn-success add-to-cart" data-id="{{ $asset->id }}" data-name="{{ $asset->namabarang }}" data-jumlah="{{ $asset->jumlah_tersedia }}">+</button></td>
                            <td>{{ $asset->namabarang }}</td>
                            <td>{{ $asset->tahun }}</td>
                            <td>{{ $asset->nomorinventaris }}</td>
                            <td>{{ $asset->nomorseri }}</td>
                            <td>{{ $asset->jumlah_tersedia }}</td>
                        </tr>
                        @endforeach
                    </tbody>                  
                </table>
                <div class="pagination">
                    {{ $assets->links() }}
                </div>                
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h2 class="modal-title" id="cartModalLabel">Keranjang Peminjaman</h2>
                </div>
                <div class="modal-body">
                    <form action="/peminjaman/create" method="GET" id="cartForm">
                        <div id="empty-cart-message" class="alert alert-warning" style="display: none;">
                            Keranjang kosong, harap pilih barang yang akan dipinjam!
                        </div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Aset</th>
                                    <th>Jumlah</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="cart-items">
                                <!-- Items will be added by JavaScript -->
                            </tbody>
                        </table>
                        <div class="text-right">
                            <button type="submit" class="btn btn-success" id="submitBorrowButton" disabled>Isi Form Peminjaman</button>
                        </div>
                    </form>
                </div>                
            </div>
        </div>
    </div>

    <style>
    .search-left {
        float: left !important;
    }
    .pagination {
    display: flex;
    justify-content: center;
    padding-left: 0px;
    margin: -5px 0;
    border-radius: 4px;
    }
    .pagination > li {
    display: inline;
    }
    .pagination > li > a,
    .pagination > li > span {
    position: relative;
    float: left;
    padding: 6px 12px;
    margin-left: -1px;
    line-height: 1.42857143;
    color: #327e33;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #ddd;
    }
    .pagination > li:first-child > a,
    .pagination > li:first-child > span {
    margin-left: 0;
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
    }
    .pagination > li:last-child > a,
    .pagination > li:last-child > span {
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
    }
    .pagination > li > a:hover,
    .pagination > li > span:hover,
    .pagination > li > a:focus,
    .pagination > li > span:focus {
    z-index: 2;
    color: #327e33;
    background-color: #eee;
    border-color: #ddd;
    }
    .pagination > .active > a,
    .pagination > .active > span,
    .pagination > .active > a:hover,
    .pagination > .active > span:hover,
    .pagination > .active > a:focus,
    .pagination > .active > span:focus {
    z-index: 3;
    color: #fff;
    cursor: default;
    background-color: #327e33;
    border-color: #327e33;
    }
    .pagination > .disabled > span,
    .pagination > .disabled > span:hover,
    .pagination > .disabled > span:focus,
    .pagination > .disabled > a,
    .pagination > .disabled > a:hover,
    .pagination > .disabled > a:focus {
    color: #777;
    cursor: not-allowed;
    background-color: #fff;
    border-color: #ddd;
    }
    .pagination-lg > li > a,
    .pagination-lg > li > span {
    padding: 10px 16px;
    font-size: 18px;
    line-height: 1.3333333;
    }
    .pagination-lg > li:first-child > a,
    .pagination-lg > li:first-child > span {
    border-top-left-radius: 6px;
    border-bottom-left-radius: 6px;
    }
    .pagination-lg > li:last-child > a,
    .pagination-lg > li:last-child > span {
    border-top-right-radius: 6px;
    border-bottom-right-radius: 6px;
    }
    .pagination-sm > li > a,
    .pagination-sm > li > span {
    padding: 5px 10px;
    font-size: 12px;
    line-height: 1.5;
    }
    .pagination-sm > li:first-child > a,
    .pagination-sm > li:first-child > span {
    border-top-left-radius: 3px;
    border-bottom-left-radius: 3px;
    }
    .pagination-sm > li:last-child > a,
    .pagination-sm > li:last-child > span {
    border-top-right-radius: 3px;
    border-bottom-right-radius: 3px;
    }
    .pager {
    padding-left: 0;
    margin: 20px 0;
    text-align: center;
    list-style: none;
    }
    .pager li {
    display: inline;
    }
    .pager li > a,
    .pager li > span {
    display: inline-block;
    padding: 5px 14px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 15px;
    }
    .pager li > a:hover,
    .pager li > a:focus {
    text-decoration: none;
    background-color: #eee;
    }
    .pager .next > a,
    .pager .next > span {
    float: right;
    }
    .pager .previous > a,
    .pager .previous > span {
    float: left;
    }
    .pager .disabled > a,
    .pager .disabled > a:hover,
    .pager .disabled > a:focus,
    .pager .disabled > span {
    color: #777;
    cursor: not-allowed;
    background-color: #fff;
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let cart = @json($cart); // Load cart data from the session if available
        renderCart(); // Render the cart on page load

        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const maxJumlah = parseInt(this.getAttribute('data-jumlah'));
                addToCart(id, name, maxJumlah);
            });
        });

        function addToCart(id, name, maxJumlah) {
            const index = cart.findIndex(item => item.id === id);
            if (index === -1) {
                cart.push({ id, name, quantity: 1, maxJumlah });
            } else {
                cart[index].quantity = Math.min(cart[index].quantity + 1, cart[index].maxJumlah);
            }
            updateCartInSession(cart);
            renderCart();
            showAlert(`Barang "${name}" telah ditambahkan ke keranjang.`);
        }

        function removeFromCart(id) {
            // Cari item di cart berdasarkan ID dan hapus
            const index = cart.findIndex(item => item.id === id);
            if (index !== -1) {
                cart.splice(index, 1); // Hapus item dari array cart
            }
            
            updateCartInSession(cart); // Perbarui sesi
            renderCart(); // Render ulang tampilan keranjang
            showAlert('Barang telah dihapus dari keranjang.');
        }

        function updateCartInSession(cart) {
            fetch('/update-cart-session', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ cart })
            });
        }

        function renderCart() {
            const cartItems = document.getElementById('cart-items');
            const cartCount = document.getElementById('cart-count');
            const cartButton = document.getElementById('cartButton');
            const submitBorrowButton = document.getElementById('submitBorrowButton');
            const emptyCartMessage = document.getElementById('empty-cart-message');

            cartItems.innerHTML = '';
            cartCount.textContent = cart.length;

            if (cart.length === 0) {
                cartButton.disabled = true;
                submitBorrowButton.disabled = true;
                emptyCartMessage.style.display = 'block';
            } else {
                cartButton.disabled = false;
                submitBorrowButton.disabled = false;
                emptyCartMessage.style.display = 'none';

                cart.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.name}</td>
                        <td><input type="number" class="form-control cart-quantity" data-id="${item.id}" value="${item.quantity}" min="1" max="${item.maxJumlah}"></td>
                        <td><button type="button" class="btn btn-danger remove-from-cart" data-id="${item.id}">Remove</button></td>
                        <input type="hidden" name="pinjam_barang[${item.id}][id]" value="${item.id}">
                        <input type="hidden" name="pinjam_barang[${item.id}][jumlah_dipinjam]" value="${item.quantity}">
                    `;
                    cartItems.appendChild(row);
                });

                document.querySelectorAll('.remove-from-cart').forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        removeFromCart(id);
                    });
                });

                document.querySelectorAll('.cart-quantity').forEach(input => {
                    input.addEventListener('change', function() {
                        const id = this.getAttribute('data-id');
                        const quantity = parseInt(this.value);
                        updateCartQuantity(id, quantity);
                    });
                });
            }
        }

        function showAlert(message) {
            const alertContainer = document.getElementById('alert-container');
            alertContainer.textContent = message;
            alertContainer.style.display = 'block';
            setTimeout(() => {
                alertContainer.style.display = 'none';
            }, 3000);
        }
    });
    </script>
@endsection
