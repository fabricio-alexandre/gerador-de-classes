<?php
foreach (new DirectoryIterator(__DIR__.'/files') as $fileInfo) {
  if ($fileInfo->isFile()) {
    unlink($fileInfo->getPathname());    
  }
}
echo 'Todos os arquivos foram removidos';