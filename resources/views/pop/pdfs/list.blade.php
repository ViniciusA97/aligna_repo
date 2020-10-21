<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>POPs - Lista</title>

    <style type="text/css">
        html, body{margin: 0; padding: 0;}
        body{
            margin: 1.8rem 1rem;
        }
        h2,h3,h5{
            font-weight:bold;
        }
        h5{
            font-size: 18px;
        }
        p{
            font-size:14px;
        }
        th{
            font-size: 12px;
        }
        td{
            font-size: 11px;
            font-weight: normal;
        }
    </style>
  </head>
  <body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th scope="col">POP</th>
                            <th scope="col">Status de Preenchimento</th>
                            <th scope="col">PDCA</th>
                            <th scope="col">Status de Execução</th>
                            <th scope="col">Perfil</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pops as $pop)
                            <tr>
                                <td scope="row">{{$pop->title}}</td>
                                <td>{{$pop->status_preenchimento}}</td>
                                <td>{{$pop->pdca}}</td>
                                <td>{{$pop->status_execucao}}</td>
                                <td>{{$pop->perfil}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div><!-- end container -->
  </body>
</html>
