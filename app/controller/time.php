<?php

require __DIR__ . '/../model/Database.php';

class Times_torneio {
    public int $id_times;
    public string $nome;
    public int $id_professor;  // Aqui adicionamos o id_professor

    // Método para cadastrar um time
    public function cadastrar(){
        $db = new Database('times');
        
        // Verifica se a tabela times tem as colunas corretas
        $res = $db->insert([
            'nome' => $this->nome,
            'id_professor' => $this->id_professor,  // Guardar o id_professor ao cadastrar
        ]);
        
        // Se a inserção for bem-sucedida, retorna o ID do time inserido
        return $res;
    }

    // Método para buscar os times do professor logado
    public function buscar($where = null, $order = null, $limit = null) {
        // A sessão já foi iniciada pelo init.php
        $id_professor = $_SESSION['id_professor'];  // Pega o ID do professor da sessão
        
        // Alterar o where para filtrar pelos desafios do professor logado
        $where = "id_professor = $id_professor";  // Garantir que estamos buscando apenas os desafios do professor logado
        
        $db = new Database('times');
        $res = $db->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
        return $res;
    }


    // Método para buscar um time pelo id
    public function buscar_por_id($id){
        $id_time = $_GET['id_time'] ?? null;

        $db = new Database('times');
        $obj = $db->select('id_times =' . (int)$id)->fetchObject(self::class);
        return $obj;
    }

    // Método para atualizar um time
    public function atualizar(){
        $db = new Database('times');
        $res = $db->update("id_times =".$this->id_times,
            [
                "nome" => $this->nome,
            ]
        );
        return $res;
    }

    // Método para excluir um time
    public function excluirTime($id_times) {
        $db = new Database();
        $res = $db->deleteTime($id_times);
        return $res;
    }

    
// Times_torneio.php (Controller)

public function getPontos() {
    try {
        $db = new Database();
        
        // Alteração da consulta SQL para filtrar pelos times do professor logado
        $query = "
            SELECT t.nome AS time, SUM(p.pontos) AS pontos
            FROM times t
            LEFT JOIN pontuacao p ON t.id_times = p.id_times
            WHERE t.id_professor = :professor_id  -- Filtra pelos times do professor logado
            GROUP BY t.id_times
        ";
        
        // Prepara e executa a consulta
        $stmt = $db->execute($query, [':professor_id' => $_SESSION['id_professor']]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Usando FETCH_ASSOC para retornar um array associativo
        
        // Se não houver dados, retornamos um array vazio
        if (empty($result)) {
            return ['error' => 'Nenhum time encontrado para este professor.'];
        } else {
            return $result;  // Retorna o resultado como array
        }
    } catch (Exception $e) {
        return ['error' => 'Erro ao obter pontos: ' . $e->getMessage()];
    }
}


    
public function listarTimes() {
    // Cria um objeto de Times_torneio
    $timesController = new Database();
    
    // Chama o método para buscar os times do professor
    $times = $timesController->buscar();

    // Retorna os times para serem usados na view
    return $times;
}


}
?>
