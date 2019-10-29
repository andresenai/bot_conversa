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

        $palavrasInuteis = ["tem", "tens", "o", "a", "aos", "ao", "um", "dos", "das", "as", "os", "de", "da", "do", "qual", "quais", "quantas", "quantos", "que", "como", "pois", "porque", "porquanto", "ou", "ora", "pois", "porque", "mas", "porém", "todavia", "contudo", "entretanto", "senão", "tão", "tanto", "tal", "é", "à", "e", "como", "com"];

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
            throw new Exception("Erro ao baixar a pagina",1);
        }
    }

    function carregarDocumento($html)
    {
        try
        {
            $doc = new DOMDocument();
            $doc->loadHTML($html);
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
            return $documento->getElementsByTagName("p");
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


    if(isset($_GET['busca']))
    {
        $busca = $_GET['busca'];
        $url = 'https://pt.wikipedia.org/wiki/'.urlencode($busca);
        
        var_dump(removerPalavrasInuteis($busca));

        try
        {

            // $pagina = baixarPagina($url);

            // $documento = carregarDocumento($pagina);

            // $paragrafos = carregarParagrafos($documento);

            // $primeiroParagrafo = capturarPrimeiraFrase($paragrafos[0]->nodeValue);

            // $posicao = rand(1,$paragrafos->length-1);
            // $paragrafoAleatorio = capturarPrimeiraFrase($paragrafos[$posicao]->nodeValue);


            // echo $primeiroParagrafo."<br><br>\n\n".$paragrafoAleatorio;
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