<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactor;
use Illuminate\Support\Facades\Auth;

use App\Models\Carro;

class CarrosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carros = Carro::all();

        return view('carros.index')->with('carros', $carros);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'termo' => 'required'
        ]);

        $termo = $request->termo;

    // buscar no site
        $ch = curl_init();
        $url = "https://www.questmultimarcas.com.br/estoque?termo=$termo";

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output  = curl_exec($ch);
        $error = curl_errno($ch);

        curl_close($ch);

        if ($error === 0) {

            // pegar cada carro e coloca em um array, caso nao tenha returna vazio
            $regexCarros = '/<article class=\"card clearfix\" id=\"(.*?)\">(.*?)<\/article>/s';

            preg_match_all($regexCarros, $output, $carros, PREG_SET_ORDER);

            // verifica se achou algum carro
            if($carros) {
                foreach ($carros as $carro) {

                    $carroFiltro = $carro[0];

        // filtro modelo e link
                    $regexModelo = '/<h2 class=\"card__title ui-title-inner\"><a href=\"(.*?)\">(.*?)<\/a><\/h2>/s';
                    preg_match_all($regexModelo, $carroFiltro, $modelo, PREG_SET_ORDER);

        // filtro img
                    $regexImg = '/<img width=\"827\" height=\"593\" src=\"(.*?)\" class=\"img-responsive wp-post-image\"/s';
                    preg_match_all($regexImg, $carroFiltro, $imgResult, PREG_SET_ORDER);

        // filtro detalhes carro ano cor portas etc ....
                    $regexDetalhes = '/<span class=\"card-list__info\">(.*?)<\/span>/s';
                    preg_match_all($regexDetalhes, $carroFiltro, $detalhes);

                    $link = trim(preg_replace('/\s+/', ' ', $modelo[0][1]));
                    $nomeVeiculo = $modelo[0][2];
                    $img = $imgResult[0][1];
                    $ano = trim(preg_replace('/\s+/', ' ', $detalhes[1][0]));
                    $quilometragem = trim(preg_replace('/\s+/', '', $detalhes[1][1]));
                    $combustivel = trim(preg_replace('/\s+/', '', $detalhes[1][2]));
                    $cambio = trim(preg_replace('/\s+/', '', $detalhes[1][3]));
                    $cor = trim(preg_replace('/\s+/', '', $detalhes[1][5]));
                    $portasString = trim(preg_replace('/\s+/', '', $detalhes[1][4]));
                    $portas = str_replace('portas', "", $portasString);
/*
                    Carro::create([
                        'link' => $link,
                        'img' => $img,
                        'id_usuario' => Auth::user()->id,
                        'nome_veiculo' => $nomeVeiculo,
                        'ano' => $ano,
                        'quilometragem' => $quilometragem,
                        'combustivel' => $combustivel,
                        'cambio' => $cambio,
                        'cor' => $cor,
                        'portas' => $portas
                    ]);
*/
                    Carro::firstOrCreate(
                        ['link' => $link],
                        [
                            'img' => $img,
                            'id_usuario' => Auth::user()->id,
                            'nome_veiculo' => $nomeVeiculo,
                            'ano' => $ano,
                            'quilometragem' => $quilometragem,
                            'combustivel' => $combustivel,
                            'cambio' => $cambio,
                            'cor' => $cor,
                            'portas' => $portas
                        ]
                    );


                }

                return response()->json(['success'=>'Carro salvo com sucesso']);

            } else {
                return response()->json(['error'=>'Carro não encontrado.']);
            }

        } else {
            return response()->json(['error'=>'Error 500.']);
        }

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $carro = Carro::findOrFail($id);
            $carro->delete();
            return $carro;
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Error 500.']);
        }

    }

    function filtroPreco($carroFiltro)
    {
        $regexPreco = '/<span class=\"card__price-number\">(.*?)<span class=\"after-price-text\"><\/span><\/span>/s';
        preg_match_all($regexPreco, $carroFiltro, $preco, PREG_SET_ORDER);
        return $preco[0][1];
    }

}
