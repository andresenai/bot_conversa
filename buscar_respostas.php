<?php

    include "MySQL.php";

    $banco = new MySQL("localhost","root","","billy");

    $sql = "select * from perguntas";
    $doc = new DOMDocument();
    $select = $doc->createElement("select");

    foreach($banco->query($sql,"",[])->linhas as $linha)
    {
        $option = $doc->createElement("option");
        $option->nodeValue = $linha['texto_perg'];
        $select->appendChild($option);
    }

    echo $doc->saveHTML($select);


    echo "<br><br><br>";

    // formulario
    $form = $doc->createElement("form");
    $form->setAttribute("method","GET");
    $form->setAttribute("action","cadastrar_pergunta.php");

    $txNovaPergunta = $doc->createElement("input");
    $txNovaPergunta->setAttribute("name","novaPergunta");
    $txNovaPergunta->setAttribute("type","text");

    $btnEnviar = $doc->createElement("input");
    $btnEnviar->setAttribute("name","cadastrar");
    $btnEnviar->setAttribute("type","submit");

    $form->appendChild($txNovaPergunta);
    $form->appendChild($btnEnviar);
    

    echo $doc->saveHTML($form);


    // formulario
    $form = $doc->createElement("form");
    $form->setAttribute("method","GET");
    $form->setAttribute("action","cadastrar_resposta.php");

    //carrega as perguntas
    $sql = "select id_perg, texto_perg from perguntas";
    $select = $doc->createElement("select");
    $select->setAttribute("name","pergunta");
    foreach($banco->query($sql,"",[])->linhas as $linha)
    {
        $option = $doc->createElement("option");
        $option->nodeValue = $linha['texto_perg'];
        $option->setAttribute("value",$linha['id_perg']);
        $select->appendChild($option);
    }
    /////////////////////

    $txNovaPergunta = $doc->createElement("input");
    $txNovaPergunta->setAttribute("name","novaResposta");
    $txNovaPergunta->setAttribute("type","text");

    $btnEnviar = $doc->createElement("input");
    $btnEnviar->setAttribute("name","cadastrar");
    $btnEnviar->setAttribute("type","submit");

    $form->appendChild($select);
    $form->appendChild($txNovaPergunta);
    $form->appendChild($btnEnviar);
    

    echo $doc->saveHTML($form);

?>