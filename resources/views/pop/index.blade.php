@extends('layouts.default')

@section('header')
    @parent
<div class="page-header">
    <h1 class="page-title">POPs</h1>
    <!-- <div class="page-header-actions">
        <a href="{{ route('pop.create') }}" class="btn btn-secondary btn-round">Criar POP</a>
    </div> -->
</div>
@endsection

@section('content')
<div id="popList"></div>
@endsection
