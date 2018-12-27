<?php

namespace app\componentes;

class ErrorLog
{

    private $file;
    private $log;

    public function __construct()
    {
        $this->fileExists();
    }

    public function fileExists()
    {

        if (file_exists('../app/log/log.txt')):
            $this->file = '../app/log/log.txt';
        elseif (file_exists('app/log/log.txt')):
            $this->file = 'app/log/log.txt';
        else:
            throw new \Exception('[Error: ' . date('Y-m-d H:i:s') . '] Arquivo log.txt não existe');
        endif;

        return $this->file;

    }

    public function writeLog($log)
    {

        $this->log = '[Error: ' . date('Y-m-d H:i:s') . '] ' . $log . " \r\n";
        // Abre o arquivo para leitura e gravação no inicio do arquivo
        if (!$filename = fopen($this->file, "r+")):
            throw new \Exception('[Error: ' . date('Y-m-d H:i:s') . '] Não foi possível abrir ' .
                ' o arquivo verifique as permissões do servidor.');
        endif;
        // Escreve o novo log no arquivo $file sem rescrever seu conteúdo.
        $txt_old = file_put_contents($this->file, $this->log, FILE_APPEND);
        // Fecha o arquivo.
        fclose($filename);

    }

    public function readError()
    {
        // Lê um arquivo em um array.
        $lines = file($this->file);
        //echo "<pre>"; print_r($lines); echo "</pre>";die;
        return $lines;

    }

}
