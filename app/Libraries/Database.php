<?php

class Database {

    private $host;
    private $usuario;
    private $senha;
    private $banco;
    private $porta;
    private $dbh;
    private $stmt;

    public function __construct()
    {
        // Carrega as configurações do arquivo configuracao.php
        $this->host = DB_HOST;
        $this->usuario = DB_USER;
        $this->senha = DB_PASS;
        $this->banco = DB_NAME;
        
        $opcoes = [
            //armazena em cache a conexão para ser reutilizada, evita a sobrecarga de uma nova conexão, resultando em um aplicativo mais rápido
            PDO::ATTR_PERSISTENT => true,
            //lança uma PDOException se ocorrer um erro 
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        
        // Tenta diferentes configurações de porta
        $portas = ['3306', '3307']; // Portas mais comuns do MySQL
        $conectado = false;
        
        foreach ($portas as $porta) {
            $this->porta = $porta;
            
            try {
                // Primeiro tenta conectar sem especificar o banco para poder criá-lo
                $dsn_base = "mysql:host={$this->host};port={$this->porta}";
                $pdo_temp = new PDO($dsn_base, $this->usuario, $this->senha, $opcoes);
                
                // Verifica se o banco existe, se não, cria
                $stmt = $pdo_temp->query("SHOW DATABASES LIKE '{$this->banco}'");
                if ($stmt->rowCount() == 0) {
                    $pdo_temp->exec("CREATE DATABASE `{$this->banco}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                }
                
                // Agora conecta ao banco específico
                $dsn = "mysql:host={$this->host};port={$this->porta};dbname={$this->banco}";
                $this->dbh = new PDO($dsn, $this->usuario, $this->senha, $opcoes);
                $conectado = true;
                break;
                
            } catch (PDOException $e) {
                // Se falhou nesta porta, tenta a próxima
                continue;
            }
        }
        
        if (!$conectado) {
            print "Error!: Não foi possível conectar ao banco de dados. Verifique se o MySQL está rodando e as configurações estão corretas.<br/>";
            die();
        }
    }// fim do contrutor

    //prepare Statements com query
    public function query($sql){
        //prepara uma consulta sql
        $this->stmt = $this->dbh->prepare($sql);
    }//fim da função query
    
    //vincula um valor ao parâmetro
    public function bind($parametro, $valor, $tipo = null){
        if(is_null($tipo)):
            switch(true){
                case is_int($valor):
                    $tipo = PDO::PARAM_INT;
                    break;
                case is_bool($valor):
                    $tipo = PDO::PARAM_BOOL;
                    break;
                case is_null($valor):
                    $tipo = PDO::PARAM_NULL;
                    break;
                    default:
                    $tipo = PDO::PARAM_STR;
            }//fim do switch
        endif;
        $this->stmt->bindValue($parametro, $valor, $tipo);
    }//fim da função bind
    //executa prepared statement

    public function executa(){
        //return $this->stmt->execute();
    }//fim da função executa
    //obtem um único registro
    public function resultado(){
        $this->executa();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }//fim da função resultado
    //obtem um conjunto de registros
    public function resultados(){
        $this->executa();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }//fim da função resultados
    //retorna o número de linhas afetadas pela última instrução SQL
    public function totalResultados(){
        return $this->stmt->rowCount();
    }//fim da função totalResultados
    //retorna o último id inserido no banco de dados
    public function ultimoIdInserido(){
        return $this->dbh->lastInsertId();
    }//fim da função ultimoIdInserido
}//fim da classe Database



