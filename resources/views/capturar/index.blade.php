@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

                <form>
                    @csrf
                    <div class="input-group">
                        <input class="form-control" type="text" name="termo" id="termo" placeholder="audi">
                        <div class="input-group-append">
                            <button class="btn btn-primary" id="capturar">Capturar</button>
                        </div>
                    </div>
                </form>

        </div>
    </div>
</div>

@endsection

@section('js')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>

    $("#capturar").click(function(e){
        e.preventDefault();

        let _token = $("input[name='_token']").val();
        let termo = document.getElementById('termo').value

        $.ajax({
            url: "{{ route('carros.store') }}",
            type:'POST',
            data: {_token:_token, termo:termo},
            success: function(data) {
                printMsg(data);
            },
            error: function(data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Algo deu erro!',
                    text: data.error
                })
            }
        });
    });

    function printMsg (msg) {
        if($.isEmptyObject(msg.error)){
            Swal.fire({
                icon: 'success',
                title: 'Adicionado',
                text: msg.success
            })
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: msg.error
            })
        }
    }



</script>
@endsection
