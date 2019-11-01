<?php

    include "MySQL.php";

    $banco = new MySQL("localhost","root","","billy");
    $documento = new DOMDocument();


    // formulario novas perguntas
    $form = $documento->createElement("form");
    $form->setAttribute("method","GET");
    $form->setAttribute("action","cadastrar_pergunta.php");

    $txNovaPergunta = $documento->createElement("input");
    $txNovaPergunta->setAttribute("name","novaPergunta");
    $txNovaPergunta->setAttribute("type","text");
    $txNovaPergunta->setAttribute("placeholder","Texto nova pergunta");

    $btnEnviar = $documento->createElement("input");
    $btnEnviar->setAttribute("name","cadastrar");
    $btnEnviar->setAttribute("type","submit");

    $form->appendChild($txNovaPergunta);
    $form->appendChild($btnEnviar);
    

    echo $documento->saveHTML($form);
    //////////////////////////////////////////////////////////





    // formulario novas respostas
    $form = $documento->createElement("form");
    $form->setAttribute("method","GET");
    $form->setAttribute("action","cadastrar_resposta.php");

    //carrega as perguntas
    $sql = "select id_perg, texto_perg from perguntas";
    $select = $documento->createElement("select");
    $select->setAttribute("name","pergunta");

    $option = $documento->createElement("option");
    $option->nodeValue = "PERGUNTAS";
    $option->setAttribute("value","");
    $select->appendChild($option);

    foreach($banco->query($sql,"",[])->linhas as $linha)
    {
        $option = $documento->createElement("option");
        $option->nodeValue = $linha['texto_perg'];
        $option->setAttribute("value",$linha['id_perg']);
        $select->appendChild($option);
    }


    $txNovaResposta = $documento->createElement("input");
    $txNovaResposta->setAttribute("name","novaResposta");
    $txNovaResposta->setAttribute("type","text");
    $txNovaResposta->setAttribute("placeholder","Texto nova resposta");


    $btnEnviar = $documento->createElement("input");
    $btnEnviar->setAttribute("name","cadastrar");
    $btnEnviar->setAttribute("type","submit");

    $form->appendChild($select);
    $form->appendChild($txNovaResposta);
    $form->appendChild($btnEnviar);
    

    echo $documento->saveHTML($form);
    ///////////////////////////////////////////////////////////////




    // todas as respostas
    $sql = "select id_resp, texto_resp from respostas";
    $select = $documento->createElement("select");
    $select->setAttribute("name","respostas");

    $option = $documento->createElement("option");
    $option->nodeValue = "RESPOSTAS";
    $option->setAttribute("value","");
    $select->appendChild($option);

    foreach($banco->query($sql,"",[])->linhas as $linha)
    {
        $option = $documento->createElement("option");
        $option->nodeValue = $linha['texto_resp'];
        $option->setAttribute("value",$linha['id_resp']);
        $select->appendChild($option);
    }

    echo $documento->saveHTML($select);
    ///////////////////////////////////////////////////////////////////
?>