<?php

// Système de scan réalisé par superrtutur

function scanDirectory($dir, $rootName) {
    $files = [];


    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $file) {
        $filePath = $file->getPathname();
        $relativePath = substr($filePath, strlen($dir) + 1);
        $fileName = $file->getFilename();
        $fileSize = $file->isFile() ? filesize($filePath) : 0;

        $files[] = [
            'name' => $fileName,
            'path' => $rootName . '/' . $relativePath,
            'size' => $fileSize . " B"
        ];
    }

    return $files;
}

function printFiles($title, $files) {
    echo "$title|";
    foreach ($files as $file) {
        echo htmlspecialchars($file['name']) . 
            "~" . htmlspecialchars($file['path']) . 
            "~" . $file['size'];
        echo "^";
    }
    echo "=";
}

$directories = [
    'ToDownload' => __DIR__ . '/ToDownload',
    'Optionnal' => __DIR__ . '/Optionnal',
    'NoModify' => __DIR__ . '/NoModify'
];


foreach ($directories as $title => $path) {
    if (is_dir($path)) {
        $files = scanDirectory($path, $title);
        printFiles($title, $files);
    } else {
        echo "$title|=";
    }
}

?>
