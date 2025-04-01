<?php
require '../../app/model/Database.php';

class Desafio{
    public int $id_desafio;
    public int $pontos;

    // public ?int $id_desafio;
    // public ?int $pontos;

    public string $enunciado;
    public string $opcaoA;
    public string $opcaoB;
    public string $opcaoC;
    public string $opcaoD;
    public string $opcaoE;
    public string $resposta;
    public int $id_professor;

    // public function __construct(
    //     $id_desafio = null, $pontos = null, $enunciado = null, 
    //     $opcaoA = null, $opcaoB = null, $opcaoC = null, 
    //     $opcaoD = null, $opcaoE = null, $resposta = null, 
    //     $id_professor = null
    // ) {
    //     $this->id_desafio = $id_desafio;
    //     $this->pontos = $pontos;
    //     $this->enunciado = $enunciado;
    //     $this->opcaoA = $opcaoA;
    //     $this->opcaoB = $opcaoB;
    //     $this->opcaoC = $opcaoC;
    //     $this->opcaoD = $opcaoD;
    //     $this->opcaoE = $opcaoE;
    //     $this->resposta = $resposta;
    //     $this->id_professor = $id_professor;
    // }

    public function cadastrar() {
        $db = new Database('desafio');
        
        // Obter o ID do professor da sessão
        // session_start();
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
        // session_start();
        $id_professor = $_SESSION['id_professor'];  // Pega o ID do professor da sessão
        
        // Se $where não for passado, criamos uma condição para o professor
        if (!$where) {
            $where = "id_professor = $id_professor";  // Garantir que estamos buscando apenas os desafios do professor logado
        }
    
        $db = new Database('desafio');  // Mudança para a tabela correta
        $res = $db->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
        return $res;
    }

public function buscar_por_id($id){
    $db = new Database('desafio');
    
    // Verificar se o ID é válido antes de tentar buscar
    if (is_numeric($id) && $id > 0) {
        $obj = $db->select('id_desafio ='.$id)->fetchObject(self::class);
        
        // Se o objeto retornado for nulo, criar um novo objeto Desafio com valores padrão
        if ($obj) {
            return $obj;
        } else {
            // Se o desafio não for encontrado, retornar um objeto vazio ou null
            return null;
        }
    } else {
        // Se o ID não for válido, retornar null
        return null;
    }
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
        $db = new Database('pontuacao');
    
        // Primeiro, excluir todas as pontuações relacionadas ao desafio
        $db->delete('id_desafio ='.$this->id_desafio);
    
        // Agora, excluir o desafio
        $db = new Database('desafio');
        return $db->delete('id_desafio ='.$this->id_desafio);
    }
}
