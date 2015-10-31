<?php
echo mongo_id();

// 生成类似mongo主键的函数
function mongo_id() {
    static $i = 0;
    $i OR $i = mt_rand(1, 0x7FFFFF);
    
    return sprintf("%08x%06x%04x%06x",
    
    /* 4-byte value representing the seconds since the Unix epoch. */
    time() & 0xFFFFFFFF,
    
    /* 3-byte machine identifier.
     *
     * On windows, the max length is 256. Linux doesn't have a limit, but it
     * will fill in the first 256 chars of hostname even if the actual
     * hostname is longer.
     *
     * From the GNU manual:
     * gethostname stores the beginning of the host name in name even if the
     * host name won't entirely fit. For some purposes, a truncated host name
     * is good enough. If it is, you can ignore the error code.
     *
     * crc32 will be better than Times33. */
    crc32(substr((string)gethostname(), 0, 256)) >> 8 & 0xFFFFFF,
    
    /* 2-byte process id. */
    getmypid() & 0xFFFF,
    
    /* 3-byte counter, starting with a random value. */
    $i = $i > 0xFFFFFE ? 1 : $i + 1);
}
