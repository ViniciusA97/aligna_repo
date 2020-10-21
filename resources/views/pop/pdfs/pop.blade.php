<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>{{$pop->version->title}}</title>

    <style type="text/css">
        h2,h3,h5{
            font-weight:bold;
        }
        h5{
            font-size: 18px;
        }
        p{
            font-size:14px;
        }
    </style>
  </head>
  <body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h2>#{{$pop->id}}</h2>
                <h3>{{$pop->version->title}}</h3>
            </div>
        </div>

        <div class="row" style="padding-top:20px; margin-bottom:15px;">
            <div class="col-12">
                <h5>Descrição</h5>
                <p>{!! $pop->version->description !!}</p>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">PDCA</th>
                            <th scope="col">Perfil</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                @if($pop->version->pdca)
                                    {{$pop->version->pdca}}
                                @else
                                    Não definido
                                @endif
                            </td>
                            <td>
                                @if($pop->version->perfil)
                                    {{$pop->version->perfil}}
                                @else
                                    Não definido
                                @endif
                            </td>
                            <td>
                                @if($pop->version->status)
                                    {{$pop->version->status}}
                                @else
                                    Não definido
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Funções</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                            @forelse($pop->functions as $item)
                            <span class="badge badge-light">{{$item->title}}</span>
                            @empty
                                <span>Não definido</span>
                            @endforelse
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Processos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                            @forelse($pop->processes as $item)
                            <span class="badge badge-light">{{$item->title}}</span>
                            @empty
                                <span>Não definido</span>
                            @endforelse
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="row">
            <div class="col">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Horas de Execucão</th>
                            <th scope="col">Data de Início</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$pop->version->hours}}</td>
                            <td>
                                @if($pop->version->start_at)
                                    {{$pop->version->start_at->format('d/m/Y')}}
                                @else
                                    <p>Não definido</p> 
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Frequência</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($recurrence)
                            <tr>
                                <td>{{$recurrence->rule}}</td>
                            </tr>
                        @else
                            <tr>
                                <td>Não definido</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div><!-- end container -->
  </body>
</html>
