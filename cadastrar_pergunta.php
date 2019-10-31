<?php

    include 'MySQL.php';

    if(isset($_GET['novaPergunta']))
    {
        $pergunta = $_GET['novaPergunta'];

        try
        {
            $banco = new MySQL("localhost","root","","billy");
            $sql = "insert into perguntas (texto_perg) values (?)";
            $saida = $banco->query($sql,"s",[$pergunta]);
            
            if($saida->linhasAfetadas > 0)
            {
                echo "SUCESSO AO CADASTRAR PERGUNTA";
            }
            else
            {
                echo "FALHA AO INSERIR PERGUNTA NO BANCO";
            }

        }
        catch (Exception $erro) {
            echo $erro->getCode();
        }
    }
?>