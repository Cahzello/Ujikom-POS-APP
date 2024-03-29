@extends('layouts.main')

@section('container')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transactions</h1>
    </div>

    <div class="card ">
        <div class="card-header">
            <div class="row justify-content-between">
                <div class="col-xl-6 col-md-6 mb-2">
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sint, hic exercitationem illum numquam ea
                        tenetur molestiae est quaerat ipsam consequuntur ad iste velit! Reiciendis neque autem eligendi
                        laudantium dolore amet.</p>
                </div>
                <div class="col-xl-auto col-md-6 mb-2">
                    <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-100">
                            <i class="fas fa-exchange-alt"></i>
                        </span>
                        <span class="text">Create Transactions</span>
                    </a>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="card-body">
            <div class="table-responsive-md">
                <table class="table table-striped table-bordered table-hover text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th rowspan="2" class="align-middle">No</th>
                            <th rowspan="2" class="align-middle">Cashier Name</th>
                            <th rowspan="2" class="align-middle">Customer Name</th>
                            <th rowspan="2" class="align-middle">Total Amount</th>
                            <th rowspan="2" class="align-middle">Timestamps</th>
                            <th colspan="2" class="align-middle">Actions</th>
                        </tr>
                        <tr>
                            <th>Show</th>
                            @if (Gate::any(['owner', 'isAdmin']))
                                <th>Delete</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data->count() > 0)
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td style="width: 5%;">{{ $data->firstItem() + $loop->index }}</td>
                                    <td>{{ $userName[$key] }}</td>
                                    <td>{{ $customerName[$key] }}</td>
                                    <td>Rp {{ number_format($item->total_amount) }}</td>
                                    <td>{{ $item->created_at->setTimeZone('Asia/Jakarta')->toDayDateTimeString() }}</td>
                                    <td style="width: 10%;">
                                        <a href="{{ route('transactions.show', $item->id) }}" title="Edit"
                                            class="btn btn-success"><i class="fas fa-eye"></i> </a>
                                    </td>
                                    @if (Gate::any(['owner', 'isAdmin']))
                                        <td style="width: 10%;">
                                            <form action="{{ route('transactions.destroy', $item->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button title="Delete" class="btn btn-danger"
                                                    onclick="return confirm('Are you want to delete this data?')"><i
                                                        class="fas fa-trash "></i></button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8">No Data</td>
                            </tr>
                        @endif

                    </tbody>
                </table>
                {{ $data->links('pagination::bootstrap-4') }}

            </div>
        </div>
    </div>
@endsection
