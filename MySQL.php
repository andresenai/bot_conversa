<?php
    class RespostaSQL
    {
        public $linhasAfetadas, $linhas;
    }

    class MySQL
    {
        private $host, $usuario, $senha, $database, $conexao;
        public function __construct($host, $usuario, $senha, $database)
        {
            $this->host = $host;
            $this->usuario = $usuario;
            $this->senha = $senha;
            $this->database = $database;

            $this->conectar();
        }

        public function conectar()
        {
            $this->conexao = new mysqli($this->host, $this->usuario, $this->senha, $this->database);
            if($this->conexao->error === null)
            {
                var_dump($this->conexao);
                throw new Exception("Erro ao conectar no banco de dados");
            }
            $this->conexao->set_charset("utf8");
        }

        public function fechar()
        {
            try {
                $this->conexao->close();
            } catch (Exception $erro) {
            }
        }

        public function __destruct()
        {
            $this->fechar();
        }

        public function query($sql, $tipos, $parametros)
        {
            $smtp = $this->conexao->prepare($sql);
            if($smtp !== false)
            {
                @$smtp->bind_param($tipos, ...$parametros);
                $status = $smtp->execute();
                $result = $smtp->get_result();

                $linhasAfetadas = $smtp->affected_rows;
                $linhas = [];
                if(!$status)
                {
                    throw new Exception("Erro ao executar a query {$sql} erro : {$smtp->error}\n");
                }
                else if($result !== false)
                {
                    $linhas = $result->fetch_all(3);
                }
                $smtp->close();

                $resposta = new RespostaSQL();
                $resposta->linhasAfetadas = $linhasAfetadas;
                $resposta->linhas = $linhas;

                return $resposta;
            }
            else
            {
                throw new Exception("Erro ao executar a query {$sql}\n");
            }
        }
    }
?>
