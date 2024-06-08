
<div class="form-group col-sm-6">
    {!! Form::label('finition', 'Type Finition:') !!}
    {!! Form::select('finition', $finition->pluck('nom', 'id')->toArray(), null, ['class' => 'form-control', 'required']) !!}
</div>


<div class="form-group col-sm-6">
    {!! Form::label('heure', 'Heure:') !!}
    {!! Form::date('date', null, ['class' => 'form-control', 'required', 'max' => 100]) !!}
</div>
<input type="hidden" name="id" id="" value="{{ $id }}">
