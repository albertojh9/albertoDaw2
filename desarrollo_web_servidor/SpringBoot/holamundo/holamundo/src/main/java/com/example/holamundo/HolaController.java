package com.ejemplo.Holamundo.Controller;

import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
public class HolaController {

    @GetMapping("/")
    public String holaMundo() {
        return "¡Hola Mundo!";
    }
}
