@if (isset($siswa))
{!! Form::hidden('id', $siswa->id) !!}    
@endif 

@if ($errors->any())
<div class="form-group {{ $errors->has('nisn') ? 'has-error' : 'has-success'}}">
@else 
<div class="form-group">
@endif
    {!! Form::label('nisn', 'NISN :', ['class'=>'control-label']) !!}
    {!! Form::text('nisn', null, ['class'=>'form-control']) !!}
</div>

@if ($errors->any())
<div class="form-group {{ $errors->has('nama_siswa') ? 'has-error' : 'has-success'}}">
@else 
<div class="form-group">
@endif
    {!! Form::label('nama_siswa', 'Nama :', ['class'=>'control-label']) !!}
    {!! Form::text('nama_siswa', null, ['class'=>'form-control']) !!}
</div>

@if ($errors->any())
<div class="form-group {{ $errors->has('tanggal_lahir') ? 'has-error' : 'has-success'}}">
@else 
<div class="form-group">
@endif
    {!! Form::label('tanggal_lahir', 'Tgl Lahir :', ['class'=>'control-label']) !!}
    {!! Form::date('tanggal_lahir', null, ['class'=>'form-control', 'id'=>'tanggal_lahir']) !!}
</div>

@if ($errors->any())
<div class="form-group {{ $errors->has('id_kelas') ? 'has-error' : 'has-success'}}">
@else 
<div class="form-group">
@endif
    {!! Form::label('id_kelas', 'Kelas :', ['class'=>'control-label']) !!}
    @if (count($list_kelas) > 0)
        {!! Form::select('id_kelas', $list_kelas, null, ['class'=>'form-control', 'id'=>'id_kelas', 'placeholder'=>'Pilih Kelas']) !!}
    @else 
        <p>Tidak ada pilihan kelas, buat dulu ya ..</p>
    @endif
    @if ($errors->has('id_kelas'))
        <span class="help-block">{{ $errors->first('id_kelas') }}</span>
    @endif  
</div>

@if ($errors->any())
<div class="form-group {{ $errors->has('jenis_kelamin') ? 'has-error' : 'has-success'}}">
@else 
<div class="form-group">
@endif
    {!! Form::label('jenis_kelamin', 'Jenis Kelamin :', ['class'=>'control-label']) !!}
    <div class="radio">
        <label>{!! Form::radio('jenis_kelamin', 'L') !!} Laki-Laki</label>
    </div>
    <div class="radio">
        <label>{!! Form::radio('jenis_kelamin', 'P') !!} Perempuan</label>
    </div>
</div>

@if ($errors->any())
<div class="form-group {{ $errors->has('nomor_telepon') ? 'has-error' : 'has-success'}}">
@else 
<div class="form-group">
@endif
    {!! Form::label('nomor_telepon', 'Telepon :', ['class'=>'control-label']) !!}
    {!! Form::text('nomor_telepon', null, ['class'=>'form-control']) !!}
</div>

@if ($errors->any())
<div class="form-group {{ $errors->has('hobi_siswa') ? 'has-error' : 'has-success'}}">
@else 
<div class="form-group">
@endif
    {!! Form::label('hobi_siswa', 'Hobi :', ['class'=>'control-label']) !!}
    @if (count($list_hobi) > 0)
        @foreach($list_hobi as $key => $value)
            <div class="checkbox">
                <label>{!! Form::checkbox('hobi_siswa[]', $key, null) !!} {{$value}}</label>
            </div>
        @endforeach
    @else 
        <p>Tidak ada pilihan hobi, buat dulu ya ..</p>
    @endif
    @if ($errors->has('hobi'))
        <span class="help-block">{{ $errors->first('hobi') }}</span>
    @endif  
</div>

@if ($errors->any())
<div class="form-group {{ $errors->has('foto') ? 'has-error' : 'has-success'}}">
@else 
<div class="form-group">
@endif
    {!! Form::label('foto', 'Foto :', ['class'=>'control-label']) !!}
    {!! Form::file('foto', ['class'=>'form-control']) !!}
    @if ($errors->has('foto'))
        <span class="help-block">{{ $errors->first('foto') }}</span>
    @endif

    <!-- MENAMPILKAN FOTO -->
    @if (isset($siswa->foto))
        <img src="{{asset('fotoupload/'.$siswa->foto)}}"/>
    @else 
        @if (isset($siswa->foto) && $siswa->jenis_kelamin == 'L')
        <img src="{{asset('fotoupload/male.png')}}"/>
        @else 
        <img src="{{asset('fotoupload/female.png')}}"/>
        @endif
    @endif
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class'=>'btn btn-primary']) !!}
</div>
