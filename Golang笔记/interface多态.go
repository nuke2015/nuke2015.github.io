package main

import (
	"fmt"
)

type Animal interface {
    Speak() string
}

type Dog struct{}
func (d Dog) Speak() string {
    return "dog Speak"
}

type Cat struct{}
func (c Cat) Speak() string {
    return "cat Speak!"
}

type Duck struct{}
func (d Duck) Speak() string {
    return "duck Speak!"
}

func main() {
	animals := []Animal{Dog{}, Cat{}, Duck{}}
    for _, animal := range animals {
        dump(animal.Speak())
    }
}

func dump(params interface{}) {
	fmt.Printf("%v", params);
}


