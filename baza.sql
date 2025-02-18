
DROP DATABASE IF EXISTS system_kina;
CREATE DATABASE system_kina;
USE system_kina;

CREATE TABLE filmy (
    film_id INT PRIMARY KEY AUTO_INCREMENT,
    tytul VARCHAR(100) NOT NULL,
    czas_trwania INT NOT NULL,
    gatunek VARCHAR(50),
    opis TEXT,
    data_premiery DATE,
    ograniczenie_wiekowe VARCHAR(5)
);

CREATE TABLE sale (
    sala_id INT PRIMARY KEY AUTO_INCREMENT,
    nazwa_sali VARCHAR(50) NOT NULL,
    pojemnosc INT NOT NULL,
    czy_3d BOOLEAN DEFAULT FALSE
);

CREATE TABLE miejsca (
    miejsce_id INT PRIMARY KEY AUTO_INCREMENT,
    sala_id INT,
    numer_rzedu INT NOT NULL,
    numer_miejsca INT NOT NULL,
    FOREIGN KEY (sala_id) REFERENCES sale(sala_id)
);

CREATE TABLE seanse (
    seans_id INT PRIMARY KEY AUTO_INCREMENT,
    film_id INT,
    sala_id INT,
    data_seansu DATETIME NOT NULL,
    cena DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (film_id) REFERENCES filmy(film_id),
    FOREIGN KEY (sala_id) REFERENCES sale(sala_id)
);

CREATE TABLE klienci (
    klient_id INT PRIMARY KEY AUTO_INCREMENT,
    imie VARCHAR(50) NOT NULL,
    nazwisko VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefon VARCHAR(15),
    data_rejestracji DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rezerwacje (
    rezerwacja_id INT PRIMARY KEY AUTO_INCREMENT,
    klient_id INT,
    seans_id INT,
    miejsce_id INT,
    data_rezerwacji DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('aktywna', 'anulowana', 'zakonczona') DEFAULT 'aktywna',
    FOREIGN KEY (klient_id) REFERENCES klienci(klient_id),
    FOREIGN KEY (seans_id) REFERENCES seanse(seans_id),
    FOREIGN KEY (miejsce_id) REFERENCES miejsca(miejsce_id)
);

CREATE TABLE platnosci (
    platnosc_id INT PRIMARY KEY AUTO_INCREMENT,
    rezerwacja_id INT,
    kwota DECIMAL(10,2) NOT NULL,
    data_platnosci DATETIME DEFAULT CURRENT_TIMESTAMP,
    metoda_platnosci ENUM('gotowka', 'karta', 'online') NOT NULL,
    FOREIGN KEY (rezerwacja_id) REFERENCES rezerwacje(rezerwacja_id)
);
