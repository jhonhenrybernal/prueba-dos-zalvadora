# Prueba zalvadora API de Cursos y Estudiantes (Laravel DDD + Sail + Redis + Scramble)

API RESTful para la gestión de cursos, estudiantes e inscripciones.  
Arquitectura DDD. Documentada automáticamente con Scramble.

---

## Instalación y primer uso

1. **Clonar el repositorio**
    ```bash
    git clone https://github.com/jhonhenrybernal/prueba-dos-zalvadora
    cd tu-repo
    ```

2. **Copiar `.env` y configurar variables**
    ```bash
    cp .env.example .env
    ```

3. **Levantar los servicios con Sail**
    ```bash
    ./vendor/bin/sail up -d
    ```

4. **Instalar dependencias Composer**
    ```bash
    ./vendor/bin/sail composer install
    ```

5. **Generar clave de la app**
    ```bash
    ./vendor/bin/sail artisan key:generate
    ```

6. **Migraciones y seeds**
    ```bash
    ./vendor/bin/sail artisan migrate --seed
    ```

## Uso de la API

- Todas las rutas bajo `/api/v1/*` requieren autenticación por token (Sanctum).
- **Ejemplo de login:**  
  `POST /api/v1/login`
    ```json
    {
      "email": "juan@example.com",
      "password": "secret123"
    }
    ```
- El token recibido se debe enviar como `Authorization: Bearer {token}` en los siguientes requests.

## Documentación automática

- [http://localhost:8021/docs/api](http://localhost:8021/docs/api)  
  Documentación interactiva generada con **Scramble**.


### Colección en Postman

1. **Descarga el archivo**  
   [Descargar Prueba Salvadora dos.postman_collection.json](./Prueba%20Salvadora%20dos.postman_collection.json)  
   (o descárgalo directamente desde este repositorio).


## Tests

- Ejecuta los tests con Pest:
    ```bash
    ./vendor/bin/sail test
    ```

## Extras

- Caching de consultas con Redis.
- Arquitectura Domain-Driven Design (DDD).
- Ejemplo de middleware de logging.
- Policies y FormRequests para seguridad y validación.
- Endpoints versionados (`/api/v1`).

---

## Licencia

MIT

---

### Créditos

- Autor: Jhon Bernal
- Basado en Laravel 12, Sail y Scramble.
