

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

4. Listo, tendrás las tablas y algunos datos iniciales cargados.

---

##  Roles de Usuario

El sistema cuenta con **roles universales de ejemplo**:

- `Administrador` → controla la configuración general.  
- `Administrativo / Recepcionista` → gestiona socios, pagos y asistencia.  
- `Profesor` → carga clases y rutinas.  
- `Socio` → accede a reservas, rutinas y asistencia.  
- `SuperAdmin` (solo desarrollo) → combina todos los roles. *No se entrega a clientes.*

---


