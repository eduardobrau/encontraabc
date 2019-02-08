<?php

/**
 * Classe para uploads de imagens e arquivos
 * aceita tanto uploads simples quanto
 * multiuploads exemplo de uso: 
 * new Upload("/^image\/(jpg|jpeg)$/");
 * @author Eduardo Esteves
 * @version 1.0
 */

class Upload{
    
    private $maxSize;
    private $error = NULL;

    public function __construct(){
                
        try{
            $this->DB = new DataBase;
        }catch(Exception $e){
            $error = $e->getMessage() .  
            ' do arquivo ' . $e->getFile() .  
            ' na linha ' . $e->getLine() .
            ' erro capturado no arquivo ' .__FILE__.
            ' da linha ' .__LINE__. '';
            new ErrorLog($error);
            mensagem(array('tipo' => 'erro_conexao'));
        }

    }
    /**
     * Método para organizar os files enviado
     * pelo usuário, reorganizando um upload 
     * de acordo a dimensão do upload enviado
     * para que seja possível fazer tanto um upload
     * simples quanto um upload multiplo após a 
     * organização tenho uma nova estrutura do 
     * tipo upload[0]['name'],upload[0]['type']
     * facilitando o acesso de seus atributos para
     * ser manipulado posteriormente pelas funções 
     * validaFile() e uploads()
     */
    public function setFiles($files){
          
        foreach ($files as $k => $value){
            if( is_array($value) ):
                foreach ($value as $i => $valores) {
                    $this->files[$i] = array(
                        'name'      => $files['name'][$i],
                        'type'      => $files['type'][$i],
                        'tmp_name'  => $files['tmp_name'][$i],
                        'error'     => $files['error'][$i],
                        'size'      => $files['size'][$i]
                    );
                }
            else:
                $this->files[] = array(
                    'name'      => $files['name'],
                    'type'      => $files['type'],
                    'tmp_name'  => $files['tmp_name'],
                    'error'     => $files['error'],
                    'size'      => $files['size']
                );  
                break;
            endif;
        }
                
        // Após setar o atributo $files destruo o parametro da função
        unset($files);            
        return $this->files;

    }
    /**
     * Faz a validação de um arquivo $_FILES
     * validando os tipos de arquivos permitidos
     * e seus tamanhos. Caso não passe na validação
     * uma exceção será lançada com as mensagens de
     * erro. 
     * Atenção como setFiles setou a propriedade
     * $this->files e destruiu a variavel passada
     * por parametro $files, faço uso de $this->files
     */
    public function validaFile($files,$pattern,$maxSize){
        
        $this->setFiles($files);
        $this->maxSize = $maxSize;
            
        foreach ($this->files as $key => $file) {
			if( !preg_match($pattern, $file['type']) ):
                $this->error[$key] .= " Arquivo '{$file['name']}' não permitido:2000: tente formatos válidos como: .jpg, .jpeg "; 
                unset($this->files[$key]);
			endif;

			if( $file['size'] > ($this->maxSize) ):
                $this->error[$key] .= "e o tamanho máximo do arquivo:2001: {$file['name']} permitido é de " . 
                round( number_format( ($this->maxSize/1024), 2, ',', '.' ), 3 ) . 
                "KB Você tentou enviar um arquivo com " . 
                round( number_format( ($file['size']/1024), 2, ',', '.' ), 3 ) .
                "KB tente diminuir a resolução do dispositivo.";
                unset($this->files[$key]);
			endif;
        }
        
        if( !empty($this->error) ):
            return FALSE;
        endif;
        
        return TRUE;

    }

    public function getErrors(){
        return $this->error;
    }

    public function getFiles(){
        return $this->files;
    }

    public function uploads($files,$dir,$userId){
        
        $this->userId = $userId;
        global $fd_tabela_uploads;

        foreach ($files as $key => $file) {        
            // Diretório onde será salvo
            $uploadDir = $dir.sha1($this->userId).'/';
            $ext = pathinfo($file['name'],PATHINFO_EXTENSION);
            $fileName = ($key+1). '_' .date('Y-m-d'). '_' . mt_rand() . '.' . $ext;
                            
            // Verifica se já existe o diretório onde se deseja salvar				
            if(!file_exists($uploadDir) && !is_dir($uploadDir)):
                if(	!mkdir($uploadDir) ):
                    throw new \Exception('[Error]: Diretório informado ' .
                    $uploadDir . ' não existe e também não foi possível criar 
                    um novo diretório.');
                endif;
            endif;         
            
            // Move cada arquivo para o diretório /uploads/idUser/nome_do_arquivo.jpg
            $uploaded = move_uploaded_file($file['tmp_name'], $uploadDir . $fileName);
            if(!$uploaded):
                throw new \Exception('[Error]: Não foi possível mover ' .
                'o arquivo ' .  $uploadDir . $fileName .' para a pasta '.
                $dir . ' verifique se a pasta existe ou tem as devidas '.
                'permissões de escrita no servidor.');
            endif;
                            
            // Nome de cada imagem upload
            $fileUploaded = $uploadDir . $fileName; 
            // Otimização de Foto
            $caminho = $fileUploaded;
            image_fix_orientation($caminho);
                        
            try{
                $lastId = $this->DB->insert(
                    $fd_tabela_uploads,
                    array(
                        'id_digitadora' => $this->userId,
                        'imagem'        => $fileUploaded
                    )
                );
            }catch(Exception $e) {
                return $e;
            }
        }
        return $lastId;
    }
        
}

