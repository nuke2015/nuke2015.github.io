// hello.go
package main

import (
	"fmt"
	"io/ioutil"
	"log"
)

func main() {
	files, err := ioutil.ReadDir("./")
	if err != nil {
		log.Fatal(err)
	}

	for _, f := range files {
		dump(f)
	}
}

func dump(x interface{}) {
	fmt.Printf("%+v\n", x)
}
