<?php

// Clears the cache and prevent unwanted output
ob_clean();
// @ini_set('error_reporting', 2047);
// @apache_setenv('no-gzip', 1);
// @ini_set('zlib.output_compression', 'Off');
//  echo $file;exit;

// header('HTTP/1.1 304 Not Modified');
header("Content-type: video/mp4");
header("Connection:keep-alive");

$file = "./video.mp4"; // The media file's location
// $mime = "application/octet-stream"; // The MIME type of the file, this should be replaced with your own.
$size = filesize($file); // The size of the file

// Send the content type header
// header('Content-type: ' . $mime);
// Check if it's a HTTP range request
if (isset($_SERVER['HTTP_RANGE'])) {
    // Parse the range header to get the byte offset
    $ranges = array_map(
        'intval', // Parse the parts into integer
        explode(
            '-', // The range separator
            substr($_SERVER['HTTP_RANGE'], 6) // Skip the `bytes=` part of the header
        )
    );

    // If the last range param is empty, it means the EOF (End of File)
    if (!$ranges[1]) {
        $ranges[1] = $size - 1;
    }

    // Send the appropriate headers
    header('HTTP/1.1 206 Partial Content');
    header('Accept-Ranges: bytes');
    header('Content-Length: ' . ($ranges[1] - $ranges[0])); // The size of the range

    // Send the ranges we offered
    header(
        sprintf(
            'Content-Range: bytes %d-%d/%d', // The header format
            $ranges[0], // The start range
            $ranges[1], // The end range
            $size // Total size of the file
        )
    );

    // It's time to output the file
    $f         = fopen($file, 'rb'); // Open the file in binary mode
    $chunkSize = 8192; // The size of each chunk to output

    // Seek to the requested start range
    fseek($f, $ranges[0]);

    // Start outputting the data
    while (true) {
        // Check if we have outputted all the data requested
        if (ftell($f) >= $ranges[1]) {
            break;
        }

        // Output the data
        echo fread($f, $chunkSize);

        // Flush the buffer immediately
        @ob_flush();
        flush();
    }
} else {
    // It's not a range request, output the file anyway
    header('Content-Length: ' . $size);

    // Read the file
    echo @readfile($file);

    // and flush the buffer
    @ob_flush();
    flush();
}
