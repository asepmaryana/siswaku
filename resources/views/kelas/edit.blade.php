@extends ('template')

@section ('main')
    <div id="kelas">
        <h2>Edit Kelas</h2>

        {!! Form::model($kelas, ['method'=>'PATCH', 'action'=>['KelasController@update', $kelas->id]]) !!}
        @include ('kelas.form', ['submitButtonText' => 'Update'])
        {!! Form::close() !!}
    </div>
@endsection 

@section ('footer')
    @include ('footer')
@endsection 