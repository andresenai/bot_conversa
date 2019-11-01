<?php

    include 'MySQL.php';

    if(isset($_GET['novaResposta']) && isset($_GET['pergunta']))
    {
        $idPergunta = $_GET['pergunta'];
        $resposta = $_GET['novaResposta'];

        try
        {
            $banco = new MySQL("localhost","root","","billy");

            // insere a resposta no banco de dados
            $sql = "insert into respostas (texto_resp) values (?)";
            $saida = $banco->query($sql,"s",[$resposta]);
            
            if($saida->linhasAfetadas > 0)
            {
                
                // busca o id da pergunta que você acabou de cadastrar
                $sql = "select id_resp from respostas where texto_resp = ?";
                $saida = $banco->query($sql,"s",[$resposta]);
                $idResposta = $saida->linhas[0][0];

                // insere a relação no banco de dados
                $sql = "insert into perg_resp (fk_perg, fk_resp) values (?,?)";
                $saida = $banco->query($sql,"ii",[$idPergunta, $idResposta]);
                if($saida->linhas > 0)
                {
                    echo "SUCESSO AO CADASTRAR RESPOSTA";
                }
                else
                {
                    echo "ERRO AO RELACIONAR PERGUNTA E RESPOSTA";
                }


            }
            else
            {
                echo "FALHA AO INSERIR RESPOSTA NO BANCO";
            }

        }
        catch (Exception $erro) {
            echo $erro->getMessage();
        }
    }
    else
    {
        echo "ERRO NA ENTRADA DE DADOS";
    }
?>