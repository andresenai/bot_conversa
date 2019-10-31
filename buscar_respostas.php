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

?>