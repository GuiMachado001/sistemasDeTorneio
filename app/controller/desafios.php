<?php
require '../../app/model/Database.php';

class Desafio{
    public int $id_desafio;
    public int $pontos;
    public string $enunciado;
    public string $opcaoA;
    public string $opcaoB;
    public string $opcaoC;
    public string $opcaoD;
    public string $opcaoE;
    public string $resposta;
    public int $id_professor;

    public function cadastrar() {
        $db = new Database('desafio');
        
        // Obter o ID do professor da sessão
        session_start();
        $id_professor = $_SESSION['id_professor'];

        // Associamos o id_professor ao desafio
        $res = $db->insert(
            [
                'pontos' => $this->pontos,
                'enunciado' => $this->enunciado,
                'opcaoA' => $this->opcaoA,
                'opcaoB' => $this->opcaoB,
                'opcaoC' => $this->opcaoC,
                'opcaoD' => $this->opcaoD,
                'opcaoE' => $this->opcaoE,
                'resposta' => $this->resposta,
                'id_professor' => $id_professor  // Associando o id_professor
            ]
        );
        return $res;
    }

    public function buscar($where = null, $order = null, $limit = null) {
        session_start();
        $id_professor = $_SESSION['id_professor'];  // Pega o ID do professor da sessão
        
        // Alterar o where para filtrar pelos desafios do professor logado
        $where = "id_professor = $id_professor";  // Garantir que estamos buscando apenas os times do professor logado
        
        $db = new Database('times_torneio');
        $res = $db->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
        return $res;
    }

    public function buscar_por_id($id){
        $db = new Database('desafio');

        $obj = $db->select('id_desafio ='.$id)->fetchObject(self::class);
        return $obj; //retorna um obj da classe usuario
    }

    public function atualizar(){
        $db = new Database('desafio');

        $res = $db->update("id_desafio =".$this->id_desafio,
                            [
                                "pontos" => $this->pontos,
                                "enunciado" => $this->enunciado,
                                'opcaoA' => $this->opcaoA,
                                'opcaoB' => $this->opcaoB,
                                'opcaoC' => $this->opcaoC,
                                'opcaoD' => $this->opcaoD,
                                'opcaoE' => $this->opcaoE,
                                'resposta' => $this->resposta,
                            ]
                        );

        return $res;
    }

    public function excluir(){
        $db = new Database('desafio');

        $res = $db->delete('id_desafio ='.$this->id_desafio);
        return $res;
    }
}
