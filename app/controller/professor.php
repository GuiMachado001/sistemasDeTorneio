<?php

require './app/model/Database.php';


class Professor{
    public int $id_professor;
    public string $nome;
    public string $senha;

    public function cadastrar(){
        $db = new Database('professor');

        $res = $db->insert(
                [
                    'nome'=> $this->nome,
                    'senha'=> $this->senha,

                ]
            );
        return $res;
    }

    public function logar(){
        // Criar instância da classe Database para trabalhar com a tabela professor
        $db = new Database('professor');

        // Realizar uma consulta para buscar o professor pelo nome e senha
        $query = 'SELECT * FROM professor WHERE nome = :nome AND senha = :senha';
        
        // Bind dos parâmetros
        $stmt = $db->execute($query, [
            ':nome' => $this->nome,
            ':senha' => $this->senha
        ]);
        
        // Verificar se encontrou algum resultado
        if ($stmt->rowCount() > 0) {
            // Se encontrar, recuperar os dados do professor
            $professor = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id_professor = $professor['id_professor'];  // Armazenar o id do professor
            return true;  // Sucesso no login
        } else {
            return false;  // Falha no login
        }
    }


}