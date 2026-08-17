CREATE DATABASE IF NOT EXISTS aeropuerto;
USE aeropuerto;

CREATE TABLE Persona (
    CI INT PRIMARY KEY,
    Credencial VARCHAR(10) UNIQUE,
    FechaNac DATE,
    Nombre VARCHAR(500)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Tripulante (
    CI INT PRIMARY KEY,
    Cargo VARCHAR(50),
    FOREIGN KEY (CI) REFERENCES Persona(CI)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Pasajero (
    CI INT PRIMARY KEY,
    FOREIGN KEY (CI) REFERENCES Persona(CI)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Avion (
    Matricula VARCHAR(50) PRIMARY KEY,
    Fabricante VARCHAR(50),
    Asientos INT,
    Carga INT,
    Modelo VARCHAR(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Vuelo (
    IDVuelo INT AUTO_INCREMENT PRIMARY KEY,
    FechaHoraS DATETIME,
    FechaHoraL DATETIME,
    Matricula VARCHAR(50),
    FOREIGN KEY (Matricula) REFERENCES Avion(Matricula)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Reserva (
    IDReserva INT AUTO_INCREMENT PRIMARY KEY,
    Clase VARCHAR(50),
    Costo VARCHAR(50),
    CI INT,
    IDVuelo INT,
    FOREIGN KEY (CI) REFERENCES Pasajero(CI),
    FOREIGN KEY (IDVuelo) REFERENCES Vuelo(IDVuelo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO Persona (CI, Credencial, FechaNac, Nombre)
VALUES
(12345678, 'ABC123', '1998-05-10', 'Ana Pérez'),
(23456789, 'DEF456', '1995-08-20', 'Luis Gómez'),
(34567890, 'TRI789', '1990-03-15', 'Carlos Tripulante');

INSERT INTO Pasajero (CI)
VALUES
(12345678),
(23456789);

INSERT INTO Tripulante (CI, Cargo)
VALUES
(34567890, 'Piloto');

INSERT INTO Avion (Matricula, Fabricante, Asientos, Carga, Modelo)
VALUES
('CX-AAA', 'Boeing', 180, 20000, '737'),
('CX-BBB', 'Airbus', 220, 25000, 'A320');

INSERT INTO Vuelo (FechaHoraS, FechaHoraL, Matricula)
VALUES
('2026-07-01 10:00:00', '2026-07-01 13:30:00', 'CX-AAA'),
('2026-07-02 15:00:00', '2026-07-02 18:45:00', 'CX-BBB');

INSERT INTO Reserva (Clase, Costo, CI, IDVuelo)
VALUES
('Turista', '100', 12345678, 1),
('Ejecutiva', '250', 23456789, 2);