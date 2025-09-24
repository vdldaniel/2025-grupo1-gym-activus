#  Activus – Sistema de Gestión de Gimnasios

Este repositorio contiene el desarrollo del sistema **Activus**, un software pensado para la gestión integral de gimnasios.  
Incluye control de socios, pagos, reservas, asistencia, rutinas, profesores, y configuración personalizada para múltiples gimnasios.

---

##  Contenido

- `db/activus_db.sql` → Script con la base de datos inicial (estructura + datos de ejemplo).
- Código fuente del backend y frontend (carpetas por definir).

---

## Requisitos

- **XAMPP** o similar con:
  - MySQL 8+  
  - PHP 7.4+  
  - Apache  

- **SQL Manager** o **phpMyAdmin** para administrar la base de datos.

---

##  Instalación de la Base de Datos

1. Clonar el repositorio:  

   ```bash
   git clone https://github.com/vdldaniel/2025-grupo1-gym-activus.git
   ```

2. Crear una base de datos vacía llamada **`activus_db`** en MySQL.

3. Importar el archivo SQL:  

   - Desde **phpMyAdmin**: ir a *Importar* → seleccionar `db/activus_db.sql` → Ejecutar.  
   - Desde consola:  

     ```bash
     mysql -u root -p activus_db < db/activus_db.sql
     ```

4. Listo 🎉 tendrás las tablas y algunos datos iniciales cargados.

---

##  Roles de Usuario

El sistema cuenta con **roles universales de ejemplo**:

- `Administrador` → controla la configuración general.  
- `Administrativo / Recepcionista` → gestiona socios, pagos y asistencia.  
- `Profesor` → carga clases y rutinas.  
- `Socio` → accede a reservas, rutinas y asistencia.  
- `SuperAdmin` (solo desarrollo) → combina todos los roles. *No se entrega a clientes.*

---

##  Datos de ejemplo incluidos

- **Usuarios iniciales**: Admin, Recepción, Profesor, Socios de prueba.  
- **Socios**: Ejemplo de socios adultos y uno menor de edad.  
- **Tutor**: Se agregó el caso de un socio menor con su tutora registrada.  
- **Membresías**: Activas con fechas de inicio y fin.  
- **Pagos**: Incluyen referencia de quién cargó el pago (`ID_Usuario_Registro`).  
- **Ejercicios y equipos**: Con ejemplos básicos precargados.  
- **Clases y reservas**: Con Zumba y Spinning como casos de prueba.

---

##  Notas importantes

- Si un socio es **menor de edad**, se debe asignar un **tutor** con datos de contacto y relación.  
- Cada pago queda registrado con el usuario que lo cargó, la fecha y hora.  
- La capacidad de cada clase puede ser configurada por el administrador del gimnasio.  
- La base está pensada como **multi-gimnasio**, es decir, cada cliente podrá adaptar ejercicios, salas, clases y horarios a sus necesidades.

---

##  Próximos pasos

- Conectar la base al backend.  
- Definir pantallas de gestión para **socios, pagos, clases, reservas, tutores y certificados médicos**.  
- Seguir probando tablas vacías (`certificado`, `configuracion_gym`) con datos reales.  

---



