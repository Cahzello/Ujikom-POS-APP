@extends('layouts.main')

@section('container')
    <div class="d-flex-column align-items-center justify-content-between mb-4">
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-icon-split mb-2">
            <span class="icon text-white-100">
                <i class="fas fa-arrow-alt-circle-left"></i>
            </span>
            <span class="text">Go Back</span>
        </a>
        <h1 class="h3 mb-0 text-gray-800">Create Transaction</h1>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row justify-content-between">
                <div class="col-xl-6 col-md-6 mb-2">
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sint, hic exercitationem illum numquam ea
                        tenetur molestiae est quaerat ipsam consequuntur ad iste velit! Reiciendis neque autem eligendi
                        laudantium dolore amet.</p>
                </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <div class="row">
            <div class="card-body col-lg-7">
                <div class="container">
                    {{ $data_item->links('pagination::bootstrap-4') }}
                    <div class="row">
                        <input type="hidden" id="userId" value="{{ auth()->id() }}">
                        @if ($data_item->total() <= 0)
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-center align-items-center flex-column">
                                    <h3>No Items Added</h3>
                                    <a href="{{ route('items.create') }}" class="btn btn-primary">Create Items</a>
                                </div>
                            </div>
                        @else
                            @foreach ($data_item as $item)
                                @if (!$item->stock_level == 0)
                                    <div class="col-lg-4 p-2">
                                        <div class="card shadow-sm">
                                            <img src="{{ $item->item_image ? asset($item->item_image) : '/img/groc_bag.svg' }}"
                                                style="object-fit: cover;" class="rounded" alt="tadfs" height="140px"
                                                width="100%">
                                            <div class="card-body p-2">
                                                <p class="h6">{{ $item->name }}</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <small class="text-body-secondary">Stock:</small>
                                                        <small class="text-body-secondary">{{ $item->stock_level }}</small>
                                                        <br>
                                                        <small class="text-body-secondary">price:</small>
                                                        <small
                                                            class="text-body-secondary">{{ number_format($item->price, 0, '.', '.') }}</small>
                                                    </div>
                                                    <div class="btn-group">
                                                        <button type="button"
                                                            onclick="create_list({{ $item->id }}, '{{ $item->name }}', '{{ number_format($item->price, 0, '.', '') }}', 1, {{ $item->id }})"
                                                            class="btn btn-sm btn-outline-primary">Add</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    {{ $data_item->links('pagination::bootstrap-4') }}
                </div>
            </div>
            <div class="card-body col-lg-5">
                <form action="{{ route('transactions.store') }}" method="POST" id="formListItems">
                    @csrf
                    <table class="table table-hover text-center" id="calculation" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Delete</th>
                            </tr>

                        </thead>
                        <tbody id="calculation_data">
                            <tr>
                                <td colspan="4">The list is currently empty.</td>
                            </tr>
                        </tbody>
                    </table>

                    <hr>

                    <div class="row">
                        <span class="col">
                            <p>Subtotal:</p>
                        </span>
                        <span class="col text-right">
                            <p id="subtotal">0</p>
                        </span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-4">

                        <label for="cusName">Customer Name: </label>
                        <div class="input-group" style="width: 60%;">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="name" id="cusName" placeholder="Input Name"
                                class="form-control">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">

                        <label for="cusEmail">Customer Email: </label>
                        <div class="input-group" style="width: 60%;">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-at"></i></span>
                            </div>
                            <input type="text" name="email" id="cusEmail" placeholder="Input Email"
                                class="form-control">
                        </div>
                    </div>


                    <hr>

                    <input type="hidden" value="" id="totalPriceInput" name="totalPrice">
                    <button type="button" id="clearList" class="btn btn-danger">Clear List</button>
                    <input type="submit" id="charge" value="Charge" class="btn btn-primary">
                </form>

            </div>

        </div>
    </div>

    <script src="/js/calculation.js"></script>
@endsection
