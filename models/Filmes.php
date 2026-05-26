<?php

class Filmes {
    private $conexao;
    
    public function __construct() {
        $this->conectarBD();
    }
    
    private function conectarBD() {
        $host = 'localhost';
        $usuario = 'root';
        $senha = '';
        $banco = 'filmes_db';
        
        $this->conexao = new mysqli($host, $usuario, $senha, $banco);
        
        if ($this->conexao->connect_error) {
            die("Erro de conexão: " . $this->conexao->connect_error);
        }
        
        $this->conexao->set_charset("utf8");
    }
    
    public function criar($nome, $diretor, $data_lancamento, $nota) {
        $nome = $this->conexao->real_escape_string($nome);
        $diretor = $this->conexao->real_escape_string($diretor);
        $data_lancamento = $this->conexao->real_escape_string($data_lancamento);
        $nota = floatval($nota);
        
        $sql = "INSERT INTO filmes (nome, diretor, data_lancamento, nota) 
                VALUES ('$nome', '$diretor', '$data_lancamento', $nota)";
        
        if ($this->conexao->query($sql)) {
            return true;
        } else {
            echo "Erro ao inserir: " . $this->conexao->error;
            return false;
        }
    }
    
    public function listar() {
        $sql = "SELECT * FROM filmes ORDER BY created_at DESC";
        $resultado = $this->conexao->query($sql);
        
        $filmes = [];
        if ($resultado->num_rows > 0) {
            while ($linha = $resultado->fetch_assoc()) {
                $filmes[] = $linha;
            }
        }
        
        return $filmes;
    }
    
    public function obterPorId($id) {
        $id = intval($id);
        $sql = "SELECT * FROM filmes WHERE id = $id";
        $resultado = $this->conexao->query($sql);
        
        if ($resultado->num_rows > 0) {
            return $resultado->fetch_assoc();
        }
        
        return null;
    }
    
    public function atualizar($id, $nome, $diretor, $data_lancamento, $nota) {
        $id = intval($id);
        $nome = $this->conexao->real_escape_string($nome);
        $diretor = $this->conexao->real_escape_string($diretor);
        $data_lancamento = $this->conexao->real_escape_string($data_lancamento);
        $nota = floatval($nota);
        
        $sql = "UPDATE filmes SET 
                nome = '$nome', 
                diretor = '$diretor', 
                data_lancamento = '$data_lancamento', 
                nota = $nota 
                WHERE id = $id";
        
        if ($this->conexao->query($sql)) {
            return true;
        } else {
            echo "Erro ao atualizar: " . $this->conexao->error;
            return false;
        }
    }
    
    public function deletar($id) {
        $id = intval($id);
        $sql = "DELETE FROM filmes WHERE id = $id";
        
        if ($this->conexao->query($sql)) {
            return true;
        } else {
            echo "Erro ao deletar: " . $this->conexao->error;
            return false;
        }
    }
}

?>