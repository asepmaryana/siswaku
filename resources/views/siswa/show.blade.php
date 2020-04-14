@extends('template')

@section('main')
        <div id="siswa">
                <h2>Detail Siswa</h2>
                <table class="table table-striped">
                    <tr>
                        <th>NISN</th>
                        <td>{{ $siswa->nisn }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $siswa->nama_siswa }}</td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td>{{ $siswa->kelas->nama_kelas }}</td>
                    </tr>
                    <tr>
                        <th>Tgl Lahir</th>
                        <td>{{ $siswa->tanggal_lahir }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>{{ $siswa->jenis_kelamin }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ !empty($siswa->telepon->nomor_telepon) ? $siswa->telepon->nomor_telepon : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Hobi</th>
                        <td>
                            @foreach($siswa->hobi as $item)
                            <span> {{$item->nama_hobi}} </span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>Foto</th>
                        <td>
                            @if (isset($siswa->foto))
                                <img src="{{asset('fotoupload/'.$siswa->foto)}}"/>
                            @else 
                                @if ($siswa->jenis_kelamin == 'L')
                                <img src="{{asset('fotoupload/male.png')}}"/>
                                @else 
                                <img src="{{asset('fotoupload/female.png')}}"/>
                                @endif
                            @endif 
                        </td>
                    </tr>
                </table>
        </div>
@endsection

@section('footer')
    @include('footer')
@endsection