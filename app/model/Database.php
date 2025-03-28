<?php



class Database {
    private $conn;
    private string $local = '192.168.22.9';
    private string $db = 'torneioArduino';
    private string $user = 'fabrica32';
    private string $password = 'fabrica2025';
    private $table;

    // private $conn;
    // private string $local = 'localhost';
    // private string $db = 'torneioArduino';
    // private string $user = 'root';
    // private string $password = 'suporte@22';
    // private $table;

    function __construct($table = null){
        $this->table = $table;
        $this->conecta();

    }

    private function conecta(){
        try{
            $this->conn = new PDO("mysql:host=".$this->local.";dbname=$this->db",$this->user,$this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Conectado com sucesso";
        }catch(PDOException $err){
            die("Connection Failed". $err->getMessage());
        }
    }

    public function execute($query, $binds = []){
        // echo $query;

        try{
            $stmt = $this->conn->prepare($query);
            $stmt->execute($binds);
            return $stmt;
        }catch(PDOException $err){
            die('Connection Failed'. $err->getMessage());
        }
    }

    public function insert($values){
        // quebrar o array associativo que veio como parametro
        $fields = array_keys($values);

        $binds = array_pad([], count($fields), '?');

        $query = 'INSERT INTO '.$this->table . '('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';

        $res = $this->execute($query, array_values($values));

        if($res){
            return true;
        }else{
            return false;
        }
    }


    public function select($where = null, $order = null, $limit = null, $fields = '*'){
        $where = $where ? 'WHERE ' . $where : '';
        $order = $order ? 'ORDER BY ' . $order : '';
        $limit = $limit ? 'LIMIT ' . $limit : '';
    
        $query = 'SELECT ' . $fields . ' FROM ' . $this->table . ' ' . $where . ' ' . $order . ' ' . $limit;
    
        $stmt = $this->conn->prepare($query);
    
        // Se houver parâmetros (binds), vamos usá-los aqui
        $stmt->execute(); 
    
        return $stmt;
    }
    public function select_by_id($where = null, $order = null, $limit = null, $fields = '*'){
        $where = strlen($where) ? 'WHERE '.$where : '';
        $order = strlen($order) ? 'ORDER BY '.$order : '';
        $limit = strlen($limit) ? 'LIMIT '.$limit : '';

        $query = 'SELECT '.$fields.' FROM '.$this->table. ' '.$where. ' '.$order . ' '.$limit ;

        return $this->execute($query)->fetch(PDO::FETCH_ASSOC);
    }


    public function delete($where){
        //Montar a query

        $query = 'DELETE FROM '.$this->table. ' WHERE '.$where;
        $del = $this->execute($query);
        $del = $del->rowCount();

        if($del == 1){
            return true;
        }else{
            return false;
        }
    }

    public function deleteTime($id_times) {
        try {
            // Iniciar transação
            $this->conn->beginTransaction();
    
            // Deletar as pontuações associadas ao time
            $sql_pontuacao = "DELETE FROM pontuacao WHERE id_times = :id_times";
            $stmt_pontuacao = $this->conn->prepare($sql_pontuacao);
            $stmt_pontuacao->bindParam(':id_times', $id_times, PDO::PARAM_INT);
            $stmt_pontuacao->execute();
    
            // Deletar o time
            $sql_time = "DELETE FROM times WHERE id_times = :id_times";
            $stmt_time = $this->conn->prepare($sql_time);
            $stmt_time->bindParam(':id_times', $id_times, PDO::PARAM_INT);
            $stmt_time->execute();
    
            // Se tudo ocorrer bem, commit a transação
            $this->conn->commit();
    
            return true;
        } catch (Exception $e) {
            // Se houver erro, rollback a transação
            $this->conn->rollBack();
            return false;
        }
    }

    public function update($where, $array){

        // echo $where;
        // echo "<br>";
        // print_r($array);

        //Extraindo as chaves, coluna
        $fields = array_keys($array);
        $values = array_values($array);
        //Montar Query
        $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields). '=? WHERE '. $where;

        $res = $this->execute($query, $values);
        return $res->rowCount();
    }



    function excluirTime($id_time) {
        try {
            // Primeiro, exclui as pontuações associadas ao time
            $sql1 = "DELETE FROM pontuacao WHERE id_times = :id_times";
            $stmt1 = $pdo->prepare($sql1);
            $stmt1->execute([':id_times' => $id_time]);
    
            // Agora, exclui o time da tabela times
            $sql2 = "DELETE FROM times WHERE id_times = :id_times";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->execute([':id_times' => $id_time]);
    
            // Confirma a transação
            $pdo->commit();
            echo "Time excluído com sucesso!";
        } catch (Exception $e) {
            // Em caso de erro, reverte a transação
            $pdo->rollBack();
            echo "Erro ao excluir o time: " . $e->getMessage();
        }
    }


    
}
