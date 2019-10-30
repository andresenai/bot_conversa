<?php

    // Tabela de erros
    //  0 - Entradas não foram fornecidas
    //  1 - Erro ao baixar a pagina do wikipedia
    //  2 - O html do wikipedia veio em formato irreconhecivel
    //  3 - Não foi possivel encontrar paragrafos na pagina do wikipedia
    //  4 - Erro ao capturar primeira frase de um paragrafo

    set_error_handler(function($errno, $errstr, $errfile, $errline, $errcontext) {
        // error was suppressed with the @-operator
        if (0 === error_reporting()) {
            return false;
        }

        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    });

    function removerPalavrasInuteis($texto)
    {
        $buscas = explode(" ",$texto);

        $palavrasInuteis = ["tem", "tens", "o", "a", "aos", "ao", "um", "dos", "das", "as", "os", "de", "da", "do", "qual", "quais", "quantas", "quantos", "que", "como", "pois", "porque", "porquanto", "ou", "ora", "pois", "porque", "mas", "porém", "todavia", "contudo", "entretanto", "senão", "tão", "tanto", "tal", "é", "à", "e", "como", "com","na"];

        $palavrasUteis = [];
        foreach($buscas as $palavra)
        {
            if(!in_array($palavra,$palavrasInuteis))
            {
                array_push($palavrasUteis, $palavra);
            }
        }
        return $palavrasUteis;
    }

    function baixarPagina($url)
    {
        try
        {
            $pagina = file_get_contents($url);
            return $pagina;
        }
        catch(Exception $e)
        {
            // echo $e->getMessage();
            throw new Exception("Erro ao baixar a pagina",1);
        }
    }

    function carregarDocumento($html)
    {
        try
        {
            $doc = $html;
            // $doc = new DOMDocument();
            // $doc->loadHTML($html);
            return $doc;
        }
        catch(Exception $e)
        {
            throw new Exception("HTML invalido",2);
        }
    }

    function carregarParagrafos($documento)
    {
        try {
            $paragrafos = explode("<p>",$documento);
            $saida = [];

            for($posicao=1;$posicao < count($paragrafos);$posicao++)
            {
                $p = $paragrafos[$posicao];
                array_push($saida, strip_tags($p));
            }
            return $saida;
        } catch (Exception $th) {
            throw new Exception("Erro ao capturar paragrafos",3);            
        }
    }

    function capturarPrimeiraFrase($texto)
    {
        try
        {
            return explode(".",$texto)[0];
        }catch(Exception $e)
        {
            throw new Exception("Primeira frase inexistente",4);
        }
    }

    function buscarParagrafoQueContem($paragrafos, $palavra)
    {
        foreach($paragrafos as $paragrafo)
        {
            if(strpos($paragrafo,$palavra))
            {
                return $paragrafo;
            }
        }
        return null;
    }

    function inverterBusca($vetor, $posicao)
    {
        foreach($vetor as $p)
        {
            if($p != $posicao)
            {
                return $p;
            }
        }
    }

    function separarEmFrases($paragrafo)
    {
        return explode(".", $paragrafo);
    }

    function buscarFrasesQueContem($frases, $busca)
    {
        $saida = [];
        foreach($frases as $frase)
        {
            if(strpos($frase,$busca))
            {
                array_push($saida, $frase);
            }
        }

        return $saida;
    }

    if(isset($_GET['busca']))
    {
        $busca = $_GET['busca'];
        $baseUrl = 'https://pt.wikipedia.org/wiki/';
        

        $palavrasUteis = removerPalavrasInuteis($busca);
        $paragrafoSaida = null;
        $fraseSaida = null;
        try
        {
            for($i=0;$i<count($palavrasUteis);$i++)
            {
                try
                {
                    $segundaBusca = inverterBusca($palavrasUteis, $palavrasUteis[$i]);

                    $url = $baseUrl.urlencode($palavrasUteis[$i]);
                    $pagina = baixarPagina($url);
                    $documento = carregarDocumento($pagina);
                    $paragrafos = carregarParagrafos($documento);
                    
                    
                    // encontra o primeiro paragrafo da primeira pagina
                    if($paragrafoSaida == null)
                    {
                        $paragrafoSaida = $paragrafos[0];
                        $frases = separarEmFrases($paragrafoSaida);

                        $temp = buscarFrasesQueContem($frases, $segundaBusca);
                        if(count($temp) > 0)
                        {
                            $fraseSaida = $temp[0];
                        }
                    }


                    $auxParagrafo = buscarParagrafoQueContem($paragrafos,$segundaBusca);
                    if($auxParagrafo != null)
                    {
                        $paragrafoSaida = $auxParagrafo;
                        $frases = separarEmFrases($paragrafoSaida);
                        $fraseSaida = buscarFrasesQueContem($frases, $segundaBusca)[0];
                    }
                }catch(Exception $e)
                {
                }
            }

            $fraseFinal = separarEmFrases($paragrafoSaida)[0];

            echo $fraseFinal;
            // var_dump($fraseSaida);
            //var_dump($paragrafoSaida);
        }
        catch(Exception $erro)
        {
            echo $erro->getMessage()."<br>".$erro->getCode();
        }
    }
    else
    {
        echo "0 - Valor de busca não informado";
    }
    
?>