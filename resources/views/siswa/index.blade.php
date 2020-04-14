@extends('template')

@section('main')
        <div id="siswa">
                <h2>Siswa</h2>
                
                @include ('_partial.flash_message')
                
                @include ('siswa.form_pencarian')

                @if (!empty($siswa))
                        <table class="table">
                                <thead>
                                        <tr>
                                                <th>NISN</th>
                                                <th>Nama</th>
                                                <th>Kelas</th>
                                                <th>Tgl Lahir</th>
                                                <th>Kelamin</th>
                                                <th>Telepon</th>
                                                <th>Action</th>
                                        </tr>
                                </thead>
                                <tbody>
                                        @foreach ($siswa as $sis)
                                        <tr>
                                                <td>{{ $sis->nisn }}</td>
                                                <td>{{ $sis->nama_siswa }}</td>
                                                <td>{{ $sis->kelas->nama_kelas }}</td>
                                                <td>{{ $sis->tanggal_lahir }}</td>
                                                <td>{{ $sis->jenis_kelamin }}</td>
                                                <td>{{ !empty($sis->telepon->nomor_telepon) ? $sis->telepon->nomor_telepon : '-' }}</td>
                                                <td>
                                                        <div class="box-button">
                                                                <a href="{{url('siswa/'.$sis->id)}}" class="btn btn-primary btn-sm">Detail</a>
                                                        </div>
                                                        @if (Auth::check())
                                                        <div class="box-button">
                                                                <a href="{{url('siswa/'.$sis->id.'/edit')}}" class="btn btn-warning btn-sm">Edit</a>
                                                        </div>
                                                        <div class="box-button">
                                                                {!! Form::open(['method'=>'DELETE', 'action' => ['SiswaController@destroy', $sis->id]]) !!}
                                                                {!! Form::submit('Delete', ['class'=>'btn btn-danger btn-sm']) !!}
                                                                {!! Form::close() !!}
                                                        </div>
                                                        @endif
                                                </td>
                                        </tr>    
                                        @endforeach
                                </tbody>
                        </table>
                @else
                <p>Tidak ada data siswa.</p>
                @endif

                <div class="table-nav">
                        <div class="jumlah-data">
                                <strong>Jumlah Siswa : {{$jumlah}}</strong>
                        </div>
                        <div class="paging">
                                {{ $siswa->links() }}
                        </div>
                </div>
                
                <div class="bottom-nav">
                        <div>
                                <a href="{{url('siswa/create')}}" class="btn btn-primary">Tambah Siswa</a>
                        </div>
                </div>
        </div>
@endsection

@section('footer')
        @include('footer')
@endsection