{{ csrf_field() }}
<input type="hidden" name="turma" value="{{ $turma->id }}" required>

<div class="form-group {{ $errors->has('diaInicial') ? 'has-error' : '' }}">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        <input type="text" value="{{ old('dataInicial') }}" minlength="10" maxlength="10" class="form-control datepicker" name="dataInicial" title="Dia inicial do intervalo" placeholder="Dia inicial do intervalo no formato dd/mm/aaaa" required>
    </div>
    @if($errors->has('dataInicial'))
        <div class="help-block">
            {!! $errors->first('dataInicial') !!}
        </div>
    @endif
</div>

<div class="form-group" {{ $errors->has('dataFinal') ? 'has-error' : '' }}>
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        <input type="text" value="{{ old('dataFinal') }}" minlength="10" maxlength="10" class="form-control datepicker" name="dataFinal" title="Dia final do intervalo" placeholder="Dia final do intervalo no formato dd/mm/aaaa">
    </div>
    @if($errors->has('dataFinal'))
        <div class="help-block">
            {!! $errors->first('dataFinal') !!}
        </div>
    @endif
</div>

<div class="form-group">
    <div class="input-group text-left">
        <span class="input-group-addon">Dias da semana</span>
        <input type="checkbox" name="dias[]" value="1"> Segunda-feira<br>
        <input type="checkbox" name="dias[]" value="2"> Terça-feira<br>
        <input type="checkbox" name="dias[]" value="3"> Quarta-feira<br>
        <input type="checkbox" name="dias[]" value="4"> Quinta-feira<br>
        <input type="checkbox" name="dias[]" value="5"> Sexta-feira<br>
        <input type="checkbox" name="dias[]" value="6"> Sábado<br>
        <input type="checkbox" name="dias[]" value="0"> Domingo<br>
    </div>
</div>

<label for="dia" class="radio-inline">
    <input id="dia" type="radio" name="opcao" value="dia">
    Somente um dia
</label>

<label for="intervalo" class="radio-inline">
    <input type="radio" id="intervalo" name="opcao" value="intervalo" checked>
    Intervalo
</label>

@if($errors->has('opcao'))
    <div class="help-block has-error">
        {{ $errors->first('opcao') }}
    </div>
@endif

<div class="help-block">
    <p class="text-center">
        Se você selecionar apenas um dia, não é necessário preencher a segunda entrada relativa ao dia final do intervalo.<br>
        Se nenhum dia da semana for selecionado, todos os dias serão exibidos.
    </p>
</div>

<div class="form-group text-center">
    <button type="button" class="btn btn-ufop" onclick="history.back()"><i class="fa fa-arrow-left"></i> Voltar</button>
    <button type="reset" class="btn btn-warning"><i class="fa fa-eraser"></i> Limpar</button>
    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Selecionar</button>
</div>