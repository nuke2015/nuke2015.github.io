<?php

// // Get real path for our folder
// $rootPath = realpath('./mqs');
// Fzip::zip_dir($rootPath,'hello.zip');
// Fzip::zip_download('hello.zip','a.zip');
// exit;

class Fzip {
    
    //打包    
    public static function zip_dir($rootPath, $zip_name) {
        
        // Initialize archive object
        $zip = new ZipArchive();
        $zip->open($zip_name, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        
        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY);
        
        foreach ($files as $name => $file) {
            
            // Skip directories (they would be added automatically)
            if (!$file->isDir()) {
                
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);
                
                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
    }

    //下载
    public static function zip_download($file_from, $file_to) {
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header('Content-disposition: attachment; filename=' . $file_to);
        
        //文件名
        header("Content-Type: application/zip");
        
        //zip格式的
        header("Content-Transfer-Encoding: binary");
        
        //告诉浏览器，这是二进制文件
        header('Content-Length: ' . filesize($file_from));
        
        //告诉浏览器，文件大小
        @readfile($file_from);
    }
}

