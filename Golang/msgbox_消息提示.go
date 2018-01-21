package main

import (
    "fmt"
    "syscall"
    "unsafe"
)

func main() {
    var mod = syscall.NewLazyDLL("user32.dll")
    var proc = mod.NewProc("MessageBoxW")
    var MB_YESNO = 0x00000001

    ret, _, _ := proc.Call(0,
        uintptr(unsafe.Pointer(syscall.StringToUTF16Ptr("This test is Done."))),
        uintptr(unsafe.Pointer(syscall.StringToUTF16Ptr("Done Title"))),
        uintptr(MB_YESNO))
    fmt.Printf("Return: %d\n", ret)

}