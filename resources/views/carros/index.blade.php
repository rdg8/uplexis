@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">

                @csrf
                @foreach ($carros as $carro)
                    <div class="col-lg-6 col-md-12" id="c{{ $carro['id'] }}">
                        <div class="card mb-md-5">
                            <img src="{{ $carro['img'] }}" alt="{{ $carro['nome_veiculo'] }}" title="{{ $carro['nome_veiculo'] }}" class="img-fluid mx-auto d-block">
                            <section class="card-body">
                                <h2>{{ $carro['nome_veiculo'] }}</h2>
                                <p>Combustíve: {{ $carro['combustivel'] }}</p>
                                <p>Ano: {{ $carro['ano'] }}</p>
                                <p>Portas: {{ $carro['portas'] }}</p>
                                <p>Câmbio: {{ $carro['cambio'] }}</p>
                                <p>Quilometragem: {{ $carro['quilometragem'] }}</p>
                                <p>cor: {{ $carro['cor'] }}</p>
                                <a href="{{ $carro['link'] }}" title="mais detalhes" class="btn btn-primary" target="_blank">visitar link</a>
                                <input type="submit" value="excluir" class="btn btn-outline-danger deleteCarro" data-id="{{ $carro['id'] }}">
                            </section>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>

$(".deleteCarro").on('click', function(e) {
    e.preventDefault();
    let token = $("input[name='_token']").val();
    let id = $(this).attr("data-id");

    const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Tem certeza que deseja deletar?',
        text: "Você não tera como reverter isso",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, deletar',
        cancelButtonText: 'Não, cancelar!',
        reverseButtons: true
    }).then((result) => {
    if (result.isConfirmed) {

        $.ajax({
            url: "carros/"+id,
            type:'DELETE',
            data: { _token: token },
            success: function(data) {
                if (data.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Algo deu erro!',
                        text: data.error
                    })
                }
                $(`#c${data.id}`).hide();
            },
            error: function(data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Algo deu erro!',
                    text: data.error
                })
            }
        }),

        swalWithBootstrapButtons.fire(
            'Deletado',
            'O carro foi deletado',
            'success'
        )

    } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire(
                'Cancelado',
                'imagino que o carro esteva a salvo = )',
                'error'
            )
        }
    })

});

</script>
@endsection
