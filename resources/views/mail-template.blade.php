<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seu pedido</title>
</head>

<body>
    <p>Pedido: {{$pedido->id_pedido}}</p>
    <p>Nome do cliente: {{ $cliente->nome }}</p>
    <p>Email do cliente: {{ $cliente->email }}</p>
    <p>CPF: {{ $cliente->cpf }}</p>
    <p>Sexo: {{ $cliente->sexo }}</p>

    <table class="table table-bordered">
        <thead>
            <tr class="table-danger">
                <td>Nome do Produto</td>
                <td>Cor</td>
                <td>Tamanho</td>
                <td>Valor</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($pedido->produtos as $pedido)
            <tr>
                <td>{{ $data->nome }}</td>
                <td>{{ $data->cor }}</td>
                <td>{{ $data->tamanho }}</td>
                <td>{{ $data->valor }}</td>
                <td>Quantidade: {{ $data->valor }}</td>
                <td>Subtotal: {{ $data->valor }}</td>
            </tr>
            @endforeach
            <tr>
                Total:
            </tr>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>