<?php

$dir = __DIR__.'/resources/views';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

foreach ($files as $file) {
    if ($file->isDir()) continue;
    $content = file_get_contents($file->getPathname());
    $original = $content;

    // Replace Artist image logic
    $content = preg_replace('/\{\{\s*asset\(\s*\'storage\/\'\s*\.\s*\(\$artist->avatar\s*\?\?\s*\$artist->image\)\s*\)\s*\}\}/', '{{ $artist->foto_url }}', $content);
    $content = preg_replace('/\{\{\s*asset\(\s*\'storage\/\'\s*\.\s*\(\$a->avatar\s*\?\?\s*\$a->image\)\s*\)\s*\}\}/', '{{ $a->foto_url }}', $content);
    $content = preg_replace('/\{\{\s*asset\(\s*\'storage\/\'\.\$artist->avatar\s*\)\s*\}\}/', '{{ $artist->foto_url }}', $content);
    $content = preg_replace('/\{\{\s*asset\(\s*\'storage\/\'\s*\.\s*\$artist->avatar\s*\)\s*\}\}/', '{{ $artist->foto_url }}', $content);
    $content = preg_replace('/\{\{\s*asset\(\s*\'storage\/\'\.\$artist->image\s*\)\s*\}\}/', '{{ $artist->foto_url }}', $content);
    $content = preg_replace('/\{\{\s*asset\(\s*\'storage\/\'\s*\.\s*\$artist->image\s*\)\s*\}\}/', '{{ $artist->foto_url }}', $content);

    // Replace $a->image / $a->avatar
    $content = preg_replace('/\{\{\s*asset\(\s*\'storage\/\'\.\$a->image\s*\)\s*\}\}/', '{{ $a->foto_url }}', $content);
    $content = preg_replace('/\{\{\s*asset\(\s*\'storage\/\'\s*\.\s*\$a->image\s*\)\s*\}\}/', '{{ $a->foto_url }}', $content);
    $content = preg_replace('/\{\{\s*asset\(\s*\'storage\/\'\.\$a->avatar\s*\)\s*\}\}/', '{{ $a->foto_url }}', $content);
    $content = preg_replace('/\{\{\s*asset\(\s*\'storage\/\'\s*\.\s*\$a->avatar\s*\)\s*\}\}/', '{{ $a->foto_url }}', $content);

    // Replace Merch image logic
    $content = preg_replace('/\{\{\s*asset\(\s*\'storage\/\'\.\$merch->foto\s*\)\s*\}\}/', '{{ $merch->foto_url }}', $content);
    $content = preg_replace('/\{\{\s*asset\(\s*\'storage\/\'\s*\.\s*\$merch->foto\s*\)\s*\}\}/', '{{ $merch->foto_url }}', $content);
    $content = preg_replace('/\{\{\s*asset\(\s*\'storage\/\'\.\$item\[\'merch\'\]->foto\s*\)\s*\}\}/', '{{ $item[\'merch\']->foto_url }}', $content);

    // Replace Banner image logic
    $content = preg_replace('/\{\{\s*asset\(\s*\'storage\/\'\.\$banner->image\s*\)\s*\}\}/', '{{ $banner->foto_url }}', $content);
    $content = preg_replace('/\{\{\s*asset\(\s*\'storage\/\'\s*\.\s*\$banner->image\s*\)\s*\}\}/', '{{ $banner->foto_url }}', $content);

    // order item
    $content = preg_replace('/\{\{\s*asset\(\s*\'storage\/\'\.\$item->gambar\s*\)\s*\}\}/', '{{ $item->foto_url }}', $content);
    $content = preg_replace('/\{\{\s*asset\(\s*\'storage\/\'\s*\.\s*\$item->gambar\s*\)\s*\}\}/', '{{ $item->foto_url }}', $content);
    
    // shop item (from UserShopController)
    $content = preg_replace('/\{\{\s*asset\(\s*\'storage\/\'\.\$item->gambar\s*\)\s*\}\}/', '{{ $item->foto_url }}', $content);

    // If conditions for images
    $content = str_replace('@if($artist->avatar || $artist->image)', '@if($artist->foto_url)', $content);
    $content = str_replace('@if($a->avatar || $a->image)', '@if($a->foto_url)', $content);
    $content = str_replace('@if($artist->avatar)', '@if($artist->foto_url)', $content);
    $content = str_replace('@if($a->avatar)', '@if($a->foto_url)', $content);
    $content = str_replace('@if($artist->image)', '@if($artist->foto_url)', $content);
    $content = str_replace('@if($a->image)', '@if($a->foto_url)', $content);

    if ($original !== $content) {
        file_put_contents($file->getPathname(), $content);
        echo "Updated: " . $file->getPathname() . "\n";
    }
}
