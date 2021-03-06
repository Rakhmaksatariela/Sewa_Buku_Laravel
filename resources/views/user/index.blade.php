@extends('layout.master')

@section('content')
    <div class="container">
        <h4>Data User</h4>
        <p align="right"><a href ="{{ route('user.create') }}" class="btn btn-primary">Tambah User</a></p>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Level</th>
                    <th>Edit</th>
                    <th>Hapus</td>
                </tr>
            <tbody>
                <?php $i = 0; ?>
                @foreach ($user_list as $user)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->level }}</td>
                    <td><a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a></td>
                    <td>
                        <form method="post" action="{{ route('user.destroy',$user->id) }}">
                            @csrf
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Andayakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </thead>
        </table>

        <div class="pull-left">
            <strong>
                Jumlah User : {{ $jumlah_user }}
                {{ $user_list->links('pagination::bootstrap-4') }}
            </strong>
        </div>
    </div>
@endsection

