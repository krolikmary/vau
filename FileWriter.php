<?php

class FileWriter
{
    public function writeFile($filename, $content)
    {
        try {
            $handler = fopen($filename, "w");
            fwrite($handler, $content);
            fclose($handler);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}